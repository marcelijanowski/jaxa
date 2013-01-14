<?php
/*
Template Name: Contact
*/
?>

<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>

<?php 
if ($tz_captcha_select == "true") { /* if captcha is enabled */
	include( get_template_directory() . '/includes/recaptchalib.php');
}
if(isset($_POST['submitted'])) {
		if ($tz_captcha_select == "true") {
			if ($_POST["recaptcha_challenge_field"]) {
	
				$privatekey = "'.$tz_private_key.'";
				$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
	
				if (!$resp->is_valid) {
					# set the error code so that we can display it
					$hasError = true;
					$captchaError = $resp->error;
				}
			}
		}
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		if(trim($_POST['email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		if(trim($_POST['comments']) === '') {
			$commentError = 'Please enter a message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		if(!isset($hasError)) {
			$emailTo = get_option('tz_email');
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}
			$subject = '[Contact Form] From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);

			$emailSent = true;

		}
	
} ?>
<?php get_header(); ?>
			<?php
				if ($tz_captcha_select == "true") {
				echo
				'<script type="text/javascript">
	 				var RecaptchaOptions = {
	    				theme : "'.$tz_captcha_theme.'"
	 				};
	 			</script>';
	 			}
 			?>
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed full-width">
                <!--<div class="wrap">-->
                    
                <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
    

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div <?php post_class('contact-page') ?> id="post-<?php the_ID(); ?>">

                    <h1 class="mainTitle"><?php the_title(); ?></h1>

					<!--BEGIN .entry-content -->
					<div class="entry-content">

				

					<?php the_content(); ?>
                        
					<?php $address = nl2br(get_option('tz_contact_address')); ?>
					<?php $phone = get_option('tz_contact_phone'); ?>
					<?php $email = get_option('tz_contact_email'); ?>
					<?php $gmap_lat = get_option('tz_contact_gmap_lat'); ?>
					<?php $gmap_lng = get_option('tz_contact_gmap_lng'); ?>
                        
                    <?php if ($address || $phone || $email) : ?>
                    <table class="addressBlock">
                        <tr>
                    <?php if ($address) : ?>
                        
                        <td class="addressWrap">
                            <div class="title"><?php _e('Address', 'framework'); ?></div>
                            <div class="address"><?php echo $address; ?></div>
                        </td>
                        
                    <?php endif; ?>
    
                    <?php if ($phone || $email) : ?>
                        
                        <td class="dataWrap">
                            
                            <?php if ($phone || $email) : ?>
                            <div class="title"><?php _e('Phone', 'framework'); ?></div>
                            <div class="phone"><?php echo $phone; ?></div>
                            <?php endif; ?>
                            
                            <?php if ($phone || $email) : ?>
                            <div class="title"><?php _e('Email', 'framework'); ?></div>
                            <div class="email"><?php echo $email; ?></div>
                            <?php endif; ?>
                        </td>
                        
                    <?php endif; ?>
                        
                        </tr>
                    </table>    
                    <?php endif; ?>
                        
                        
                    <?php if ($gmap_lat && $gmap_lat) : ?>

                    
                    <div class="mainWrap">
    
                    <script type="text/javascript">
                        //<![CDATA[

                        var lat = '<?php echo $gmap_lat; ?>',
                            lng = '<?php echo $gmap_lng; ?>',
                            gmap_point = '<?php echo get_template_directory_uri(); ?>/images/gmap-pin-black.png'
                        ;

                        //]]>
                    </script>

                    <div class="gmapWrap">
                        <div class="gmap" id="gmap"></div>
                    </div>
                    
                    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gmap_point.js"></script>
                    

                    <?php endif; ?>
                        
                    
                    <?php if(isset($emailSent) && $emailSent == true) { ?>

					<div class="thanks">
						<h2><?php _e('Thanks, your email was sent successfully.', 'framework') ?></h2>
					</div>

                    <?php } else { ?>
		
					<?php if(isset($captchaError)) { ?>
						<p class="error"><?php 
						if($captchaError == "incorrect-captcha-sol") { _e('The CAPTCHA solution was incorrect.','framework'); }
						else if($captchaError == "invalid-request-cookie") { _e('The challenge parameter of the verify script was incorrect.','framework'); }
						else if($captchaError == "invalid-site-private-key") { _e('We weren\'t able to verify the private key.','framework'); }
						else { echo $captchaError; } 
						?>
						</p>
						<?php } 
						else if(isset($hasError)) { ?>
						<p class="error"><?php _e('Sorry, an error occured..', 'framework') ?></p>
					<?php } ?>
	
                        <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                            
                            <h2><?php _e('Contactform', 'framework') ?></h2>
                            
                            <ul class="contactform">
                                <li>
                                    <div class="input-container">
                                        <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" placeholder="<?php _e('Name:', 'framework') ?>" />
                                    </div>
                                    <?php if($nameError != '') { ?>
                                        <span class="error"><?php $nameError; ?></span> 
                                    <?php } ?>
                                </li>

                                <li>
                                    <div class="input-container">
                                        <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" placeholder="<?php _e('Email:', 'framework') ?>"/>
                                    </div>
                                    <?php if($emailError != '') { ?>
                                        <span class="error"><?php $emailError; ?></span>
                                    <?php } ?>
                                </li>

                                <li class="textarea">
                                    <div class="textarea-container">
                                        <textarea name="comments" id="commentsText" rows="20" cols="30" class="required requiredField" placeholder="<?php _e('Message:', 'framework') ?>"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
                                    </div>
                                    <?php if($commentError != '') { ?>
                                        <span class="error"><?php $commentError; ?></span> 
                                    <?php } ?>
                                </li>
                                <li>
                                <?php
                                if ($tz_captcha_select == "true") {
                                    $publickey = "'.$tz_public_key.'"; // you got this from the signup page
                                    echo recaptcha_get_html($publickey);
                                }
                                ?>
                                </li>

                                <li class="buttons">
                                    <input type="hidden" name="submitted" id="submitted" value="true" />
                                    <button type="submit"><?php _e('Send email', 'framework') ?></button>
                                </li>
                            </ul>
                        </form>
				<?php } ?>
                    </div>
				</div><!-- .entry-content -->	
				<!--END .hentry-->
				</div>
				
				<?php endwhile; endif; ?>
			
                <!--</div>-->
			<!--END #primary .hfeed-->
			</div>

<?php get_footer(); ?>