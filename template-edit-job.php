<?php    
// TEMPLATE NAME: Edit job

get_header(); 



if (is_user_logged_in()) {
	global $wpdb;

	function elastic_editjob_data_insertion($Postid){
	    $job_meta = get_post_meta( $Postid );
	    $job   = get_post( $Postid );
        $ONet_Id = $job->post_excerpt;
    	$id = $job->ID;

		$job_industry = get_the_terms($Postid, 'job_industry');
		$job_sector = get_the_terms($Postid, 'job_sector');
		$job_experience_level = get_the_terms($Postid, 'job_experience_level');
		$job_functions = get_the_terms($Postid, 'job_functions');

		if (!empty($job_industry) && !is_wp_error($job_industry)) : 
        foreach ($job_industry as $industry) :
            $industry_m =  $industry->name;
         endforeach;
	    endif;

	    if (!empty($job_sector) && !is_wp_error($job_sector)) : 
	        foreach ($job_sector as $sector) :
	            $sector_m =  $sector->name;
	        endforeach;
	    endif;

	    if (!empty($job_experience_level) && !is_wp_error($job_experience_level)) : 
	        foreach ($job_experience_level as $level) :
	            $level_m =  $level->name;
	        endforeach;
	    endif;

	    if (!empty($job_functions) && !is_wp_error($job_functions)) : 
	        foreach ($job_functions as $function) :
	            $function_m =  $function->name;
	        endforeach;
	    endif;


        if($id.'P' == $ONet_Id){
	        $ONet_Id = $Postid.'P';
	        $updated = $job->post_date;
	        $updated_on = date('Y-m-d\TH:i:s', strtotime($updated));
	        $lat = "";
	        $long = "";
	        $Source = 'MCE';
	    } else {
	        $ONet_Id = $job->post_excerpt;
	        $updated_on = $job_meta['updated_on'][0];
	        $lat = $job_meta['lat'][0];
	        $long = $job_meta['long'][0];
	        $Source = 'joblink';
	    }

	    $data = '';
	    $data .= '{"index":{"_index":"mce-jobs","_id":"' . $ONet_Id . '"}}' . "\n";
	    $data .= '{"id":"' . $ONet_Id . '","post_title":"' . $job->post_title . '","address":"' . $job_meta['address'][0] . '","zip_code":"' . $job_meta['zip_code'][0] . '","employer":"' . $job_meta['employer'][0] . '","ONetCode":"' . $job_meta['ONetCode'][0] . '","Experience":"' . $level_m . '","Industry":"' . $industry_m . '","JobFunction":"' . $function_m . '","Sector":"' . $sector_m . '","Source":"' . $Source . '","updated_on":"' . $updated_on . '"';
	    $data .= "}\n";
	    // "address":"' . $job_meta['address'][0] . '","zip_code":"' . $job_meta['zip_code'][0] . '","employer":"' . $job_meta['employer'][0] . '","Experience":"' . $job_meta['Experience'][0] . '","Industry":"' . $job_meta['Industry'][0] . '","JobFunction":"' . $job_meta['JobFunction'][0] . '","Sector":"' . $job_meta['Sector'][0] . '","updated_on":"' . $updated_on . '"';
	    // if ($lat !== "" && $long !== "") {
	    //     $data .= ',"location":{"lat": ' . $lat . ', "lon": ' . $long . '}';
	    //$data .= "}\n";

	    // $data .= '{"index":{"_index":"mce-employers","_id":"' . $job_meta['employer'][0] . '"}}' . "\n";
	    // $data .= '{"id":"' . $ONet_Id . '","address":"' . $job_meta['address'][0] . '","zip_code":"' . $job_meta['zip_code'][0] . '","updated_on":"' . $updated_on . '","employer":"' . $job_meta['employer'][0] . '","Industry":"' . $job_meta['Industry'][0] . '","Sector":"' . $job_meta['Sector'][0] . '"';
	    // if ($lat !== "" && $long !== "") {
	    //     $data .= ',"location":{"lat": ' . $lat . ', "lon": ' . $long . '}';
	    // }
	    // $data .= "}\n";


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
	    //elastic_search_approve_logs($response);
	    return $response;
	    
	}

	if (isset($_POST['update_meta'])) {
	    $post_id = $_GET['jobid'];
		// $job_workmode_id = intval($_POST['job_workmode']);
		// $job_experience_id = intval($_POST['job_experience']);
		// $job_type_id = intval($_POST['job_type']);
		// $job_functions_id = intval($_POST['job_functions']);
		// $job_sector_id = intval($_POST['job_sector']);
		// $job_industry_id = intval($_POST['job_industry']);
		$new_title = $_POST['Job_title'];
		$new_content = $_POST['contents'];

		// wp_set_object_terms($post_id, $job_workmode_id, 'job_workmode', false);
		// wp_set_object_terms($post_id, $job_experience_id, 'job_experience', false);
		// wp_set_object_terms($post_id, $job_type_id, 'job_type', false);
		// wp_set_object_terms($post_id, $job_functions_id, 'job_functions', false);
		// wp_set_object_terms($post_id, $job_sector_id, 'job_sector', false);
		// wp_set_object_terms($post_id, $job_industry_id, 'job_industry', false);

	    // Update post meta values
	    update_post_meta($post_id, 'url', $_POST['link']);
	    // update_post_meta($post_id, 'Benefits', $_POST['Benefits']);
	    // update_post_meta($post_id, 'salary', $_POST['Pay']);

	    $post_data = array(
		    'ID'           => $post_id,
		    'post_title'   => $new_title,
		    'post_content' => $new_content,
		);
		$post_updated = wp_update_post($post_data);
		elastic_editjob_data_insertion($post_id);
		header("Location: /job-updated-success/");
		// $response = elastic_editjob_data_insertion($post_id);
		// print_r($response);
	}

	$post_id = $_GET['jobid'];
	$title   = get_the_title($post_id);
	$contents = get_post_field('post_content', $post_id);
	// $address = get_post_meta($post_id, 'address', true );
	// $State = get_post_meta($post_id, 'State', true );
	// $zip_code = get_post_meta($post_id, 'zip_code', true );
	// $employer = get_post_meta($post_id, 'employer', true );
	// $Experience = get_post_meta($post_id, 'Experience', true );
	// $salary = get_post_meta($post_id, 'salary', true );
	// $Benefits = get_post_meta($post_id, 'Benefits', true );
	$url = get_post_meta($post_id, 'url', true );



	// $job_workmodes = get_the_terms($post_id, 'job_workmode');
	// foreach ($job_workmodes as $workmodes) {$sele_workmodes = $workmodes->term_id;}

	// $job_sector = get_the_terms($post_id, 'job_sector');
	// foreach ($job_sector as $sector) {echo $sector->name;}

	// $job_experience = get_the_terms($post_id, 'job_experience');
	// foreach ($job_experience as $experience) {echo $experience->name;}

	// $job_functions = get_the_terms($post_id, 'job_functions');
	// foreach ($job_functions as $functions) {echo $functions->name;}


	?>
	<style>
	    .editJobsSection input,
	    .editJobsSection select,
	    .editJobsSection textarea {
	        border: 1px solid #BFBFBF;
	        border-radius: 8px;
	        min-height: 48px;
	        margin-top: 10px !important;
	        padding: 10px;
	        font-size: 20px;
	        font-family: Zeitung Micro Pro;
	        width: 100%;
	    }

	    .editJobsSection input:focus,
	    .editJobsSection select:focus,
	    .editJobsSection textarea:focus {
	        box-shadow: none !important;
	        outline: none;
	        border-color: #BFBFBF;
	    }

	    .inputDiv {
	        margin-bottom: 30px;
	    }

	    .editJobsSection .inputDiv label {
	        font-weight: 700;
	        margin-bottom: 8px;
	        color: black;
	        font-size: 25px !important;
	        font-family: Zeitung Micro Pro;
	    }

	    .editJobsSection .checkBoxDiv,
	    .editJobsSection .checkboxInput {
	        display: flex;
	        align-items: center;
	        margin-bottom: 0;
	    }

	    .editJobsSection .checkBoxDiv .inputDiv.checkboxInput {
	        margin-bottom: 0;
	    }

	    .editJobsSection .checkBoxDiv .inputDiv.checkboxInput label {
	        font-size: 20px !important;
	        font-weight: 400;
	        margin-bottom: 0;
	    }

	    .editJobsSection .checkBoxDiv .inputDiv.checkboxInput input {
	        width: 30px;
	        margin-right: 15px;
	        margin-top: 0 !important;
	    }

	    .editJobsSection input[type=submit] {
	        color: #fff;
	        background-color: #79b44b;
	        border: 1px solid #79b44b;
	        padding: 15px 30px;
	        font-size: 25px;
	        font-weight: 600;
	        text-transform: uppercase;
	        font-family: Zeitung Micro Pro;
	    }

	    .editJobsSection input[type=submit]:hover {
	        color: #79b44b;
	        background-color: #fff;
	    }
	</style>
	<div class="editJobsSection">
	    <div class="x-container max width">
	    	<form method="post" action="">
	        	<div class="row">
		            <div class="col-md-12">
		                <div class="inputDiv">
		                    <label for="Job_title" class="form-label">Job Title *</label>
		                    <input type="text" class="form-control"  name="Job_title" id="Job_title" placeholder="Job Title" value="<?php echo $title; ?>">
		                </div>
		            </div>

		            <!-- <div class="col-md-6">
		                <div class="inputDiv">
		                    <label for="Desired_start_date" class="form-label">Desired start date *</label>
		                    <input type="date" class="form-control" name=">Desired_start_date" id="Desired_start_date"
		                        placeholder="Desired start date">
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label for="Benefits" class="form-label">Benefits</label>
		                    <input type="text" class="form-control" name="Benefits" id="Benefits" placeholder="Benefits" value="<?php echo $Benefits; ?>">
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label for="Pay" class="form-label">Pay</label>
		                    <input type="text" class="form-control" name="Pay" id="Pay" placeholder="Pay" value="<?php echo $salary; ?>">
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="job_workmode">Job Work Mode</label>
		                    <div>
		                    	<?php $job_workmode = get_terms(array('taxonomy' => 'job_workmode', 'hide_empty' => false)); ?>
		                        <select class="form-select" name="job_workmode" aria-label="Job Work Mode" >
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	foreach ( $job_workmode as $workmode ) {
									        echo '<option value="' . esc_attr($workmode->term_id) . '" ' . $selected . '>' . esc_html($workmode->name) . '</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="job_experience">Experience Level *</label>
		                    <div>
		                    	 <?php $job_experience = get_terms(array('taxonomy' => 'job_experience', 'hide_empty' => false)); ?>
		                        <select class="form-select" name="job_experience" aria-label="Experience Level">
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	foreach ( $job_experience as $experience ) {
									        echo '<option value="'. esc_html($experience->term_id) .'">'.  esc_html($experience->name) .'</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="">Job Type</label>
		                    <div>
		                        <select class="form-select" name="job_type" aria-label="Job Type">
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	$job_type = get_terms(array('taxonomy' => 'job_type', 'hide_empty' => false,));
		                            	foreach ( $job_type as $type ) {
									        echo '<option value="'. esc_html($type->term_id) .'">'.  esc_html($type->name) .'</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="job_industry">Job Industry *</label>
		                    <div>
		                    	<?php $job_industry = get_terms(array('taxonomy' => 'job_industry', 'hide_empty' => false)); ?>
		                        <select class="form-select" name="job_industry" aria-label="Job function">
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	foreach ( $job_industry as $industry ) {
									        echo '<option value="'. esc_html($industry->term_id) .'">'.  esc_html($industry->name) .'</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="">Job function *</label>
		                    <div>
		                    	<?php $job_functions = get_terms(array('taxonomy' => 'job_functions', 'hide_empty' => false)); ?>
		                        <select class="form-select" name="job_functions" aria-label="Job function">
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	foreach ( $job_functions as $functions ) {
									        echo '<option value="'. esc_html($functions->term_id) .'">'.  esc_html($functions->name) .'</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="inputDiv">
		                    <label class="form-label" for="job_sector">Job Sector *</label>
		                    <div>
		                    	<?php $job_sector = get_terms(array('taxonomy' => 'job_sector', 'hide_empty' => false)); ?>
		                        <select class="form-select" name="job_sector" aria-label="Job function">
		                            <option value="">Open this select menu</option>
		                            <?php 
		                            	foreach ( $job_sector as $sector ) {
									        echo '<option value="'. esc_html($sector->term_id) .'">'.  esc_html($sector->name) .'</option>';
									    }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6 checkBoxDiv">
		                <div class="inputDiv checkboxInput">
		                    <input type="checkbox">
		                    <label for="">On the job training included</label>
		                </div>
		            </div> -->

		            <div class="col-md-12">
		                <div class="inputDiv">
		                    <label for="contents" class="form-label des">Job description*</label>
		                    <textarea class="form-control" name="contents" id="contents" rows="3"><?php echo $contents; ?></textarea>
		                </div>
		            </div>
		            <div class="col-md-12">
		                <div class="inputDiv">
		                    <label for="link" class="form-label">Application link</label>
		                    <input type="text" class="form-control" name="link" id="link" placeholder="Pay" value="<?php echo $url; ?>">
		                </div>
		            </div>
		            <div class="col-md-12">
		                <div class="inputDiv">
		                	<button type="submit" name="update_meta">Update</button>
		                </div>
		            </div>
	        	</div>
	        </form>
	    </div>
	</div>
	<?php

}
?>


<?php get_footer(); ?>