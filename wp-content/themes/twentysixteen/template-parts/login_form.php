<?php
/**
 * Created by PhpStorm.
 * User: margo
 * Date: 27.12.2016
 * Time: 12:07
 */

// Error messages
$errors = array();
if ( isset( $_REQUEST['login'] ) ) {
    $error_codes = explode( ',', $_REQUEST['login'] );

    foreach ( $error_codes as $code ) {
        $errors []= $this->get_error_message( $code );
    }
}
$attributes['errors'] = $errors;



// Check if user just logged out
$attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;

// Check if user just updated password
$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';


?>


    <?php if ( $attributes['show_title'] ) : ?>
    <h2>Вход в личный кабинет<?php // _e( 'Sign In', 'personalize-login' ); ?></h2>
    <?php endif;   ?>



    <!-- Show errors if there are any -->
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
    <div class="registration-errors"><div>
        <p class="login-error">
        <?php foreach ( $attributes['errors'] as $error ) : ?>

                <br><span class="dashicons dashicons-warning"></span><?php echo $error; ?>

        <?php endforeach; ?>
        </p>
            </div></div>
    <?php endif; ?>

    <!-- Show logged out message if user just logged out -->
    <?php if ( $attributes['logged_out'] ) : ?>
        <p class="login-info">
           Вы успешно вышли с сайта. Можете авторизироваться повторно.
        </p>
    <?php endif; ?>

    <?php if ( $attributes['lost_password_sent'] ) : ?>
        <p class="login-info">
            <span class="dashicons dashicons-warning"></span> На вашу почту отправлена ссылка для сброса пароля. Проверьте Email
        </p>
    <?php endif; ?>

    <?php if ( $attributes['password_updated'] ) : ?>
        <p class="login-info">
            <span class="dashicons dashicons-warning"></span> Ваш пароль изменён. Вы можете войти.
        </p>
    <?php endif; ?>


    <div class="login-form-container">
        <form method="post" action="<?php echo wp_login_url(); ?>">
            <p class="login-username">
                <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
                <input type="text" name="log" id="user_login">
            </p>
            <p class="login-password">
                <label for="user_pass">Пароль<?php // _e( 'Password', 'personalize-login' ); ?></label>
                <input type="password" name="pwd" id="user_pass">
            </p>
            <p class="login-submit">
                <input type="submit" value="Sign In<?php //_e( 'Sign In', 'personalize-login' ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/registration"><button type="button">Sign Up</button></a>
            </p>
        </form>
    </div>


<?php

/*
wp_login_form(
    array(
        'label_username' => __( 'Email', 'personalize-login' ),
        'label_log_in' => __( 'Sign In', 'personalize-login' ),
        'redirect' => $attributes['redirect'],
    )
);
*/

?>

<a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
    Забыли пароль?<?php // _e( 'Forgot your password?', 'personalize-login' ); ?>
</a>

</div>