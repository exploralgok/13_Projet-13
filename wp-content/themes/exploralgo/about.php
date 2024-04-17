<?php
/*
  Template Name: About
*/
	get_header();
	if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>
    <div class="content">

        <div class=hero-row>
            <div class="hero__content">
                <?php the_content(); ?>
            </div>
            <div class="hero__img">
                <img class="img-item" src="<?php echo get_template_directory_uri() . '/assets/images/1.jpg'; ?>" alt="">        

            </div>
        </div>

        <div class="experiences">

            <div class="experiences__section-name">
                <h2 class="experiences__title">Experiences professionnelles</h2>
                <h2 class="experiences__title">Outils de travail</h2>
            </div>

            <div class="experiences__list">
                <?php
                $args = array(
                'post_type' => 'experiences',
                'posts_per_page' => -1 // this will retrive all the post that is published 
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>

                <div class="experiences__details">

                    <div class="experiences__item border-light">
                        <?php the_post_thumbnail('post-thumbnail', ['class' => 'icon']);?>
                        <h2 class="experience__title"><?php the_title(); ?></h2>
                        <p class="experience__duration"><?php the_field("duree"); ?></p>
                        <p class="experience__mission"><?php the_field("description"); ?></p>

                    </div>

                    <div class="experiences__tools border-light">

                        <?php
                            $the_post_id   = get_the_ID();
                            $article_terms = wp_get_post_terms( $the_post_id, [ 'outils' ] );

                            if ( empty( $article_terms ) || ! is_array( $article_terms ) ) {
                                return;
                            }

                            foreach ( $article_terms as $key => $article_term ) {
                                $term_id = $article_term->term_id;
                                $image = get_term_meta($term_id, 'category_image', true);
                                $term_name = $article_term->name;?>
                                <div class="tools-item">
                                    <img class="icon" src=" <?php echo $image ; ?>" />
                                    <p class="tools-name"> <?php echo $term_name ; ?> </p>
                                </div>
                            <?php }
                        ?>  
                </div>   
            </div> 
                <?php endwhile; endif; ?>
        </div>
        </div>

        <div class=formations>
            <h2 class="section-title">Formations</h2>
            <div class=formations__list>
            <?php
                $args = array(
                'post_type' => 'formations',
                'posts_per_page' => -1 // this will retrive all the post that is published 
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>
                    <div class="formations__item border-light">
                        <?php the_post_thumbnail('post-thumbnail', ['class' => 'icon']);?>
                        <h2 class="formations__title"><?php the_title(); ?></h2>
                        <p class="formations__learning"><?php the_field("description"); ?></p>
                        <p class="formations__name"><?php the_field("etablissement"); ?></p>
                        <p class="formations__date"><?php the_field("date"); ?></p>
                    </div>
                <?php endwhile; endif; ?>
            </div>


<?php
    endwhile; endif;
    get_footer();
?>