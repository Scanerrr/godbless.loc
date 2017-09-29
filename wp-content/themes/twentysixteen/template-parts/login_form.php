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

$current_url = rtrim($_SERVER["REQUEST_URI"], '/');
?>


    <?php if ( $attributes['show_title'] ) : ?>
    <h2>Вход в личный кабинет<?php // _e( 'Sign In', 'personalize-login' ); ?></h2>
    <?php endif;   ?>



    <!-- Show errors if there are any -->
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
    <div class="registration-errors"><div>
        <p class="login-error">
        <?php foreach ( $attributes['errors'] as $error ) : ?>

                <br><span class="validation-error"><?php echo $error; ?></span>

        <?php endforeach; ?>
        </p>
            </div></div>
    <?php endif; ?>

    <!-- Show logged out message if user just logged out -->
    <?php if ( $attributes['logged_out'] ) : ?>
        <p class="login-info">
            You have just log out but you can log in again.
        </p>
    <?php endif; ?>

    <?php if ( $attributes['lost_password_sent'] ) : ?>
        <p class="login-info">
            <span class="validation-error" style="color: inherit">Please check your email, the email was sent.</span>
        </p>
    <?php endif; ?>

    <?php if ( $attributes['password_updated'] ) : ?>
        <p class="login-info">
            <span class="validation-error">Ваш пароль изменён. Вы можете войти.</span>
        </p>
    <?php endif; ?>


    <div class="login-form-container">
        <form method="post" action="<?php echo wp_login_url(); ?>">
            <p class="login-username">
                <label for="user_login"><?php _e( 'EMAIL OR LOGIN', 'personalize-login' ); ?></label>
                <input type="text" name="log" id="user_login">
            </p>
            <p class="login-password">
                <label for="user_pass">PASSWORD<?php // _e( 'Password', 'personalize-login' ); ?></label>
                <input type="password" name="pwd" id="user_pass">
            </p>
            <p class="login-submit">
                <input type="submit" value="Sign In<?php //_e( 'Sign In', 'personalize-login' ); ?>">&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="/registration"><button type="button">Sign Up</button></a>
                <?php
                /* ADD REDIRECT FIELD IF NOT DEFAULT LOGIN PAGE */
                if (get_page_uri() != 'member-login'): ?>
                    <input type="hidden" name="redirect_to" value="<?php echo home_url() . $current_url ?>">
                <?php endif; ?>
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
    Forgot your password?<?php // _e( 'Forgot your password?', 'personalize-login' ); ?>
</a>

</div>