<?php

/**
 * Template Name: Single Training
 *
 * This template is used to display a single training post.
 *
 * @package YourThemeName
 */
get_header(); ?>
<style>
    .article.description {
        max-height: 110px;
        overflow: hidden;
    }

    .similer-job-sec::before {
        position: absolute;
        content: "";
        width: 12% !important;
        height: 74vh;
        top: 0;
        right: 0;
        background-image: url(/wp-content/themes/pro-child/img/jbg-lst2.png);
        background-position: right;
        background-repeat: no-repeat;
        z-index: 1;
        background-size: contain;
        margin-top: -261px;
    }

    .profile-card-deatils {
        margin-bottom: 30px;
        border-bottom: 3px solid #79B44B;
        padding-bottom: 30px;
    }

    .profile-cardSec h6 {
        font-size: 21px;
        font-weight: 400;
        text-align: left;
        border-bottom: 2px solid #000;
        margin-bottom: 28px;
        padding-bottom: 4px;
    }

    .paragraph img {
        max-width: 100%;
        width: 25px;
        margin-right: 16px;
        height: auto;
        vertical-align: middle;
        border: 0;
    }

    .profile-information.pi {
        border-bottom: 1px solid #BFBFBF;
        margin-bottom: 15px;
    }

    h4.add_class {
        color: #000;
        font-family: "ZeitungMicroProBold";
        font-weight: 700;
    }

    span.label2 {
        color: #000;
        font-family: "ZeitungMicroProBold";
        font-weight: 500;
    }

    .bg-img-cir {
        width: 160px;
    }

    .bmk-img {
        filter: brightness(0) invert(1);
    }

    .secondray-btn.gb-btn.bg-img-cir:hover .bmk-img {
        filter: none;
    }
</style>


<?php while (have_posts()) : the_post(); ?>
    <?php
    $post_id = get_the_ID();
    $training_title   = get_the_title();
    $training_employer = get_post_meta($post_id, 'employer', true);
    $training_url = get_post_meta($post_id, 'URL', true);
    $training_location0 = get_post_meta($post_id, 'address', true);
    if (substr($training_location0, 0, 1) === ',') {
        $training_location = substr($training_location0, 2);
    } else {
        $training_location = $job_location0;
    }
    $City = get_post_meta($post_id, 'City', true);
    $State = get_post_meta($post_id, 'State', true);
    $Country = get_post_meta($post_id, 'Country', true);
    $job_url = get_post_meta($post_id, 'url', true);
    $organization = get_post_meta($post_id, 'Name of Organization', true);
    $training_contact = get_post_meta($post_id, 'Contact', true);
    $training_degree_outcome = get_post_meta($post_id, 'Degree Outcome');
    $licensure = get_post_meta($post_id, 'Licensure Certificate');
    $training_experience = get_the_terms($post_id, 'job_experience');
    $timestampStr = get_post_meta($post_id, 'updated_on', true);
    $status = get_post_meta($post_id, 'Status', true);
    $created_at = get_the_date('Y-m-d');
    $training_work_mode = get_the_terms($post_id, 'training_work_mode');
    $training_sector = get_the_terms($post_id, 'training_sector');
    $secondary_sector = get_post_meta($post_id, 'Secondary Sector');
    $training_functions = get_the_terms($post_id, 'training_functions');
    $training_type = get_the_terms($post_id, 'training_type');

    $updated_on = convertToDaysAgo($created_at);

    // Check if the post is saved
    $is_training_post_saved = is_training_post_saved($post_id);
    $bookmark_image_url = $is_training_post_saved ? '' . home_url() . '/wp-content/uploads/2024/02/bookmark.png' : '' . home_url() . '/wp-content/uploads/2024/01/asd2.svg';

    $location_string = '';

    // Check if training_location0 is set
    if (isset($training_location0)) {
        $location_string .= $training_location0;
    }

    // Function to check if a substring exists in a string (case-insensitive)
    function contains($haystack, $needle)
    {
        return strpos(strtolower($haystack), strtolower($needle)) !== false;
    }

    // Check if training_location0 contains any of the location parts
    $contains_city = isset($City) && contains($training_location0, $City);
    $contains_state = isset($State) && contains($training_location0, $State);
    $contains_country = isset($Country) && contains($training_location0, $Country);
    $contains_address = isset($Address) && contains($training_location0, $Address);

    // Add city, state, and country if they are set and not already in the training_location0
    if (!$contains_city && isset($City)) {
        $location_string .= ', ' . $City;
    }
    if (!$contains_state && isset($State)) {
        $location_string .= ', ' . $State;
    }
    if (!$contains_country && isset($Country)) {
        $location_string .= ', ' . $Country;
    }

    // Add address if set and not already in the training_location0
    if (!$contains_address && isset($Address)) {
        $location_string .= ', ' . $Address;
    }

    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="static job-posting-page">
            <div class="x-container max width">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="profile-card">
                            <!-- <div class="pci">
								<div class="logo-org" >
									<?php echo $organization; ?>
								</div>
                               
                            </div> -->
                            <div class="profile-card-deatils">
                                <span class="paragraph">
                                    <?php foreach ($training_sector as $sector) {
                                        echo $sector->name;
                                    } ?>
                                </span>
                            </div>
                            <div class="profile-cardSec">
                                <h6><a href="javascript:history.back()">Back to search results</a></h6>


                            </div>
                            <!-- <div class="job-title-inner">
                                    <p class="paragraph bold"><strong><?php echo $training_title; ?></strong></p>
                                    <p class="paragraph">
                                        <?php
                                        // if ($job_types && !is_wp_error($job_types)) {
                                        //     foreach ($job_types as $job_type) {
                                        //     echo $job_type->name;
                                        //     }
                                        // }
                                        ?>
                                    </p> 
									<p class="paragraph"><i>posted <?php echo  $updated_on; ?></i></p>
                                </div>
                            </div>-->
                            <!--profile card ends-->
                            <!--                             <ul class="job-list-tag">
                                <li><a class="paragraph" href="javascript:void(0)">Back to search results</a></li>
                                <li><a class="paragraph" href="javascript:void(0)">View all jobs from this business </a></li>
                                <li><a class="paragraph" href="javascript:void(0)">About this business</a></li>
                            </ul> -->
                        </div>
                    </div>
                    <div class="col-lg-9 job-posting-article">
                        <div class="enegry-space-left">
                            <div class="profile-information pi">
                                <div class="pp-dg-1">
                                    <h3 class="bd-title3"><?php the_title(); ?></h3>
                                    <!-- <p class="bd-title4"></p> -->
                                    <ul class="job-info">
                                        <li><a><?php if (isset($organization)) echo $organization; ?></a></li>
                                        <li><a><?php if (isset($training_location0)) echo $location_string; ?></a></li>
                                    </ul>
                                    <ul class="pi-group-btn jb-div-in2">
                                        <li><a href="<?php echo $training_url; ?>" class="green-btn gb-btn" target="_blank" id="training-apply-button">Apply</a></li>

                                        <li>

                                            <!-- <img src="/wp-content/themes/pro-child/img/share-1.png"> -->
                                            <?php
                                            echo '<span class=" secondray-btn gb-btn jobicon-share2 bg-img-cir" post-id="' . esc_attr($post_id) . '">';
                                            if ($bookmark_image_url) {
                                                echo '<img decoding="async" class="bookmark-image bmk-img" src="' . $bookmark_image_url . '" data-postid="' . esc_attr($post_id) . '">';
                                            } else {
                                                echo '<img decoding="async" class="bookmark-image bmk-img" src="' . home_url('/wp-content/uploads/2024/02/bookmark.png') . '" data-postid="' . esc_attr($post_id) . '">';
                                            }
                                            echo ' Save</span>';
                                            ?>

                                        </li>
                                        <li>
                                            <div class="tooltip1">
                                                <button onclick="myFunction()" value="<?php echo $job_url; ?>" class="blu-trans-btn gb-btn">
                                                    <span class="tooltiptext" id="myTooltip">Share</span>
                                                </button>
                                            </div>
                                        </li>
                                    </ul>
                                    <h4 class="add_class">Address</h4>
                                    <p class="paragraph">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Vector.svg" alt="location">
                                        <?php echo $location_string; ?>
                                    </p>
                                    <p class="paragraph"> <?php if (isset($training_location)) echo $training_location; ?></p>
                                    <!-- <p class="paragraph"> City: <?php if (isset($City)) echo $City; ?></p>
                                <p class="paragraph"> Country: <?php if (isset($Country)) echo $Country; ?></p>
                                <p class="paragraph"> Status: <?php if (isset($status)) echo $status; ?></p> -->

                                    <?php
                                    // if (is_array($secondary_sector) && !empty(array_filter($secondary_sector))) {
                                    // 	echo '<p class="paragraph">';
                                    // 	foreach ($secondary_sector as $value) {
                                    // 		if(isset($value)) {
                                    // 			echo '<span>Secondary Sector: ' . $value . '</span>';
                                    // 		}
                                    // 	}
                                    // 	echo '</p>';
                                    // }
                                    ?>




                                </div>
                                <!--<ul class="pi-group-btn jb-div-in2">
                                <li><a href="<?php // echo $job_url; 
                                                ?>" class="green-btn gb-btn" target="_blank">Apply</a></li>
                                <li><a href="javascript:void(0)" class="secondray-btn gb-btn"><img src="/wp-content/themes/pro-child/img/share-1.png">Save</a></li>
                                <li><a href="javascript:void(0)" class="blu-trans-btn gb-btn">Share</a></li>
                            </ul> -->
                                <div class="article description">
                                    <div class="paragraph"><?php the_content(); ?></div>
                                </div>

                                <?php if (get_the_content()) { ?>
                                    <p class="moreless-button">Read more</p>
                                <?php } ?>

                            </div>
                            <div class="profile-information1 pi jd-in-sec">
                                <div class="profile-information1 pi jd-in-sec">
                                    <h4 class="bd-title4">Training Details</h4>
                                    <ul>
                                        <?php if (!empty($licensure) && is_array($licensure)) : ?>
                                            <li>
                                                <span class="paragraph">
                                                    <span class="label2">Licensure Certificate:</span>
                                                    <?php foreach ($licensure as $value) : ?>
                                                        <?php if (isset($value)) : ?>
                                                            <?php echo $value; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </span>
                                            </li>
                                        <?php endif; ?>

                                        <?php if (!empty($training_degree_outcome) && is_array($training_degree_outcome)) : ?>
                                            <li>
                                                <span class="paragraph">
                                                    <span class="label2">Degree Outcome:</span>
                                                    <?php foreach ($training_degree_outcome as $value1) : ?>
                                                        <?php if (isset($value1)) : ?>
                                                            <?php echo $value1; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </span>
                                            </li>
                                        <?php endif; ?>

                                        <?php if (!empty($training_functions) && !is_wp_error($training_functions)) : ?>
                                            <li>
                                                <span class="paragraph">
                                                    <span class="label2">Training Function:</span>
                                                    <?php foreach ($training_functions as $functions) {
                                                         $names[] = $functions->name;                                                                                                                                                               
                                                    } echo implode(', ', $names);
                                                   
                                                    ?>
                                                </span>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (!empty($training_type) && !is_wp_error($training_type)) : ?>
                                            <li>
                                                <span class="paragraph">
                                                    <span class="label2">Training Type:</span>
                                                    <?php foreach ($training_type as $type) {
                                                        $types[] = $type->name;   
                                                    }echo implode(', ', $types);
                                                     ?>
                                                </span>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="profile-information2 pi">
                                    <h4 class="bd-title4">How to Apply</h4>
                                    <div class="apply-div">
                                        <li><a href="<?php echo $training_url; ?>" class="green-btn" target="_blank">go to website</a></li>
                                        <!-- <?php
                                                // Check if $training_contact is a valid email address
                                                if (filter_var($training_contact, FILTER_VALIDATE_EMAIL)) {
                                                    // If $training_contact is an email address, display the "send an email" link
                                                    echo '<li><a href="mailto:' . $training_contact . '" class="blu-trans-btn">Send an email</a></li>';
                                                } else {
                                                    // If $training_contact is not an email address, assume it's a phone number and display the "Contact Us" link
                                                    echo '<li><a href="tel:' . $training_contact . '" class="blu-trans-btn">Contact Us</a></li>';
                                                }
                                                ?> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <section class="similer-job-sec">
            <div class="similer-job-sec-div">
                <div class="x-container max width">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sjs-div1 mb-5">
                                <h2 class="heading2 clr-head">Similar Trainings</h2>
                            </div>
                            <div class="sjs-div">
                                <?php echo do_shortcode('[display_recent_training_posts]'); ?>
                                <div class="morejobs"><a href="/trainings">See more Trainings<img decoding="async" src="/wp-content/uploads/2024/01/right-arrow.svg"></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="acc-div-curve">
                <img src="/wp-content/uploads/2024/01/web_white_cut_top-2.png" class="destop-curve">
                <img src="/wp-content/uploads/2024/01/mob_white_cut_top.png" class="mobile-curve">
            </div>
        </section>
        <section class="job-list-account">
            <div class="x-container max width">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="account-sec-div">
                            <div class="sjs-div1 mb-5">
                                <h2 class="heading2 clr-head ">Create an Account </h2>
                                <p class="paragraph">Sign up today to save your favorite jobs and get email alerts when new ones are posted. </p>
                                <a href="" class="primary-btn sg-popup-id-2256">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>

<?php endwhile; // End of the loop. 
?>

<script>
    jQuery(document).ready(function() {
        jQuery('.moreless-button').click(function() {
            jQuery('.article.description').toggleClass('active');
            if (jQuery('.article.description').hasClass('active')) {
                jQuery('.article.description').css('max-height', 'none');
                jQuery('.moreless-button').text('Read Less');
            } else {
                jQuery('.article.description').css('max-height', '110px');
                jQuery('.moreless-button').text('Read More');
            }
        });
    });

    function myFunction() {
        var button = document.querySelector('button');
        var buttonValue = button.value;
        navigator.clipboard.writeText(buttonValue);

        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copied";

        setTimeout(function() {
            tooltip.innerHTML = "Copy to clipboard";
        }, 1000);
    }
</script>
<?php

get_footer();
?>