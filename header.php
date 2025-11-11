<?php do_action( 'tco_header' ); ?>
<?php 
global $current_user; wp_get_current_user();
global $current_user; wp_get_current_user();
$first_name = $current_user->first_name;
$display_name = $current_user->display_name;
if ($first_name) {
 $m_name = $first_name;
}else{
 $m_name = $display_name;
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<header class="mainHeader">
   <nav class="custom-navbar">
      <div class="x-container max width">
         <div class="navbar-main">
            <div class="logo">
             <a class="navbar-brand logohe logo-heading" href="/" aria-label="Maine Clean Energy Jobs Home"><img src="/wp-content/uploads/2024/01/main-clean-energy-logo.svg" alt="Maine Clean Energy Jobs"></a>
          </div>
          <div class="main-navbar">
            <div class="navbar-list">
               <?php wp_nav_menu( array( 'theme_location'=>'primary', 'menu' => 'Primary', 'container_class'=>'custom-menu-class' ) ); ?> 
            </div>

            <div class="main-navbar-submienu">
               <div class="main-navbar-icon">
                  <a class="toggle-menu" tabindex="0" id="hamburger_menu">
                     <img src="/wp-content/uploads/2023/12/hamburger-menu1.svg" width="50" height="auto" alt="Hamburger Icon">
                  </a>
               </div>
               <div id="menu">
                  <div class="cross-icon">
                    <a href="javascript:void(0)"><img src="/wp-content/uploads/2023/12/cross.svg"></a>
                 </div>
                 <nav class="main-nav1">
                  <div class="navigation-sec destop-header">

                     <div class="nv-sec">

                        <?php 
                        wp_nav_menu( 
                           array(
                              'container'       => '',                            
                              'container_class' => '',                             
                              'menu'            => '',                            
                              'menu_class'      => 'menu fullscreen-menu-column-1 clearfix',  
                              'theme_location' => 'fullscreen-menu-column-1',                      
                              'before'          => '',                             
                              'after'           => '',                           
                              'link_before'     => '',                            
                              'link_after'      => '',                            
                              'depth'           => 0,                              
                              'fallback_cb'     => '',                              
                              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                              'walker'          => new Custom_Walker_Nav_Menu(),

                           ) 
                        );
                        ?>

                     </div>

                     <div class="nv-sec">

                       <?php 
                       wp_nav_menu( 
                        array(
                           'container'       => '',                            
                           'container_class' => '',                             
                           'menu'            => '',                            
                           'menu_class'      => 'menu fullscreen-menu-column-2 clearfix',  
                           'theme_location' => 'fullscreen-menu-column-2',                      
                           'before'          => '',                             
                           'after'           => '',                           
                           'link_before'     => '',                            
                           'link_after'      => '',                            
                           'depth'           => 0,                              
                           'fallback_cb'     => '',                              
                           'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                           'walker'          => new Custom_Walker_Nav_Menu(),

                        ) 
                     );
                     ?>

                     <div class="group-btn mobile-contact-btn"><a class="primary-btn" href="/contact">Contact Us</a></div>

                  </div>

                  <div class="nv-sec">

                     <?php 
                     wp_nav_menu( 
                        array(
                           'container'       => '',                            
                           'container_class' => '',                             
                           'menu'            => '',                            
                           'menu_class'      => 'menu fullscreen-menu-column-3 clearfix',  
                           'theme_location' => 'fullscreen-menu-column-3',                      
                           'before'          => '',                             
                           'after'           => '',                           
                           'link_before'     => '',                            
                           'link_after'      => '',                            
                           'depth'           => 0,                              
                           'fallback_cb'     => '',                              
                           'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                           'walker'          => new Custom_Walker_Nav_Menu(),

                        ) 
                     );
                     ?>
                     <!-- <div class="group-btn destop-contact-btn"><a class="primary-btn" href="/contact">Contact Us</a></div> -->
                  </div>

               </div>
               <div class="navigation-sec mobile-header">
                  <div class="nv-sec">
                     <div class="user_dropdown">
                      <?php 
                      if ( is_user_logged_in() ) {?>
                       <li id="menu-item-216792" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-216792"><a href="javascript:void(0)"><?php echo "Hi, <span class='truncate'>". $m_name. "</span>"; ?></a>
                        <ul class="sub-menu">
                         <li id="menu-item-216775" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-216775">
                          <a href="<?php echo home_url('/business-profile/'); ?>">Business Profile</a>
                       </li>
                       <li id="menu-item-63322" class="menu-item menu-item-type- menu-item-object-logout menu-item-63322">
                          <a href="https://energyjobsme.wpenginepowered.com/wp-login.php?action=logout&amp;redirect_to=https%3A%2F%2Fenergyjobsme.wpenginepowered.com%2Fjobs%2F&amp;_wpnonce=c0338a918b">Logout</a>
                       </li>
                       <li id="menu-item-216793" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-216793">
                          <a href="<?php echo home_url('/create-an-event/'); ?>">Create an event</a>
                       </li>
                       <li id="menu-item-16151" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-16151">
                          <a href="/employer-posting-form">Post A Job</a>
                       </li>
                    </ul>
                 </li>
              <? } else { 
                 $loginout = '<li class="menu-item"><a href="/log-in/">Log in</a></li>';
                 echo $loginout;
              } ?>
           </div>
           <ul class="menu">
            <li class="menu-item"><a href="/jobs">Jobs</a></li>
            <li class="menu-item"><a href="/trainings">Training</a></li>
            <li class="menu-item"><a href="/employers">Employers</a></li>
            <li class="menu-item"><a href="/employer-posting-form">Post a Job</a></li>
            <li class="menu-item"><a href="/resources">Resources</a></li>
            <li class="menu-item"><a href="/faqs">FAQs</a></li>
            <li class="menu-item"><a href="/news-events">News & Events</a></li>
            <!-- <li class="menu-item"><a href="/news-events">Events</a></li> -->
         </ul>
      </div>
      <div class="nv-sec">
        <ul class="menu">
         <li class="menu-item">
            <a href="javascript:void(0)">About</a>
            <ul class="sub-menu">
               <li><a href="/about">Mission Statement</a></li>
               <li><a href="/clean-energy-generation">Clean Energy In Maine</a></li>
            </ul>
         </li>
         <li class="menu-item">
            <a href="javascript:void(0)">Clean Energy Sectors</a>
            <ul class="sub-menu">
               <li><a href="/energy-efficiency">Energy Efficiency</a></li>
               <li><a href="/clean-energy-generation">Clean Energy Generation</a></li>
               <li><a href="/alternative-transportation">Alternative Transportation</a></li>
               <li><a href="/grid-modernization-storage">Clean Grid & Storage</a></li>
               <li><a href="/renewable-fuels">Renewable Fuels</a></li>
            </ul>
         </li>
      </ul>
      <div class="group-btn mobile-contact-btn"><a href="/contact" class="primary-btn">CONTACT US</a></div>
   </div>
</div>
</nav>
</div>

</div>
</div>
</div>
</nav>


<?php if( is_page(2368) ) { ?>
<!-- <div class="progress-bar"> 
 <div class="progress" style="width: 0%;"></div> 
</div> --> 
<?php } ?>

</header>
<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.getElementById('hamburger_menu');

    hamburgerMenu.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' || event.keyCode === 13) {
            event.preventDefault(); // Prevent default behavior if necessary
            hamburgerMenu.click();
        }
    });
});



   jQuery('.navigation-menu > a').wrap('<span class="navigation-menu-item"></span>');
   jQuery('.contact-btn > a').addClass('primary-btn');

  jQuery('.toggle-menu').click (function(){
    jQuery(this).toggleClass('active');
    jQuery('#menu').toggleClass('open');
  });

   jQuery('.cross-icon, .main-nav1').click (function(){
   //alert('hell');
   jQuery('#menu').removeClass('open');
});

   jQuery(window).scroll(function(){
     if (jQuery(window).scrollTop() >= 50) {
       jQuery('.mainHeader').addClass('sticky-bar');
    }
    else {
       jQuery('.mainHeader').removeClass('sticky-bar');
    }
 });

   jQuery(document).ready(function() {
        // Select the "Forget your password?" link
        var forgetPasswordLink = jQuery('.forget-password');
        
        // Select the ".gform_footer" section
        var gformFooter = jQuery('.login-sec-popup .gform_footer.top_label');
        
        // Append the "Forget your password?" link to the end of the ".gform_footer" section
        gformFooter.append(forgetPasswordLink);
     });

  </script>
