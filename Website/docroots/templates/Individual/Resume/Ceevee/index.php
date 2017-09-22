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
    /*
    if(!isset($_SESSION["user"])) {
        
        try {
            $url = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";            
            $_SESSION["destpage"] = $url;
            header("Location: /loginPage.php");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }        
    }
    */
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
   // $user = new User("billgates", "", "", "bill", "gates", "", "", "", "", "", "", "", "", "");
   // $client = new Client("cl1", "microsoft", "", "", "", "", "", "", "", "", "microsoft.sitejinni.com", "", "");
    $isedit = ($client != NULL && $user != NULL);
    //testing
   $isedit=true;
 //  $IsOpenFromSite=true;
   /// var_dump($isedit);
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
                         <div style="position: fixed;top: 0;z-index: 1; width: 45%; height: 60px; background-color: white;opacity:.3; border-bottom:solid ;border-bottom-width:1px;">    
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
             <div class=" col-lg-8 col-md-8 col-xs-8">
                    <h1><span>Education</span></h1>
             </div>
            <?php
            if($isedit==TRUE)
            {
                   echo'<div class="col-lg-4 col-md-4 col-xs-4">
                        <form action="index.php#feducation" method="post" enctype="multipart/form-data" id="feducation">
                            <div>
                                <button type="submit" id="btnAddEdu" name="btnAddEdu" class="btn btn-info btn-sx">
                                    <span class="fa fa-plus" style="font-weight:bold"> </span> 
                                </button>
                            </div>
                         
                         </form>
                    </div>';
            }
            ?>
         </div>

         <div class="nine columns main-col  ">

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
             <div class="col-lg-8 col-md-8 col-xs-8">
            <h1><span>Work</span></h1>
            </div>
            <?php
            if($isedit==TRUE)
            {
                   echo'<div class="col-lg-4 col-md-4 col-xs-4">
                        <form action="index.php#fwork" method="post" enctype="multipart/form-data" id="fwork">
                            <div>
                                <button type="submit" id="btnAddWork" name="btnAddWork" class="btn btn-info btn-sx">
                                    <span class="fa fa-plus" style="font-weight:bold"> </span> 
                                </button>
                            </div>
                        </form>
                    </div>';
            }
            ?>
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
             <div class="col-lg-8 col-md-8 col-xs-8">
            <h1><span>Skills</span></h1>
            </div>
              <?php
            if($isedit==TRUE)
            {
                   echo'<div class="col-lg-4 col-md-4 col-xs-4">
                        <form action="index.php#fskill" method="post" enctype="multipart/form-data" id="fskill">
                            <div>
                                <button type="submit" id="btnAddSkill" name="btnAddSkill" class="btn btn-info btn-sx">
                                    <span class="fa fa-plus" style="font-weight:bold"> </span> 
                                </button>
                            </div>
                        </form>
                    </div>';
            }
            ?>
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
                            echo '<li>
                                    <em>
                                        <div class="row">
                                            <div id="Skills_Skills_'.$cnt.'_SkillName" class=" col-lg-10 brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $skill->{'SkillName'} . '</div> 
                                            <!--<div id="Skills_Skills_'.$cnt.'_SkillExpInPercent" class="col-lg-2 brand ' . (($isedit == TRUE) ? 'texteditor' : ' ') . '" >' . $skill->{'SkillExpInPercent'} . '</div>-->
                                            <div class="col-lg-2"> <input id="Skills_Skills_'.$cnt.'_SkillExpInPercent" class="brand" width="20%" type="text" name="LastName" value="'. $skill->{'SkillExpInPercent'} .'"></div>    
                                        </div>
                                   </em><br>
                                   <span class="bar-expand allSkill" style="width:' . $skill->{'SkillExpInPercent'} .'%"></span>
                                </li>';
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
               <li><a onclick="goToLogin()">Login for Edit</a></li>
            </ul>

         <!--</div>-->

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