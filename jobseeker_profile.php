<?php
// =============================================================================
// TEMPLATE NAME: job seeker profile
// -----------------------------------------------------------------------------
// =============================================================================
get_header();?>
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
.jobsearch_candidate .gb-btn{
    color:#fff !important;
    cursor: pointer;
}
.jobsearch_candidate .gb-btn:hover{
    color:#79b44b !important;
}
li.event-list{
    margin-bottom: 40px;
}
</style>
<?php
  if ( is_user_logged_in() ) {
    // Get the current user object
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();
    $udata = get_userdata($user_id);
    $registered = $udata->user_registered;

    $upload_logo = get_user_meta( $user_id, 'upload_logo', true );
    $upload_emp_logo = get_user_meta( $user_id, 'upload_a_logo', true );

    $fname = get_user_meta( $user_id, 'first_name', true );
    $lname = get_user_meta( $user_id, 'last_name', true );
    $fullnam = $fname .' '. $lname;

    $company_name = get_user_meta( $user_id, 'company_name', true );
    $website_url = get_user_meta( $user_id, 'website_url', true );
    $address = get_user_meta( $user_id, 'address', true );
    $zip_code = get_user_meta( $user_id, 'zip_code', true );
    $city = get_user_meta( $user_id, 'city', true );
    $country = get_user_meta( $user_id, 'country', true );
    $about_company = get_user_meta( $user_id, 'about_company', true );
    $Industry_type = get_user_meta( $user_id, 'Industry_type', true );
    $sector = get_user_meta( $user_id, 'sector', true );
    $post_count = count_user_posts( $user_id, 'job' );
?>
    <section class="space-sec static jobsearch_candidate subscriber">
          <div class="x-container max width">
            <div class="row">
                <div class="col-lg-3">
                <div class="profile-card">
                    <div class="pci">
                        <?php if (!empty( $upload_logo)) : ?>
                        <img src="<?php echo  $upload_logo; ?>" alt="user" class="profile-photo">
                        <?php endif; ?>
                    </div>
                    <div class="profile-card-deatils profile-card-sec">
                        <h4 class="bd-title4"><?php if ($fname) {echo $fullnam;} else{echo 'Name';} ?></h4>
                        <ul class="pc-list">
                            <li class="paragraph">
                            <?php
                            if ($city) {echo $city;} else{echo 'city';}
                            if ($country) {echo " ".$country;} else{echo 'Country';}
                            ?>
                           </li>
                            <li class="paragraph">Joined in <?php printf( date( " F Y", strtotime( $registered ) ) );?></li>
                        </ul>
                    </div>
                </div>
                <div class="jobs-tabs mt-5">
                    <div class="jobs-saved-con">
                        <img src="/wp-content/themes/pro-child/img/shareicon.png"><span>Saved items</span>
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="active" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Jobs</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact2" type="button" role="tab" aria-controls="pills-contact1" aria-selected="false">Employers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Trainings</button>
                        </li>
                        
                    </ul>
                </div>
                <ul class="pi-group-btn pi-group-btn1">
                    <!-- <li><a href="javascript:void(0)" class="green-btn gb-btn">upload resume</a></li> -->
                    <li><a href="<?php echo home_url('/create-a-training-posting/'); ?>" class="green-btn">POST A TRAINING</a></li>
                    <li><a href="<?php echo home_url('/edit-jobseeker-profile/'); ?>" class="green-btn gb-btn user-profile-form">Edit Profile</a></li>

                </div>
                <div class="col-lg-9">
                <div class="enegry-space-left">
                <div class="profile-information pi">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="saved-job-sec">
                            <div class="saved-job-inner">
                                <h4 class="bd-title4 mb-4">Saved Jobs</h4>
                                <?php echo do_shortcode( '[display_saved_posts]' ); ?>                                 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact2" role="tabpanel" aria-labelledby="pills-contact-tab2">
                        <h4 class="bd-title4 mb-4">Saved Employers</h4>
                        <?php echo do_shortcode('[saved_users]'); ?>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <h4 class="bd-title4 mb-4">Saved Trainings</h4>
                        <?php echo do_shortcode('[display_saved_training_posts]'); ?>
                    </div>

                    
                </div>
                </div>
                </div>
                </div>
            </div>
          </div>
    </section>
<?  
}
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.moreless-button').click(function(){
            jQuery('.jobs-article-sec-discription').toggleClass('icon-active');
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
</script>
<?php get_footer(); ?>