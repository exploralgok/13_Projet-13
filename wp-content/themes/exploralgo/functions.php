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

// NL

function enqueue_my_script() {
  wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/assets/js/ajax.js', array('jquery'));
  wp_localize_script('my-ajax-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_my_script');

function montraitement_callback() {
  $formData = $_POST['formData'];

  // Récupérer les données du formulaire
  parse_str($formData, $formFields);

  // Récupérer l'email soumis
  $email = sanitize_email($formFields['email']);

  // Vérifier si l'utilisateur existe déjà
  $user_id = email_exists($email);

  if (!$user_id) {
      // Si l'utilisateur n'existe pas, enregistrer un nouvel utilisateur
      $password = wp_generate_password(12, false);
      $user_id = wp_create_user($email, $password, $email);
      if (!is_wp_error($user_id)) {
          // Ajouter le rôle d'abonné à l'utilisateur
          $user = new WP_User($user_id);
          $user->set_role('subscriber');
      } else {
          // Gérer les erreurs si la création de l'utilisateur échoue
          echo 'Une erreur s\'est produite lors de la création de l\'utilisateur.';
          wp_die();
      }
  }

  echo 'Votre message a été envoyé avec succès !';
  wp_die();
}
add_action('wp_ajax_montraitement', 'montraitement_callback');
add_action('wp_ajax_nopriv_montraitement', 'montraitement_callback');


// Page d'options

/**
 * Add a new options page named "Contact".
 */
function contact_register_options_page() {
  add_menu_page(
      'Contact',
      'Contact',
      'manage_options',
      'contact_options',
      'contact_options_page_html'
  );
}
add_action( 'admin_menu', 'contact_register_options_page' );

/**
* The "Contact" page html.
*/
function contact_options_page_html() {
  if ( ! current_user_can( 'manage_options' ) ) {
      return;
  }

  if ( isset( $_GET['settings-updated'] ) ) {
      add_settings_error(
          'contact_options_mesages',
          'contact_options_message',
          esc_html__( 'Settings Saved', 'text_domain' ),
          'updated'
      );
  }

  settings_errors( 'contact_options_mesages' );

  ?>
  <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
          <?php
              settings_fields( 'contact_options_group' );
              do_settings_sections( 'contact_options' );
              submit_button( 'Enregistrer les paramètres' );
          ?>
      </form>
  </div>
  <?php
}

/**
 * Register our settings.
 */
function contact_register_settings() {
  register_setting( 'contact_options_group', 'contact_options' );

  add_settings_section(
      'contact_options_sections',
      false,
      false,
      'contact_options'
  );

  add_settings_field(
      'contact_option_tel',
      esc_html__( 'Téléphone', 'text_domain' ),
      'render_contact_option_tel_field',
      'contact_options',
      'contact_options_sections',
      [
          'label_for' => 'contact_option_tel',
      ]
  );

  add_settings_field(
    'contact_option_mail',
    esc_html__( 'E-mail', 'text_domain' ),
    'render_contact_option_mail_field',
    'contact_options',
    'contact_options_sections',
    [
        'label_for' => 'contact_option_mail',
    ]
);

}
add_action( 'admin_init', 'contact_register_settings' );

/**
 * Render the "my_option_1" field.
 */
function render_contact_option_tel_field( $args ) {
  $value = get_option( 'contact_options' )[$args['label_for']] ?? '';
  ?>
  <input
      type="text"
      id="<?php echo esc_attr( $args['label_for'] ); ?>"
      name="contact_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
      value="<?php echo esc_attr( $value ); ?>">
  <p class="description"><?php esc_html_e( 'This is a description for our field.', 'text_domain' ); ?></p>
  <?php
}

function render_contact_option_mail_field( $args ) {
  $value = get_option( 'contact_options' )[$args['label_for']] ?? '';
  ?>
  <input
      type="text"
      id="<?php echo esc_attr( $args['label_for'] ); ?>"
      name="contact_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
      value="<?php echo esc_attr( $value ); ?>">
  <p class="description"><?php esc_html_e( 'This is a description for our field.', 'text_domain' ); ?></p>
  <?php
}


//  Envoie d'email

// Fonction pour envoyer un e-mail aux abonnés lorsqu'un nouvel article est publié
function envoyer_email_nouvel_article($post_id) {
  // Vérifie si l'article est nouvellement publié
  if (get_post_status($post_id) === 'publish') {
      // Récupère les abonnés du site
      $abonnes = get_users(array('role' => 'subscriber'));

      // Récupère les détails de l'article publié
      $article = get_post($post_id);
      $titre_article = $article->post_title;
      $contenu_article = $article->post_content;

      // Charge le contenu HTML du modèle d'e-mail
      $template_path = get_template_directory() . '/email_template.html';
      $email_template = file_get_contents($template_path);

      // Remplace les balises de substitution par les valeurs réelles
      $email_template = str_replace('{{TITRE_ARTICLE}}', $titre_article, $email_template);
      $email_template = str_replace('{{CONTENU_ARTICLE}}', $contenu_article, $email_template);

      // Construit le contenu de l'e-mail
      $sujet = 'Nouvel article publié : ' . $titre_article;

      // Envoie l'e-mail à chaque abonné
      foreach ($abonnes as $abonne) {
          wp_mail($abonne->user_email, $sujet, $email_template);
      }
  }
}

// Ajoute un crochet pour déclencher la fonction lorsqu'un nouvel article est publié
add_action('publish_post', 'envoyer_email_nouvel_article');
