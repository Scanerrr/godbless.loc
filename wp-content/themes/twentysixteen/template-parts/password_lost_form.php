<?php
/**
 * Created by PhpStorm.
 * User: margo
 * Date: 27.12.2016
 * Time: 12:07
 */

?>
<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
    <div class="password-lost-errors"><div>
    <?php foreach ( $attributes['errors'] as $error ) :  ?>
        <p>

            <br><span class="dashicons dashicons-warning"></span><?php echo $error; ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>


<div id="password-lost-form" class="widecolumn">
    <?php if ( $attributes['show_title'] ) : ?>
    <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
<?php endif; ?>

<p>
    <?php
    _e(
        "Введите ваш Email и мы отправим вам ссылку для сброса пароля",
        'personalize_login'
    );
    ?>
</p>

<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    <p class="form-row">
        <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?>
            <input type="text" name="user_login" id="user_login">
    </p>

        <p>
        <?php echo '<img id=_captcha src="/captcha/?' . session_name() . '=' . session_id() . '"><br>
        <a href="./" onclick="document.getElementById(\'_captcha\').src = \'/captcha/?<?=session_name()?>=<?=session_id()?>&\'+Math.random(99999999999999999); return false;">
            Обновить код</a><br><br>
        <label for="bio">Проверочный код (captcha) *</label>
        <input id="keystring" type="text" name="keystring">'; ?>
    </p>

    <p class="lostpassword-submit">
        <input type="submit" name="submit" class="lostpassword-button"
               value="Сбросить пароль<?php //_e( 'Reset Password', 'personalize-login' ); ?>"/>
    </p>


</form>
</div>