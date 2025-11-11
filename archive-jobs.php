<?php
// Template Name: Archive Page Custom
get_header();
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$zip_code = isset($_GET['zip_code']) ? sanitize_text_field($_GET['zip_code']) : '';
$location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';

?>

<div class="clear"></div>
</header> <!-- / END HOME SECTION -->

<div id="content" class="site-content">

    <div class="container">

        <div class="content-left-wrap col-md-9">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">

                    <?php
                    // Custom query based on search parameters
                    $args = array(
                        'post_type' => 'jobs',
                        's' => $search_query,
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'zip_code',
                                'value' => $zip_code,
                                'compare' => 'LIKE',
                            ),
                            array(
                                'key' => 'location',
                                'value' => $location,
                                'compare' => 'LIKE',
                            ),
                        ),
                    );

                    $custom_query = new WP_Query($args);

                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                            $post_id = get_the_ID();
                    ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php the_title(); ?></h1>
                                </header>
                                <p>Post Id: <?php echo $id; ?></p>
                                <?php
                                $terms = get_the_terms($post_id, 'job_category');
                                if ($terms && !is_wp_error($terms)) {
                                    $category = reset($terms);
                                    $category_name = $category->name;
                                    echo 'Category Name: ' . $category_name;
                                } else {
                                    echo 'No category found.';
                                }
                                ?>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                </div>
                            </article>

                        <?php endwhile;
                    else :
                        ?>
                        <h1>No data available.</h1>
                    <?php
                    endif;

                    wp_reset_postdata();
                    ?>
                </main>
            </div>
        </div>
        <div class="sidebar-wrap col-md-3 content-left-wrap">
            <?php get_sidebar(); ?>
        </div>
    </div>
    <?php get_footer(); ?>
