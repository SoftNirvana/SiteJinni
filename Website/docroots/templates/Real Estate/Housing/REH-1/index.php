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
    //$isedit=true;
    //$IsOpenFromSite=true;
?>

﻿<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <META charset="utf-8">
    <META http-equiv="X-UA-Compatible" content="IE=edge">
    <META name="viewport" content="width=device-width, initial-scale=1">
    <META name="description" content="">
    <META name="author" content="">
    <TITLE>
        Business Casual - Start Bootstrap
        Theme
    </TITLE>
<?php 
  echo '<script src="/js/sitejinnijs.js"></script> ';
?>
    <META name="GENERATOR" content="WDL-Website-Builder">     <!-- Bootstrap Core CSS -->
    <LINK href="css/bootstrap.min.css" rel="stylesheet">     <!-- Custom CSS -->
    <LINK href="css/business-casual.css" rel="stylesheet">     <!-- Fonts -->
    
    <LINK href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <LINK href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link href="css/reccustom.css" rel="stylesheet" />
    <script src="js/recCustom.js"></script>
    <script type="text/javascript">
        //-----------------JQuery events-------------------------
        //-------------------------------------------------------
        //To refresh JS API Map when modal form is open - Without
        //this the MAP will not show on the modal form unless
        //browser is resized
        $(document).ready(function () {
            $('#edit_location').on('shown.bs.modal', function() {
                google.maps.event.trigger(map, 'resize');
            });
        });
        //-------------------------------------------------------

        //-------------------------------------------------------
        //Setting description data on submit of amenity-edit form
        $(document).ready(function() {
                $("#amenity_form").submit(function(event)
                {
                        //event.preventDefault();
                        var descData = CKEDITOR.instances.description_editor.getData();
                        var fld = document.getElementById("descDataFld");
                        fld.value = descData;
                        return true;
                });
        });
        //--------------------------------------------------------

        //--------------------------------------------------------
        //Setting description data on submit of about-edit form
        $(document).ready(function() {
                $("#about_form").submit(function(event)
                {
                        //event.preventDefault();
                        var abtDesc = CKEDITOR.instances.about_description_editor.getData();
                        var fld = document.getElementById("aboutDesc");
                        fld.value = abtDesc;
                        return true;
                });
        });
        //--------------------------------------------------------

        //--------------------------------------------------------
        //Setting data on Header-edit form  submission
        $(document).ready(function(){
            $('#save_header').click(function (event) {

                        var header = $("#header").val();

                        var address1 = $("#address1").val();
                        var address2 = $("#address2").val();
                        var phonenum = $("#phonenum").val();
                        var compname = $("#compname").val();
                        var dataString = 'header1='+ header + '&address11='+ address1 + '&address21='+ address2 + '&phonenum1='+ phonenum + '&compname1='+ compname;
                        if(header==''||address1==''||address2==''||phonenum==''||compname=='')
                        {
                                alert("Please Fill All Fields");
                        }
                        else
                        {
                                $.ajax({
                                        type: "POST",
                                        url: "index.php",
                                        data: dataString,
                                        cache: false,
                                        success: function(result){
                                                alert("OK");
                                                $('#header_div').load(document.URL + "#header_div")	;
                                        }
                                });
                        }
                });
        });
        //------------------------------------------------------------
        //------------------------------------------------------------
    </script>
	<script src="js/textEditor.js"></script>
   
</HEAD>
<BODY>
     <?php
        include($locpath . '/htmlassets/datapost.php');
    ?>
      
    <DIV>
        
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="topnav container-fluid">
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
        <!----- Install button for Template ---------->
       
        <?php 
            if($IsOpenFromSite==FALSE)
            {
               echo '<div class="row" >
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
        <!----- Edit button for header ---------->
        <?php
     
        if($isedit == TRUE)
        {
        echo '<div class="col-md-1 col-sm-1" style="position:absolute;background-color:transparent;z-index: 1">
            <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_header" style="background-color:transparent;border:none">
                <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" ></button>
            </div>
        </div>';
        }
        ?>
        
        <!--------------------------------------->
        <DIV class="row" id="header_div">
            <DIV id="Header_Header" class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>" ><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></DIV>
            <DIV class="address-bar" > 
                <div id="Header_Address1" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> ><?php echo $pageDesign->allParts['Header']->Address1; ?></div>
                <div id="Header_Address2" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> > <?php echo $pageDesign->allParts['Header']->Address2; ?></div>
                <div id="Header_Phonenum" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> ><?php echo $pageDesign->allParts['Header']->Phonenum; ?></div>
            </DIV>
        </DIV>
        <DIV>
            <NAV class="navbar navbar-default" role="navigation">
                <DIV class="container">
                    <DIV class="navbar-header">
                        <BUTTON class="navbar-toggle" type="button" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse">
                            <SPAN class="sr-only">
                                Toggle
                                navigation
                            </SPAN>
                            <SPAN class="icon-bar"></SPAN>
                            <SPAN class="icon-bar"></SPAN>
                            <SPAN class="icon-bar"></SPAN>
                        </BUTTON>
                        <A class="navbar-brand" href="index.html"><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></A>
                    </DIV>
                    <DIV class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <UL class="nav navbar-nav">
                            <LI><A href="index.php">Home</A></LI>
                            <LI><A href="about.php">About</A></LI>
                        </UL>
                    </DIV>
                </DIV>
            </NAV>
            <DIV class="container" >
                <DIV class="row">
                    <DIV class="box">
                        <DIV class="col-lg-12 text-center">
                            <!----- Edit button for main images ---->
                            <?php
                            if($isedit == TRUE)
                            {
                            echo '<div class="col-md-1 col-sm-1" style="position:absolute;background-color:transparent;z-index: 1">
                                <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_description" style="background-color:transparent;border:none">
                                    <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                </div>
                            </div>';
                            }
                            ?>
                            <!-------------------------------------->
                            <DIV class="carousel slide" id="carousel-example-generic" style="z-index: 0">
                                <OL class="carousel-indicators hidden-xs">
                                    <!------------ Main Images Display - indicators ------------->
                                    <?php
                                    $i = 0;
                                    if($pageDesign->allParts['MainImages']!= NULL && $pageDesign->allParts['MainImages']->images != NULL) {
                                    foreach ($pageDesign->allParts['MainImages']->images as $keyImg => $valueImg) {
                                    if($i == 0) {
                                    echo '
                                    <LI class="active" data-target="#carousel-example-generic" data-slide-to="'.$i.'"></LI>';
                                    }
                                    else {
                                    echo '
                                    <LI data-target="#carousel-example-generic" data-slide-to="'.$i.'"></LI>';
                                    }

                                    $i = $i + 1;
                                    }
                                    }
                                    ?>
                                    <!----------------------------------------------------------->
                                </OL>
                                <DIV class="carousel-inner">
                                    <!------------ Main Images Display - images ----------------->
                                    <?php
                                    $i = 0;
                                    if($pageDesign->allParts['MainImages']!= NULL && $pageDesign->allParts['MainImages']->images != NULL) {
                                    foreach ($pageDesign->allParts['MainImages']->images as $keyImg => $valueImg) {
                                    if($i == 0) {
                                    echo '<DIV class="item active"><IMG class="img-responsive img-full" alt="" src="'.$valueImg.'"></DIV>';
                                    }
                                    else {
                                    echo '<DIV class="item"><IMG class="img-responsive img-full" alt="" src="'.$valueImg.'"></DIV>';
                                    }
                                    $i = $i + 1;
                                    }
                                    }
                                    ?>
                                    <!----------------------------------------------------------->
                                </DIV>

                                <A class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <SPAN class="icon-prev"></SPAN>
                                </A>
                                <A class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <SPAN class="icon-next"></SPAN>
                                </A>
                            </DIV>

                            <H2 class="brand-before"><SMALL>Welcome to</SMALL> </H2>
                            <H1 class="brand-name"><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></H1>
                            <HR class="tagline-divider">
                            <H2>
                                <SMALL>
                                    By <STRONG><?php echo $pageDesign->allParts['Header']->CompanyName; ?></STRONG>
                                </SMALL>
                            </H2>
                        </DIV>
                    </DIV>
                </DIV>
                <DIV class="row" >
                    <!--------- Edit button for Amenities --------->
                    <?php
                    if($isedit == TRUE)
                    {
                    echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_amenities" style="background-color:transparent;border:none">
                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                        </div>
                    </div>';
                    }
                    ?>
                    <!--------------------------------------------->
                    <DIV  class="box " style="z-index: 0">
                        <!-------------------- Amenities Display -------------------->
                        <?php
                        $allignments = array("img-left", "img-right");
                        $existingAmenities = $pageDesign->allParts['Amenities']->Amenities;
                        $cnt = 0;
                        foreach ($existingAmenities as $keyExAm => $valueExAm) {
                        if (!in_array($valueExAm->imagePath,array(".","..")))
                        {
                        if($valueExAm->imagePath != '' || $valueExAm->AmenityDescription != '')
                        {
                        if (!is_dir($valueExAm->imagePath))
                        {
                        echo '<div class="row ">
                            <DIV class="col-lg-12">
                                <IMG style="height: 170px; width: 200px;margin:7px 7px 7px 7px;" class="img-responsive img-border '. $allignments[$cnt % 2] .'" alt="" src="'.$valueExAm->imagePath.'">
                                <HR class="visible-xs">
                                <div id="Amenities_Amenities_'.$cnt.'_AmenityDescription"  '.(($isedit == TRUE) ? 'class="texteditor" ' : ' ') . ' style="margin:7px 7px 7px 7px;">
                                    '.$valueExAm->AmenityDescription.'
                                </div>
                            </DIV>
                        </div>';
                        }
                        }
                        }
                        $cnt = $cnt + 1;
                        }
                        ?>
                        <!----------------------------------------------------------->
                    </DIV>
                </DIV>
                <DIV class="row">
                    <!--------- Edit button for Location(site) -------->
                    <?php
                    if($isedit == TRUE)
                    {
                    echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_location" style="background-color:transparent;border:none">
                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                        </div>
                    </div>';
                    }
                    ?>
                    <!------------------------------------------------->
					  <!--  style="background-color: beige; padding:5px 5px 5px 5px; border:solid; border-color: black; -moz-box-shadow: inherit; -webkit-box-shadow: inherit; box-shadow: inherit;"-->
                    <DIV class="box" id="divMap">
                        <DIV class="col-lg-12">
                            <DIV class="row">
                                <div class="box hover">
                                    <div  style="background-color: white; margin: 10px 0px 10px 0px; padding: 7px; box-shadow: 11px 1px 11px -1px rgba(0, 0, 0, 0.3); border-radius: 2px;">
                                        <?php echo $pageDesign->allParts['Location']->LocationName ?><br>
                                        <?php echo $pageDesign->allParts['Location']->LocationDesc ?><br>
                                    </div>
                                </div>
                                <!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->
                                <IFRAME width="100%" height="400" src="https://maps.google.com/maps/embed/v1/place?key=AIzaSyDvp8iqxZqSa_9YrjAcYlP5CvYvwNBomes&amp;q=<?php echo $pageDesign->allParts['Location']->LocationLat .','.$pageDesign->allParts['Location']->LocationLng ?>&amp;center=<?php echo $pageDesign->allParts['Location']->LocationLat .','.$pageDesign->allParts['Location']->LocationLng ?>&amp;zoom=13" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></IFRAME>
                            </DIV>

                        </DIV>
                    </DIV>
                </DIV>
                <DIV class="row">
                    <!--------- Edit button for Documents ------------->
                    <?php
                    if($isedit == TRUE)
                    {
                    echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_documents" style="background-color:transparent;border:none">
                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                        </div>
                    </div>';
                    }
                    ?>
                    <!------------------------------------------------->
                    <DIV class="box">
                        <DIV class="col-lg-12">
                            <DIV class="row">
                                <ul class="list-group">
                                    <!-------------------- Documents Display -------------------->
                                    <?php
                                    $allignments = array("img-left", "img-right");
                                    $existingDocuments = $pageDesign->allParts['Documents']->Documents;
                                    $cnt = 0;
                                    foreach ($existingDocuments as $keyExDc => $valueExDc) {
                                    if (!in_array($valueExDc->DocumentPath,array(".","..")))
                                    {
                                    if($valueExDc->DocumentPath != '' || $valueExDc->DocumentDescription != '')
                                    {
                                    if (!is_dir($valueExDc->DocumentPath))
                                    {
                                    echo '
                                    <li class="list-group-item">
                                        <a href="' . $valueExDc->DocumentPath . '" >
                                            <h4 class="list-group-item-heading">' . $valueExDc->DocumentName . '</h4>
                                            <p class="list-group-item-text">' . $valueExDc->DocumentDescription . '</p>
                                        </a>
                                    </li>';
                                    }
                                    }
                                    }
                                    $cnt = $cnt + 1;
                                    }
                                    ?>
                                    <!----------------------------------------------------------->
                                </ul>
                            </DIV>

                        </DIV>
                    </DIV>
                </DIV>
                
              
                <!--------------- Header edit dialog ----------------->
                <div class="modal fade" id="edit_header" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Header</h4>
                            </div>
                            <div class="box">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <form action="index.php" method="post">
                                            Main Header <br><input type="text" id="header" name="header" style="width: 100%"><br>
                                            Company Name <br><input type="text" id="compname" name="compname" style="width: 100%"><br>
                                            Address Line1 <br><input type="text" id="address1" name="address1" style="width: 100%"><br>
                                            Address Line2 <br><input type="text" id="address2" name="address2" style="width: 100%"><br>
                                            Phone Number <br><input type="text" id="phonenum" name="phonenum" style="width: 100%"><br>
                                            <hr>
                                            <input class="col-lg-12" id="save_header" name="save_header" type="submit" value="Save">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------------------------------------------->
                <!--------------- Main Images edit dialog ------------>
                <div class="modal fade" id="edit_description" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-lg-4 col-md-2 col-xs-2"></div>
                                <div class="col-lg-7 col-md-4 col-xs-10">
                                    <h4 class="h4 modal-title">Edit Description</h4>
                                </div>
                            </div>
                            <div class="box">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <form action="index.php" method="post" enctype="multipart/form-data" id="mainImageForm">
                                            <div class="row" style="margin:5px">
                                                <input name="files[]" multiple="multiple" type="file" id="mainImageFormInpF" />
                                            </div>
                                            <div class="row" style="margin:5px">
                                                <div class="row">
                                                    <?php
                                                    $target_dir = "mainimages/";
                                                    $cnt = 0;
                                                    $existingImageFiles = scandir($target_dir);

                                                    foreach ($existingImageFiles as $key => $value) {
                                                    if (!in_array($value,array(".","..")))
                                                    {
                                                    if (!is_dir("$target_dir/$value"))
                                                    {
                                                    echo '<div class="col-sm-7 col-md-4" id="mainImg' . $cnt . '">
                                                        ';
                                                        echo "<div class='thumbnail'>
                                                            <div class='Generic placeholder' style='background-image:URL("."$target_dir/$value"."); background-size:contain; height: 100px'>
                                                                <button class='glyphicon glyphicon-trash' type='button' onclick=\"deleteImage('"."$target_dir/$value"."','"."mainImg".$cnt."')\" />
                                                            </div>
                                                        </div>";
                                                        echo '
                                                    </div>';
                                                    $cnt = $cnt + 1;
                                                    }
                                                    }
                                                    }
                                                    $cnt = 0;
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                    if (isset($_POST['preview'])) {
                                                    if ($_FILES['files']) {
                                                    foreach ($_FILES["files"]["error"] as $key => $error) {
                                                    if ($error == UPLOAD_ERR_OK) {
                                                    $tmp_name = $_FILES["files"]["tmp_name"][$key];
                                                    $name = basename($_FILES["files"]["name"][$key]);

                                                    move_uploaded_file($tmp_name, "$target_dir/$name");

                                                    echo '<div class="col-sm-7 col-md-4" id="mainImg' . $cnt . '">
                                                        ';
                                                        echo "<div class='thumbnail'>
                                                            <div class='Generic placeholder' style='background-image:URL("."$target_dir/$name"."); background-size:contain; height: 100px'>
                                                                <button class='glyphicon glyphicon-trash' type='button' onclick=\"deleteImage('"."$target_dir/$name"."','"."mainImg".$cnt."')\" />
                                                            </div>
                                                        </div>";
                                                        echo '
                                                    </div>';
                                                    $cnt = $cnt + 1;
                                                    }
                                                    }
                                                    echo "
                                                    <script>$('#edit_description').modal('show');</script>";
                                                    }
                                                    }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6" style="-ms-align-content: flex-end; -webkit-align-content: flex-end; align-content: flex-end;">
                                                    <input class="btn btn-info btn-sm" name="preview" type="submit" value="Preview" style="margin: 5px 5px 5px 5px;" id="mainImageFormInp1">
                                                </div>
                                                <div class="col-md-6 col-lg-6" style="-ms-align-content: flex-start; -webkit-align-content: flex-start; align-content: flex-start;">
                                                    <input class="btn btn-info btn-sm" name="accept" type="submit" value="Accept" style="margin: 5px 5px 5px 5px" id="mainImageForInp2">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------------------------------------------->
                <!--------------- Amenities edit dialog -------------->
                <div class="modal fade" id="edit_amenities" role="dialog">
                    <!-- Modal content-->
                    <div class="modal-dialog">
                        <div class="well">
                            <div>
                                <form action="index.php" method="post" enctype="multipart/form-data" id="amenity_form">
                                    <div>
                                        <div class="row">
                                            <div>
                                                <h4 class="modal-title">Add Amenity</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <input type="file" id="amenityImageFile" name="amenityImageFile" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <input name="descDataFld" id="descDataFld" type="hidden" />
                                                <textarea id="description_editor" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <input type="submit" id="amenity_submit" name="amenity_submit" value="Accept" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------------------------------------------->
                <!--------------- Location (site) edit dialog -------->
                <div class="modal fade" id="edit_location" role="dialog" style="height:570px">
                    <div class="modal-dialog" id="hidden-map" style="height:500px">
                        <!-- Modal content-->
                        <div class="modal-content" style="height:490px">
                            <div class="modal-header">
                                <div class="col-lg-4 col-md-2 col-xs-2"></div>
                                <div class="col-lg-7 col-md-4 col-xs-10">
                                    <h4 class="h4 modal-title">Edit Location</h4>
                                </div>
                            </div>
                            <div class="box" id="map-container" style="height: 420px; width: 565px">
                                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                <div id="map-content" style="height: 410px; width: 565px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------------------------------------------->
                <!--------------- Documents edit dialog -------------->
                <div class="modal fade" id="edit_documents" role="dialog">
                    <!-- Modal content-->
                    <div class="modal-dialog">
                        <div class="well">
                            <div>
                                <form action="index.php" method="post" enctype="multipart/form-data" id="amenity_form">
                                    <div>
                                        <div class="row">
                                            <div>
                                                <h4 class="modal-title">Add Document</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <input type="file" id="docFile" name="docFile" /><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <span style="font-family:Arial;font-size:13px;font-weight:300;">Document Heading :</span>&emsp;<input name="docName" id="docName" type="text" /><br><br>
                                                <span style="font-family:Arial;font-size:13px;font-weight:300;">Document Description :</span>&emsp;<input name="docDesc" id="docDesc" type="text" /><br><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div>
                                                <input type="submit" id="amenity_submit" name="amenity_submit" value="Accept" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------------------------------------------->
            </DIV>
            <FOOTER>
                <DIV class="container">
                    <DIV class="row">
                        <DIV class="col-lg-12 text-center">
                            <P> <a href="http://www.sitejinni.com" target="_blank" >www.sitejinni.com</a>  <br><SPAN>Copyright © <?php echo $pageDesign->allParts['Header']->{'CompanyName'}; ?> 2017</SPAN></P>
                        </DIV>
                    </DIV>
                </DIV>
            </FOOTER>
            <SCRIPT src="js/jquery.js"></SCRIPT>
            <!-- Bootstrap Core JavaScript -->
            <SCRIPT src="js/bootstrap.min.js"></SCRIPT>
            <script src="ckeditor/jquery.js"></script>
            <script src="ckeditor/ckeditor.js"></script>
            <script src="ckeditor/adapters/jquery.js"></script>
            <!-- Script to Activate the Carousel -->
            <SCRIPT>
                $('.carousel').carousel({
                    interval: 5000 //changes the speed
                })
            </SCRIPT>
            <script>
                CKEDITOR.replace('description_editor');
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.20&sensor=true&key=AIzaSyCYKHARqf-KwLQ5pJG6xVHHa_E2dt9wNJA&libraries=places&callback=initMap" type="text/javascript">

            </script>
            <script type="text/javascript">
              CreateEditor();
            </script>
</BODY>
</HTML>
