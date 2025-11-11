<?php
// =============================================================================
// TEMPLATE NAME: Employers Jobs
// -----------------------------------------------------------------------------
// =============================================================================
get_header();
?>

<?php
if (isset($_GET['employer_id'])) {
    $employer_id = $_GET['employer_id'];

    $company_name = get_user_meta($employer_id, 'company_name', true);
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = 10; 

    $employer_jobs_query = new WP_Query(array(
        'post_type' => 'job',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'employer',
                'value' => $company_name,
                'compare' => '=',
            ),
        ),
    ));

    if ($employer_jobs_query->have_posts()) {
        echo '<div class="container mt-5 mb-5">';
        echo '<div class ="contPostCount" >';
        echo '<div><span>' . $employer_jobs_query->found_posts . '</span> jobs found</div>';
        echo '</div>';
        echo '<ul class="job-listing">';

        while ($employer_jobs_query->have_posts()) {
            $employer_jobs_query->the_post();
            $post_id = get_the_ID();
            $job_title = get_the_title();
            $job_permalink = get_the_permalink();
            $job_location0 = get_post_meta($post_id, 'address', true);
            if (substr($job_location0, 0, 1) === ',') {
                $job_location = substr($job_location0, 2);
            } else {
                $job_location = $job_location0;
            }
            $job_employer = $company_name;
            $bookmark_image_url = '';

            // Check if the post is saved
            $is_post_saved = is_post_saved($post_id);

            if ($is_post_saved) {
                $bookmark_image_url = home_url() . '/wp-content/uploads/2024/02/bookmark.png';
            } else {
                $bookmark_image_url = home_url() . '/wp-content/uploads/2024/01/asd2.svg';
            }

            // Output the job details
            echo '<li class="job-listing-list">';
            echo '<div class="job-details">';
            echo '<div class="job-details-inner">';
            echo '<h3 class="job-title"><a href="' . esc_html($job_permalink) . '">' . esc_html($job_title) . '</a></h3>';
            echo '<p class="job-compnay-name"><a href="' . esc_html($job_permalink) . '">' . esc_html($job_employer) . '</a></p>';
            echo '<ul class="job-info">';
            echo '<li><a href="' . esc_html($job_permalink) . '">Full Time</a></li>';
            if ($job_location) {
                echo '<li><a href="' . esc_html($job_permalink) . '">' . esc_html($job_location) . '</a></li>';
            }
            echo '</ul>';
            echo '</div>';
            echo '<div class="job-icon">';
            echo '<span class="jobicon-share" post-id="' . esc_attr($post_id) . '">';
            echo '<img decoding="async" class="bookmark-image" src="' . $bookmark_image_url . '" data-postid="' . esc_attr($post_id) . '">';
            echo '</span>';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        }

        echo '</ul>';

        echo '<div class="resultnumber-sec">';
        $start = ($paged - 1) * $posts_per_page + 1;
        $end = min($paged * $posts_per_page, $employer_jobs_query->found_posts);
        echo '<div class="results-info">' . $start . ' - ' . $end . ' of ' . $employer_jobs_query->found_posts . '</div>';

        // Pagination
        echo '<div class="pagination">';
        $total_pages = $employer_jobs_query->max_num_pages;

        if ($paged > 1) {
            echo '<a href="' . get_pagenum_link($paged - 1) . '" class="job_pagination"><i class="fas fa-chevron-left"></i></a>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $paged) {
                echo '<a class="job_pagination active">' . $i . '</a>';
            } elseif ($i <= 3 || $i > $total_pages - 1 || ($i >= $paged - 1 && $i <= $paged + 1)) {
                echo '<a href="' . get_pagenum_link($i) . '" class="job_pagination">' . $i . '</a>';
            } elseif ($i == 4 || $i == $total_pages - 1) {
                echo '<span class="dots">...</span>';
            }
        }

        if ($paged < $total_pages) {
            echo '<a href="' . get_pagenum_link($paged + 1) . '" class="job_pagination"><i class="fas fa-chevron-right"></i></a>';
        }

        echo '</div>'; // .pagination
        echo '</div>';

        echo '</div>';


        wp_reset_postdata();
    } else {
        echo 'No jobs found for this company.';
    }
} else {
    echo 'Employer ID not provided.';
}
?>

<?php get_footer(); ?>
