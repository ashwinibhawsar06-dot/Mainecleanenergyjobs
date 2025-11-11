<?php 
// Enqueue parent theme style
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});

// Enqueue child theme style
add_action( 'wp_enqueue_scripts', function () {
      $theme = wp_get_theme();
    $version = $theme->get( 'Version' ) . '.' . time(); // Appending timestamp to the version
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), $version );
    wp_enqueue_style( 'child-style2',  'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css', array('parent-style'), $version );
    wp_enqueue_style( 'child-style1',  'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array('parent-style'), $version );
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');
});

// Enqueue additional styles or scripts in child theme
add_action( 'wp_enqueue_scripts', function () {
  wp_enqueue_style( 'bootstrap-select1', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', array('child-style'), '4.0.0' );
  wp_enqueue_script( 'script3', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '4.0.0', true );
  wp_enqueue_script('bootstrap3-typeahead', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js', true );
  //  wp_enqueue_script( 'script1', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array('jquery'), '3.2.1', true );
  // wp_enqueue_script( 'script2', 'https://code.jquery.com/jquery-3.2.1.min.js', array('jquery'), '3.2.1', true );
  wp_enqueue_script('', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array('jquery'), '4.2.1', true );
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() .'/custom.js', array('jquery'), true );
  wp_localize_script( 'custom-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
  wp_enqueue_script('leaflet', 'https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js', true );
  wp_enqueue_script('Geocoder Js', 'https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js', true );
  wp_enqueue_script('typeahead bundle Js', 'https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', true );

});
// function enqueue_custom_scripts() {
//     wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/custom.js', array('jquery'), '1.0', true );   
// }
// add_action( 'wp_enqueue_scripts', 'enqueue_custom_scripts' );

// Wp v4.7.1 and higher
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
  $filetype = wp_check_filetype( $filename, $mimes );
  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

// Update the post thumbnail on form submission
add_action('gform_after_submission', 'set_featured_image', 10, 2);
function set_featured_image($entry, $form) {
    // Get the post ID from the form submission
    $post_id = rgar($entry, 'post_id');

    // Get the URL of the uploaded image from the form field
    $image_url = rgar($entry, 'input_2_24'); // Change 'input_1' to the actual field ID

    // Set the image as the post thumbnail
    if ($post_id && $image_url) {
        $image_id = media_sideload_image($image_url, $post_id, '', 'id');
        set_post_thumbnail($post_id, $image_id);
    }
}
add_filter( 'gform_userregistration_login_form', 'change_login_username', 10, 1 );
function change_login_username( $form ) {
    $fields = $form['fields'];
    foreach ( $fields as &$field ) {
        if ( $field->label == 'Username' ) {
            $field->label = 'Email';
        }
    }
    return $form;
}
add_filter( 'gform_userregistration_login_form', function ( $form ) {
 
    // Remove Remember Me field.
    unset ( $form['fields']['2'] );
 
return $form;
} );

// Redirect users after login
add_action('wp_login', 'custom_redirect_after_login', 10, 2);

function custom_redirect_after_login($user_login, $user) {
    $user_roles = $user->roles;
    if (in_array('jobsearch_employer', $user_roles)) {

        wp_redirect(home_url('/employer-profile/'));
    }
    elseif (in_array('jobsearch_candidate', $user_roles)) {


        wp_redirect(home_url('/job-seeker-profile/'));
    }
    else {
        wp_redirect( admin_url() );
    }
    exit;
}


add_filter('cron_schedules', 'add_custom_cron_intervals');
function add_custom_cron_intervals($schedules) {
    $schedules['every_15_min'] = array(
        'interval' => 900,
        'display'  => __('Every 15 Minutes'),
    );
    return $schedules;
}

/*Add Page Slug Class in Body*/
function pine_add_page_slug_body_class( $classes ) {
    global $post;
    global $current_user;
    $user_role = array_shift($current_user->roles);
    $classes[] = $user_role;
  
  if (is_user_logged_in()) {
        $classes[] = 'user-login';
    } else {
        $classes[] = 'user-logout';
    }

    return $classes;
}
add_filter( 'body_class', 'pine_add_page_slug_body_class' );

// Registering a new menu location with a hint
function register_fullscreen_menu_column_1_location() {
    register_nav_menus( array(
        'fullscreen-menu-column-1' => esc_html__( 'FullScreen Menu Column 1', 'pro' ),
    ) );
}
add_action( 'after_setup_theme', 'register_fullscreen_menu_column_1_location' );


function register_fullscreen_menu_column_2_location() {
    register_nav_menus( array(
        'fullscreen-menu-column-2' => esc_html__( 'FullScreen Menu Column 2', 'pro' ),
    ) );
}
add_action( 'after_setup_theme', 'register_fullscreen_menu_column_2_location' );


function register_fullscreen_menu_column_3_location() {
    register_nav_menus( array(
        'fullscreen-menu-column-3' => esc_html__( 'FullScreen Menu Column 3', 'pro' ),
    ) );
}
add_action( 'after_setup_theme', 'register_fullscreen_menu_column_3_location' );

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"sub-menu navItem-inner\">\n";
    }
    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }
}

function third_party_tracking_code() { ?>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-G9RZEHX4SW"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-G9RZEHX4SW');
  </script>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NVCC4VWX');</script>
  <!-- End Google Tag Manager -->
  <?php 
}
add_action( 'wp_head', 'third_party_tracking_code' ); 

// Register custom post statuses on 'init'
add_action('init', 'register_custom_post_statuses');
function register_custom_post_statuses() {
    // Register custom post status for "publishing"
    register_post_status('publishing', array(
        'label'                     => _x('Publishing', 'job'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Publishing <span class="count">(%s)</span>', 'Publishing <span class="count">(%s)</span>')
    ));

    // Register custom post status for "unpublishing"
    register_post_status('unpublishing', array(
        'label'                     => _x('Unpublishing', 'job'),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Unpublishing <span class="count">(%s)</span>', 'Unpublishing <span class="count">(%s)</span>')
    ));

    // Register custom post status for "expired"
    register_post_status('expired', array(
        'label'                     => _x('Expired', 'job'),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>')
    ));
}

// Add custom statuses to the post status dropdown
add_filter('display_post_states', 'add_custom_post_status_to_display', 10, 2);
function add_custom_post_status_to_display($post_states, $post) {
    if (get_post_type($post->ID) === 'job') {
        if ($post->post_status === 'publishing') {
            $post_states[] = __('Publishing', 'textdomain');
        } elseif ($post->post_status === 'unpublishing') {
            $post_states[] = __('Unpublishing', 'textdomain');
        }elseif ($post->post_status === 'expired') {
            $post_states[] = __('expired', 'textdomain');
        }
    }
    return $post_states;
}

// Add custom statuses to the post status dropdown options
add_action('admin_footer-post.php', 'append_post_status_list');
add_action('admin_footer-post-new.php', 'append_post_status_list');
function append_post_status_list() {
    global $post, $post_type;
    if ($post_type === 'job') {
        if ($post->post_status === 'publishing' || $post->post_status === 'unpublishing' || $post->post_status === 'expired') {
            echo '
            <script type="text/javascript">
            jQuery(document).ready(function($){
                $("select#post_status").append("<option value=\"publishing\" ' . selected($post->post_status, 'publishing', false) . '>Publishing</option>");
                $("select#post_status").append("<option value=\"unpublishing\" ' . selected($post->post_status, 'unpublishing', false) . '>Unpublishing</option>");
                ("select#post_status").append("<option value=\"expired\" ' . selected($post->post_status, 'expired', false) . '>expired</option>");
            });
            </script>
            ';
        } else {
            echo '
            <script type="text/javascript">
            jQuery(document).ready(function($){
                $("select#post_status").append("<option value=\"publishing\">Publishing</option>");
                $("select#post_status").append("<option value=\"unpublishing\">Unpublishing</option>");
                $("select#post_status").append("<option value=\"expired\">expired</option>");
            });
            </script>
            ';
        }
    }
}

function custom_content_after_body_open_tag() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVCC4VWX" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
add_action('wp_body_open', 'custom_content_after_body_open_tag');

// custom post news & events
require_once( __DIR__ . '/function_assets/event.php');

// get employer data and search with elastic search
require_once( __DIR__ . '/function_assets/employer.php');

// custom post type Training data
require_once( __DIR__ . '/function_assets/training.php');

// custom post type Jobs
require_once( __DIR__ . '/function_assets/job.php');

// For saving and unsave posts
require_once( __DIR__ . '/function_assets/save-unsave-post.php');

// code to run post insertion with cron
require_once( __DIR__ . '/function_assets/cron_jobs_insertion.php');

// code to add job index insertion and edit at setting option
require_once( __DIR__ . '/function_assets/search_index_form_with_insertion.php');

// For Job approved or reject
require_once( __DIR__ . '/function_assets/job_approval_functions.php');

// For Job side category
require_once( __DIR__ . '/function_assets/get_category_from_elastic.php');

// For user approval after registration
require_once( __DIR__ . '/function_assets/user-approval.php');

// For user approval with cron after registration
require_once( __DIR__ . '/function_assets/user-approval-cron.php');

// For make jobs expire after 60 days
require_once( __DIR__ . '/function_assets/expired_jobs.php');

// For check the status of elastic search is up or not
require_once( __DIR__ . '/function_assets/elastic_status_check.php');
require_once( __DIR__ . '/function_assets/cron_status_check.php');

function convertToDaysAgo($timestampStr) {
    $timestamp = new DateTime($timestampStr);
    $currentTime = new DateTime();
    $difference = $currentTime->getTimestamp() - $timestamp->getTimestamp();
    $daysAgo = floor($difference / (60 * 60 * 24));
    if ($daysAgo == 0) {
        return "Today";
    } elseif ($daysAgo == 1) {
        return "1 day ago";
    } else {
        return "$daysAgo days ago";
    }
}


if (!wp_next_scheduled('my_cron_hook')) {
    wp_schedule_event(time(), 'every_minute', 'my_cron_hook');
}

// Define the interval for every minute
function add_every_minute_schedule($schedules) {
    $schedules['every_minute'] = array(
        'interval' => 60,
        'display'  => __('Every Minute')
    );
    return $schedules;
}
add_filter('cron_schedules', 'add_every_minute_schedule');

function employers_job_data(){
  ob_start();
  // Get form values from URL query parameters
  $post_type = isset($_GET['posttype']) ? $_GET['posttype'] : '';
  $keyword = isset($_GET['keywaord']) ? $_GET['keywaord'] : '';
  $location = isset($_GET['location']) ? $_GET['location'] : '';

  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $meta_query = array('relation' => 'OR');
  if (!empty($location)) {
      $meta_query[] = array(
          'key'     => 'Address',
          'value'   => $location,
          'compare' => 'LIKE',
      );
      $meta_query[] = array(
          'key'     => 'City',
          'value'   => $location,
          'compare' => 'LIKE',
      );
      $meta_query[] = array(
          'key'     => 'Country',
          'value'   => $location,
          'compare' => 'LIKE',
      );
  }
  if (!empty($keyword)) {
      $meta_query[] = array(
          'key'     => 'Degree Outcome',
          'value'   => $keyword,
          'compare' => 'LIKE',
      );
      $meta_query[] = array(
          'key'     => 'Name of Organization',
          'value'   => $keyword,
          'compare' => 'LIKE',
      );
  }
  $formargs = array(
      'post_type'       => 'job',
      'post_status'     => 'publish',
      'orderby'         => 'date',
      'order'           => 'DESC',
      //'s'               => $keyword,
      'posts_per_page'  => 10, // Number of posts per page
      'paged'           => $paged, // Current page number
      'meta_query'      => $meta_query

  );

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $formargs['paged'] = $paged;

    $query = new WP_Query($formargs);
    $total_posts = $query->found_posts; // Total number of posts found

    $start_index = ($paged - 1) * $formargs['posts_per_page'] + 1;
    $end_index = min($paged * $formargs['posts_per_page'], $total_posts); 
  if ($query->have_posts()) {
      echo '<div id="employers_results">';
        echo '<ul class="job-listings">';
        $training_count = 0;
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $job_title   = get_the_title();
            $job_permalink = get_the_permalink();
            $job_date = get_post_meta($post_id, 'event_date', true );

            $job_city = get_post_meta($post_id, 'City', true );
            $job_country = get_post_meta($post_id, 'Country', true );
            $job_employer = get_post_meta($post_id, 'employer', true );

            $job_location0 = get_post_meta($post_id, 'address', true );
            if (substr($job_location0, 0, 1) === ',') {
              $job_location = substr($job_location0, 2);
            } else {
              $job_location = $job_location0;
            }
            $job_image = get_the_post_thumbnail();

            $timestampStr = get_post_meta($post_id, 'updated_on', true );
            $result = convertToDaysAgo($timestampStr);
            
            // Check if the post is saved
            $is_post_saved = is_post_saved($post_id);
            $bookmark_image_url = $is_post_saved ? home_url('/wp-content/uploads/2024/02/bookmark.png') : home_url('/wp-content/uploads/2024/01/asd2.svg');

            echo '<li class="job-listing-list">';
       
              echo '<div class="job-details">';
                echo '<div class="job-details-inner">';
                
                  echo '<h3 class="job-title ppp"><a href="'.esc_html($job_permalink).'">'.esc_html($job_employer).'</a></h3>';
                  if ($job_location) {
                  echo '<p class="job-compnay-name"><a href="'.esc_html($job_permalink).'">'.esc_html($job_location).'</a></p>';
                  }
                echo '</div>';
                echo '<div class="job-icon">';
                  echo '<span class="jobicon-share" post-id="'.$post_id.'">';
                    echo '<img decoding="async" src="' . $bookmark_image_url . '" data="' . $post_id . '">';
                  echo '</span>';
                  echo '<span class="post-title">' . $result . '</span>';
                echo '</div>';
              echo '</div>';
            echo '</li>';
            $training_count++;
        }
        echo '</ul>';
        echo '<script>jQuery("#post_count").html('.$total_posts.')</script>';  
        echo '<div class="resultnumber-sec">';
        echo '<div class="re-num"><span>' . $start_index . ' - ' . $end_index . ' of ' . $total_posts . '</span></div>';
        echo '<div class="pagination-links pagination">';
        // Pagination
        $big = 999999999;
        echo paginate_links(array(
            'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'  => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total'   => $query->max_num_pages,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;'
        ));
        echo '</div>';
        echo '</div>';    
      echo '</div>';
  } else {
      echo 'No posts found.';
  }

  return ob_get_clean();
}
add_shortcode('employers_job_data', 'employers_job_data');

function bulkdata_opensearch_insertion(){
  global $wpdb;
  $query = "select pm.post_id as post_id,concat('{\"id\":\"',pm.post_id,'\",\"post_title\":\"',po.post_title,'\",',GROUP_CONCAT(CONCAT('\"',pm.meta_key, '\":\"', pm.meta_value,'\"') SEPARATOR ','),'}') as source from wp_posts po inner join wp_postmeta pm on po.id = pm.post_id where po.post_type='job' and pm.meta_key in('industry','jobfunction','experience','sector','address','zip_code','employer','ONetCode') group by pm.post_id, po.post_title";
  print_r($query);
  die();
  $results = $wpdb->get_results($query, ARRAY_A);
  
  if ($results) {

    $data = '';
    foreach ($results as $row) {
        $data .= '{"index":{"_index":"mce-jobs","_id":"' . $row["post_id"] . '"}}' . "\n";
        $data .= $row["source"] . "\n";
    }
    print_r($data);
    die();

    $endpoint = custom_elastic_link;
    $username = custom_elastic_username;
    $password = custom_elastic_password;

    // Send the bulk request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . '/_bulk');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'maine-ce-user:Hskdgu$bdsm7jb');
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;

  } else {
      // Handle the case where the query failed
      echo "Error executing query.";
  }
}
add_shortcode( 'bulkdata_opensearch_insertion', 'bulkdata_opensearch_insertion' );


/* Action triggered when a user successfully registers through any Profile Builder registration form */
add_action( 'wppb_after_user_approval', 'wppbc_custom_code', 20, 1 );
function wppbc_custom_code($user_id){

    $company_name = get_user_meta( $user_id,  'company_name', true );

    $metas = array( 
        'nickname'   => $company_name,
        'display_name' => $company_name,
    );

    foreach($metas as $key => $value) {
        update_user_meta( $user_id, $key, $value );
    }

    // Set default display name for new users
    $user_data = array(
        'ID'           => $user_id,
        'display_name' => $company_name,
    );

    wp_update_user( $user_data );


    $user_meta = get_user_meta ( $user_id);

    $user = get_user_by('id', $user_id);


    // Convert user registered date to the desired format
    $user_registered = date_create_from_format('Y-m-d H:i:s', $user->data->user_registered);
    $user_registered->setTimezone(new DateTimeZone('Europe/London'));
    $updated_on = $user_registered->format('Y-m-d\TH:i:s.uP');
    $Source = 'MCE';

    $data = '';

    $data .= '{"index":{"_index":"mce-employers","_id":"' . $user_meta['company_name'][0] . '"}}' . "\n";
    $data .= '{"id":"' . $user_id . '","address":"' . $user_meta['address'][0] . '","zip_code":"' . $user_meta['zip_code'][0] . '","updated_on":"' . $updated_on . '","employer":"' . $user_meta['company_name'][0] . '","Industry":"' . $user_meta['Industry_type'][0] . '","Sector":"' . $user_meta['sector'][0] . '","Source":"' . $Source . '"}' . "\n";

    $endpoint = custom_elastic_link;
    $username = custom_elastic_username;
    $password = custom_elastic_password;


  // Send the bulk request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . '/_bulk');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'maine-ce-user:Hskdgu$bdsm7jb');
    $response = curl_exec($ch);
    curl_close($ch);

    error_log("Your log message goes here.", 3, ABSPATH . 'your-log-file.log');
    custom_log($response, $ONetCode, $pageToProcess, $per_page_data);

    return $response;

}

/* dynamic populate job function in gravity form */
add_filter( 'gform_pre_render', 'populate_job_functions' );
function populate_job_functions( $form ) {
    if ( $form['id'] == 2 ) {
        $job_functions = get_terms( array(
            'taxonomy' => 'job_functions',
            'hide_empty' => false,
        ) );
        
        $job_function_options = array();
        foreach ( $job_functions as $job_function ) {
            $job_function_options[] = array(
                'text' => $job_function->name,
                'value' => $job_function->name
            );
        }
        
        $job_function_field_id = 39;
        foreach ( $form['fields'] as &$field ) {
            if ( $field->id == $job_function_field_id ) {
                $field->choices = $job_function_options;
                break;
            }
        }
    }
    return $form;
}

/* dynamic populate job Industry in gravity form */
add_filter( 'gform_pre_render', 'populate_job_industry' );
function populate_job_industry( $form ) {
    if ( $form['id'] == 2 ) {
        $job_industries = get_terms( array(
            'taxonomy' => 'job_industry',
            'hide_empty' => false,
        ) );
        
        $job_industry_options = array();
        foreach ( $job_industries as $job_industry ) {
            $job_industry_options[] = array(
                'text' => $job_industry->name,
                'value' => $job_industry->name
            );
        }
        
        $job_industry_field_id = 27;
        foreach ( $form['fields'] as &$field ) {
            if ( $field->id == $job_industry_field_id ) {
                $field->choices = $job_industry_options;
                break;
            }
        }
    }
    return $form;
}


add_action( 'admin_head', 'remove_custom_post_type_count' );

function remove_custom_post_type_count() {
    global $menu, $submenu;

    // Replace 'your_post_type' with the name of your custom post type
    $post_type = 'job';

    // Find the menu item for the post type
    foreach( $submenu as $key => $value ) {
        if( $key == 'edit.php?post_type=' . $post_type ) {
            foreach( $value as $k => $v ) {
                if( $v[0] == 'All ' . ucwords( $post_type ) ) {
                    $submenu[$key][$k][0] = 'All ' . ucwords( $post_type );
                    break;
                }
            }
            break;
        }
    }
}



// Add custom columns to specific custom post type 'job'
function custom_job_columns( $columns ) {
    // Add 'ONetCode' column before the last column
    $position = count($columns) - 1;
    $columns = array_slice($columns, 0, $position, true) +
               array('ONetCode' => 'ONetCode') +
               array_slice($columns, $position, null, true);

    // Add 'Job From' column before the last column
    $position = count($columns) - 1;
    $columns = array_slice($columns, 0, $position, true) +
               array('job_from' => 'Source ') +
               array_slice($columns, $position, null, true);

    $position = count($columns) - 1;
    $columns = array_slice($columns, 0, $position, true) +
               array('employer' => 'Employer ') +
               array_slice($columns, $position, null, true);

    return $columns;
}
add_filter( 'manage_job_posts_columns', 'custom_job_columns' );

// Display custom meta value in the custom columns for specific custom post type 'job'
function display_custom_job_columns( $column, $post_id ) {
    if ( 'ONetCode' === $column && 'job' === get_post_type( $post_id ) ) {
        $ONetCode_value = get_post_meta( $post_id, 'ONetCode', true );
        echo $ONetCode_value;
    }
    if ( 'employer' === $column && 'job' === get_post_type( $post_id ) ) {
        $employer_value = get_post_meta( $post_id, 'employer', true );
        echo $employer_value;
    }

    if ( 'job_from' === $column && 'job' === get_post_type( $post_id ) ) {
      $excerpt = get_the_excerpt($post_id);
      $job_source = get_post_meta($post_id, 'job_source', true);

      echo $job_source;

      // if (empty($excerpt) || empty($job_url)) {
      //     echo "Employer Portal";
      // } else {
      //     preg_match('/(\d+)\//', $excerpt, $matches);
      //     $key = $matches[1];
      //     preg_match('/\/(\d+)$/', $job_url, $matches);
      //     $job_id = $matches[1];
      //     if ($key == $job_id) {
      //         echo "Joblink";
      //     } else {
      //         echo "Employer Portal";
      //     }
      // }

    }
}
add_action( 'manage_job_posts_custom_column', 'display_custom_job_columns', 10, 2 );

/*
function insert_employer_data_to_elastic(){
  ob_start();
  global $wpdb;
  $sql_get_training = "SELECT * FROM $wpdb->posts WHERE post_type ='job' AND post_status = 'publish'";
  $training_data = $wpdb->get_results($sql_get_training);

  foreach ($training_data as $post) {

    $post_id = $post->ID;
    $title = $post->post_title;
    $content = $post->post_content;
    $excerpt = $post->post_excerpt;
    $date = $post->post_date;
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    $outputDate = $dateTime->format('Y-m-d\TH:i:s');

    $address = get_post_meta($post_id, 'address', true );
    $employer = get_post_meta($post_id, 'employer', true );
    $zip_code = get_post_meta($post_id, 'zip_code', true );
    $lat = get_post_meta($post_id, 'lat', true );
    $long = get_post_meta($post_id, 'long', true );
    $Secondary_Sector = get_post_meta($post_id, 'Secondary Sector', true );
    $Licensure = get_post_meta($post_id, 'Licensure Certificate', true );
    $URL = get_post_meta($post_id, 'URL', true );

    $Industry = get_the_terms($post_id, 'job_industry');
    foreach ($Industry as $Industri) {$Industrys = $Industri->name;}

    $Sectors = get_the_terms($post_id, 'job_sector');
    foreach ($Sectors as $sector) {$sectorss = $sector->name;}

    // echo "<br>Start<br>";
	   //  echo "<br>excerpt: ".$excerpt."<br>";
	   //  echo "<br>address: ".$address."<br>";
	   //  echo "<br>zip_code: ".$zip_code."<br>";
	   //  echo "<br>date: ".$date."<br>";
	   //  echo "<br>employer: ".$employer."<br>";
	   //  echo "<br>lat: ".$lat."<br>";
	   //  echo "<br>long: ".$long."<br>";
	   //  echo "<br>Industry: ".$Industrys."<br>";
	   //  echo "<br>sectors: ".$sectorss."<br>";
    // echo "<br>End<br><br><br>";

    $data = '';
    $data .= '{"index":{"_index":"mce-employers","_id":"' . $employer . '"}}' . "\n";
        $data .= '{"id":"' . $excerpt . '","address":"' . $address . '","zip_code":"' . $zip_code . '","updated_on":"' . $outputDate . '","employer":"' . $employer . '","Industry":"' . $Industrys . '","Sector":"' . $sectorss . '","location":{"lat": ' . $lat . ', "lon": ' . $long . '}}' . "\n";

    // print_r($data);
    // echo "<br><br>";
    $response = elastic_search_training_data_insertion($data);
    print_r($response);
    //die();
  }


  $output = ob_get_clean();
  return $output; 
}
add_shortcode('insert_employer_data_to_elastic', 'insert_employer_data_to_elastic');
*/
/*
function insert_training_data_to_elastic(){
  ob_start();
  global $wpdb;
  $sql_get_training = "SELECT * FROM $wpdb->posts WHERE post_type ='training' AND post_status = 'publish'";
  $training_data = $wpdb->get_results($sql_get_training);

  foreach ($training_data as $post) {

    $post_id = $post->ID;
    $training_title = $post->post_title;
    $training_content = $post->post_content;
    $training_date = $post->post_date;
    $training_Degree = get_post_meta($post_id, 'Degree Outcome', true );
    $training_Address = get_post_meta($post_id, 'Address', true );
    $training_City = get_post_meta($post_id, 'City', true );
    $training_State = get_post_meta($post_id, 'State', true );
    $training_Country = get_post_meta($post_id, 'Country', true );
    $training_Contact = get_post_meta($post_id, 'Contact', true );
    $Organization_name = get_post_meta($post_id, 'Name of Organization', true );
    $Priority_level = get_post_meta($post_id, 'Priority level', true );
    $training_Licensure = get_post_meta($post_id, 'Licensure Certificate', true );
    $URL = get_post_meta($post_id, 'URL', true );
    $latitude = get_post_meta($post_id, 'latitude', true );
    $longitude = get_post_meta($post_id, 'longitude', true );

    $training_functions = get_the_terms($post_id, 'training_functions');
    foreach ($training_functions as $function) {$functions = $function->name;}

    $training_type = get_the_terms($post_id, 'training_type');
    foreach ($training_type as $type) {$types = $type->name;}

    $training_sector = get_the_terms($post_id, 'training_sector');
    foreach ($training_sector as $sector) {$sectors = $sector->name;}

    // echo "<br>Start<br>";
     //  echo "<br>training_title: ".$training_title."<br>";
     //  echo "<br>training_Degree: ".$training_Degree."<br>";
     //  echo "<br>Address: ".$Address."<br>";
     //  echo "<br>City: ".$City."<br>";
     //  echo "<br>Country: ".$Country."<br>";
     //  echo "<br>Contact: ".$Contact."<br>";
     //  echo "<br>Organization_name: ".$Organization_name."<br>";
     //  echo "<br>Secondary_Sector: ".$Secondary_Sector."<br>";
     //  echo "<br>URL: ".$URL."<br>";
     //  echo "<br>functions: ".$functions."<br>";
     //  echo "<br>types: ".$types."<br>";
     //  echo "<br>sectors: ".$sectors."<br>";
    // echo "<br>End<br><br><br>";

    $data = '';
    $data .= '{"index":{"_index":"mce-trainings","_id":"' .$post_id.'/'.$training_title. '"}}' . "\n";
    $data .= '{"training_title":"' . $training_title . '","address":"' . $training_Address . '","training_City":"' . $training_City . '","training_State":"' . $training_State . '","training_Country":"' . $training_Country . '","training_Contact":"' . $training_Contact . '","training_Degree":"' . $training_Degree . '","training_Licensure":"' . $training_Licensure . '","training_Organization":"' . $Organization_name . '","training_type":"' . $types . '","training_sector":"' . $sectors . '","training_functions":"' . $functions . '","updated_on":"' . $training_date . '","Priority_level":"' . $Priority_level . '","location":{"lat":' . $latitude . ',"lon":' . $longitude . '}}' . "\n";


    //print_r($data);
    elastic_search_training_data_insertion($data);
    //die();
  }


  $output = ob_get_clean();
  return $output; 
}
add_shortcode('insert_training_data_to_elastic', 'insert_training_data_to_elastic');
*/

add_action('wp_ajax_load_more_jobs', 'load_more_jobs');
add_action('wp_ajax_nopriv_load_more_jobs', 'load_more_jobs');

function load_more_jobs() {
    global $wpdb;
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $posts_per_page = 5;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $company_name = sanitize_text_field($_GET['company_name']);

    $query = "SELECT * 
              FROM {$wpdb->posts} AS posts 
              INNER JOIN {$wpdb->postmeta} AS meta 
              ON posts.ID = meta.post_id 
              WHERE posts.post_type = 'job' 
              AND meta.meta_key = 'employer' 
              AND posts.post_status = 'publish' 
              AND meta.meta_value = '$company_name'
              ORDER BY posts.post_date DESC 
              LIMIT $posts_per_page OFFSET $offset";
            $result_data = $wpdb->get_results($query);
            $response = count($result_data);

        $querydata = "SELECT * 
        FROM {$wpdb->posts} AS posts 
        INNER JOIN {$wpdb->postmeta} AS meta 
        ON posts.ID = meta.post_id 
        WHERE posts.post_type = 'job' 
        AND meta.meta_key = 'employer' 
        AND posts.post_status = 'publish' 
        AND meta.meta_value = '$company_name'
        ORDER BY posts.post_date DESC";
        $result_data_count = $wpdb->get_results($querydata);
       $responsedata= count($result_data_count);
        if ($result_data) {
          foreach ($result_data as $item) {
            echo '<li class="paragraph">';
            echo '<a href="/job/' . $item->post_name . '"><span>' . esc_html($item->post_title) . '</span></a>';
            echo '</li>';
            echo '<input type="hidden" class="totalpost" value="' . esc_html($responsedata) . '" />';
        }
        if($response < 5){
            echo '<span class="Lastpost">';
            echo '</span>';
           } 
        
          
    } else {
     //   echo '<p>' . esc_html("No more Data...") . '</p>';
      
    }
   
    wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_load_more_jobs_emp', 'load_more_jobs_emp');
add_action('wp_ajax_nopriv_load_more_jobs_emp', 'load_more_jobs_emp');

function load_more_jobs_emp() {
    global $wpdb;

    $posts_per_page = 5;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $company_name = sanitize_text_field($_GET['company_name']);

    $query = "SELECT * 
              FROM {$wpdb->posts} AS posts 
              INNER JOIN {$wpdb->postmeta} AS meta 
              ON posts.ID = meta.post_id 
              WHERE posts.post_type = 'job' 
              AND meta.meta_key = 'employer' 
              AND posts.post_status = 'publish' 
              AND meta.meta_value = '$company_name'
              ORDER BY posts.post_date DESC 
              LIMIT $posts_per_page OFFSET $offset";

    $result_data = $wpdb->get_results($query);

    if ($result_data) {
        foreach ($result_data as $item) {
            echo '<li class="paragraph">';
            echo '<a href="/job/' . $item->post_name . '"><span>' . esc_html($item->post_title) . '</span></a>';
           //echo '<a href="/job/' . $item->post_name . '"><span>' . esc_html($item->post_date_gmt) . '</span></a>';
            echo '<a href="/edit-job/?jobid=' . $item->ID . '" class="edit-icon sg-popup-id-881624" data-post-id="' . $item->ID . '">Edit</a>';
            echo '<a href="#" class="delete-icon" data-post-id="' . $item->ID . '">Delete</a>';
            echo '</li>';
        }
    } else {
      //  echo '<p>' . esc_html("No more Data...") . '</p>';
      
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_delete_post', 'delete_post' );
add_action( 'wp_ajax_nopriv_delete_post', 'delete_post' ); 

function delete_post() {
  $postId = $_GET['post_id'];

  if (get_post_status($postId)) {
      if (wp_delete_post($postId, true)) {
          echo "Post with ID ".$post_id." has been deleted.";
      } else {
          echo "Failed to delete post with ID ".$post_id.".";
      }
  } else {
      echo "Post with ID ".$post_id." does not exist.";
  }
}

// when post is trashed
add_action('wp_trash_post', 'my_trash_job_function');
function my_trash_job_function($post_id) {
    // Check if the trashed post is of the type 'job'
    if (get_post_type($post_id) == 'job') {
        $joblink = get_post_meta($post_id, 'url', true );
        $url = get_permalink($post_id);
        $jobss_id = getIdFromUrl($joblink);
        $deleteQuery_CRON = '{"query": {"match_phrase": {"_id": "' . $jobss_id . '"}}}';
        $deleteQuery_MCE = '{"query": {"match_phrase": {"_id": "' . $post_id . 'P"}}}';
        $search_index_jobs = 'mce-jobs';
        $response1 = elastic_search_delete($search_index_jobs, $deleteQuery_CRON);
        // print_r($deleteQuery_CRON);
        // print_r($response1);
        $response2 = elastic_search_delete($search_index_jobs, $deleteQuery_MCE);
        // print_r($response2);
        // print_r($deleteQuery_MCE);
        // die();
    }
    if (get_post_type($post_id) == 'training') {
      $title = get_the_title($post_id);
      $title1 = $post_id."/".$title;
      $search_index_training = 'mce-trainings';
      $deleteQuery_training = '{"query": {"match_phrase": {"_id": "' . $title1 . '"}}}';
      $response1 = elastic_search_delete($search_index_training, $deleteQuery_training);

    }
}

function getIdFromUrl($url) {
    $path = parse_url($url, PHP_URL_PATH);
    $path = rtrim($path, '/');
    $segments = explode('/', $path);
    $lastSegment = end($segments);
    preg_match('/\d+$/', $lastSegment, $matches);
    return $matches ? $matches[0] : null;
}

// when post is restored
function set_post_to_pending_on_restore($post_id) {
  if (get_post_type($post_id) == 'job') {
    $post = array(
        'ID'           => $post_id,
        'post_status'  => 'pending'
    );
    wp_update_post($post);
  }
  if (get_post_type($post_id) == 'training') {
    $post = array(
        'ID'           => $post_id,
        'post_status'  => 'publish'
    );
    wp_update_post($post);
    $training_title = get_the_title($post_id);
      $training_content = get_post($post_id);
      $training_date = get_the_date('Y-m-d H:i:s', $post_id);
      $training_Degree = get_post_meta($post_id, 'Degree Outcome', true );
      $training_Address = get_post_meta($post_id, 'Address', true );
      $training_City = get_post_meta($post_id, 'City', true );
      $training_State = get_post_meta($post_id, 'State', true );
      $training_Country = get_post_meta($post_id, 'Country', true );
      $training_Contact = get_post_meta($post_id, 'Contact', true );
      $Organization_name = get_post_meta($post_id, 'Name of Organization', true );
      $Priority_level = get_post_meta($post_id, 'Priority level', true );
      $training_Licensure = get_post_meta($post_id, 'Licensure Certificate', true );
      $URL = get_post_meta($post_id, 'URL', true );
      $latitude = get_post_meta($post_id, 'latitude', true );
    $longitude = get_post_meta($post_id, 'longitude', true );


    $training_functions = get_the_terms($post_id, 'training_functions');
    foreach ($training_functions as $function) {$functions = $function->name;}

    $training_type = get_the_terms($post_id, 'training_type');
    foreach ($training_type as $type) {$types = $type->name;}

    $training_sector = get_the_terms($post_id, 'training_sector');
    foreach ($training_sector as $sector) {$sectors = $sector->name;}

    $data = '';
    $data .= '{"index":{"_index":"mce-trainings","_id":"' .$post_id.'/'.$training_title. '"}}' . "\n";
    $data .= '{"training_title":"' . $training_title . '","address":"' . $training_Address . '","training_City":"' . $training_City . '","training_State":"' . $training_State . '","training_Country":"' . $training_Country . '","training_Contact":"' . $training_Contact . '","training_Degree":"' . $training_Degree . '","training_Licensure":"' . $training_Licensure . '","training_Organization":"' . $Organization_name . '","training_type":"' . $types . '","training_sector":"' . $sectors . '","training_functions":"' . $functions . '","updated_on":"' . $training_date . '","Priority_level":"' . $Priority_level . '","location":{"lat":' . $latitude . ',"lon":' . $longitude . '}}' . "\n";

    $response = elastic_search_training_data_insertion($data);
    // print_r($response);
    // die();
  }
}
add_action('untrashed_post', 'set_post_to_pending_on_restore');

/*
add_action( 'admin_init', 'toggle_user_off_callback' );
function toggle_user_off_callback(){
    global $wpdb;
    if(isset($_POST['toggle_user_off'])) {
        $user_id = isset($_POST['user-id']) ? $_POST['user-id'] : 0;        
        echo "Run Function off User Id".$user_id;
        $company_name = get_user_meta($user_id, 'company_name', true);
        $deleteQuery = '{"query": {"match_phrase": {"employer": "' . $company_name . '"}}}';
        $search_index_employers = 'mce-employers';
        $search_index_jobs = 'mce-jobs';
        $response1 = elastic_search_delete($search_index_employers, $deleteQuery);
        $response2 = elastic_search_delete($search_index_jobs, $deleteQuery);
        $sql_status = "UPDATE wp_posts SET post_status = 'pending' WHERE ID IN ( SELECT post_id FROM wp_postmeta WHERE meta_key = 'employer' AND meta_value = '". $company_name ."' )";
        $users = $wpdb->query($sql_status);
        print_r($sql_status);
    }
}

add_action( 'admin_init', 'toggle_user_on_callback' );
function toggle_user_on_callback(){
    global $wpdb;
    if(isset($_POST['toggle_user_on'])) {
        $user_id = isset($_POST['user-id']) ? $_POST['user-id'] : 0;        
        // echo "Run Function on User Id ".$user_id. "<br><br>";
        $company_name = get_user_meta($user_id, 'company_name', true);
        $get_jobs = "SELECT p.* FROM wp_posts p JOIN wp_postmeta pm ON p.ID = pm.post_id WHERE p.post_type = 'job' AND pm.meta_key = 'employer' AND pm.meta_value = '".$company_name."';";
        $get_jobs_data = $wpdb->get_results($get_jobs);
        // print_r($get_jobs). "<br><br>";
        $response = employer_elastic_insertion($user_id);
        print_r($response). "<br><br>";
        foreach ($get_jobs_data as $post) {
          $Postid = $post->ID;
          $job_post = array(
            'ID'           => $Postid,
            'post_status'  => 'publish'
          );
          wp_update_post($job_post);
          elastic_search_approve_data_insertion($Postid);
        }
        // die();
    }
}
*/

function employer_elastic_insertion($user_id){

    $user_meta = get_user_meta ( $user_id);
    $user = get_user_by('id', $user_id);

    $email = $user->data->user_email;

    $user_registered = date_create_from_format('Y-m-d H:i:s', $user->data->user_registered);
    $user_registered->setTimezone(new DateTimeZone('Europe/London'));
    $updated_on = $user_registered->format('Y-m-d\TH:i:s.uP');
    
    if($email =='email@example.com'){
      $ONet_Id = $user_id;
      $Source = 'joblink';
      $Industry = $user_meta['api_employer_industry'][0];
      $Sector = $user_meta['api_employer_sector'][0];
    } else {
      $ONet_Id = $user_id.'P';
      $Source = 'MCE';
      $Industry = $user_meta['Industry_type'][0];
      $Sector = $user_meta['sector'][0];
    }

    $data = '';
     $data .= '{"index":{"_index":"mce-employers","_id":"' . $user_meta['company_name'][0] . '"}}' . "\n";
    $data .= '{"id":"' . $ONet_Id . '","address":"' . $user_meta['address'][0] . '","zip_code":"' . $user_meta['zip_code'][0] . '","updated_on":"' . $updated_on . '","employer":"' . $user_meta['company_name'][0] . '","Industry":"' . $Industry . '","Sector":"' . $Sector . '","Source":"' . $Source . '"}' . "\n";


    // print_r($data);
    // die();
	$endpoint = custom_elastic_link;
    $username = custom_elastic_username;
    $password = custom_elastic_password;

    // Send the bulk request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint . '/_bulk');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    $response = curl_exec($ch);
    curl_close($ch);
    
    // error_log("Your log message goes here.", 3, ABSPATH . 'elastic_search_approve_log_file.log');
    elastic_search_approve_logs($response, $data);
    return $data;

}

function elastic_search_delete($search_index, $deleteQuery){

  $endpoint = custom_elastic_link.'/'.$search_index.'/_delete_by_query';
  $username = custom_elastic_username;
  $password = custom_elastic_password;

  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $deleteQuery);
    $response = curl_exec($ch);
  curl_close($ch);
  $results = json_decode($response, true);

  return $response;  
}

// Disable all update notifications for plugins
//remove_action('load-update-core.php', 'wp_update_plugins');
//add_filter('pre_site_transient_update_plugins', '__return_null');

// Change the From address.
add_filter( 'wp_mail_from', function ( $original_email_address ) {
    return 'no-reply@mainecleanenergyjobs.com';
} );


// hide trash icon from admin area
function hide_trash_for_job_post_type() {
    global $pagenow, $post_type;

    // Apply the CSS only on the job post type pages
    if ($pagenow === 'edit.php' && $post_type === 'job') {
        echo '<style>
            span.trash {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'hide_trash_for_job_post_type');