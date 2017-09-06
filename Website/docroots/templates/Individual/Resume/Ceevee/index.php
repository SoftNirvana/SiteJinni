<?php
    
    $IsOpenFromSite=false;
    $path = $_SERVER['DOCUMENT_ROOT'];
    $spath = $_SERVER["REQUEST_URI"];

    if (strpos($path, 'userdocroots') != false || strpos($spath, 'userdocroots') != false ) {
      $IsOpenFromSite=true;
    }
    $locpath = str_replace(stristr($path, '/docroots'), '', $path) ;

    include $locpath . '/Classes/DataAccess.php';
    include $locpath . '/Classes/Entities/EntityBase.php';
    include $locpath . '/Classes/Entities/User.php';
    include $locpath . '/Classes/Entities/Client.php';
    include $locpath . '/Classes/Entities/Service.php';
    include $locpath . '/Classes/Entities/ServiceType.php';
    include $locpath . '/Classes/Entities/Cart.php';
    include $locpath . '/Classes/Entities/CartItem.php';
    include $locpath . '/Classes/Entities/BillItem.php';
    include $locpath . '/Classes/PageDesignData.php';
    include $locpath . '/Classes/FunctionClasses/CartFunctionsClass.php';
    
    if(session_status()!=PHP_SESSION_ACTIVE) {session_start(); }

    $user = NULL;
    $client = NULL;
    $service = NULL;
    if(isset($_SESSION["user"]) && $_SESSION["user"] != NULL)
    {
        $user = $_SESSION["user"];        
    }
    if(isset($_SESSION["client"]) && $_SESSION["client"] != NULL)
    {
        $client = $_SESSION["client"];
    }
    //$user = new User("billgates", "", "", "bill", "gates", "", "", "", "", "", "", "", "", "");
   // $client = new Client("cl1", "microsoft", "", "", "", "", "", "", "", "", "microsoft.sitejinni.com", "", "");
    $isedit = ($client != NULL && $user != NULL);
    //testing
   // $isedit=true;
   // $IsOpenFromSite=true;
?>
<!DOCTYPE html>
<html class="no-js" lang="en"> 
<head>

   <!--- Basic Page Needs
   ================================================== -->
   <meta charset="utf-8">
	<title>Individual</title>
	<meta name="description" content="">
	<meta name="author" content="">

   <!-- Mobile Specific Metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
    ================================================== -->
   <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
   
   <link rel="stylesheet" href="css/default.css">
   <link rel="stylesheet" href="css/layout.css">
   <link rel="stylesheet" href="css/media-queries.css">
   <link rel="stylesheet" href="css/magnific-popup.css">
   
   <link href="css/reccustom.css" rel="stylesheet" />
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>    
  
     <?php 
         echo '<script src="/js/sitejinnijs.js"></script> ';
     ?>
   <!-- Script
   ================================================== -->
	<script src="js/modernizr.js"></script>

   <!-- Favicons
	================================================== -->
    <link rel="shortcut icon" href="favicon.png" >
    
    <script src="js/textEditor.js"></script>
    <script src="js/spwCustom.js" type="text/javascript"></script>
</head>

<body>
     <?php
        include($locpath . 'htmlassets/datapost.php');
    ?>
     
   <!-- Header
   ================================================== -->
   
          <?php 
             if(($isedit==true)&&($IsOpenFromSite==true)){
                 
                 echo '<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">'
                       .'<div class="container topnav container-fluid">';
                  include( $locpath . "/htmlassets/sitejinniNavBar.php");
                  echo ' </div></nav>';
             }

        ?>      
               
   <header id="home">
  
      <nav id="nav-wrap">
       
     <!----- Install button for Template ---------->
       
        <?php 
            if($IsOpenFromSite==FALSE)
            {
               echo '<div class="row"  style="z-index: 3">
                         <div style="position: fixed;top: 0;z-index: 1; width: 100%; height: 60px; background-color: white;opacity:.3; border-bottom:solid ;border-bottom-width:1px;">    
                         </div>
                         <div class="row">

                         <div  style="position: fixed;top: 0;right: 45%;z-index: 2; margin: 10px">
                               <button type="button" class="btn  btn-info " style="background-color:#ff9800 ;height: 35px; width:150px;font-weight:bold;color:black" onclick="installPage()">Install</button>
                         </div>
                       </div>
                     </div>';
            }
              
        ?>      
         <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
	      <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

         <ul id="nav" class="nav">
            <li class="current"><a class="smoothscroll" href="#home">Home</a></li>
            <li><a class="smoothscroll" href="#about">About</a></li>
	    <li><a class="smoothscroll" href="#resume">Resume</a></li>
            <li><a class="smoothscroll" href="#portfolio">Works</a></li>
            <li><a class="smoothscroll" href="#testimonials">Testimonials</a></li>
            <li><a class="smoothscroll" href="#contact">Contact</a></li>
         </ul> <!-- end #nav -->

      </nav> <!-- end #nav-wrap -->
<!--<DIV id="sitejinninavbar"></DIV>-->
               
      <div class="row banner">
         <div class="banner-text">
             <h1 class="responsive-headline"> 
                 <div id="Header_Header" class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>" >
                 <?php echo $pageDesign->allParts['Header']->{'Header'}; ?></div> </h1>
               <hr />
               <div id="Header_CompanyName" class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>" >
                  <?php echo $pageDesign->allParts['Header']->CompanyName; ?></div>
         </div>
      </div>

      <p class="scrolldown">
         <a class="smoothscroll" href="#about"><i class="icon-down-circle"></i></a>
      </p>

   </header> <!-- Header End -->


   <!-- About Section
   ================================================== -->
   <section id="about">

      <div class="row">

         <div class="three columns">

            <img class="profile-pic"  src="images/profilepic.jpg" alt="" />

         </div>

         <div class="nine columns main-col">

            <h2>About Me</h2>
            <p><div id="About_AboutDescription"class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>" >
                <?php echo $pageDesign->allParts['About']->{'AboutDescription'}; ?></div>
            </p>

            <div class="row">

               <div class="columns contact-details">

                    <h2>Contact Details</h2>
                    <p>
                            <div id="CompanyLocation_CompanyAddress" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>"> 
                               <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyAddress'}; ?></div>
                            <div id="CompanyLocation_CompanyNumber" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>">	 
                               <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyNumber'}; ?></div>   
                            <div id="CompanyLocation_CompanyEmail" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>">	 
                               <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyEmail'}; ?></div>   
                     </p>			   
               </div>
<!--
               <div class="columns download">
                  <p>
                     <a href="#" class="button"><i class="fa fa-download"></i>Download Resume</a>
                  </p>
               </div>
-->
            </div> <!-- end row -->

         </div> <!-- end .main-col -->

      </div>

   </section> <!-- About Section End-->


   <!-- Resume Section
   ================================================== -->
   <section id="resume">

      <!-- Education
      ----------------------------------------------- -->
      <div class="row education">

         <div class="three columns header-col">
            <h1><span>Education</span></h1>
         </div>

         <div class="nine columns main-col">

             <?php 
             $cnt = 0;
                foreach ($pageDesign->allParts['Educations']->Educations as $key => $edu) {
                    echo '<div class="row item">
                            <div class="twelve columns">
                            <h3> <div id="Educations_Educations_'.$cnt.'_UniversityName"class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') .'" >' . $edu->{'UniversityName'} . '</div> </h3>
                              <div id="Educations_Educations_'.$cnt.'_Degree"class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $edu->{'Degree'} . '</div> 
                                <div id="Educations_Educations_'.$cnt.'_YearOfPassing"class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $edu->{'YearOfPassing'} . '</div>
                              <div id="Educations_Educations_'.$cnt.'_Info"class="brand '.(($isedit == TRUE) ? 'texteditor' : ' '). '" >' . $edu->{'Info'} .'</div>  
                             </div>
                          </div> <!-- item end -->';
                    $cnt++;
                }
            
            ?>
          
            </div> <!-- item end -->

         </div> <!-- main-col end -->

      </div> <!-- End Education -->


      <!-- Work
      ----------------------------------------------- -->
      <div class="row work">

         <div class="three columns header-col">
            <h1><span>Work</span></h1>
         </div>

         <div class="nine columns main-col">


            <?php 
                $cnt = 0;
                foreach ($pageDesign->allParts['WorkExperiences']->WorkExperiences as $key => $woEx) {
                    echo '<div class="row item">
                            <div class="twelve columns">
                            <h3> <div id="WorkExperiences_WorkExperiences_'.$cnt.'_CompanyName" class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') .'" >' . $woEx->{'CompanyName'} . '</div> </h3>
                              <span>  
                              <div id="WorkExperiences_WorkExperiences_'.$cnt.'_Designation" class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $woEx->{'Designation'} . '</div> 
                              <div id="WorkExperiences_WorkExperiences_'.$cnt.'_Experience" class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $woEx->{'Experience'} . '</div>
                              </span>    
                              <div id="WorkExperiences_WorkExperiences_'.$cnt.'_Desc" class="brand '.(($isedit == TRUE) ? 'texteditor' : ' '). '" >' . $woEx->{'Description'} .'</div>  
                             </div>
                          </div> <!-- item end -->';
                    $cnt ++;
                }
            
            ?> 
            
         </div> <!-- main-col end -->

      </div> <!-- End Work -->


      <!-- Skills
      ----------------------------------------------- -->
      <div class="row skill">

         <div class="three columns header-col">
            <h1><span>Skills</span></h1>
         </div>

        <div class="nine columns main-col">

                <p>
                    <div id="Skills_SkillDesc" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>">	 
                       <?php echo $pageDesign->allParts['Skills']->{'SkillDesc'};?>
                    </div>  
                </p>

                <div class="bars">

                    <ul class="skills">

                    <?php 
                        $cnt = 0;
                        foreach ($pageDesign->allParts['Skills']->Skills as $key => $skill) {
                            echo '<li><span class="bar-expand allSkill" style="width:' . $skill->{'SkillExpInPercent'} .';"></span><em>'
                                 . '<div id="Skills_Skills_'.$cnt.'_SkillName" class="brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $skill->{'SkillName'} . '</div> </em></li>';
                            $cnt++;
                        }
                    ?>
                <!--    <li><span class="bar-expand photoshop" style="width: 40%;"></span><em>Photoshop</em></li>
                        <li><span class="bar-expand illustrator"></span><em>Illustrator</em></li>
                        <li><span class="bar-expand wordpress"></span><em>Wordpress</em></li>
                        <li><span class="bar-expand css"></span><em>CSS</em></li>
                        <li><span class="bar-expand html5"></span><em>HTML5</em></li>
                        <li><span class="bar-expand jquery"></span><em>jQuery</em></li>-->
                    </ul>

                </div><!-- end skill-bars -->
        </div> <!-- main-col end -->

      </div> <!-- End skills -->

   </section> <!-- Resume Section End-->


   <!-- Portfolio Section
   ================================================== -->
   <section id="portfolio">

      <div class="row">

         <div class="twelve columns collapsed">

            <h1>Check Out Some of My Works.</h1>

            <!-- portfolio-wrapper -->
            <div id="portfolio-wrapper" class="bgrid-quarters s-bgrid-thirds cf">

          	   <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-01" title="">
                        <img alt="" src="images/portfolio/coffee.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Coffee</h5>
                              <p>Illustrration</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-02" title="">
                        <img alt="" src="images/portfolio/console.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Console</h5>
                              <p>Web Development</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-03" title="">
                        <img alt="" src="images/portfolio/judah.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Judah</h5>
                              <p>Webdesign</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-04" title="">
                        <img alt="" src="images/portfolio/into-the-light.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Into The Light</h5>
                              <p>Photography</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-05" title="">
                        <img alt="" src="images/portfolio/farmerboy.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Farmer Boy</h5>
                              <p>Branding</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-06" title="">
                        <img alt="" src="images/portfolio/girl.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Girl</h5>
                              <p>Photography</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-07" title="">
                        <img alt="" src="images/portfolio/origami.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Origami</h5>
                              <p>Illustrration</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div> <!-- item end -->

               <div class="columns portfolio-item">
                  <div class="item-wrap">

                     <a href="#modal-08" title="">
                        <img alt="" src="images/portfolio/retrocam.jpg">
                        <div class="overlay">
                           <div class="portfolio-item-meta">
          					      <h5>Retrocam</h5>
                              <p>Web Development</p>
          					   </div>
                        </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                     </a>

                  </div>
          		</div>  <!-- item end -->

            </div> <!-- portfolio-wrapper end -->

         </div> <!-- twelve columns end -->


         <!-- Modal Popup
	      --------------------------------------------------------------- -->

         <div id="modal-01" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-coffee.jpg" alt="" />

		      <div class="description-box">
			      <h4>Coffee Cup</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Branding, Webdesign</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-01 End -->

         <div id="modal-02" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-console.jpg" alt="" />

		      <div class="description-box">
			      <h4>Console</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Branding, Web Development</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-02 End -->

         <div id="modal-03" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-judah.jpg" alt="" />

		      <div class="description-box">
			      <h4>Judah</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Branding</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-03 End -->

         <div id="modal-04" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-intothelight.jpg" alt="" />

		      <div class="description-box">
			      <h4>Into the Light</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Photography</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-04 End -->

         <div id="modal-05" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-farmerboy.jpg" alt="" />

		      <div class="description-box">
			      <h4>Farmer Boy</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Branding, Webdesign</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-05 End -->

         <div id="modal-06" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-girl.jpg" alt="" />

		      <div class="description-box">
			      <h4>Girl</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Photography</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-06 End -->

         <div id="modal-07" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-origami.jpg" alt="" />

		      <div class="description-box">
			      <h4>Origami</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Branding, Illustration</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-07 End -->

         <div id="modal-08" class="popup-modal mfp-hide">

		      <img class="scale-with-grid" src="images/portfolio/modals/m-retrocam.jpg" alt="" />

		      <div class="description-box">
			      <h4>Retrocam</h4>
			      <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.</p>
               <span class="categories"><i class="fa fa-tag"></i>Webdesign, Photography</span>
		      </div>

            <div class="link-box">
               <a href="http://www.behance.net">Details</a>
		         <a class="popup-modal-dismiss">Close</a>
            </div>

	      </div><!-- modal-01 End -->


      </div> <!-- row End -->

   </section> <!-- Portfolio Section End-->


   <!-- Call-To-Action Section
   ================================================== -->
    <!-- Testimonials Section
   ================================================== -->
   <section id="testimonials">

      <div class="text-container">

         <div class="row">

            <div class="two columns header-col">

               <h1><span>Client Testimonials</span></h1>

            </div>

            <div class="ten columns flex-container">

               <div class="flexslider">

                  <ul class="slides">

                     <li>
                        <blockquote>
                           <p>Your work is going to fill a large part of your life, and the only way to be truly satisfied is
                           to do what you believe is great work. And the only way to do great work is to love what you do.
                           If you haven't found it yet, keep looking. Don't settle. As with all matters of the heart, you'll know when you find it.
                           </p>
                           <cite>Steve Jobs</cite>
                        </blockquote>
                     </li> <!-- slide ends -->

                     <li>
                        <blockquote>
                           <p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
                           Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem
                           nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris.
                           </p>
                           <cite>Mr. Adobe</cite>
                        </blockquote>
                     </li> <!-- slide ends -->

                  </ul>

               </div> <!-- div.flexslider ends -->

            </div> <!-- div.flex-container ends -->

         </div> <!-- row ends -->

       </div>  <!-- text-container ends -->

   </section> <!-- Testimonials Section End-->


   <!-- Contact Section
   ================================================== -->
   <section id="contact">

         <div class="row section-head">

            <div class="two columns header-col">

               <h1><span>Get In Touch.</span></h1>

            </div>

            <div class="ten columns">

                  <p class="lead">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
                  eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                  voluptatem quia voluptas sit aspernatur aut odit aut fugit.
                  </p>

            </div>

         </div>

         <div class="row">

            <div class="eight columns">

               <!-- form -->
               <form action="" method="post" id="contactForm" name="contactForm">
					<fieldset>

                  <div>
						   <label for="contactName">Name <span class="required">*</span></label>
						   <input type="text" value="" size="35" id="contactName" name="contactName">
                  </div>

                  <div>
						   <label for="contactEmail">Email <span class="required">*</span></label>
						   <input type="text" value="" size="35" id="contactEmail" name="contactEmail">
                  </div>

                  <div>
						   <label for="contactSubject">Subject</label>
						   <input type="text" value="" size="35" id="contactSubject" name="contactSubject">
                  </div>

                  <div>
                     <label for="contactMessage">Message <span class="required">*</span></label>
                     <textarea cols="50" rows="15" id="contactMessage" name="contactMessage"></textarea>
                  </div>

                  <div>
                     <button class="submit">Submit</button>
                     <span id="image-loader">
                        <img alt="" src="images/loader.gif">
                     </span>
                  </div>

					</fieldset>
				   </form> <!-- Form End -->

               <!-- contact-warning -->
               <div id="message-warning"> Error boy</div>
               <!-- contact-success -->
				   <div id="message-success">
                  <i class="fa fa-check"></i>Your message was sent, thank you!<br>
				   </div>

            </div>


            <aside class="four columns footer-widgets">

               <div class="widget widget_contact">

                    <h4>Address and Phone</h4>
                        <p class="address">
                            <div id="CompanyLocation_CompanyAddress" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>"> 
                               <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyAddress'}; ?></div>
                            <div id="CompanyLocation_CompanyNumber" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>">	 
                                <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyNumber'}; ?></div>   
                            <div id="CompanyLocation_CompanyEmail" class="brand <?php echo($isedit == TRUE) ? 'texteditor' : ' ';?>">	 
                                <?php echo $pageDesign->allParts['CompanyLocation']->{'CompanyEmail'}; ?></div>   
                        </p>
                </div>
<!--
               <div class="widget widget_tweets">

                  <h4 class="widget-title">Latest Tweets</h4>

                  <ul id="twitter">
                     <li>
                        <span>
                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
                        Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum
                        <a href="#">http://t.co/CGIrdxIlI3</a>
                        </span>
                        <b><a href="#">2 Days Ago</a></b>
                     </li>
                     <li>
                        <span>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
                        eaque ipsa quae ab illo inventore veritatis et quasi
                        <a href="#">http://t.co/CGIrdxIlI3</a>
                        </span>
                        <b><a href="#">3 Days Ago</a></b>
                     </li>
                  </ul>

		</div>
-->
            </aside>

      </div>

   </section> <!-- Contact Section End-->


   <!-- footer
   ================================================== -->
   <footer>
<!--
      <div class="row">

         <div class="twelve columns">

            <ul class="social-links">
               <li><a href="#"><i class="fa fa-facebook"></i></a></li>
               <li><a href="#"><i class="fa fa-twitter"></i></a></li>
               <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
               <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
               <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
               <li><a href="#"><i class="fa fa-skype"></i></a></li>
            </ul>
-->
            <ul class="copyright">
               <li>&copy; Copyright 2017 </li>
               <li>Design by <a title="Styleshout" href="http://www.sitejinni.com/">SiteJinni</a></li>   
            </ul>

         </div>

         <div id="go-top"><a class="smoothscroll" title="Back to Top" href="#home"><i class="icon-up-open"></i></a></div>

      </div>

   </footer> <!-- Footer End-->

   <!-- Java Script
   ================================================== -->
   <SCRIPT src="js/jquery.js"></SCRIPT>
    <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
   <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

   <script src="js/jquery.flexslider.js"></script>
   <script src="js/waypoints.js"></script>
   <script src="js/jquery.fittext.js"></script>
   <script src="js/magnific-popup.js"></script>
   <script src="js/init.js"></script>
   
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js" type="text/javascript"></script>
 
 <script src="ckeditor/adapters/jquery.js"></script>
 <script src="ckeditor/jquery.js"></script>
 <script src="ckeditor/ckeditor.js"></script>
 <script>
                CKEDITOR.replace('description_editor');
            </script>
  <script type="text/javascript">
              CreateEditor();
 </script>
</body>

</html>