<?php

/**
 * Template Name: Employer-single
 *
 * This template is used to display a Employer-single .
 *
 * @package YourThemeName
 */
get_header(); ?>
<style type="text/css">
    .article.description {
        max-height: 110px;
        overflow: hidden;
    }

    .jobsearch_employer .pci {
        display: flex;
        align-items: center;
        background-color: #233f88;
        justify-content: center;
        height: 300px;
    }

    .jobsearch_employer .pci .profile-photo-placeholder {
        font-size: 190px;
        font-weight: 700;
    }

    li.event-list {
        margin-bottom: 40px;
    }

    .cmg_soon {
        height: 800px;
        display: flex;
        text-align: center;
        align-items: center;
        justify-content: center;
    }

    li.paragraph {
        margin: 0px 0px 30px 0px;
    }
</style>
<?php
$employer_id = isset($_GET['employer_id']) ? intval($_GET['employer_id']) : 0;
global $wpdb;
if ($employer_id) {
    $user_data = get_userdata($employer_id);
    $company_name = get_user_meta($employer_id, 'company_name', true);
	$company_name_sanitized = get_user_meta($employer_id, 'company_name', true);
    $registered = $user_data->user_registered;
    $upload_emp_logo = get_user_meta($employer_id, 'upload_a_logo', true);
    $address = get_user_meta($employer_id, 'address', true);
    $zip_code = get_user_meta($employer_id, 'zip_code', true);
    $city = get_user_meta($employer_id, 'city', true);
    $country = get_user_meta($employer_id, 'country', true);
    $about_company = get_user_meta($employer_id, 'about_company', true);
    $Industry_type = get_user_meta($employer_id, 'Industry_type', true);
    $api_emp_sector = get_user_meta($employer_id, 'api_employer_sector', true);
    $api_emp_industry = get_user_meta($employer_id, 'api_employer_industry', true);
    $sector = get_user_meta($employer_id, 'sector', true);
    $website_url = get_user_meta($employer_id, 'website_url', true);



    // Fetch number of job posts by the employer
    $post_count = count_user_posts($employer_id, 'job');

    // Fetch number of job posts by the job count
    $post_count_query = "SELECT COUNT(posts.ID) AS post_count FROM {$wpdb->posts} AS posts INNER JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id WHERE posts.post_type = 'job' AND meta.meta_key = 'employer' AND posts.post_status = 'publish' AND meta.meta_value = '" . $company_name_sanitized . "'"; 
    $post_count_result = $wpdb->get_results( $post_count_query );
   
    // Fetch number of job posts by the list
    $posts_per_page = 5; // Number of posts to load each time
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0; // Offset for pagination
    
    $query = "SELECT * 
              FROM {$wpdb->posts} AS posts 
              INNER JOIN {$wpdb->postmeta} AS meta 
              ON posts.ID = meta.post_id 
              WHERE posts.post_type = 'job' 
              AND meta.meta_key = 'employer' 
              AND posts.post_status = 'publish' 
              AND meta.meta_value = '" . $company_name_sanitized . "'
              ORDER BY posts.post_date DESC 
              LIMIT $posts_per_page OFFSET $offset";
    
    $result_data = $wpdb->get_results($query);

    // Start HTML output
?>
    <section class="space-sec static jobsearch_employer administrator">
        <div class="x-container max width">
            <div class="row">
                <div class="col-lg-3">
                    <div class="profile-card">
                        <!-- <div class="pci">
					<?php echo $upload_emp_logo; ?>
                   <?php if (!empty($upload_emp_logo)) : ?>
                            <img src="<?php echo  $upload_emp_logo; ?>" alt="emp-logo" class="profile-photo">
                        <?php else : ?>
                            <div class="profile-photo-placeholder">
                                <?php echo strtoupper(substr($company_name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                </div> -->
                        <div class="profile-card-deatils profile-card-sec">
                            <h4 class="bd-title4 "><?php echo $company_name; ?></h4>
                            <ul class="pc-list">
                                <li class="paragraph"><?php echo $address; ?></li>
                                <!-- <li class="paragraph">28 Employees</li> -->
<!--                                 <li class="paragraph">Joined in<?php printf(date(" F Y", strtotime($registered))); ?></li>-->
                                <li><a href="<?php echo esc_url($website_url); ?>" target="_blank" class="green-btn">Visit Website</a></li>

                            </ul>
                             <div>
                                <?php if ($post_count_result['0']->post_count > 0) : 
                                ?>
                                    <h6 class="bd-title4 mb-4"><?php  echo $post_count_result['0']->post_count; 
                                                                ?> Jobs</h6>
                                <?php else : 
                                ?>
                                    <p>No jobs posted</p>
                                <?php endif; 
                                ?>
                            </div> 

                            <div class="jobs-tabs mt-5">
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="enegry-space-left">



                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <!-- Content for Jobs tab -->
                                <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Industry</h4>
                                    <p class="paragraph"><?php
                                                            if (!empty($api_emp_industry)) {
                                                                echo $api_emp_industry;
                                                            } else {
                                                                echo $Industry_type;
                                                            }
                                                            ?></p>
                                </div>
                                <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Sector</h4>
                                    <p class="paragraph"> <?php
                                                            if (!empty($api_emp_sector)) {
                                                                echo $api_emp_sector;
                                                            } else {
                                                                echo $sector;
                                                            }
                                                            ?></p>
                                </div>
                                <!-- <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Location</h4>

                                    <p class="paragraph">
                                        <?php if (!empty($address) || !empty($zip_code) || !empty($city) || !empty($country)) : ?>
                                            <img src="/wp-content/uploads/2024/01/jobs-location-icon.svg" class="location-icon">
                                            <?php  echo ltrim($address, ', ') . " " . $zip_code . " "  . $city . " "  . $country ?>
                                        <?php else : ?>
                                            Location not found
                                        <?php endif; ?>
                                    </p>
                                </div> -->
                                <div class="profile-information2 pi">

                                     <?php 
                                     if($post_count_result['0']->post_count == 0){
                                        ?>
                                          <h4 class="bd-title4">No current job openings.</h4>
                                   <?php  }else{ ?>
                                          <h4 class="bd-title4">Current Openings</h4>
                                          
                                    <ul class="pi-job-info" id="jobListing">
                                        <!-- Job list items will be inserted here -->
                                       
                                    </ul>
                                    <?php   if($post_count_result['0']->post_count > 5){?>
                                    <button  class="secondray-btn gb-btn" id="loadMoreBtn">Load More</button>
                                                 
                                    <?php }} ?>
                                  
                                


                                </div>
                              <!--   <div class="profile-information3 pi">
                                    <h4 class="bd-title4">Upcoming Events </h4>
                                    <ul class="pi-job-info" id="jobList">
                                        <?php

                                        // $args = array(

                                        //     'post_type'      => 'news_events',
                                        //     'post_status'    => 'publish',
                                        //     'posts_per_page' => -1,
                                        //     'category_name'  => 'events',
                                        //     'posts_per_page' => 5,
                                        //     'orderby'        => 'date',
                                        //     'order'          => 'DESC',
                                        // );

                                        // $query = new WP_Query($args);

                                        // if ($query->have_posts()) {
                                        //     while ($query->have_posts()) {
                                        //         $query->the_post();
                                        //         $post_id = get_the_ID();
                                        //         $all_day = get_post_meta($post_id, 'all_day', true);
                                        //         $start_date = get_post_meta($post_id, 'event_start_date', true);
                                        ?>
                                                <li class="paragraph">
                                                    <span><?php //the_title(); ?></span>
                                                    <span><?php //echo $start_date; ?></span>
                                                    <span> all day: <?php //echo $all_day; ?></span>
                                                </li>
                                        <?php
                                         //   }
                                        //     wp_reset_postdata(); // Reset post data
                                        // } else {
                                        //     echo '<li class="paragraph">No job openings found for this user.</li>';
                                        // }
                                        ?>
                                    </ul>
                                </div> -->
                            </div>
                            <!-- <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="saved-job-sec">
                            <div class="saved-job-inner">
                                <h4 class="bd-title4 mb-4">Saved Jobs</h4>
                                <?php //echo do_shortcode( '[display_saved_posts]' ); 
                                ?>                                 
                            </div>
                        </div>
                    </div> -->
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <h3 class="bd-title3 cmg_soon">Internship Coming Soon!</h3>
                            </div>
                            <div class="tab-pane fade" id="pills-contact1" role="tabpanel" aria-labelledby="pills-events-tab">
                                <!-- <h3 class="bd-title3">Events Coming Soon</h3>
                        <p class="paragraph"></p> -->
                                <?php echo do_shortcode('[news_events_list]'); ?>
                            </div>
                            <div class="tab-pane fade" id="pills-contact2" role="tabpanel" aria-labelledby="pills-employers-tab">
                                <!-- Content for Employers tab -->
                                <?php echo do_shortcode('[user_role_users role="jobsearch_employer" limit="5"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
} else {
    echo 'No employer ID provided.';
}

get_footer(); ?>
<!-- Add a "Load More" button -->


<script>
jQuery(document).ready(function($) {
    var offset = 0; // Initial offsets
    var totalPosts = 0; 
   
   
    function loadPosts() {
        var totalPosts_data = parseInt($('.totalpost').val());
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'GET',
            data: {
                action: 'load_more_jobs',
                offset: offset,
                company_name: '<?php echo $company_name_sanitized; ?>'
            },
            success: function(response) {
            if (response) {
                // console.log(response);
                $('#jobListing').append(response); // Append new posts to the list
                offset += <?php echo $posts_per_page; ?>; // Increase the offset
                // console.log(offset);
                if (totalPosts_data == offset) {
                    $('#loadMoreBtn').hide();
                }
            } else {
                $('#loadMoreBtn').hide(); // Hide the "Load More" button if no more posts
            }
            if ($('.Lastpost').length) {
                    $('#loadMoreBtn').hide();
                }


        },
        complete: function() {
            if ($('#jobListing').text().includes('No more Data...')) {
                $('#loadMoreBtn').prop('disabled', true); // Disable the "Load More" button
            }
        }
        });
    }

    // Load initial posts
    loadPosts();

    // Load more posts when "Load More" button is clicked
    $('#loadMoreBtn').click(function() {
        loadPosts();
    });
});
</script>
