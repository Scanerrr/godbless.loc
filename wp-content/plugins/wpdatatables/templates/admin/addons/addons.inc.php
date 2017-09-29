<div class="wrap wdt-datatables-admin-wrap">
    <?php do_action('wpdatatables_admin_before_addons'); ?>

    <!-- .container -->
    <div class="container">

        <!-- .row -->
        <div class="row">

            <div class="card Addons">

                <!-- Preloader -->
                <?php include WDT_TEMPLATE_PATH . 'admin/common/preloader.inc.php'; ?>
                <!-- /Preloader -->

                <div class="card-header wdt-admin-card-header ch-alt">
                    <img id="wpdt-inline-logo" style="width: 60px;height: 50px;"
                         src="<?php echo WDT_ROOT_URL; ?>assets/img/logo-large.png"/>
                    <h2>
                        <span title="<?php _e('Addons for the plugin', 'wpdatatables'); ?>">wpDataTables Addons</span>
                        <small class="m-r-25">
                            <?php _e('Unique extensions for wpDataTables', 'wpdatatables'); ?>
                        </small>
                    </h2>
                </div>

                <div class="card-body card-padding">

                    <div class="alert alert-info" role="alert">
                        <span class="wdt-alert-title f-600"><?php _e('About Addons', 'wpdatatables'); ?></span><br>
                        <span class="wdt-alert-subtitle"><?php _e('While wpDataTables itself provides quite a large amount of features and unlimited customisation flexibility, you can achieve even more with our premium addons. Each addon brings you some unique extension to the core functionality. There will be more addons developed over time by wpDataTables creators and 3rd party developers, so stay tuned.', 'wpdatatables'); ?></span>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="thumbnail">
                                <a href="http://wpreportbuilder.com?utm_source=wpdt" target="_blank">
                                    <img class="img-responsive" src="<?php echo WDT_ASSETS_PATH; ?>/img/addons/report-builder.png" alt="">
                                </a>
                                <div class="caption">
                                    <h4><?php _e('Report Builder', 'wpdatatables'); ?></h4>
                                    <p><?php _e('A unique tool that allows you to generate almost any Word DOCX and Excel XLSX documents filled in with actual data from your database.', 'wpdatatables'); ?></p>
                                    <div class="m-b-5">
                                        <a href="http://wpreportbuilder.com?utm_source=wpdt" target="_blank" class="btn btn-sm btn-icon-text btn-primary waves-effect" role="button"><?php _e('Find out more ', 'wpdatatables'); ?>
                                            <i class="zmdi zmdi-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div>

    </div>
    <!-- /.container -->

</div>
<!-- /.wdt-datatables-admin-wrap .wrap -->