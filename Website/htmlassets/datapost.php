<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
   
  //------------------ Handling POST requests -----------------------
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {	
                            //----------- POST Request - Save Header ----------------------
                            if(isset($_POST["send_enquiry"])) 
                            {
                                    $enq_name = $_POST["enq_name"];
                                    $enq_address1 = $_POST["enq_address1"];
                                    $enq_address2= $_POST["enq_address2"];
                                    $enq_phonenum = $_POST["enq_phonenum"];
                                    $enq_mail_add = $_POST["enq_mail_add"];
                                    $enq_mailbody = $_POST["enq_mailbody"];
                                    $to = $client->clientmailaddress;
                                    
                                    
                                    $enqbody = '<html>' . 
                                               '<body>' .
                                               '<p>' .
                                               str_replace('\n', '<br>', $enq_mailbody) . "<br>" . PHP_EOL . 
                                               '</p>' . 
                                               '<p>' . 
                                               $enq_name . '<br>' . PHP_EOL . 
                                               $enq_address1 . '<br>' . PHP_EOL . 
                                               $enq_address2 . '<br>' . PHP_EOL . 
                                               $enq_phonenum . '<br>' . PHP_EOL . 
                                               $enq_mail_add . 
                                               '</p>' . 
                                               '</body>' . 
                                               '</html>';
                                    
 
                                    
                                    $mail = new PHPMailer();
                                    
                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = 'bishwaroop.mukherjee@gmail.com';                 // SMTP username
                                    $mail->Password = 'JAGANATH';                           // SMTP password
                                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = 465;    
                                    $mail->Priority = 1;

                                    $mail->setFrom($enq_mail_add);
                                    $mail->addAddress($to);     // Add a recipient
                                    $mail->addReplyTo($enq_mail_add);
                                                                        
                                    $mail->isHTML(TRUE);

                                    $mail->Subject = 'Enquiry from '.$enq_name;
                                    $mail->Body    = $enqbody;
                                    $mail->AltBody = $enqbody;
                                    
                                    if(!$mail->Send()) {
                                    echo 'Message was not sent.';
                                    echo 'Mailer error: ' . $mail->ErrorInfo;
                                    } else {
                                    echo 'Message has been sent.';
                                    }
                            }
                    }
    //------------------ Handling POST requests -----------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //----------- POST Request - Save Header ----------------------
    if(isset($_POST["save_header"]))
    {
    $pageDesign->allParts['Header']->Header = $_POST["header"];
    $pageDesign->allParts['Header']->Address1 = $_POST["address1"];
    $pageDesign->allParts['Header']->Address2 = $_POST["address2"];
    $pageDesign->allParts['Header']->Phonenum = $_POST["phonenum"];
    $pageDesign->allParts['Header']->CompanyName = $_POST["compname"];
    }
    //--------------------------------------------------------------

    //----------- POST Request - Delete Image ----------------------
    if(isset($_POST['delimg']) && !empty($_POST['delimg'])) {
    $imgPath = $_POST['delimg'];
    unlink($imgPath);
    }
    //--------------------------------------------------------------

    //----------- POST Request - Save Amenity ----------------------
    if(isset($_POST['descDataFld']) && isset($_FILES['amenityImageFile'])) {
    $amenityDescription = $_POST['descDataFld'];

    if(!empty($_FILES['amenityImageFile'])) {
    $target_dir_amenity = "amenityimages";
    $file_name_am = $_FILES['amenityImageFile']['name'];
    $tmp_name_am = $_FILES['amenityImageFile']['tmp_name'];
    $target_file_path = "$target_dir_amenity/$file_name_am";

    move_uploaded_file($tmp_name_am, $target_file_path);
    }

    $amenity = new PageDesignAmenity("Amenity");
    $amenity->AmenityDescription = $amenityDescription;
    $amenity->imagePath = $target_file_path;
    $pageDesign->allParts['Amenities']->addAmenity($amenity);
    }
    //----------------------------------------------------------------

    //----------- POST Request - Save Project -------------------------
    if(isset($_POST['projNameFld']) && isset($_POST['projDescFld']) && isset($_POST['projURLFld']) && isset($_FILES['projectImageFile'])) {
    $projName = $_POST['projNameFld'];
    $projectDescription = $_POST['projDescFld'];
    $projURL = $_POST['projURLFld'];

    if(!empty($_FILES['projectImageFile'])) {
    $target_dir_project = "projectimages";
    $file_name_pr = $_FILES['projectImageFile']['name'];
    $tmp_name_pr = $_FILES['projectImageFile']['tmp_name'];
    $target_file_path = "$target_dir_project/$file_name_pr";

    move_uploaded_file($tmp_name_pr, $target_file_path);
    }

    $project = new PageDesignProject("Project");
    $project->ProjectName = $projName;
    $project->ProjectDescription = $projectDescription;
    $project->ProjectURL = $projURL;
    $project->imagePath = $target_file_path;
    $pageDesign->allParts['Projects']->addProject($project);
    }
    //-----------------------------------------------------------------

    //----------- POST Request - Save Document -------------------------
    if(isset($_POST['docDesc']) && isset($_POST['docName']) && isset($_FILES['docFile'])) {
    $docDescription = $_POST['docDesc'];
    $documentName = $_POST['docName'];

    if(!empty($_FILES['docFile'])) {
    $target_dir_documents = "documentfiles";
    $file_name_dc = $_FILES['docFile']['name'];
    $tmp_name_dc = $_FILES['docFile']['tmp_name'];
    $target_file_path = "$target_dir_documents/$file_name_dc";

    move_uploaded_file($tmp_name_dc, $target_file_path);
    }

    $document = new PageDesignDocument("Document");
    $document->DocumentDescription = $docDescription;
    $document->DocumentPath = $target_file_path;
    $document->DocumentName = $documentName;
    $pageDesign->allParts['Documents']->addDocument($document);
    }
    //------------------------------------------------------------------

    //----------- POST Request - Save location - site -------------------------
    if(isset($_POST['locationName']) && isset($_POST['locationDescription']) && isset($_POST['lat']) && !empty($_POST['lat'])&& isset($_POST['lng']) && !empty($_POST['lng'])) {
    $locName = $_POST['locationName'];
    $locDesc = $_POST['locationDescription'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $pageDesign->allParts['Location']->LocationName = $locName;
    $pageDesign->allParts['Location']->LocationDesc = $locDesc;
    $pageDesign->allParts['Location']->LocationLat = $lat;
    $pageDesign->allParts['Location']->LocationLng = $lng;
    }
    //---------------------------------------------------------------------------

    //----------- POST Request - Save Location - Company (business office) -------------------------
    if(isset($_POST['compAddress']) && isset($_POST['compNumber']) && isset($_POST['compEmail']) && isset($_POST['complat']) && !empty($_POST['complat'])&& isset($_POST['complng']) && !empty($_POST['complng'])) {
    $cmpAddress = $_POST['compAddress'];
    $cmpNumber = $_POST['compNumber'];
    $cmpEmail = $_POST['compEmail'];
    $cmplat = $_POST['complat'];
    $cmplng = $_POST['complng'];

    $pageDesign->allParts['CompanyLocation']->CompanyAddress = $cmpAddress;
    $pageDesign->allParts['CompanyLocation']->CompanyNumber = $cmpNumber;
    $pageDesign->allParts['CompanyLocation']->CompanyEmail = $cmpEmail;
    $pageDesign->allParts['CompanyLocation']->CompanyLat = $cmplat;
    $pageDesign->allParts['CompanyLocation']->CompanyLng = $cmplng;
    }
    //------------------------------------------------------------------------------------------------

    //----------- POST Request - Save Member ---------------------------------------------------------
    if(isset($_POST['memName']) && isset($_POST['memDesig']) && isset($_FILES['memberImageFile'])) {
    $memName = $_POST['memName'];
    $memDesig = $_POST['memDesig'];

    if(!empty($_FILES['memberImageFile'])) {
    $target_dir_members = "memberfiles";
    $file_name_mm = $_FILES['memberImageFile']['name'];
    $tmp_name_mm = $_FILES['memberImageFile']['tmp_name'];
    $target_file_path = "$target_dir_members/$file_name_mm";

    move_uploaded_file($tmp_name_mm, $target_file_path);
    }

    $member = new PageDesignTeamMember("Member");
    $member->MemberDesignation = $memDesig;
    $member->imagePath = $target_file_path;
    $member->MemberName = $memName;
    $pageDesign->allParts['Members']->addMember($member);
    }
    //-------------------------------------------------------------------------------------------------

    //----------- POST Request - Save about description -------------------------
    if(isset($_POST['aboutDesc']) && isset($_FILES['aboutFile'])) {
    $target_file_path = '';
    if(!empty($_FILES['aboutFile'])) {
    $target_dir_about = "aboutfile";
    $file_name_ab = $_FILES['aboutFile']['name'];
    $tmp_name_ab = $_FILES['aboutFile']['tmp_name'];
    $target_file_path = "$target_dir_about/$file_name_ab";

    move_uploaded_file($tmp_name_ab, $target_file_path);
    }

    $pageDesign->allParts['About']->AboutDescription = $_POST['aboutDesc'];
    $pageDesign->allParts['About']->AboutImagePath = $target_file_path;
    }
    
    //----------------Scanning Directory 'mainimages' for loading images -------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept'])) {
    $target_dir_data = "mainimages";
    $imageFiles = scandir($target_dir_data);
    $mainImages = new MainImages("MainImages");
    $mainImages->images = array();

    foreach ($imageFiles as $key => $value) {

    if (!in_array($value,array(".","..")))
    {
    $path = $target_dir_data . DIRECTORY_SEPARATOR . $value;

    if (!is_dir($path))
    {
    $mainImages->addImage($path);
    }
    }
    }
    $pageDesign->allParts['MainImages'] = $mainImages;
    }
    }
    //----------------------------------------------------------------------------------------

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
