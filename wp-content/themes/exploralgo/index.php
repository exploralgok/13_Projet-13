<?php get_header(); ?>

<div class="hero">
    <h1 class="hero__title">Je crée votre site web sur mesure pour donner vie à <span class="highlight-word">vos idées</span> </h1>
    <a class="hero__btn btn-primary" href="#colophon">
        <p class='cta'>Discutons-en</p>
        <img class='icon' src="<?php echo get_template_directory_uri() . '/assets/images/right-arrow.png'?>;" alt="">
    </a>
</div>


<div class="gallery">
    <h2 class="gallery__title">Mes réalisations</h2>
    <div class="gallery__content">

        <?php
        $args = array(
        'post_type' => 'projets',
        'posts_per_page' => -1 // this will retrive all the post that is published 
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
            <div class="gallery__illu"><?php the_post_thumbnail();?></div>
            <div class="gallery__text">
                <div class="project-summary">
                    <div class="project-name"><?php the_title(); ?></div>

                    <?php
                    $the_post_id   = get_the_ID();
                    $article_terms = wp_get_post_terms( $the_post_id, [ 'outils' ] );

                    if ( empty( $article_terms ) || ! is_array( $article_terms ) ) {
                        return;
                    }
                    ?>
                    <div class="project-tools">
                        <?php
                        foreach ( $article_terms as $key => $article_term ) {
                            ?>
                            <a class="project-tools__item" href="<?php echo esc_url( get_term_link( $article_term ) ); ?>">
                                <?php echo esc_html( $article_term->name ); ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <a href="<?php echo get_permalink()?>">
                    <button class="see-more btn-secondary">
                        <img class="icon" src="<?php echo get_template_directory_uri() . '/assets/images/right-arrow.png' ;?>" alt="">
                    </button>
                </a>
                
            </div>

                <?php
            endwhile;
        endif;
        ?>
    </div>

</div>

<div class='about'>
    <h2 class="about__title">Dans l’ombre pour mettre en lumière votre projet</h2>
    <p class="about__text">Concentrez-vous sur votre objectif principal : le développement de votre activité, et confiez-moi le soin de veiller à ce que la technologie utilisée soit alignée à vos objectifs stratégiques et qu'elle contribue à votre succès à long terme.</p>
    <a class="btn-secondary btn-icon" href="<?php echo get_permalink( 31 )?>">
        <p class="cta">Qui suis-je ?</p>
        <img class='icon' src="<?php echo get_template_directory_uri() . '/assets/images/right-arrow.png'?>;" alt="">
    </a>
</div>
<?php get_footer(); ?>