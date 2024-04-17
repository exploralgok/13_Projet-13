<?php 
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();?>

        <div class="hero-row light-background">
            <div class="hero__content ">
                <h2 class="project-name"><?php the_title();?></h2>
                <div class="project-detail"><?php the_field("description") ;?></div>
            </div>
            <img class="hero__img"src="<?php the_field("illustration") ;?>" alt="">
        </div>

        <div class="case-study">
        <div class="probleme half-columns">
            <h2 class="first-column title-column">Problème</h2>
            <p class=""><?php the_field("probleme") ;?></p>
        </div>

        <div class="solution half-columns separator-light">
            <h2 class="first-column  title-column ">Solution</h2>
            <p class=""><?php the_field("solution", false) ;?></p>
        </div>

        <div class="resultat separator-light">
            <h2 class="first-column title-column">Résultat</h2>
            <p class="second-column"><?php the_field("resultat") ;?></p>
            <div class="half-columns">
                <div class="">
                    <h3>Avant</h3>
                    <img class="" src="<?php the_field("avant") ;?>" alt="">
                </div>
                <div>
                    <h3>Après</h3>
                    <img class="" src="<?php the_field("apres") ;?>" alt="">
                </div>
            </div>
        </div>
        </div>
        <?php endwhile; ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>