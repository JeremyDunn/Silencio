<?php
$options = get_theme_mods();

if (isset($options['theme_option_street_txt_input'], $options['theme_option_city_txt_input'], $options['theme_option_state_txt_input'], $options['theme_option_zip_txt_input'])) {
    $directions = silencio_build_directions_url(
        $options['theme_option_street_txt_input'],
        $options['theme_option_city_txt_input'],
        $options['theme_option_state_txt_input'],
        $options['theme_option_zip_txt_input']
    );
}

?>
                </div><!-- .container -->
            </div><!-- #content .site-content -->

            <footer id="colophon" class="site-footer" role="contentinfo">
                <div class="container">
                    <!-- <nav id="footer-nav" role="navigation">
<?php wp_nav_menu(array('theme_location' => 'footer-menu')); ?>
                    </nav> -->

                    <!-- <aside id="footer-widget" role="complementary">
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-sidebar')) {
}
?>
                    </aside> -->

                    <aside class="site-info">
                        <ul class="address" itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                            <li>&#169; <?php echo date('Y');?>  <span itemprop="name"><?php bloginfo('name'); ?></span></li>
<?php
if (!empty($options['theme_option_street_txt_input'])) {
?>
                            <li><span itemprop="street-address"><?php echo $options['theme_option_street_txt_input']; ?></span></li>
<?php
}
if (!empty($options['theme_option_city_txt_input'])) {
?>
                            <li><span itemprop="locality"><?php echo $options['theme_option_city_txt_input']; ?></span>,
<?php
}
if (!empty($options['theme_option_state_txt_input'])) {
?>
                                <span itemprop="region"><?php echo $options['theme_option_state_txt_input']; ?></span>
<?php
}
if (!empty($options['theme_option_zip_txt_input'])) {
?>
                                <span itemprop="postal-code"><?php echo $options['theme_option_zip_txt_input']; ?></span></li>
<?php
}
if (!empty($options['theme_option_phone_txt_input'])) {
?>
                            <li><span itemprop="tel"><?php echo $options['theme_option_phone_txt_input']; ?></span></li>
<?php
}
if (!empty($options['theme_option_email_txt_input'])) {
?>
                            <li><span itemprop="email"><a href="<?php echo $options['theme_option_email_txt_input']; ?>">Email</a></span></li>
<?php
}
?>
                        </ul><!-- .address -->

<?php
if (isset($directions)) {
?>
                        <!-- <div class="directions">
                            <a href="<?php echo $directions ?>"><i class="icon-map-marker"></i> View on a map</a>
                        </div> -->
<?php
}
?>
                        <ul class="social-media">
<?php
if (!empty($options['theme_option_facebook_txt_input'])) {
?>
                            <li><a href="<?php echo $options['theme_option_facebook_txt_input']; ?>"><i class="fa fa-facebook"></i></a></li>
<?php
} if (!empty($options['theme_option_twitter_txt_input'])) {
?>
                            <li><a href="<?php echo $options['theme_option_twitter_txt_input']; ?>"><i class="fa fa-twitter"></i></a></li>
<?php
} if (!empty($options['theme_option_youtube_txt_input'])) {
?>
                            <li><a href="<?php echo $options['theme_option_youtube_txt_input']; ?>"><i class="fa fa-youtube-play"></i></a></li>
<?php
} if (!empty($options['theme_option_googleplus_txt_input'])) {
?>
                            <li><a href="<?php echo $options['theme_option_googleplus_txt_input']; ?>"><i class="fa fa-google-plus"></i></a></li>
<?php
}
?>
                        </ul><!-- .social-media -->
                    </aside><!-- .site-info -->

                   <!--  <aside class="via_tag">
                        <p><a href="http://viastudio.com" rel="external" title="Built by VIA Studio">Built by VIA Studio</a></p>
                    </aside> -->
                </div><!-- .container -->
            </footer><!-- #colophon .site-footer -->
        </div><!-- #page -->
    </div> <!-- .body-wrap -->

<?php wp_footer(); ?>

</body>
</html>
