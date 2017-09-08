<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

</div><!-- .site-content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer_wrapper">


        <div class="site-info">
            <div class="games-footer-statistic">
                <p> <span class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                            rel="home">UNFREEZE</a>

                    </span>
                    BLESS URSELF

                <!-- Всего курсов: <span>114479</span> Обменников: <span>264/284</span> <span>Обновление: 09:31:27</span>
                    <span>+1 059 868 895 89</span> -->
                    </p>

            </div>


            <nav id="footer-navigation" class="footer-navigation"
                 aria-label="<?php esc_attr_e('Primary Menu', 'twentysixteen'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'bottom',
                    'menu_class' => 'primary-menu',
                    'container_class' => 'primary-menu-container',
                    'container_id' => 'primary-menu-container',
                    'menu_id' => 'primary-menu'
                ));
                ?>
            </nav>


        </div>
       <!-- .site-info -->
    </div>
</footer><!-- .site-footer -->
</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
