<?php

class Personalize_Login_Plugin {

    /**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
    public function __construct() {

        // добавляем шоткод, которі используется на странице логина /member-login/
        add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );

        //
        add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );

        add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );

        add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );

        add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );

        // используется на странице формы восстановления пароля
        add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );

        // используется на странице сброса формы пароля
        add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );

        // вызывается если зашли на страничку восстановленяи пароля, проверяет  if ( 'GET' == $_SERVER['REQUEST_METHOD'] )
        add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );

        // вызывается если был сабмит формы восстановления пароля , проверяетif ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );

        // корректируем текст письма с восстановлением пароля
        add_filter( 'retrieve_password_message', array( $this, 'replace_retrieve_password_message' ), 10, 4 );

        //  перехватываем момент когда происходит сброс пароля (тут два одинаковых экшена) -  редирект на нашу форму , только для GET запроса
        add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
        add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );

        //  перехватываем момент когда происходит сброс пароля (тут два одинаковых экшена) - для POST запроса
        add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
        add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );

    }

    /**
     * A shortcode for rendering the login form.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_login_form( $attributes, $content = null ) {


        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );
        $show_title = $attributes['show_title'];

        if ( is_user_logged_in() ) {
            return __( 'You are already signed in.', 'personalize-login' );
        }

        // Pass the redirect parameter to the WordPress login functionality: by default,
        // don't specify a redirect, but if a valid redirect URL has been passed as
        // request parameter, use it.
        $attributes['redirect'] = '';
        if ( isset( $_REQUEST['redirect_to'] ) ) {
            $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
        }

        // Render the login form using an external template

        // Check if the user just requested a new password
        $attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';

        return $this->get_template_html( 'login_form', $attributes );
    }

    /**
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $template_name The name of the template to render (without .php)
     * @param array  $attributes    The PHP variables for the template
     *
     * @return string               The contents of the template.
     */
    private function get_template_html( $template_name, $attributes = null ) {
        if ( ! $attributes ) {
            $attributes = array();
        }



        ob_start();


        do_action( 'personalize_login_before_' . $template_name );

        require ( get_template_directory() . DIRECTORY_SEPARATOR . "template-parts" . DIRECTORY_SEPARATOR . "$template_name" .".php" );

        do_action( 'personalize_login_after_' . $template_name );

        $html = ob_get_contents();
        ob_end_clean();


        return $html;
    }

    /**
     * Redirect the user to the custom login page instead of wp-login.php.
     */
    function redirect_to_custom_login() {
        if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;


            if ( is_user_logged_in() ) {

                $this->redirect_logged_in_user( $redirect_to );
                exit;
            }

            // The rest are redirected to the login page
            $login_url = home_url( 'member-login' );
            if ( ! empty( $redirect_to ) ) {
                $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
            }

            wp_redirect( $login_url );
            exit;
        }
    }

    /**
     * Redirects the user to the correct page depending on whether he / she
     * is an admin or not.
     *
     * @param string $redirect_to   An optional redirect_to URL for admin users
     */
    private function redirect_logged_in_user( $redirect_to = null ) {
        $user = wp_get_current_user();
        if ( user_can( $user, 'manage_options' ) ) {
            if ( $redirect_to ) {
                wp_safe_redirect( $redirect_to );
            } else {
                wp_redirect( admin_url() );
            }
        } else {
            wp_redirect( home_url( 'exchange' ) );
        }
    }

    /**
     * Redirect the user after authentication if there were any errors.
     *
     * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
     * @param string            $username   The user name used to log in.
     * @param string            $password   The password used to log in.
     *
     * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
     */
    function maybe_redirect_at_authenticate( $user, $username, $password ) {
        // Check if the earlier authenticate filter (most likely,
        // the default WordPress authentication) functions have found errors
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            if ( is_wp_error( $user ) ) {
                $error_codes = join( ',', $user->get_error_codes() );

                $login_url = home_url( 'member-login' );
                $login_url = add_query_arg( 'login', $error_codes, $login_url );

                wp_redirect( $login_url );
                exit;
            }
        }

        return $user;
    }

    /**
     * Finds and returns a matching error message for the given error code.
     *
     * @param string $error_code    The error code to look up.
     *
     * @return string               An error message.
     */
    private function get_error_message( $error_code ) {
        switch ( $error_code ) {
            case 'empty_username':
                return __( 'Вы ввели пустое имя пользователя!', 'personalize-login' );

            case 'empty_password':
                return __( 'Вы ввели пустой пароль!', 'personalize-login' );

            case 'invalid_username':
                return __(
                    "Пользователь с таки логином не найден, проверьте корректность.",
                    'personalize-login'
                );

            case 'incorrect_password':
                $err = __(
                    "Неверный пароль. <a href='%s'>Забыли пароль?</a>?",
                    'personalize-login'
                );
                return sprintf( $err, wp_lostpassword_url() );

            case 'invalid_email':
            case 'invalidcombo':
                return "Нет пользователя с таким Email";

            // Reset password

            case 'expiredkey':
            case 'invalidkey':
                return "Данная ссылка для сброса пароля уже не актуальная.";

            case 'password_reset_mismatch':
                return "Пароли, которые вы ввели не совпадают."; //__( "The two passwords you entered don't match.", 'personalize-login' );

            case 'password_reset_empty':
                return "Пустой пароль!";//__( "Sorry, we don't accept empty passwords.", 'personalize-login' );

            case 'invalid-captcha':
                return "Неверно введен проверочный код (captcha)!";//__( "Sorry, we don't accept empty passwords.", 'personalize-login' );



            default:
                break;
        }

        return "Неизвестная ошибка. Попробуйте позже.";
    }

    /**
     * Redirect to custom login page after the user has been logged out.
     */
    public function redirect_after_logout() {
        $redirect_url = home_url( 'member-login?logged_out=true' );
        wp_safe_redirect( $redirect_url );
        exit;
    }


    /**
     * Returns the URL to which the user should be redirected after the (successful) login.
     *
     * @param string           $redirect_to           The redirect destination URL.
     * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
     * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
     *
     * @return string Redirect URL
     */
    public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {
        $redirect_url = home_url();

        if ( ! isset( $user->ID ) ) {
            return $redirect_url;
        }

        if ( user_can( $user, 'manage_options' ) ) {
            // Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
            if ( $requested_redirect_to == '' ) {
                $redirect_url = admin_url();
            } else {
                $redirect_url = $requested_redirect_to;
            }
        } else {
            // Non-admin users always go to their account page after login
            $redirect_url = home_url( 'exchange' );
        }

        return wp_validate_redirect( $redirect_url, home_url() );
    }

    /**
     * Redirects the user to the custom "Forgot your password?" page instead of
     * wp-login.php?action=lostpassword.
     */
    public function redirect_to_custom_lostpassword() {
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
            if ( is_user_logged_in() ) {
                $this->redirect_logged_in_user();
                exit;
            }

            wp_redirect( home_url( 'member-password-lost' ) );
            exit;
        }
    }


    /**
     * A shortcode for rendering the form used to initiate the password reset.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_password_lost_form( $attributes, $content = null ) {


        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );

        // Retrieve possible errors from request parameters
        $attributes['errors'] = array();
        if ( isset( $_REQUEST['errors'] ) ) {
            $error_codes = explode( ',', $_REQUEST['errors'] );

            foreach ( $error_codes as $error_code ) {
                $attributes['errors'] []= $this->get_error_message( $error_code );
            }
        }

        if ( is_user_logged_in() ) {
            return __( 'You are already signed in.', 'personalize-login' );
        } else {
            return $this->get_template_html( 'password_lost_form', $attributes );
        }
    }

    /**
     * Initiates password reset.
     */
    public function do_password_lost() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {


            if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
                //echo "Капача правильная";
            }else{
                $redirect_url = home_url( 'member-password-lost' );
                $redirect_url = add_query_arg( 'errors', "invalid-captcha", $redirect_url );
                wp_redirect( $redirect_url );
                exit;
            }
            unset($_SESSION['captcha_keystring']);

            $errors = retrieve_password();


            if ( is_wp_error( $errors ) ) {

                // Errors found
                $redirect_url = home_url( 'member-password-lost' );
                $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
            } else {
                // Email sent
                $redirect_url = home_url( 'member-login' );
                $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
            }

            wp_redirect( $redirect_url );
            exit;
        }
    }

    /**
     * Returns the message body for the password reset mail.
     * Called through the retrieve_password_message filter.
     *
     * @param string  $message    Default mail message.
     * @param string  $key        The activation key.
     * @param string  $user_login The username for the user.
     * @param WP_User $user_data  WP_User object.
     *
     * @return string   The mail message to send.
     */
    public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
        // Create new message
        $msg  = "Привет!\r\n\r\n";
        $msg .= sprintf( "Кто-то запросил сброс пароля для следующей учётной записи: %s" , $user_login ) . "\r\n\r\n";
        $msg .= "Если произошла ошибка, просто проигнорируйте это письмо, и ничего не произойдёт.\r\n\r\n";
        $msg .= "Чтобы сбросить пароль, перейдите по следующей ссылке:\r\n\r\n";
        $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
        $msg .= "Спасибо!\r\n\r\n";
        $msg .= "Команда " . site_url() ."\r\n";

        return $msg;
    }


    /**
     * Redirects to the custom password reset page, or the login page
     * if there are errors.
     */
    public function redirect_to_custom_password_reset() {
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
            // Verify key / login combo
            $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
            if ( ! $user || is_wp_error( $user ) ) {
                if ( $user && $user->get_error_code() === 'expired_key' ) {
                    wp_redirect( home_url( 'member-login?login=expiredkey' ) );
                } else {
                    wp_redirect( home_url( 'member-login?login=invalidkey' ) );
                }
                exit;
            }

            $redirect_url = home_url( 'member-password-reset' );
            $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
            $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

            wp_redirect( $redirect_url );
            exit;
        }
    }


    /**
     * A shortcode for rendering the form used to reset a user's password.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    public function render_password_reset_form( $attributes, $content = null ) {
        // Parse shortcode attributes
        $default_attributes = array( 'show_title' => false );
        $attributes = shortcode_atts( $default_attributes, $attributes );

        if ( is_user_logged_in() ) {
            return __( 'You are already signed in.', 'personalize-login' );
        } else {
            if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
                $attributes['login'] = $_REQUEST['login'];
                $attributes['key'] = $_REQUEST['key'];

                // Error messages
                $errors = array();
                if ( isset( $_REQUEST['error'] ) ) {
                    $error_codes = explode( ',', $_REQUEST['error'] );

                    foreach ( $error_codes as $code ) {
                        $errors []= $this->get_error_message( $code );
                    }
                }
                $attributes['errors'] = $errors;

                return $this->get_template_html( 'password_reset_form', $attributes );
            } else {
                return __( 'Invalid password reset link.', 'personalize-login' );
            }
        }
    }

    /**
     * Resets the user's password if the password reset form was submitted.
     */
    public function do_password_reset() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $rp_key = $_REQUEST['rp_key'];
            $rp_login = $_REQUEST['rp_login'];

            $user = check_password_reset_key( $rp_key, $rp_login );




            if ( ! $user || is_wp_error( $user ) ) {
                if ( $user && $user->get_error_code() === 'expired_key' ) {
                    wp_redirect( home_url( 'member-login?login=expiredkey' ) );
                } else {
                    wp_redirect( home_url( 'member-login?login=invalidkey' ) );
                }
                exit;
            }

            if ( isset( $_POST['pass1'] ) ) {
                if ( $_POST['pass1'] != $_POST['pass2'] ) {
                    // Passwords don't match
                    $redirect_url = home_url( 'member-password-reset' );

                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }

                if ( empty( $_POST['pass1'] ) ) {
                    // Password is empty
                    $redirect_url = home_url( 'member-password-reset' );

                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

                    wp_redirect( $redirect_url );
                    exit;
                }

                // Parameter checks OK, reset password
                reset_password( $user, $_POST['pass1'] );
                wp_redirect( home_url( 'member-login?password=changed' ) );
            } else {
                echo "Invalid request.";
            }

            exit;
        }
    }




}



// Создаем экземпляр класса, там в конструкторе все шоткоды и нужные экшены
$personalize_login_pages_plugin = new Personalize_Login_Plugin();