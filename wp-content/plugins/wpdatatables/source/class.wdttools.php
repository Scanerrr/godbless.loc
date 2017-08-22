<?php

class WDTTools {
    
    public static $remote_path = 'http://wpdatatables.com/version-info.php';
    
    public static function getPossibleColumnTypes(){
            return array(
                'input' => __('One line string','wpdatatables'),
                'memo' => __('Multi-line string','wpdatatables'),
                'select' => __('One-line selectbox', 'wpdatatables'),
                'multiselect' => __('Multi-line selectbox','wpdatatables'),
                'integer' => __('Integer','wpdatatables'),
                'float' => __('Float','wpdatatables'),
                'date' => __('Date','wpdatatables'),
                'link' => __('URL Link','wpdatatables'),
                'email' => __('E-mail','wpdatatables'),
                'image' => __('Image','wpdatatables'),
                'file' => __('Attachment','wpdatatables')
            );
    }
    
    public static function curlGetData( $url ){
        $ch = curl_init();
        $timeout = 5;
        $agent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
                
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_USERAGENT, $agent );
        curl_setopt( $ch, CURLOPT_REFERER, site_url() );
        $data = curl_exec( $ch );
        curl_close( $ch );
        return $data;
        
    }
    
    public static function csvToArray( $csv ){
        $arr = array();
        $i = 0;
        $lines = str_getcsv( $csv, "\n" );
        foreach( $lines as $row ){
            $arr[] = str_getcsv( $row, "," );
        }
        $count = count( $arr ) - 1;
        $labels = array_shift( $arr );
        $keys = array();
        foreach ($labels as $label) {
          $keys[] = $label;
        }
        $returnArray = array();
        for( $j = 0; $j < $count; $j++ ){
          $d = array_combine( $keys, $arr[$j] );
          $returnArray[$j] = $d;
        }
        return $returnArray;
    }
    
    public static function extractGoogleSpreadsheetArray( $url ){
        if( empty( $url ) ){
            return '';
        }
        $url_arr = explode( '/', $url );
        $spreadsheet_key = $url_arr[ count($url_arr)-2 ];
        $csv_url = "https://docs.google.com/spreadsheets/d/{$spreadsheet_key}/pub?hl=en_US&hl=en_US&single=true&gid=0&output=csv";
        $csv_data = WDTTools::curlGetData( $csv_url );
        $array = WDTTools::csvToArray( $csv_data );
        return $array;
    }
    
    public static function getTranslationStrings(){
        return array(
            'select_upload_file' => __( 'Select a file to use in table', 'wpdatatables' ),
            'choose_file' => __( 'Use selected file', 'wpdatatables' ),
            'detach_file' => __( 'detach', 'wpdatatables' ),
            'from' => __( 'From', 'wpdatatables' ),
            'to' => __( 'To', 'wpdatatables' ),
            'invalid_email' => __( 'Please provide a valid e-mail address for field', 'wpdatatables' ),
            'invalid_link' => __( 'Please provide a valid URL link for field', 'wpdatatables' ),
            'cannot_be_empty' => __(' field cannot be empty!', 'wpdatatables' )
        );
    }
    
    public static function defineDefaultValue( $possible, $index, $default = '' ){
        return isset($possible[$index]) ? $possible[$index] : $default;
    }
    
    public static function extractHeaders( $rawDataArr ){
        reset($rawDataArr);        
        if( !is_array( $rawDataArr[ key($rawDataArr) ] ) ){
            throw new WDTException('Please provide a valid 2-dimensional array.');
        }
        return array_keys( $rawDataArr[ key( $rawDataArr ) ] );
    }    
    
    public static function detectColumnDataTypes( $rawDataArr, $headerArr ){
        $autodetectData = array();
        $autodetectRowsCount = (10 > count( $rawDataArr )) ? count( $rawDataArr )-1 : 9;
        $wdtColumnTypes = array();
        for( $i = 0; $i <= $autodetectRowsCount; $i++ ){
            foreach($headerArr as $key) {
                $cur_val = current( $rawDataArr );
                if(!is_array($cur_val[$key])){
                    $autodetectData[$key][] = $cur_val[$key];
                }else{
                    if(array_key_exists('value',$cur_val[$key])){
                        $autodetectData[$key][] = $cur_val[$key]['value'];
                    }else{
                        throw new WDTException('Please provide a correct format for the cell.');
                    }
                }
            }
            next( $rawDataArr );
        }
        foreach( $headerArr as $key ){  $wdtColumnTypes[$key] = self::_wdtDetectColumnType( $autodetectData[$key] ); }
        return $wdtColumnTypes;
    }
    
    public static function convertXMLtoArr( $xml, $root = true ) {
	    if (!$xml->children()) {
		return (string)$xml;
	    }

	    $array = array();
	    foreach ($xml->children() as $element => $node) {
		    $totalElement = count($xml->{$element});

		    // Has attributes
		    if ($attributes = $node->attributes()) {
			    $data = array(
                                'attributes' => array(),
                                'value' => (count($node) > 0) ? self::xmlToArray($node, false) : (string) $node
			    );

			    foreach ($attributes as $attr => $value) {
				    $data['attributes'][$attr] = (string)$value;
			    }
                            
                            $array[] = $data['attributes'];

		    // Just a value
		    } else {
			    if ($totalElement > 1) {
                                $array[][] = self::convertXMLtoArr($node, false);
			    } else {
                                $array[$element] = self::convertXMLtoArr($node, false);
			    }
                    }
            }
            
            return $array;
    }    
    
    public static function isArrayAssoc($arr) {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }    
    
    private static function _wdtDetectColumnType( $values ) {
        if ( self::_detect( $values, 'ctype_digit' ) ) { 
            return 'int'; 
        }
        if ( self::_detect( $values, 'is_numeric' ) ) { 
            return 'float'; 
        }
        if ( self::_detect( $values, 'strtotime' ) ) { return 'date'; }
        if ( self::_detect( $values, 'preg_match', WDT_EMAIL_REGEX ) ) { return 'email'; }
        if ( self::_detect( $values, 'preg_match', WDT_URL_REGEX ) ) { return 'link'; }
        return 'string';
    }
    
    private static function _detect( 
                $valuesArray, 
                $checkFunction, 
                $regularExpression = '' 
            ) {
        if( !is_callable( $checkFunction ) ){
            throw new WDTException( 'Please provide a valid type detection function for wpDataTables' ); 
        }
        $count = 0;
        for( $i=0; $i<count($valuesArray); $i++) {
            if( $regularExpression != '' ) {
                if( call_user_func( 
                        $checkFunction, 
                        $regularExpression, 
                        $valuesArray[$i]
                    ) 
                ) { 
                    $count++; 
                }
                else { return false; }
            } else {
                if( call_user_func( 
                        $checkFunction, 
                        $valuesArray[$i]
                        ) 
                    ) { 
                    $count++; 
                }
                else { return false; }
            }
        }
        if( $count == count( $valuesArray ) ) {
            return true;
        }
    }
    
    public static function checkRemoteVersion(){
        $request = wp_remote_post(self::$remote_path, array('body' => array('action' => 'version', 'purchase_code' => get_option('wdtPurchaseCode'))));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $request['body'];
        }
        return false;        
    }
    
    public static function checkRemoteInfo(){
        $request = wp_remote_post(self::$remote_path, array('body' => array('action' => 'info', 'purchase_code' => get_option('wdtPurchaseCode'))));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return unserialize($request['body']);
        }
        return false;        
    }    
    
}

?>