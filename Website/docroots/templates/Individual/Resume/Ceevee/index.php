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
    $user = new User("billgates", "", "", "bill", "gates", "", "", "", "", "", "", "", "", "");
    $client = new Client("cl1", "microsoft", "", "", "", "", "", "", "", "", "microsoft.sitejinni.com", "", "");
    $isedit = ($client != NULL && $user != NULL);
    //testing
    $isedit=true;
    $IsOpenFromSite=true;
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
   <script src="js/recCustom.js"></script>
   <script src="js/textEditor.js"></script>
   <!-- Script
   ================================================== -->
	<script src="js/modernizr.js"></script>

   <!-- Favicons
	================================================== -->
    <link rel="shortcut icon" href="favicon.png" >
   
</head>

<body>
 <?php

    //------------ PHP Initializations - Objects from json file -------------------------

    //------------ JSON File read and decode --------------------------
    $string_data = file_get_contents("header_data.json");
    $json_a = json_decode($string_data, true);
    //-----------------------------------------------------------------

    $pageDesign = new FullPageDesign("FullPage"); //----- Main - full page class object initialization

    $header = new PageDesignHeaderData("Header"); //----- Header data object initialization
    $mainimages = new MainImages("MainImages"); //----- Main Images data object initialization
    $location = new PageDesignMapLocation("Location"); //----- Site Location data object initialization
    $companyloc = new PageDesignCompanyLocation("CompanyLocation"); //----- Office location data object initialization
    $about = new PageDesignAbout("About"); //----- About data object initialization

    //----- Amenities data object initialization
    $amenities = new PageDesignAmenities("Amenities");
    $amenities->Amenities= array();

    //----- Team members data object initialization
    $members = new PageDesignTeamMembers("Members");
    $members->Members= array();

    //----- Documents data object initialization
    $documents = new PageDesignDocuments("Documents");
    $documents->Documents= array();

    //----- Projects data object initialization
    $projects = new PageDesignProjects("Projects");
    $projects->Projects= array();
    
    //---------------------- Array to object conversions ----------------------------
    if($json_a["allParts"]["Header"] != NULL) {
    foreach ($json_a["allParts"]["Header"] as $key1 => $value1) $header->{$key1} = $value1;  //----- Header data conversion --- $key1 $value1
    } else {
    $header->CompanyName = $client->clientname;
    $header->Address1 = $client->clientaddressline1;
    $header->Address2 = $client->clientaddressline2 . ($client->clientaddressline3 != NULL? ', ' . $client->clientaddressline3 . ',':'') . ' ' . $client->clientcity . ' - ' . $client->clientzipcode;
    $header->Phonenum = $client->clientcontactnumber1;
    $header->CompanyName = $client->clientname;
    }
    foreach ($json_a["allParts"]["MainImages"] as $key2 => $value2) $mainimages->{$key2} = $value2;  //----- Main Images data conversion --- $key2 $value2

    //----- Amenities data conversion------------------------------
    // $key3 $value3 $keyTemp1 $valueTemp1 $keyTemp2 $valueTemp2
    foreach ($json_a["allParts"]["Amenities"] as $key3 => $value3) {
    $amenities_temp = array();
    foreach ($value3 as $keyTemp1 => $valueTemp1) {
    $amenity_temp = new PageDesignAmenity("Amenity");
    foreach($valueTemp1 as $keyTemp2 => $valueTemp2) {
    $amenity_temp->{$keyTemp2} = $valueTemp2;
    }
    array_push($amenities_temp,$amenity_temp);
    }
    $amenities->{$key3} = $amenities_temp;
    }
    //-------------------------------------------------------------

    //----- Documents data conversion------------------------------
    // $key4 $value4 $keyTemp3 $valueTemp3 $keyTemp4 $valueTemp4
    foreach ($json_a["allParts"]["Documents"] as $key4 => $value4) {
    $documents_temp = array();
    foreach ($value4 as $keyTemp3 => $valueTemp3) {
    $document_temp = new PageDesignDocument("Document");
    foreach($valueTemp3 as $keyTemp4 => $valueTemp4) {
    $document_temp->{$keyTemp4} = $valueTemp4;
    }
    array_push($documents_temp,$document_temp);
    }
    $documents->{$key4} = $documents_temp;
    }
    //---------------------------------------------------------------
    
    
    if($json_a["allParts"]["Location"] != NULL) {
    foreach ($json_a["allParts"]["Location"] as $key5 => $value5) $location->{$key5} = $value5;  //----- Location(Site) data conversion --- $key5 $value5
    } else {
    $location->LocationLat = 37.0625;
    $location->LocationLng = -95.677068;
    }
    foreach ($json_a["allParts"]["About"] as $key6 => $value6) $about->{$key6} = $value6;  //----- About data conversion --- $key6 $value6

    //----- Documents data conversion------------------------------
    // $key7 $value7 $keyTemp5 $valueTemp5 $keyTemp6 $valueTemp6
    foreach ($json_a["allParts"]["Members"] as $key7 => $value7) {
    $members_temp = array();
    foreach ($value7 as $keyTemp5 => $valueTemp5) {
    $member_temp = new PageDesignTeamMember("Member");
    foreach($valueTemp5 as $keyTemp6 => $valueTemp6) {
    $member_temp->{$keyTemp6} = $valueTemp6;
    }
    array_push($members_temp,$member_temp);
    }
    $members->{$key7} = $members_temp;

    }
    //--------------------------------------------------------------

    if($json_a["allParts"]["CompanyLocation"] != NULL) {
    foreach ($json_a["allParts"]["CompanyLocation"] as $key8 => $value8) $companyloc->{$key8} = $value8;  //----- Location(Company - Office/Business Office) data conversion --- $key8 $value8
    } else {
    $companyloc->CompanyAddress = $client->clientaddressline1 . ', ' . $client->clientaddressline2 . ($client->clientaddressline3 != NULL? ', ' . $client->clientaddressline3 . ',':'') . ' ' . $client->clientcity . ' - ' . $client->clientzipcode;
    $companyloc->CompanyNumber = $client->clientcontactnumber1;
    $companyloc->CompanyEmail = $client->clientmailaddress;
    $companyloc->CompanyLat = 37.0625;
    $companyloc->CompanyLng = -95.677068;
    }

    //----- Projects data conversion--------------------------------
    // $key9 $value9 $keyTemp7 $valueTemp7 $keyTemp8 $valueTemp8
    foreach ($json_a["allParts"]["Projects"] as $key9 => $value9) {
    $projects_temp = array();
    foreach ($value9 as $keyTemp7 => $valueTemp7) {
    $project_temp = new PageDesignProject("Project");
    foreach($valueTemp7 as $keyTemp8 => $valueTemp8) {
    $project_temp->{$keyTemp8} = $valueTemp8;
    }
    array_push($projects_temp,$project_temp);
    }
    $projects->{$key9} = $projects_temp;
    }
    //----------------------------------------------------------------

    // -- Education object
    $objEducations=new PageDesignEducations("Educations");
    $objEducations->Educations=array();
    
    //----- Eduction data conversion------------------------------
    // $edu_key $edu_value $edu_key_Temp $edu_value_Temp $edu_key_Temp4 $edu_value_Temp4
    foreach ($json_a["allParts"]["Educations"] as $edu_key => $edu_value) {
        $edus_temp = array();
        foreach ($edu_value as $edu_key_Temp => $edu_value_Temp) {
        $edu_temp = new PageDesignEducation("Education");
        foreach($edu_value_Temp as $edu_key_Temp4 => $edu_value_Temp4) {
        $edu_temp->{$edu_key_Temp4} = $edu_value_Temp4;
        }
        array_push($edus_temp,$edu_temp);
        }
        $objEducations->{$edu_key} = $edus_temp;
    }
     // -- WorkExperience object
    $objWorkExperiences=new PageDesignWorkExperiences("WorkExperiences");
    $objWorkExperiences->WorkExperience=array();
    // $wexkey $wexvalue4 $wexkeyTemp3 $wexvalueTemp3 $wexkeyTemp4 $wexvalueTemp4
    foreach ($json_a["allParts"]["WorkExperiences"] as $wexkey => $wexvalue4) {
    $wex_temp = array();
    foreach ($wexvalue4 as $wexkeyTemp3 => $wexvalueTemp3) {
    $wex1_temp = new PageDesignWorkExperience("WorkExperience");
    foreach($wexvalueTemp3 as $wexkeyTemp4 => $wexvalueTemp4) {
    $wex1_temp->{$wexkeyTemp4} = $wexvalueTemp4;
    }
    array_push($wex_temp,$wex1_temp);
    }
    $objWorkExperiences->{$wexkey} = $wex_temp;
    }
     // -- Education object
    $objSkills=new PageDesignSkills("Skills");
    $objSkills->Skills=array();
    // $skkey4 $skvalue4 $skkeyTemp3 $skvalueTemp3 $skkeyTemp4 $skvalueTemp4
    foreach ($json_a["allParts"]["Skills"] as $skkey4 => $skvalue4) {
        $sks_temp = array();
        if(is_array($skvalue4)) {
            foreach ($skvalue4 as $skkeyTemp3 => $skvalueTemp3) {
                $sk_temp = new PageDesignSkill("Skill");
                foreach($skvalueTemp3 as $skkeyTemp4 => $skvalueTemp4) {
                $sk_temp->{$skkeyTemp4} = $skvalueTemp4;
                }
            }
            array_push($sks_temp,$sk_temp);
        }
        $objSkills->{$skkey4} = $sks_temp;   
    }
     $objSkills->SkillDesc="";
    //---------------------------------------------------------------

    ///---------------------------------------------------------------
    //Composing the full design object (Loaded from JSON)
    $pageDesign->allParts= array(
    "Header"=>$header,
    "MainImages"=>$mainimages,
    "Amenities"=>$amenities,
    "Documents"=>$documents,
    "Location"=>$location,
    "About"=>$about,
    "Members"=>$members,
    "CompanyLocation"=>$companyloc,
    "Projects"=>$projects,
    "Educations"=>$objEducations,
    "WorkExperiences"=>$objWorkExperiences,
    "Skills"=>$objSkills);
    //-----------------------------------------------------------------

    //------------------ Handling POST requests -----------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //----------- POST Request - Save Header ----------------------
   
    //----------------------------------------------------------------------------
    // 27062017 code
    if(isset($_POST['moddata']) && isset($_POST['modpath']))  {
        $path = $_POST['modpath'];
        $moddata = $_POST['moddata'];
        
        $arr = str_getcsv($path, ";");
        if(count($arr)==2) {
             $pageDesign->allParts[$arr[0]]->{$arr[1]} = $moddata;
        } else if(count($arr)==3) {
            $pageDesign->allParts[$arr[0]]->{$arr[1]}[$arr[2]] = $moddata;
        } else  if(count($arr)==4) {
            $pageDesign->allParts[$arr[0]]->{$arr[1]}[$arr[2]]->{$arr[3]} = $moddata;
        }
        echo $data;
    }
    ////
       
    
    //----------------------------------------------------------------------------------------

    //------------ Writing changes to json file ---------------------------------------------
    $json = json_encode($pageDesign);
    if (json_decode($json) != null)
    {
    $file = fopen('header_data.json','w+');
    fwrite($file, $json);
    fclose($file);
    }
    //----------------------------------------------------------------------------------------
    }
 
    ?>
   <!-- Header
   ================================================== -->
   <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="container topnav container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <?php
                 
                    if((!isset($_SESSION["user"]) || $_SESSION["user"]==NULL))
                    {
                        echo '<div class="navbar-header">                
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navdiv">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand topnav" href="loginPage.php">Login</a>
                            </div>';
                        
                         
                    }
                ?>
                <!--<DIV id="sitejinninavbar"></DIV>-->
               <?php 
             
                    if(($isedit==true)&&($IsOpenFromSite==true)){
                         include( $locpath . "/htmlassets/sitejinniNavBar.php");
                         
                    }

               ?>
            </div>
            <!-- /.container -->
        </nav>
   <header id="home">
 
      <nav id="nav-wrap">

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

            <ul class="copyright">
               <li>&copy; Copyright 2014 CeeVee</li>
               <li>Design by <a title="Styleshout" href="http://www.styleshout.com/">Styleshout</a></li>   
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