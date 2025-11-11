<?php
// =============================================================================
// TEMPLATE NAME: Employers Register 
// -----------------------------------------------------------------------------
// =============================================================================
get_header();

?>
<section class="bpsec-main">
    <div class="x-container max width main">
        <div class="offset cf">
            <div class="<?php x_main_content_class(); ?>" role="main">
                <h2 class="heading2 clr-head">Create an account</h2>

                <div class="energy-business-profile-creation">
                    <?php echo do_shortcode('[wppb-register form_name="business-profile-creation"]');?>
                </div>
            </div>
        </div>
    </div>
</section>




<style type="text/css">
    .wppb-recaptcha > label{
        display: none;
    }

    .bpsec-main{
        position: relative;
            padding-top: 4em;
    padding-bottom: 4rem;
    }
.business-profile-form .wppb-checkbox{
  flex: 1 1 100%;
}
.business-profile-form .wppb-checkbox input{
    width: 25px !important;
    height: 25px !important;
}
.business-profile-form .wppb-checkbox {
    flex: 1 1 100% !important;
}

.business-profile-form .wppb-form-field select {
    outline: none;
}
.business-profile-form #wppb-form-element-24 {
    flex: 1 1 100%;
}
.business-profile-form #wppb-form-element-20 {
    position: relative;
}
.business-profile-form #wppb-form-element-20:after {
    content: "Street Address";
    color: #BFBFBF;
    font-family: "Zeitung Micro Pro";
    font-size: 20px;
    font-style: normal;
    font-weight: 400;
    line-height: 30px;
    position: absolute;
    bottom: -5px;
}
.business-profile-form .wppb-form-field {
    margin-bottom: 10px !important;
}
#wppb_register_pre_form_message{
  display: none;
}


.button-hero{
    box-shadow: unset !important;
    text-shadow: unset !important;
}

#wppb-form-element-26 input {
    margin-right: 39px;
    width: 27px;
}

@media (max-width: 1300px) {
    .bpsec-main::after{
        height: 381px;
        margin-top: -5px;
    }
    .bpsec-main::before{
        margin-bottom: -400px;
        height: 900px;
    }
}

</style>

<script type="text/javascript">

</script>
<?php get_footer(); ?>