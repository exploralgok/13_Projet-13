<?php

foreach(glob(get_template_directory() . "/inc/*.php") as $file){
  require $file;
}

 add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
 function theme_enqueue_scripts() {
    // chargement css
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/assets/css/main.css'
    );

    // chargement js
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/assets/js/custom.js', ["jquery"]);
    wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/assets/js/ajax.js', ["jquery"]);

    $translation_array = array( 'templateUrl' => get_template_directory_uri() );
    //after wp_enqueue_script
    wp_localize_script( 'custom-script', 'object_name', $translation_array );
    wp_localize_script( 'ajax-script', 'object_name', $translation_array );

    // Passer l'URL Ajax depuis PHP vers JavaScript
    wp_localize_script('custom-script', 'ajaxurl', array(admin_url( 'admin-ajax.php' )) );
    wp_localize_script('ajax-script', 'ajaxurl', array(admin_url( 'admin-ajax.php' )) );
 }

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// encodning apostrophe
add_filter('run_wptexturize', '__return_false');

// gestion des images à la une 
add_theme_support( 'post-thumbnails' );

// Emplacement des menus
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Menu Header' ),
            'footer-menu' => __( 'Menu Footer' ),
            )
    );
  }

  // problème upload image large
  add_filter( 'big_image_size_threshold', '__return_false' );

  function wpb_image_editor_default_to_gd( $editors ) {
    $gd_editor = 'WP_Image_Editor_GD';
    $editors = array_diff( $editors, array( $gd_editor ) );
    array_unshift( $editors, $gd_editor );
    return $editors;
}
add_filter( 'wp_image_editors', 'wpb_image_editor_default_to_gd' );

/// add img to taxonomy

function taxonomy_add_custom_field() {
  ?>
  <div class="form-field term-image-wrap">
      <label for="cat-image"><?php _e( 'Image' ); ?></label>
      <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
      <input type="text" name="category_image" id="cat-image" value="" size="40" />
  </div>a
  <?php
}
add_action( 'outils_add_form_fields', 'taxonomy_add_custom_field', 10, 2 );

function taxonomy_edit_custom_field($term) {
  $image = get_term_meta($term->term_id, 'category_image', true);
  ?>
  <tr class="form-field term-image-wrap">
      <th scope="row"><label for="category_image"><?php _e( 'Image' ); ?></label></th>
      <td>
          <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p><br/>
          <input type="text" name="category_image" id="cat-image" value="<?php echo $image; ?>" size="40" />
      </td>
  </tr>
  <?php
}
add_action( 'outils_edit_form_fields', 'taxonomy_edit_custom_field', 10, 2 );

function aw_include_script() {
 
  if ( ! did_action( 'wp_enqueue_media' ) ) {
      wp_enqueue_media();
  }

  wp_enqueue_script( 'awscript', get_stylesheet_directory_uri() . '/assets/js/awscript.js', array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'aw_include_script' );

function save_taxonomy_custom_meta_field( $term_id ) {
  if ( isset( $_POST['category_image'] ) ) {
      update_term_meta($term_id, 'category_image', $_POST['category_image']);
  }
}  
add_action( 'edited_outils', 'save_taxonomy_custom_meta_field', 10, 2 );  
add_action( 'create_outils', 'save_taxonomy_custom_meta_field', 10, 2 );