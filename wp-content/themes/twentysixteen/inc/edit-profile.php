<?php
/**
 * Created by PhpStorm.
 * User: Bohdan
 * Date: 9/21/2017
 * Time: 17:01
 */
function unfreeze_edit_profile_form($password, $website, $bio)
{
    global $wp_http_referer;
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $wp_http_referer = remove_query_arg( array( 'update', 'delete_count', 'user_id' ), $wp_http_referer );
    ?>
    <div class="unfreeze-registration">
    <form action="edit-profile" method="post"<?php do_action('user_edit_form_tag'); ?>>
        <?php wp_nonce_field('update-user_'.$user_id) ?>
        <?php if ($wp_http_referer) : ?>
            <input type="hidden" name="wp_http_referer" value="<?php echo esc_url($wp_http_referer); ?>" />
        <?php endif; ?>
        <p>
            <input type="hidden" name="from" value="profile" />
            <input type="hidden" name="checkuser_id" value="<?php echo $user_id ?>" />
        </p>

    <?php if ( get_option( 'show_avatars' ) ) : ?>
        <tr class="user-profile-picture">
            <th><?php _e( 'Profile Picture' ); ?></th>
            <td>
                <?php echo get_avatar($user_id) ?>
            </td>
        </tr>
        <tr>
            <input type="file" name="edit_avatar" class="">
        </tr>
    <?php endif; ?>
    <div>
        <label for="website">URL</label>
        <input type="text" name="website" value="<?= $user->user_url/*(isset($_POST['website']) ? $website : null)*/ ?>">
    </div>

    <div>
        <label for="bio">OTHER INFORMATION</label>
        <textarea name="bio">'<?= $user->user_description/*(isset($_POST['bio']) ? $bio : null)*/ ?>'</textarea>
    </div>

    <div>
        <label for="password">NEW PASSWORD</label>
        <input type="password" name="password">
    </div>

    <div>
        <p><br>
        <?php echo '
          <img id=_captcha src="/captcha/?' . session_name() . '=' . session_id()
            . '"><br>
            <a href="./" onclick="document.getElementById(\'_captcha\').src = \'/captcha/?<?=session_name()?>=<?=session_id()?>&\'+Math.random(99999999999999999); return false;">
    REFRESH</a><br>';
        ?>
        <label for="bio">CAPTCHA <strong>*</strong></label>
        <input id="keystring" type="text" name="keystring"></p>
    </div>

    <button type="submit" name="submit" value="Edit">Edit</button>
    </form>
    </div>
<?php
}


function editing_validation($password, $website, $bio)
{
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ($password && 5 > strlen($password)) {
        $reg_errors->add('password', 'PASSWORD MUST BE AT LEAST 5 CHARACTERS LONG.'/*'Пароль должен быть больше 5 символов'*/);
    }

    if (!empty($website)) {
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $reg_errors->add('website', 'INVALID WEBSITE LINK.');
        }
    }

    if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
        //echo "Капача правильная";
    }else{
        $reg_errors->add('captcha', 'WRONG CAPTCHA');
    }
    unset($_SESSION['captcha_keystring']);


    if (is_wp_error($reg_errors)) {

        echo '<div class="registration-errors">';

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div>';
            echo '<span class="validation-error">' . $error . '</span>';
            echo '</div>';

        }
        echo '<div>';
    }
}

function complete_editing() {
    global $reg_errors, $password, $website, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_id'       =>   get_current_user_id(),
            'user_pass'     =>   $password,
            'user_url'      =>   $website,
            'description'   =>   $bio,
        );
        $user = wp_update_user( $userdata );

        echo 'Information edited successfully';
    }
}

function custom_editing_function() {

    if ( isset($_POST['submit'] ) ) {
        editing_validation(
            $_POST['password'],
            $_POST['website'],
            $_POST['bio']
        );

        // sanitize user form input
        global $password, $website, $bio;
        $password   =   esc_attr( $_POST['password'] );
        $website    =   esc_url( $_POST['website'] );
        $bio        =   esc_textarea( $_POST['bio'] );

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_editing(
            $password,
            $website,
            $bio
        );
    }

    unfreeze_edit_profile_form(
        $password,
        $website,
        $bio
    );
}

add_shortcode('edit-profile', 'unfreeze_edit_profile');

// The callback function that will replace [book]
function unfreeze_edit_profile()
{
    ob_start();
    custom_editing_function();
    return ob_get_clean();
}

