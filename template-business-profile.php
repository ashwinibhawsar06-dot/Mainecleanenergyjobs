<?php
// =============================================================================
// TEMPLATE NAME: business profile 
// -----------------------------------------------------------------------------
// =============================================================================
get_header(); ?>
<style type="text/css">
    #pills_renew ul li.paragraph {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    #pills_renew ul li .renew-job-form .button.button-primary {
        padding: 5px;
        margin-top: -4px;
        box-shadow: none;
        margin-left: 10px;
    }

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

    .pi-job-info a.edit-icon,
    .pi-job-info a.delete-icon {
        background: #79b44b;
        color: white;
        padding: 0px 10px 2px 10px;
        text-decoration: none !important;
        border-radius: 5px;
        border: 1px solid #79b44b;
        line-height: 1.5;
    }

    .pi-job-info a:hover {
        background: #fff;
        color: #79b44b;
    }

    .jobs-tabs ul .nav-item button:hover {
        background: #79b44b;
        color: white !important;
    }

    #user_email,
    #\38 86985 {
        display: none;
    }
</style>


<?php
if (is_user_logged_in()) {

    global $wpdb;

    // Check if the form is submitted
    if (isset($_POST['renew_job'])) {
        // Get the post ID
        $post_id = isset($_POST['post-id']) ? intval($_POST['post-id']) : 0;

        // Get the expiry date from the form and format it to yy/mm/dd
        $expiry_date = isset($_POST['new_expiry_date']) ? sanitize_text_field($_POST['new_expiry_date']) : '';

        // Convert the expiry date to the required format (Y-m-d)
        $formatted_expiry_date = date('Y-m-d', strtotime($expiry_date));

        // Update the job post
        $job_post = array(
            'ID'            => $post_id,
            'post_status'   => 'pending',  // Renew the job by setting it to 'pending'
            'post_date'     => date('Y-m-d H:i:s', current_time('timestamp')),
            'post_date_gmt' => date('Y-m-d H:i:s', current_time('timestamp', 1))
        );
        wp_update_post($job_post);

        // Update the job_close_date meta field with the formatted expiry date
        if (!empty($formatted_expiry_date)) {
            update_post_meta($post_id, 'job_close_date', $formatted_expiry_date);
        }

        // Call the Elasticsearch function to handle further actions
        //elastic_search_approve_data_insertion($post_id);

        // Redirect back to the page or wherever you want after submission
        wp_redirect($_SERVER['HTTP_REFERER']);
        exit;
    }
    // Get the current user object
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();
    $udata = get_userdata($user_id);
    $registered = $udata->user_registered;
    $user_email = $udata->user_email;

    $upload_logo = get_user_meta($user_id, 'upload_logo', true);
    $upload_emp_logo = get_user_meta($user_id, 'upload_a_logo', true);
    $approve_status = get_user_meta($user_id, 'pending_approval', true);

    $fname = get_user_meta($user_id, 'first_name', true);
    $lname = get_user_meta($user_id, 'last_name', true);
    $fullnam = $fname . ' ' . $lname;

    $company_name = get_user_meta($user_id, 'company_name', true);
    $website_url = get_user_meta($user_id, 'website_url', true);
    $address = get_user_meta($user_id, 'address', true);
    $zip_code = get_user_meta($user_id, 'zip_code', true);
    $city = get_user_meta($user_id, 'city', true);
    $country = get_user_meta($user_id, 'country', true);
    $about_company = get_user_meta($user_id, 'about_company', true);
    $Industry_type = get_user_meta($user_id, 'Industry_type', true);
    $sector = get_user_meta($user_id, 'sector', true);

    $post_count_query = "SELECT COUNT(posts.ID) AS post_count FROM wp_posts AS posts INNER JOIN wp_postmeta AS meta ON posts.ID = meta.post_id WHERE posts.post_type = 'job' AND posts.post_status = 'publish' AND meta.meta_key = 'employer' AND meta.meta_value = '" . $company_name . "'";
    $post_count_result = $wpdb->get_results($post_count_query);
    $post_count = $post_count_result[0]->post_count;


    $employee_post_id_query = "SELECT * FROM wp_posts AS posts INNER JOIN wp_postmeta AS meta ON posts.ID = meta.post_id WHERE posts.post_type = 'job' AND posts.post_status = 'publish' AND meta.meta_key = 'employer' AND meta.meta_value = '" . $company_name . "'";
    $employee_post_id = $wpdb->get_results($employee_post_id_query);
    $current_user_id = get_current_user_id();
    $current_user_nickname = get_user_meta($current_user_id, 'nickname', true);


    $employee_posts = $wpdb->get_results($employee_post_id_query);

    if (!empty($employee_posts)) {
        foreach ($employee_posts as $post) {
            // Display the employer
            $employerMatch = $post->meta_value;
        }
    } else {
        //echo "No employer found.";
    }

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
             AND meta.meta_value = '" . $company_name . "'
             ORDER BY posts.post_date DESC 
             LIMIT $posts_per_page OFFSET $offset";

    $result_data = $wpdb->get_results($query);

    $expirejobquerydata = $wpdb->prepare(
        "SELECT posts.* 
        FROM {$wpdb->posts} AS posts 
        INNER JOIN {$wpdb->postmeta} AS meta 
        ON posts.ID = meta.post_id 
        WHERE posts.post_type = 'job' 
        AND posts.post_status = 'expired' 
        AND meta.meta_key = 'employer' 
        AND meta.meta_value = %s
        ORDER BY posts.post_date DESC
        LIMIT %d OFFSET %d",
        $company_name,
        $posts_per_page,
        $offset
    );
    $expire_result_data = $wpdb->get_results($expirejobquerydata);

?>
    <section class="space-sec static jobsearch_employer administrator">
        <div class="x-container max width">
            <?php
            if ($approve_status == 1) {
                echo "<div class='pendingContent'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> <h6 class='paragraph'>Your Employer account is under review. If approved, it will be live on the website shortly. Have a question? <a href='/contact/'>Contact us here.</a></h6></div>";
            }

            ?>
            <div class="row">
                <div class="col-lg-3">
                    <div class="profile-card">
                        <div class="profile-card-deatils profile-card-sec">
                            <h4 class="bd-title4 "><?php echo $company_name; ?></h4>
                            <p id="user_email"><?php echo $user_email; ?></p>
                            <button class="sg-popup-id-886985" id="886985">popup</button>
                            <ul class="pc-list">
                                <li class="paragraph"><?php echo $address; ?></li>
                                <li class="paragraph">Joined in<?php printf(date(" F Y", strtotime($registered))); ?></li>
                                <li><a href="<?php echo $website_url; ?>" class="green-btn">Visit Website</a></li>
                            </ul>
                            <script>
                                jQuery(document).ready(function() {
                                    setTimeout(function() {
                                        var userEmail = jQuery('#user_email').text().trim();
                                        if (userEmail === 'email@example.com') {
                                            jQuery('#886985').trigger('click');
                                        }
                                    }, 1000);
                                });
                            </script>
                            <div>
                                <?php if ($post_count > 0) { ?>
                                    <h4 class="bd-title4 mb-4"><?php echo $post_count; ?> Jobs</h4>
                                <?php } ?>
                            </div>

                            <div class="jobs-tabs mt-5">
                                <div class="jobs-saved-con">
                                    <span>Saved items</span>
                                </div>
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="active" id="pills_details-tab" data-toggle="pill" data-target="#pills_details" type="button" role="tab" aria-controls="pills" aria-selected="true"><span>Profile</span></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="pills_jobs-tab" data-toggle="pill" data-target="#pills_jobs" type="button" role="tab" aria-controls="pills" aria-selected="true">Jobs</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="pills_employers-tab" data-toggle="pill" data-target="#pills_employers" type="button" role="tab" aria-controls="pills" aria-selected="false">Employers</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button id="pills_trainings-tab" data-toggle="pill" data-target="#pills_trainings" type="button" role="tab" aria-controls="pills" aria-selected="false">Trainings</button>
                                    </li>
                                        <li class="nav-item" role="presentation">
                                        <button id="pills_renew-tab" data-toggle="pill" data-target="#pills_renew" type="button" role="tab" aria-controls="pills" aria-selected="false">Renew Expired Jobs</button>
                                    </li>
                                </ul>
                            </div>
                            <ul class="pi-group-btn">
                                <li><a href="<?php echo home_url('/employer-posting-form/'); ?>" class="green-btn">POST A JOB</a></li>
                                <li><a href="<?php echo home_url('/create-a-training-posting/'); ?>" class="green-btn">POST A TRAINING</a></li>
                                <li><a href="<?php echo home_url('/create-an-event/'); ?>" class="green-btn mht_event" data-popup-id="2275">add event</a></li>
                                <li><a href="<?php echo home_url('/edit-employer-profile/'); ?>" class="green-btn gb-btn">Edit Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="enegry-space-left">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills_details" role="tabpanel" aria-labelledby="pills_details-tab">
                                <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Industry</h4>
                                    <p class="paragraph"><?php echo $Industry_type; ?></p>
                                </div>
                                <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Sector</h4>
                                    <p class="paragraph"><?php echo $sector; ?></p>
                                </div>
                                <div class="profile-information1 pi">
                                    <h4 class="bd-title4">Location</h4>

                                    <p class="paragraph">
                                        <?php if (!empty($address) || !empty($zip_code) || !empty($city) || !empty($country)) : ?>
                                            <img src="/wp-content/uploads/2024/01/jobs-location-icon.svg" class="location-icon">
                                            <?php echo $address . " " . $zip_code . " "  . $city . " "  . $country ?>
                                        <?php else : ?>
                                            Location not found
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <?php
                                $current_user_id = get_current_user_id();
                                $employee_post_id = $employee_post_id['0']->post_author; // Assuming $post_count_result contains the post author ID

                                if ($current_user_id && $current_user_id == $employee_post_id) { ?>
                                    <div class="profile-information2 pi">

                                        <?php if ($post_count_result['0']->post_count == 0) { ?>
                                            <h4 class="bd-title4">No current job openings.</h4>
                                        <?php  } else { ?>
                                            <h4 class="bd-title4">Current Openings</h4>
                                            <ul class="pi-job-info" id="jobListing"></ul>
                                            <?php if ($post_count_result['0']->post_count >= 5) { ?>
                                                <button class="secondray-btn gb-btn" id="loadMoreBtnEmp">Load More</button>

                                        <?php }
                                        } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="profile-information2 pi">

                                        <?php if ($post_count_result['0']->post_count == 0) { ?>
                                            <h4 class="bd-title4">No current job openings.</h4>
                                        <?php  } else { ?>
                                            <h4 class="bd-title4">Current Openings</h4>
                                            <ul class="pi-job-info" id="jobListing"></ul>
                                            <?php if ($post_count_result['0']->post_count >= 5) { ?>
                                                <button class="secondray-btn gb-btn" id="loadMoreBtn">Load More</button>

                                        <?php }
                                        } ?>
                                    </div>
                                <?php }

                                ?>

                            </div>
                            <div class="tab-pane fade" id="pills_jobs" role="tabpanel" aria-labelledby="pills_jobs-tab">
                                <h4 class="bd-title4">Saved Jobs</h4>
                                <?php do_shortcode("[display_saved_posts]") ?>
                            </div>
                            <div class="tab-pane fade" id="pills_employers" role="tabpanel" aria-labelledby="pills_employers-tab">
                                <h4 class="bd-title4">Saved Employers</h4>
                                <?php echo do_shortcode('[saved_users]'); ?>
                            </div>
                            <div class="tab-pane fade" id="pills_trainings" role="tabpanel" aria-labelledby="pills_trainings-tab">
                                <h4 class="bd-title4">Saved Trainings</h4>
                                <?php echo do_shortcode('[display_saved_training_posts]'); ?>
                            </div>
                            <div class="tab-pane fade" id="pills_renew" role="tabpanel" aria-labelledby="pills_renew-tab">
                                

                                <?
                                // Check if results exist
                                if (!empty($expire_result_data)) {
                                echo '<h4 class="bd-title4">Renew Expired Jobs</h4>';
                                echo '<ul>';
                                $counter = 1;
                                foreach ($expire_result_data as $item) {
                                    echo '<li class="paragraph">';
                                        echo '<a href="/job/' . esc_attr($item->post_name) . '" target="_blank"><span>' . esc_html($item->post_title) . '</span></a>';?>
                                        <form method="post" id="renew-job-form-<?php echo $counter; ?>" class="renew-job-form">
                                            <input type="hidden" name="post-id" value="<?php echo $item->ID; ?>">
                                            <input type="date" class="expiry-date" name="new_expiry_date" placeholder="mm/dd/yy">
                                            <input type="submit" class="button button-primary renew-job-btn" value="Renew Job" name="renew_job" disabled="disabled">
                                        </form>
                                        <?
                                    echo '</li>';
                                    $counter++; 
                                }
                                echo '<ul>';
                                } else {
                                    echo '<h4 class="bd-title4">No Expired Job found</h4>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
}



?>

<?php get_footer(); ?>
<script>

    jQuery(document).ready(function($) {
        // Target all inputs with the class 'expiry-date'
        $('.expiry-date').on('input', function() {
            // Get the closest form and related submit button
            var form = $(this).closest('form');
            var submitButton = form.find('.renew-job-btn');

            // Enable the submit button if the date field is not empty, otherwise disable it
            if ($(this).val() !== "") {
                submitButton.removeAttr('disabled');  // Enable button
            } else {
                submitButton.attr('disabled', 'disabled');  // Disable button
            }
        });
    });

    jQuery(document).ready(function($) {
        var offset = 0; // Initial offset
        var action; // Variable to store the action for AJAX request

        <?php
        // echo 'Current user: ' . $current_user_id . '<br>';
        // echo 'current_user_nickname : ' . $current_user_nickname . '<br>';
        // echo 'Employee user: ' . $employee_post_id;
        // echo 'employerMatch : ' . $employerMatch;

        ?>
        // Check if current user ID matches employee post ID
        <?php if ($company_name == $employerMatch) : ?>
            action = 'load_more_jobs_emp'; // Load employee posts
        <?php else : ?>
            action = 'load_more_jobs'; // Load regular posts
        <?php endif; ?>

        function loadPosts() {
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                type: 'GET',
                data: {
                    action: action,
                    offset: offset,
                    company_name: '<?php echo $company_name; ?>'
                },
                success: function(response) {
                    if (response) {
                        $('#jobListing').append(response); // Append new posts to the list
                        offset += <?php echo $posts_per_page; ?>; // Increase the offset
                    } else {
                        if (action == 'load_more_jobs_emp') {
                            $('#loadMoreBtnEmp').hide(); // Hide the "Load More" button for employee posts
                        } else {
                            $('#loadMoreBtn').hide(); // Hide the "Load More" button for regular posts
                        }
                    }
                }
            });
        }

        // Load initial posts
        loadPosts();

        // Load more posts when corresponding "Load More" button is clicked
        if (action == 'load_more_jobs_emp') {
            $('#loadMoreBtnEmp').click(function() {
                loadPosts();
            });
        } else {
            $('#loadMoreBtn').click(function() {
                loadPosts();
            });
        }
    });


    jQuery(document).ready(function($) {
        $(document).on('click', '.delete-icon', function(e) {
            e.preventDefault();

            var postId = $(this).attr('data-post-id');
            var listItem = $(this).closest('li');

            if (confirm("Are you sure you want to delete this post?")) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'delete_post',
                        post_id: postId
                    },
                    success: function(response) {
                        console.log(response);
                        $(this).closest('li').remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

    });
</script>