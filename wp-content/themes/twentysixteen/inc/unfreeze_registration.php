<?php
/**
 * Created by PhpStorm.
 * User: Freelanos
 * Date: 25.10.2016
 * Time: 10:44
 */

function unfreeze_registration_form($username, $password, $email, $website, $first_name, $last_name, $bio)
{

    echo '
    <div class="unfreeze-registration">
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="username">LOGIN <strong>*</strong></label>
    <input type="text" name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
    </div>

    <div>
    <label for="password">PASSWORD <strong>*</strong></label>
    <input type="password" name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
    </div>

    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . (isset($_POST['email']) ? $email : null) . '">
    </div>

    <div>
    <label for="website">Website</label>
    <input type="text" name="website" value="' . (isset($_POST['website']) ? $website : null) . '">
    </div>

    <div>
    <label for="firstname">nickname</label>
    <input type="text" name="fname" value="' . (isset($_POST['fname']) ? $first_name : null) . '">
    </div>

    <!--<div>
    <label for="website">Фамилия</label>
    <input type="text" name="lname" value="' . (isset($_POST['lname']) ? $last_name : null) . '">
    </div> -->

    <div>
    <label for="bio">OTHER INFORMATION</label>
    <textarea name="bio">' . (isset($_POST['bio']) ? $bio : null) . '</textarea>
    </div>

    <div>
    <p><br>
      <img id=_captcha src="/captcha/?' . session_name() . '=' . session_id() . '"><br>
        <a href="./" onclick="document.getElementById(\'_captcha\').src = \'/captcha/?<?=session_name()?>=<?=session_id()?>&\'+Math.random(99999999999999999); return false;">
REFRESH</a><br>
    <label for="bio">CAPTCHA <strong>*</strong></label>
    <input id="keystring" type="text" name="keystring"></p>
    </div>

    <button type="submit" name="submit" value="Register">Sign Up</button>
    </form>
    </div>
    ';


}


function registration_validation($username, $password, $email, $website, $first_name, $last_name, $bio)
{
    global $reg_errors;
    $reg_errors = new WP_Error;

    if (empty($username) || empty($password) || empty($email)) {
        $reg_errors->add('field', 'FILL IN ALL FIELDS WITH *');
    }

    if (4 > strlen($username)) {
        $reg_errors->add('username_length', 'LOGIN MUST BE AT LEAST 4 CHARACTERS LONG.'/*'Имя пользователя слишком короткое. Необходимо минимум 4 символа.'*/);
    }

    if (username_exists($username))
        $reg_errors->add('user_name', 'SORRY THIS NAME '.$username.' ALREADY TAKEN');

    if (!validate_username($username)) {
        $reg_errors->add('username_invalid', 'INVALID USERNAME FORMAT.'/*'Неверный формат имени пользователя'*/);
    }
    if (5 > strlen($password)) {
        $reg_errors->add('password', 'PASSWORD MUST BE AT LEAST 5 CHARACTERS LONG.'/*'Пароль должен быть больше 5 символов'*/);
    }

    if (!is_email($email)) {
        $reg_errors->add('email_invalid', 'WRONG FORMAT OF EMAIL');
    }

    if (email_exists($email)) {
        $reg_errors->add('email', 'Email '.$email. ' already taken!');
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

function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_login'    =>   $username,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'user_url'      =>   $website,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'description'   =>   $bio,
        );
        $user = wp_insert_user( $userdata );

        $login_page = wp_login_url( get_site_url() );
        echo 'Регистрация прошла успешно! Авторизируйтесь  <a href="'.$login_page. '"> на странице входа</a>.';
    }
}

function custom_registration_function() {

    if ( isset($_POST['submit'] ) ) {
        registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['website'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['bio']
        );

        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $bio;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $bio        =   esc_textarea( $_POST['bio'] );

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
            $username,
            $password,
            $email,
            $website,
            $first_name,
            $last_name,
            $bio
        );
    }

    unfreeze_registration_form(
        $username,
        $password,
        $email,
        $website,
        $first_name,
        $last_name,
        $bio
    );
}

add_shortcode( 'unfreeze_registration', 'unfreeze_registration_shortcode' );

// The callback function that will replace [book]
function unfreeze_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}