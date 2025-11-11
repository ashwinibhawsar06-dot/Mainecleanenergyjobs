<?php
// =============================================================================
// TEMPLATE NAME: Jobs-training 
// -----------------------------------------------------------------------------
// =============================================================================
get_header();?>

<section class="static job-posting-page pt-5 job-traning-sec">
        <div class="x-container max width">
            <div class="row job-traning--row">
                <div class="col-lg-3">
                    <div class="profile-card">
                        <div class="pci">
                            <img src="/wp-content/themes/pro-child/img/company-logoinner.png" alt="user" class="profile-photo">
                        </div>
                        <div class="profile-card-deatils">
                            <h4 class="bd-title4">Job Title Goes <br>Right Here </h4>
                            <div class="job-title-inner">
                                <p class="paragraph bold"><strong>Company Name </strong></p>
                                <p class="paragraph">Location</p>
                                <p class="paragraph">Job Type</p>
                                <p class="paragraph"><i>Posted XX days ago</i></p>
                            </div>
                            <a href="javascript:void(0)" class="green-btn mt-4 mb-4">apply now</a>
                        </div><!--profile card ends-->
                        <ul class="job-list-tag">
                            <li><a class="paragraph" href="javascript:void(0)">Back to search results</a></li>
                            <li><a class="paragraph" href="javascript:void(0)">View all jobs from this business </a></li>
                            <li><a class="paragraph" href="javascript:void(0)">About this business</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 job-posting-article">
                    <div class="profile-information pi">
                        <div class="pp-dg-1">
                                <h3 class="bd-title3">Job Title Goes Right Here</h3>
                        <h4 class="bd-title4">Company Name </h4>
                        <p class="paragraph">Location</p>
                        </div>
                        <ul class="pi-group-btn jb-div-in2">
                            <li><a href="javascript:void(0)" class="green-btn gb-btn">Apply</a></li>
                            <li><a href="javascript:void(0)" class="secondray-btn gb-btn"><img src="/wp-content/themes/pro-child/img/share-1.png">Save</a></li>
                            <li><a href="javascript:void(0)" class="blu-trans-btn gb-btn">Share</a></li>
                        </ul>
                        <div class="article">
                            <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p class="moretext paragraph">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
                            </p>
                        </div>
                        <a class="moreless-button"  href="javascript:void(0)">Read more</a>
                    </div>
                    <div class="profile-information1 pi jd-in-sec">
                        <h4 class="bd-title4">Job Details</h4>
                        <ul>
                            <li><span class="label1">JOB TYPE</span><span class="paragraph">Full-Time</span></li>
                            <li><span class="label1">PAY</span><span class="paragraph">$00,000 - $00,000</span></li>
                            <li><span class="label1">EXPERIENCE</span><span class="paragraph">Entry Level</span></li>
                            <li><span class="label1">BENEFITS</span><span class="paragraph">401k, dental insurance, health insurance, health savings account, flexible spending account, paid time off, vision insurance  </span></li>
                        </ul>
                    </div>
                    <div class="profile-information2 pi">
                        <h4 class="bd-title4">How to Apply</h4>
                        <div class="apply-div">
                            <li><a href="javascript:void(0)" class="green-btn">go to website</a></li>
                            <li><a href="javascript:void(0)" class="blu-trans-btn">send an email</a></li>
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
                    <h2 class="heading2 clr-head">Create an Account </h2>
                    <p class="paragraph">Sign up today to save your favorite jobs and get email alerts when new ones are posted. </p>
                    <a href="javascript:void(0)" class="primary-btn">Create an account</a>
                </div>
            </div>
           </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // Start with '.moretext' hidden
        jQuery('.moretext').hide();

        jQuery('.moreless-button').click(function() {
            jQuery('.moretext').slideToggle();
            jQuery(this).toggleClass('active');

            if (jQuery(this).hasClass('active')) {
                jQuery(this).text("Read more");
            } else {
                jQuery(this).text("Read more");
            }
        });
    });
</script>
<?php get_footer(); ?>