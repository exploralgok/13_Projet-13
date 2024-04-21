<?php 
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();?>

        <div class="hero-row">
            <div class="hero__content ">
                <h2 class="project-name"><?php the_title();?></h2>
                <div class="project-detail"><?php the_field("description") ;?></div>
                <div class="links">
                    <a class="link-wrapper links__btn btn-secondary btn-icon" href="<?php the_field("lien_du_git") ;?>">
                        <img class="icon" src="<?php echo get_template_directory_uri() . '/assets/images/arrondi.png' ;?>"></img>
                        <p class="cta">J'accède au GitHub</p>
                    </a>
                    <a class="link-wrapper btn-icon links__btn btn-primary" href="<?php the_field("lien_du_site") ;?>">
                        <img class="icon" src="<?php echo get_template_directory_uri() . '/assets/images/site-internet.png' ;?>"></img>
                        <p class="cta">J'accède au site</p>
                    </a>
                </div>
            </div>
            <img class="hero__img"src="<?php the_field("illustration") ;?>" alt="">
        </div>

        <div class="case-study">
            <div class="probleme half-columns">
                <h2 class="first-column title-column">Problème</h2>
                <div class="second-column"><?php the_field("probleme") ;?></div>
            </div>

            <div class="solution half-columns separator-light">
                <h2 class="first-column  title-column ">Solution</h2>
                <div class="second-column"><?php the_field("solution", false) ;?></div>
            </div>
        </div>
        <?php endwhile; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>