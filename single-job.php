<?php

/**
 * Template Name: Single Job
 *
 * This template is used to display a single job post.
 *
 * @package YourThemeName
 */
get_header(); ?>

<style>
    /*.article.description {
        max-height: 343px;
        overflow: hidden;
    }*/
    .morecontent span {
        display: none;
    }

    .morelink {
        display: block;
    }

    .moreless-button {
        cursor: pointer;
    }

    .tooltip1 .blu-trans-btn {
        padding: 8px 45px 8px;
    }

    .tooltip1 {
        position: relative;
        display: inline-block;
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 155px;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 115%;
        left: 50%;
        margin-left: -80px;
        opacity: 0;
        transition: opacity 0.2s;
        font-size: 12px;
    }

    .tooltip1 .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    .enegry-space-left .profile-information .job-info li a {
        font-size: 20px
    }

    .profile-card {
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
    $job_date = get_post_meta($post_id, 'event_date', true);
    $job_employer = get_post_meta($post_id, 'employer', true);
    $experience = get_post_meta($post_id, 'Experience', true);
    $industry = get_post_meta($post_id, 'Industry', true);
    $industry_family = get_post_meta($post_id, 'IndustryFamily', true);
    $job_experience = get_the_terms($post_id, 'job_experience');
    $job_function = get_post_meta($post_id, 'JobFunction');
    $job_url = get_post_meta($post_id, 'url', true);
    $job_location0 = get_post_meta($post_id, 'address', true);
    $zip_code = get_post_meta($post_id, 'zip_code', true);
    $excerpt = get_the_excerpt();
    if (substr($job_location0, 0, 1) === ',') {
        $job_location = substr($job_location0, 2);
    } else {
        $job_location = $job_location0;
    }
    $job_time = get_post_meta($post_id, 'event_time', true);
    $job_salary_range = get_post_meta($post_id, 'salary_range', true);
    $sector = get_post_meta($post_id, 'Sector', true);
    $job_types = get_the_terms($post_id, 'job_type');
    $job_work_mode = get_the_terms($post_id, 'job_workmode');
    $job_industry = get_the_terms($post_id, 'job_industry');
    $job_sector = get_the_terms($post_id, 'job_sector');
    $job_experience_level = get_the_terms($post_id, 'job_experience_level');
    $job_functions = get_the_terms($post_id, 'job_functions');
    $created_at = get_the_date('Y-m-d');
    $timestampStr = get_post_meta($post_id, 'updated_on', true);
    $updated_on = convertToDaysAgo($created_at);
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name');

    $user_data = get_user_by('login', $job_employer);
    $emp_id = $user_data->ID;
    
    if (empty($emp_id)) {
        $emp_id = $author_id;
    }

    // Check if the post is saved
    $is_post_saved = is_post_saved($post_id);
    if ($is_post_saved) {
        $bookmark_image_url = home_url() . '/wp-content/uploads/2024/02/bookmark.png';
    } else {
        $bookmark_image_url = home_url() . '/wp-content/uploads/2024/01/asd2.svg';
    }


    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="static job-posting-page">
            <div class="x-container max width">
                <div class="row">
                    <div class="col-lg-3 m-hide">
                        <div class="profile-card">
                            <h3 class="bd-title3"><?php the_title(); ?></h3>
                            <?php echo $industry; ?>
                            <p class="paragraph"><i>posted <?php echo $updated_on; ?></i></p>
                        </div>
                        <div class="profile-cardSec">
                            <h6><a href="javascript:history.back()">Back to search results</a></h6>

                            <h6><a href="/employer-jobs/?employer_id=<?php echo $emp_id; ?>">View all jobs from this employer</a> </h6>

                            <h6><a href="/employer-detail/?employer_id=<?php echo $emp_id; ?>"> About this employer</a></h6>

                        </div>

                    </div>
                    <div class="col-lg-9 job-posting-article">
                        <div class="enegry-space-left">
                            <div class="profile-information pi">
                                <h3 class="bd-title3"><?php the_title(); ?></h3>
                                <ul class="job-info">
                                    <li><a><?php echo $job_employer; ?></a></li>
                                    <li><a><?php echo $job_location; ?></a></li>
                                </ul>
                                <ul class="pi-group-btn jb-div-in2">
                                    <li><a href="<?php echo $job_url; ?>" class="green-btn gb-btn" target="_blank" id="job-apply-button">Apply</a></li>
                                    <li>

                                        <!-- <img src="/wp-content/themes/pro-child/img/share-1.png"> -->
                                        <?php
                                        echo '<span class=" secondray-btn gb-btn jobicon-share bg-img-cir saveJobBtn" post-id="' . esc_attr($post_id) . '" >';
                                        if ($bookmark_image_url) {
                                            echo '<img decoding="async" class="bookmark-image bmk-img" src="' . $bookmark_image_url . '" data-postid="' . esc_attr($post_id) . '">';
                                        } else {
                                            echo '<img decoding="async" class="bookmark-image" src="' . home_url('/wp-content/uploads/2024/02/bookmark.png') . '" data-postid="' . esc_attr($post_id) . '">';
                                        }
                                        echo ' Save</span>';
                                        ?>

                                    </li>

                                    <li>
                                        <div class="tooltip1">
                                            <button onclick="myFunction()" value="<?php echo $job_url; ?>" class="blu-trans-btn gb-btn">
                                                <span class="tooltiptext" id="myTooltip">Copy to clipboard</span> Share
                                            </button>
                                        </div>
                                    </li>
                                </ul>

                                <div class="article description">
                                    <div class="paragraph"><?php the_content(); ?></div>
                                </div>

                                <!-- 
                                <div class="pp-dg-1">
                                    <h3 class="bd-title3"><?php the_title(); ?></h3>
                                    <h4 class="bd-title4"><?php echo $job_employer; ?></h4>
                                    <p class="paragraph"> job Location: <?php echo $job_location; ?></p>
                                    <?php if ($sector) { ?>
                                        <p class="paragraph"> Sector: <?php echo $sector; ?></p>
                                    <?php } ?>
                                    <?php if ($experience) { ?>
                                        <p class="paragraph"> Job Experience: <?php echo $experience; ?></p>
                                    <?php } ?>

                                    <?php if ($industry) { ?>
                                        <p class="paragraph">Industry: <?php echo $industry; ?></p>
                                    <?php } ?>
                                    <?php if ($industry_family) { ?>
                                        <p class="paragraph">Industry Family: <?php echo $industry_family; ?></p>
                                    <?php } ?>
                                    <p class="paragraph">
                                        <?php

                                        if (is_array($job_function) && !empty($job_function)) {

                                            foreach ($job_function as $value) {

                                                echo '<span> Licensure Certificate: ' . $value . '</span>';
                                            }
                                        }
                                        ?>
                                    </p>
                                    <p class="paragraph">Excerept:<?php //echo $excerpt 
                                                                    ?></p>
                                    <p class="paragraph">job url:<?php //echo $job_url; 
                                                                    ?></p>

                                    <p class="paragraph">Source: <?php
                                                                    // Check if either the excerpt or the job URL is empty
                                                                    if (empty($excerpt)) {
                                                                        echo "Employer Portal";
                                                                    } else {
                                                                        echo "Joblink";
                                                                    }
                                                                    ?></p>
                                </div>
                                <ul class="pi-group-btn jb-div-in2">
                                <li><a href="<?php // echo $job_url; 
                                                ?>" class="green-btn gb-btn" target="_blank">Apply</a></li>
                                <li><a href="javascript:void(0)" class="secondray-btn gb-btn"><img src="/wp-content/themes/pro-child/img/share-1.png">Save</a></li>
                                <li><a href="javascript:void(0)" class="blu-trans-btn gb-btn">Share</a></li>
                            </ul> 
                                <div class="article description">
                                    <div class="paragraph"><?php the_content(); ?></div>
                                </div>
                                <?php
                                $word_count = str_word_count(strip_tags($content));
                                if ($word_count > 20) {
                                    echo '<p class="moreless-button">Read more</p>';
                                }
                                ?>
                            -->
                            </div>
                            <!--  <div class="profile-information1 pi jd-in-sec">
                                <h4 class="bd-title4">Job Details</h4>
                                <ul>

                                    <?php if (!empty($job_types) && !is_wp_error($job_types)) : ?>
                                        <li><span class="label1">JOB TYPE</span><span class="paragraph">
                                                <?php foreach ($job_types as $job_type) : ?>
                                                    <?php echo $job_type->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>
                                    <?php if (!empty($job_work_mode) && !is_wp_error($job_work_mode)) : ?>
                                        <li><span class="label1">JOB WORK MODE</span><span class="paragraph">
                                                <?php foreach ($job_work_mode as $job_mode) : ?>
                                                    <?php echo $job_mode->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_industry) && !is_wp_error($job_industry)) : ?>
                                        <li><span class="label1">JOB INDUSTRY</span><span class="paragraph">
                                                <?php foreach ($job_industry as $industry) : ?>
                                                    <?php echo $industry->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_sector) && !is_wp_error($job_sector)) : ?>
                                        <li><span class="label1">JOB SECTOR</span><span class="paragraph">
                                                <?php foreach ($job_sector as $sector) : ?>
                                                    <?php echo $sector->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_experience_level) && !is_wp_error($job_experience_level)) : ?>
                                        <li><span class="label1">EXPERIENCE LEVEL</span><span class="paragraph">
                                                <?php foreach ($job_experience_level as $level) : ?>
                                                    <?php echo $level->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_functions) && !is_wp_error($job_functions)) : ?>
                                        <li><span class="label1">JOB FUNCTIONS</span><span class="paragraph">
                                                <?php foreach ($job_functions as $function) : ?>
                                                    <?php echo $function->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_salary_range)) : ?>
                                        <li><span class="label1">PAY</span><span class="paragraph"><?php echo $job_salary_range; ?></span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_experience) && !is_wp_error($job_experience)) : ?>
                                        <li><span class="label1">EXPERIENCE</span><span class="paragraph">
                                                <?php foreach ($job_experience as $job_experienc) : ?>
                                                    <?php echo $job_experienc->name . ", "; ?>
                                                <?php endforeach; ?>
                                            </span></li>
                                    <?php endif; ?>

                                    <?php if (!empty($job_benefits)) : ?>
                                        <li><span class="label1">BENEFITS</span><span class="paragraph"><?php echo $job_benefits; ?></span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="profile-information2 pi">
                                <h4 class="bd-title4">How to Apply</h4>
                                <div class="apply-div">
                                    <li><a href="<?php echo $job_url; ?>" class="green-btn">go to website</a></li>
                                    <li><a href="javascript:void(0)" class="blu-trans-btn ">send an email</a></li>
                                </div>
                            </div> -->
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
                                <h2 class="heading2 clr-head">Similar Jobs</h2>
                            </div>
                            <div class="sjs-div">
                                <?php echo do_shortcode('[job_post_grid post_count="4"]'); ?>
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

        var showChar = 500;
        var ellipsestext = "...";
        var moretext = "Read more";
        var lesstext = "Read less";

        jQuery('.paragraph').each(function() {
            var $this = jQuery(this);
            var content = $this.find('p').map(function() {
                return jQuery(this).html();
            }).get().join('<div class="job-description-divider"></div>');

            if (content.length > showChar) {
                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + ' </span><span class="morecontent"><span style="display:none;">' + h + '</span>  <a href="#" class="morelink">' + moretext + '</a></span>';

                $this.html(html);
            }
        });


        jQuery(".morelink").click(function() {
            if (jQuery(this).hasClass("less")) {
                jQuery(this).removeClass("less");
                jQuery(this).html(moretext);
            } else {
                jQuery(this).addClass("less");
                jQuery(this).html(lesstext);
            }
            jQuery(this).parent().prev().toggle();
            jQuery(this).prev().toggle();

            // Scroll back to the initial start of the section
            var sectionTop = jQuery(this).closest('.description').offset().top - 120;
            jQuery('html, body').animate({
                scrollTop: sectionTop
            }, 500);

            return false;
        });


        // jQuery('.moreless-button').click(function() {
        //     jQuery('.article.description').toggleClass('active');
        //     if (jQuery('.article.description').hasClass('active')) {
        //         jQuery('.article.description').css('max-height', 'none');
        //         jQuery('.moreless-button').text('Read Less');
        //     } else {
        //         jQuery('.article.description').css('max-height', '350px');
        //         jQuery('.moreless-button').text('Read More');

        //          var scrollToElement = jQuery('.description').offset().top - 150;
        //         jQuery('html, body').animate({
        //             scrollTop: scrollToElement
        //         }, 1000); 

        //     }
        // });

    });
</script>
<script>
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