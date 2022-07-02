
<!DOCTYPE html>
<html lang="en">
<head><meta charset="windows-1252">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Brutecorp - Client Login</title>
	<link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />

</head>
<body>
                  
                  <div class="root-node">
                     <div class="app application">
                        <div class="brutecorp_login">
                           <div class="transfer__window uploader uploader--form uploader--type-email">
                            <?php echo $form->open(); ?>
                              <div class="scrollable transfer__contents">
                                 <div class="scrollable__content" style="margin-right: -17px;">                                    
						            <?php echo $form->messages(); ?>
                                    <div class="uploader__files">                                       
                                       <div class="uploader__empty-state uploader__empty-state--with-directories-selector">
                                          <h2><?= lang('enter_ur_email_pass_for_login') ?></h2>
                                       </div>
                                    </div>
                                    <div class="uploader__fields">
                                       <div class="uploader__recipientsContainer ">
                                          <div class="uploader__autosuggest">
                                             <div class="textfield textfield--default textfield--borderbottom form-focus">
                                             <label for="email" class="textfield__label focus-label">Email</label>
                                             <input name="email" class="textfield__field floating" type="email" autocomplete="off"></div>
                                          </div>
                                       </div>
                                        <div class="textfield textfield--default uploader__sender textfield--borderbottom form-focus">
                                            <label for="password" class="textfield__label focus-label"><?= lang('password') ?></label>
                                            <input name="password" class="textfield__field floating" type="password" autocomplete="Off">
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="transfer__footer">
                                 <button type="submit" class="login__button login__button--inactive"><?= lang('log_in') ?>!</button>
                              </div>
                              <?php echo $form->close(); ?>
                           </div>
                        </div>
                        <div class="dropzone">
                           <h3 class="dropzone__title">Drop it like it’s hot</h3>
                           <p class="dropzone__text">Add files or folders by dropping them in this window</p>
                        </div>
                        <div class="wallpaper wallpaper--no-transition">
                           <div class="wallpaper__content wallpaper__content--enter-done">
                              <div class="wallpaper__html">
                                <div class="brute_wallpaper">
                                    <div src="assets/images/1px.png" onload="onBackgroundLoad()" fullscreen="" id="background" style="background-image: url(&quot;https://backgrounds.wetransfer.net/cf_markosian/markosian2_t3_v1/assets/images/1px.png&quot;);"></div>
                                    <div class="wrapper" onclick="wetransfer.click()">
                                      <div class="wrappercopy">
                                          <div class="copy">
                                            <p>
                                            <h2>Customer Satisfaction</h2>                
                                            is our top priority. We have dedicated, experienced & passionable team. We are in IT industry since 2002, a trust-able brand.</p>
                                          </div>
                                     </div>
                                     <div class="imgwrapper">
                                        <div class="image-container">
                                             <img class="photo red" src="<?php echo base_url() . IMAGE . 'photo1.png' ?>" style="transform: translate(-50%, -50%) rotate(5deg);">
                                             <img class="photo blue" src="<?php echo base_url() . IMAGE . 'photo2.png' ?>" style="transform: translate(-50%, -50%) rotate(-4deg);">
                                             <img class="photo green" src="<?php echo base_url() . IMAGE . 'photo3.png' ?>" style="transform: translate(-50%, -50%) rotate(2deg);">
                                         </div>
                                       </div>
                                     </div>
                                  </div>
                              
                              <a href="https://wepresent.wetransfer.com/story/diana-markosian-santa-barbara/" rel="noopener noreferrer" class="wallpaper__title" target="_blank" title="© Diana Markosian, Courtsey of (Aperture, 2020)">© Diana Markosian, Courtsey of (Aperture, 2020)</a>
                           </div>
                        </div>
                        <nav class="nav nav--loaded">
                           <ul class="nav__items">
                              <li class="nav__item"><a href="#" class="nav__link"><span class="nav__label">Help</span></a></li>
                              <li class="nav__item"><a href="#" target="_blank" class="nav__link"><span class="nav__label">About us</span></a></li>
                              <li class="nav__item"><a href="#" class="nav__link"><span class="nav__label">Sign up</span></a></li>
                              <li class="nav__item"><a href="#" class="nav__link"><span class="nav__label">Log in</span></a></li>
                           </ul>
                        </nav>
                        <div class="spinner logo spinner--single">
                           <img class="img-responsive" src="<?php echo site_url(UPLOAD_LOGO .'brute-logo.png') ?>" width="52" height="52">
                        </div>
                     </div>
                  </div>
                  <img alt="" src="WeTransfer4_files/iui3.gif" width="1" height="1" border="0">
                  <div style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon644425749439"><img style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon457083468649" alt="" src="WeTransfer4_files/0.txt" width="0" height="0"></div>

<script src="<?php echo base_url(); ?>assets/js/login/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/login/script.js"></script>           
     </body>
</html>

