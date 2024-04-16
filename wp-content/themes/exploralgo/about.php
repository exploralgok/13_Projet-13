<?php
/*
  Template Name: About
*/
	get_header();
	if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>
	<h1><?php the_title(); ?></h1>
    <div class="content">
        <div>
            <div><?php the_content(); ?>
            </div>
            <img src="<?php echo get_template_directory_uri() . '/assets/images/Logo Exploralgo-2.png'; ?>" alt="">        
        </div>
        <div>

        <h2>experiences</h2>
        <h2>working tools </h2>


        <?php
        $args = array(
        'post_type' => 'experiences',
        'posts_per_page' => -1 // this will retrive all the post that is published 
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
            <h2><?php the_title(); ?></h2>
            <p><?php the_field("duree"); ?></p>
            <p><?php the_field("description"); ?></p>

            <?php
                $the_post_id   = get_the_ID();
                $article_terms = wp_get_post_terms( $the_post_id, [ 'outils' ] );

                if ( empty( $article_terms ) || ! is_array( $article_terms ) ) {
                    return;
                }

                foreach ( $article_terms as $key => $article_term ) {
                    $term_id = $article_term->term_id;
                    $image = get_term_meta($term_id, 'category_image', true);
                    echo '<img src="'.$image.'" />';
                }
             ?>
        </div>        
    <?php endwhile; endif; ?>
    </div>
<?php
	endwhile; endif;
	get_footer();
?>