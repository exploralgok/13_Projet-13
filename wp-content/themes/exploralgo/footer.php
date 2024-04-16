</div><!-- .site-content -->

<footer id="colophon" class="site-footer" role="contentinfo">

        <div class="footer__contact now">
            <h2 class="title">Vous avez un projet ?</h2>
            <p class="subtitle">Construisons-le <span class="word-highlight">ensemble</span></p>
            <div class="details-contact">
                <a class="footer__whatsapp btn-contact btn-icon" target='_blank' href="https://wa.me/33605742162">
                    <img class='icon' src="<?php echo get_template_directory_uri() . '/assets/images/whatsapp.svg';?>"></img>
                    <p class="contact">+33 6 05 74 21 62</p>
                </a>
                <a class="footer__mail btn-contact btn-icon" taget='_blank' href="mailto:contact@exploralgo.fr">
                    <img class='icon' src="<?php echo get_template_directory_uri() . '/assets/images/envelope-regular.svg';?>"></img>
                    <p class="contact">contact@exploralgo.fr</p>
                </a>
            </div>
        </div>

        <div class="footer__contact later" >
            <p class="title regular-size">Restons en contact <3</p>
            <div class="footer__social-media">
                <?php 
                    wp_nav_menu ( array (
                        'theme_location' => 'footer-menu' ,
                        'menu_class' => 'menu-footer', 
                    ) ); 
                ?>
                <div class="footer__newsletter">NL</div>
            </div>
            <p class="title small-size">Fait à la main, en France, avec amour et sur Wordpress 🤍</p>
        </div>

    </div>

</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>
</body>

</html>