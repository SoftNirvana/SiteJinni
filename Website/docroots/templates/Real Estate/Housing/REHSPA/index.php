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
    require($locpath . "/PHPmailer/class.phpmailer.php"); // path to the PHPMailer class
    require($locpath . "/PHPmailer/class.smtp.php"); // path to the PHPMailer class
    
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
   /* 
    $key = NULL;
    $val = NULL;
    $iv = NULL;
    if(isset($_GET['str']) && isset($_GET['key']) && isset($_GET['iv']))
    {
        $str = $_GET['str'];
        $key = $_GET['key'];
        $iv = $_GET['iv'];

        $ciphertext_dec = base64_decode($str);

        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                        $ciphertext_dec, MCRYPT_MODE_CBC, $iv);

        $val = substr($plaintext_dec , strlen($plaintext_dec) - 16);
    }*/
   
   //$user = new User("billgates", "", "", "bill", "gates", "", "", "", "", "", "", "", "", "");
   // $client = new Client("cl1", "microsoft", "", "", "", "", "", "", "", "", "microsoft.sitejinni.com", "", "");
    $isedit = ($client != NULL && $user != NULL);
    //testing
  //  $isedit=true;
   //$IsOpenFromSite=true;    
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Stylish Portfolio - Start Bootstrap Theme</title>
        <?php 
         echo '<script src="/js/sitejinnijs.js"></script> ';
        ?>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <LINK href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <LINK href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   
    <script src="js/spwCustom.js" type="text/javascript"></script>
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <style>
        li {
            font-family: sans-serif;
            font-size: 12px;
            font-weight: bold;
        }

        .carousel-inner {
            padding: 0px;
            list-style: none;
        }

        .carousel-inner > .item > img {
                width: 1280px;
                height: 520px;
        }
        /* Always set the map height explicitly to define the size of the div
        * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
		
        .hidden-map {
                opacity: 0;
                position: absolute;
                bottom: 0
        }

        #map-container {
                width:100%; 
                height:200px; 
                overflow:hidden;
        }


        #map-content {
                height: 100% ;
                width: 100% ;
        }		

        .gm-style-iw {
                height: 220px;
                overflow-y: auto !important;
                overflow-x: hidden !important;
        }
        .gm-style-iw > div {
                max-height: 180px;
            overflow: visible !important;   
        }
        .infoWindow {
            overflow: hidden !important;
        }

        .wrapper {
                display: inline-block;
                position: relative;
        }

        .hover {
                position: absolute;
                top: 0;
                right: 0;
                background-color: rgba(170, 188, 212, 0);
                transition: background-color 0.5s;
        }

        .hover:hover {
                background-color: rgba(170, 188, 212, 0.8);

        }
    </style>
    <script type="text/javascript">
        var map;
        var service;
        var selectedLocation;
        
        function showImageEditor() {
            var div = document.getElementById("edit_item");
            div.hidden = "";
        }

        //-----------------------------------
        //---------Unused--------------------
        function fixInfoWindowScrollbars() {

                if (this.hasFixApplied) return;

                // Find the DOM node for this infoWindow
                var InfoWindowWrapper = $((this.B || this.D).contentNode.parentElement);

                // We disable scrollbars temporarily
                // Then increase .infoWindow's natural dimensions by 2px in width and height    

                InfoWindowWrapper.children().css('overflow', 'visible');

                var InfoWindowElement = InfoWindowWrapper.find('.infoWindow');
                InfoWindowElement            
                        .width(function(i, oldWidth) { return oldWidth + 3 })

                // Will this content need scrollbars?  If so, add another 20px padding on right
                if (InfoWindowElement.height() > InfoWindowWrapper.height()) {
                        InfoWindowElement
                                .css({'padding-right': '20px'})
                                .width(function(i, oldWidth) { return oldWidth - 20 })
                }

                InfoWindowElement
                        .height(function(i, oldHeight) { return oldHeight + 3 })            

                // Replace infoWindow content with our new DOM nodes
                this.hasFixApplied = true;
                this.setContent(InfoWindowElement.get(0))

        }
        //----------------------------------------

        //----------------------------------------
        //Map initialization - passed to google map API
        //This function defines the selection (input) map
        function initMap() {
            var locationLoaded = true;  
            var loc = { lat: 37.0625, lng: -95.677068 };
            var editmode = true;
            map = new google.maps.Map(document.getElementById('map-content'), {
                center: loc,
                zoom: 13
            });
            service = new google.maps.places.PlacesService(map);


			var latt = 37.0625; 
			var longg = -95.677068; 
			loc = { lat: latt, lng: longg };
			map.setCenter(loc);
			var marker = new google.maps.Marker({
				position: loc,
				map: map
			});

			var contentstring = '<div style="width: 100%;padding-left:10px; padding-top:20px;padding-right:20px; height: 180px;float: left;line-height: 25px;border-radius:5px 5px 0px 0px;">' +
									'<form action="index.php" method="post" id="mapEditForm">'+
										'Location Name: <input name="locationName" type="text"><br/><br/>' +
										'Location Desc: <input name="locationDescription" type="text"><br/><br/>' +
										'<input id="set_location" value="Set Location" type="button" onclick="setLocation()">' +
									'</form>' +
								'</div>';
				
			var infowindow = new google.maps.InfoWindow({content:contentstring});

			marker.addListener('click', function () {
				infowindow.open(map, marker);
			});

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });
			map.addListener('click', function(e) {
				placeMarkerAndPanTo(e.latLng, map);
			});

            var markers = [];

            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                markers.forEach(function (marker) {
                    marker.setMap(null);
                });

                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    var marker = new google.maps.Marker({
                        title: place.name,
                        position: place.geometry.location,
                        map: map
                    });

                    var contentstring = '<div style="width: 100%;padding-left:10px; padding-top:20px;padding-right:20px; height: 180px;float: left;line-height: 25px;border-radius:5px 5px 0px 0px;">' +
                                                '<form action="index.php" method="post" id="mapEditForm">'+
                                                        'Location Name: <input name="locationName" id="locationName" type="text"><br/><br/>' +
                                                        'Location Desc: <input name="locationDescription" id="locationDescription" type="text"><br/><br/>' +
                                                        '<input id="set_location" value="Set Location" type="button" onclick="setLocation()">' +
                                                '</form>' +
                                        '</div>';
                    
                    var infowindow = new google.maps.InfoWindow({content:contentstring});
					//google.maps.event.addListener(infowindow, 'domready', fixInfoWindowScrollbars);

                    marker.addListener('click', function () {
                        infowindow.open(map, marker);
                    });

                    markers.push(marker);
                    map.setCenter(place.geometry.location);
                    selectedLocation = place.geometry.location;
                });
            });
        }
        //-------------------------------------------

        //-------------------------------------------
        //Marker detail definition- Info Window form
        function placeMarkerAndPanTo(latLng, map) {
                var marker = new google.maps.Marker({
                        position: latLng,
                        map: map
                });
                map.setCenter(latLng);
                selectedLocation = latLng;
                var contentstring = '<div style="width: 100%;padding-left:10px; padding-top:20px;padding-right:20px; height: 180px;float: left;line-height: 25px;border-radius:5px 5px 0px 0px;">' +
                                                                '<form action="index.php" method="post" id="mapEditForm">'+
                                                                        'Location Name: <input name="locationName" id="locationName" type="text"><br/><br/>' +
                                                                        'Location Desc: <input name="locationDescription" id="locationDescription" type="text"><br/><br/>' +
                                                                        '<input id="set_location" value="Set Location" type="button" onclick="setLocation()">' +
                                                                '</form>' +
                                                        '</div>';

                var infowindow = new google.maps.InfoWindow({content:contentstring});

                marker.addListener('click', function () {
                        infowindow.open(map, marker);
                });

        }
        //-------------------------------------------

        //--------------------------------------------
        //Create location marker function
        function createMarker(place) {
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                icon: {
                    url: 'https://developers.google.com/maps/documentation/javascript/images/circle.png',
                    anchor: new google.maps.Point(10, 10),
                    scaledSize: new google.maps.Size(10, 17)
                }
            });

            service.getDetails(place, function (result, status) {
                var div = document.createElement("div");
                var content = document.createElement("text");
                content.textContent = result.name;
                div.appendChild(content);

                var infowindow = new google.maps.InfoWindow();
                infowindow.setContent(div);
                marker.addListener('click', function () {
                    infowindow.open(map, marker);
                });
            });
        }
        //---------------------------------------------

        //---------------------------------------------
        //Marker click callback
        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    var place = results[i];
                    createMarker(results[i]);
                }
            }
        }
        //----------------------------------------------

        //----------------------------------------------
        //Ajax refresh header-div
        function refreshDiv()
        {
                $('#header_div').load(document.URL + "#header_div");
        }
        //-----------------------------------------------

        //-----------------------------------------------
        //Ajax delete image function
        function deleteImage(imgPath, name)
        {
                $.ajax({
                            type: "POST",
                            url: "index.php",
                            data: {delimg: imgPath},
                            cache: false,
                            success: function(result){
                                    document.getElementById(name).remove();
                                    document.getElementById("mainImageForm").reset();							
                            }							
                    });
        }


        function SetFOAClass(clsName)
        {
                var hdnFoaClass=document.getElementById('hdnFoaClass');
                hdnFoaClass.value=clsName;
        }
        
        //-----------------------------------------------

        //-----------------JQuery events-------------------------
        //-------------------------------------------------------
        //To refresh JS API Map when modal form is open - Without 
        //this the MAP will not show on the modal form unless 
        //browser is resized
        $(document).ready(function () {
            $('#edit_location').on('shown.bs.modal', function() {
                google.maps.event.trigger(map, 'resize');
            });

            var allRules = [];
            var sSheetList = document.styleSheets;
            var strhtm = '<div class="box text-center" style="width: 95%; margin: 5px;"><div class="row">';
            var ruleList = null;
            for (var sSheet = 0; sSheet < sSheetList.length; sSheet++)
            {
                    if(document.styleSheets[sSheet].href != null)
                    {
                            var idx = document.styleSheets[sSheet].href.lastIndexOf("/");
                            var str = document.styleSheets[sSheet].href.substring(idx + 1, document.styleSheets[sSheet].href.length);

                            if(str === "font-awesome.min.css")
                                    ruleList = document.styleSheets[sSheet].cssRules; 
                    }
            }
            if(ruleList != null)
            {
                    for (var rule = 0; rule < ruleList.length; rule ++)
                    {
                            if(rule > 31)
                            {						
                                    var classstr = ruleList[rule].selectorText.substring(1,ruleList[rule].selectorText.indexOf(":"));
                                    var idxr = classstr.indexOf("-");
                                    var faclassname=classstr.substring(idxr + 1,classstr.length);
                                    var str = '<div class="fa-hover col-md-3 col-sm-4"><a href="#" onclick="SetFOAClass(\'' + classstr + '\')"><div class="row"><i class="fa ' + classstr + ' fa-2x" aria-hidden="true"></i> </div><div class="row"><text style="font-size: 10px">'+faclassname+'</text></div></a></div>';
                                    strhtm = strhtm + str;
                            }
                    }
                    var strhtm = strhtm + "</div></div>";
                    var divList = document.getElementById("serviceiconlist");
                    divList.innerHTML = strhtm;
            }

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
        //Setting enquiry mail body
        $(document).ready(function() {
                $("#enq_form").submit(function(event)
                {
                        var enq_mail = document.getElementById("enq_mailbody");
                        var mail_text = CKEDITOR.instances.enq_mailtext.getData();
                        enq_mail.value = mail_text;
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

        //-----------------------JavaScript functions-----------------
        //------------------------------------------------------------
        //Set location with AJAX post of location data from map
        //Call - Infowindow form - dynamically created - Init map function
        function setLocation()
        {
                var latVal = selectedLocation.lat();
                var lngVal = selectedLocation.lng();
                var locName = document.getElementById("locationName").value;
                var locDescription = document.getElementById("locationDescription").value;

                $.ajax({
                                type: "POST",
                                url: "index.php",
                                data: {locationName: locName, locationDescription: locDescription, lat: latVal, lng: lngVal},
                                datatype: 'HTML',						
                                cache: false,
                                success: function(result){	
                                        $('#divMap').load(document.URL + " #divMap")	;
                                }							
                        });
        }
        //-------------------------------------------------------------

        //-------------------------------------------------------------
        //Function for submission of amenity-form with description 
        function SubmitAmenity()
        {	 
                //e.preventDefault();
                var descData = CKEDITOR.instances.description_editor.getData()
                var inpFile = document.getElementById("amenityImageFile");
                var filePath = inpFile.value;
                $.ajax({
                            type: "POST",
                            url: "index.php",
                            data: {descriptionAM: descData, filePathAM: filePath},
                            datatype: 'HTML',						
                            cache: false,
                            success: function(result){
                                    location.reload();
                                    $('#edit_amenities').modal('show');
                            }							
                        });
}
        //---------------------------------------------------------------

		
    </script>
    
</HEAD>
<BODY>
    <?php
        include($locpath . 'htmlassets/datapost.php');
        include($locpath . 'htmlassets/visitortoclientdatapost.php');
    ?>
     
        
        <?php 
             if(($isedit==true)&&($IsOpenFromSite==true)){
                 
                 echo '<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">'
                       .'<div class="container topnav container-fluid">';
                  include( $locpath . "/htmlassets/sitejinniNavBar.php");
                  echo ' </div></nav>';
             }

        ?>
    
        <!-- Navigation -->
        <a id="menu-toggle" href="#" class="btn btn-dark btn-lg toggle"><i class="fa fa-bars"></i></a>
        <nav id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-times"></i></a>
                <li class="sidebar-brand">
                    <a href="#top" onclick=$("#menu-close").click();>Start Bootstrap</a>
                </li>
                <li>
                    <a href="#top" onclick=$("#menu-close").click();>Home</a>
                </li>
                <li>
                    <a href="#about" onclick=$("#menu-close").click();>About</a>
                </li>
                <li>
                    <a href="#services" onclick=$("#menu-close").click();>Services</a>
                </li>
                <li>
                    <a href="#portfolio" onclick=$("#menu-close").click();>Portfolio</a>
                </li>
                <li>
                    <a href="#contact" onclick=$("#menu-close").click();>Contact</a>
                </li>
            </ul>
           
        </nav>

        <!----- Edit button for header ---------->
        <?php
            if($isedit == TRUE)
            {
                echo '<div class="col-md-1 col-sm-1" style="position:absolute;background-color:transparent;z-index: 1">
                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_header" style="background-color:transparent;border:none">
                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                        </div>
                    </div>';
            }
        ?>
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
        <!--------------------------------------->
        <!-- Header -->
        <header id="top" class="header">
            <div class="text-vertical-center">
                <h1> <div id="Header_Header" class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>"><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></div></h1>
                <h3> <div id="Header_Address1" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?>><?php echo $pageDesign->allParts['Header']->Address1; ?> </div>
                    <div id="Header_Address2" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> > <?php echo $pageDesign->allParts['Header']->Address2; ?> </div>
                    <div id="Header_Phonenum" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> ><?php echo $pageDesign->allParts['Header']->Phonenum; ?></div>
                </h3>
                <br>
                <a href="#about" class="btn btn-dark btn-lg">Find Out More</a>
            </div>
            
            
       <!-- <DIV class="row" id="header_div">
            <DIV id="Header_Header" class="brand <?php echo ($isedit == TRUE) ? 'texteditor' : ' ';?>" ><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></DIV>
            <DIV class="address-bar" > 
                <div id="Header_Address1" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> ><?php echo $pageDesign->allParts['Header']->Address1; ?></div>
                <div id="Header_Address2" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> > <?php echo $pageDesign->allParts['Header']->Address2; ?></div>
                <div id="Header_Phonenum" <?php echo ($isedit == TRUE) ? 'class="texteditor"' : ' ';?> ><?php echo $pageDesign->allParts['Header']->Phonenum; ?></div>
            </DIV>
        </DIV>-->
        </header>

        <!-- About -->
        <section id="about" class="about">
            <!----- Edit button for about ----------->
            <?php
                if($isedit == TRUE)
                {
                    echo '<div class="col-md-1 col-sm-1" style="position:absolute;background-color:transparent;z-index: 1; right:0">
                                <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_about" style="background-color:transparent;border:none">
                                        <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                </div>
                        </div>';
                }
            ?>
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-6 col-lg-offset-3 text-center">
                            <div class="col-lg-3">
                                <?php
                                    if($pageDesign->allParts['About'] != NULL && $pageDesign->allParts['About']->AboutImagePath != NULL) {
                                        echo '<img src="' . $pageDesign->allParts['About']->AboutImagePath . '" style="height:50px; width: 50px;"/>';
                                    }
                                
                                ?>
                            </div>
                            <div class="col-lg-8 text-left" style="margin: 5px">
                                <?php echo $pageDesign->allParts['About']->AboutDescription; ?>
                            </div>
                    </div>
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- Services -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
        <section id="services" class="services bg-primary">
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
            
        <div class="container">
            <div class="row text-center">
                   <div class="col-lg-10 col-lg-offset-1">
                        <h2>Our Services</h2>
                        <hr class="small">
                        <div class="row text-center">
                            <?php
                                $existingAmenities = $pageDesign->allParts['Amenities']->Amenities;
                                $cnt = 0;
                                $amcount = count($existingAmenities)-1;
                                $off = (12- (3*$amcount))/2;
                                foreach ($existingAmenities as $keyExAm => $valueExAm) {
                                    if ($valueExAm->AmenityDescription != NULL)
                                    {
                                        if($valueExAm->AmenityName != NULL)
                                        {
                                            echo '<div class="col-md-'.($amcount>1?'3':'4').' col-sm-6 text-center '.($cnt==0?'col-md-offset-'.floor($off) :'').'">
                                                    <div class="service-item">
                                                        <span class="fa-stack fa-4x">
                                                            <i class="fa fa-circle fa-stack-2x"></i>
                                                            <i class="fa ' . $valueExAm->iconclass . ' fa-stack-1x text-primary"></i>
                                                        </span>
                                                        <h4>
                                                            <strong>' . $valueExAm->AmenityName . '</strong>
                                                        </h4>
                                                        <p>
                                                            <button type="button" class="btn btn-light" data-slide-to="collapse" data-toggle="tab" data-target="#' . str_replace(" ", "_", $valueExAm->AmenityName) . '" onclick="SetServiceInfo()">Learn More</button>
                                                        </p>
                                                    </div>
                                                </div>';
                                            $cnt = $cnt + 1;
                                        }
                                    }
                                }	
                            ?>
                            
                            
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.col-lg-10 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- Callout -->
        <section class="callout ">
        <!--<div class="container">-->
            <div class="row">
                <!--<div class="board">-->                
                    <div class="tab-content">
                        <?php
                            $existingAmenities = $pageDesign->allParts['Amenities']->Amenities;
                            $cnt = 0;
                            foreach ($existingAmenities as $keyExAm => $valueExAm) 
                                {
                                    $activestring = '';
                                    if($cnt == 0)
                                        $activestring = ' in active';
                                    echo '<div class="tab-pane fade'.$activestring.' text-center" id="' . str_replace(" ", "_", $valueExAm->AmenityName) . '">
                                            <div class="row">
                                                <div class="thumbnail col-md-2 col-md-offset-5">
                                                    <img src="' . $valueExAm->imagePath . '"  style="width:100%;height:100%"/>
                                                </div>
                                            </div>
                                            <div class="row">                                                    
                                                <h3 class="head text-center">' . $valueExAm->AmenityName . '</h3>
                                                <p class="narrow text-center">
                                                    ' . $valueExAm->AmenityDescription . '
                                                </p>
                                            </div>
                                        </div>';
                                    $cnt = $cnt + 1;
                                }
                        ?>
                       
                        <div class="clearfix"></div>
                    </div>
                <!--</div>-->
            </div>
        <!--</div>-->
        </section>
        

        <!-- Portfolio -->
        <section id="portfolio" class="portfolio">
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
            <!--<div class="col-md-11 col-sm-11">-->
            <div class="container">
			
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <h2>Our Work</h2>
                        <hr class="small">
                        
                        <!------------ Main Images Display - indicators ------------->
                        
                        <?php
                            $cnt = 0;
                            if($pageDesign->allParts['MainImages']!= NULL && $pageDesign->allParts['MainImages']->images != NULL) {
                                $tot = count($pageDesign->allParts['MainImages']->images);
                                foreach ($pageDesign->allParts['MainImages']->images as $keyImg => $valueImg) {
                                    if($cnt % 3 == 0) {
                                        if($cnt>0)
                                            echo '</div>';
                                        echo '<div class="row">';

                                    }
                                    $offstr = '';
                                    if(floor($cnt/3) == floor($tot/3) && $tot % 3 >0 && $cnt % 3 == 0) {
                                        $off = (12-(4*($tot%3)))/2;
                                        $offstr =  ' col-md-offset-' . $off;
                                    }
                                    echo '<div class="col-md-4'.$offstr.'">
                                            <div class="portfolio-item thumbnail">
                                                <a href="#">
                                                    <img class="img-portfolio img-responsive" src="'.$valueImg.'" style="width: 100%; height: 100%">
                                                </a>
                                            </div>
                                        </div>';

                                    if($cnt==$tot)
                                        echo '</div>';

                                    $cnt = $cnt + 1;
                                 }
                            }
                        ?>
                    </div>
                    <!-- /.col-lg-10 -->
                </div>
                <!-- /.row -->
            </div>
            
			<!-- /.container -->
        </section>

        <!-- Call to Action -->
        <aside class="call-to-action bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3>Send an enquiry to <?php echo $pageDesign->allParts['Header']->CompanyName; ?></h3>
                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#send_enquiry" style="background-color:transparent;border:none">
                            <button class="btn btn-lg btn-light">Send Enquiry</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </aside>

        <!-- Map -->
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
        <section id="contact" class="map">
            <div class="box hover" style="right:0;">
                <div style="background-color: beige; padding:5px 5px 5px 5px; border:solid; border-color: black; -moz-box-shadow: inherit; -webkit-box-shadow: inherit; box-shadow: inherit position: absolute;">
                    <?php echo $pageDesign->allParts['Location']->LocationName ?><br>
                    <?php echo $pageDesign->allParts['Location']->LocationDesc ?><br>
                </div>
            </div>
            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="https://maps.google.com/maps/embed/v1/place?key=AIzaSyDvp8iqxZqSa_9YrjAcYlP5CvYvwNBomes&amp;q=<?php echo $pageDesign->allParts['Location']->LocationLat .','.$pageDesign->allParts['Location']->LocationLng ?>&amp;center=<?php echo $pageDesign->allParts['Location']->LocationLat .','.$pageDesign->allParts['Location']->LocationLng ?>&amp;zoom=13"></iframe>
            <br />
            <small>
                <a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a>
            </small>
        </section>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                      
                        <ul class="list-unstyled">
                            <li>
                                <i class="fa fa-envelope-o fa-fw"></i> <a href="mailto:name@example.com"><?php echo $pageDesign->allParts['CompanyLocation']->CompanyEmail;?></a>
                            </li>
                        </ul>
                       
                  </div>
                    
                    <DIV class="row">
                        <DIV class="col-lg-12 text-center">
                            <P> <a href="http://www.sitejinni.com" target="_blank" >www.sitejinni.com</a>  <br><SPAN>Copyright © <?php echo $pageDesign->allParts['Header']->{'CompanyName'}; ?> 2017</SPAN></P>
                        </DIV>
                    </DIV>
                

                </div>
            </div>
            <a id="to-top" href="#top" class="btn btn-dark btn-lg"><i class="fa fa-chevron-up fa-fw fa-1x"></i></a>
        </footer>
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
        
        <!--------------- Send Enquiry form ----------------->
        <div class="modal fade" id="send_enquiry" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enquiry</h4>
                    </div>
                    <div class="box">
                        <div class="row" style="padding: 25px">
                            <div class="col-lg-12 col-md-12" style="margin: 5px">
                                <form action="index.php" method="post" id="enq_form">
                                    <label style="font-weight: bold">Sender Name </label><br><input type="text" id="enq_name" name="enq_name" style="width: 100%"><br>
                                    <label style="font-weight: bold">Sender Address Line1 </label><br><input type="text" id="enq_address1" name="enq_address1" style="width: 100%"><br>
                                    <label style="font-weight: bold">Sender Address Line2 </label><br><input type="text" id="enq_address2" name="enq_address2" style="width: 100%"><br>
                                    <label style="font-weight: bold">Phone Number </label><br><input type="text" id="enq_phonenum" name="enq_phonenum" style="width: 100%"><br>
                                    <label style="font-weight: bold">Sender Email </label><br><input type="text" id="enq_mail_add" name="enq_mail_add" style="width: 100%"><br>
                                    <hr>                                    
                                    <label style="font-weight: bold">Body</label><br>
                                    <hr>                                    
                                    <textarea style="width:100%; height: 200px" id="enq_mailtext" onchange="setBigTExt()" >                                        
                                    </textarea><br>
                                    <hr>                                    
                                    <input type="hidden" name="enq_mailbody" id="enq_mailbody">
                                    <input type="submit" value="Send Mail" name="send_enquiry"/>
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
                                        <input name="files[]" multiple="multiple" type="file"  id="mainImageFormInpF" />
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
                                                            echo '<div class = "col-sm-7 col-md-4"  id="mainImg' . $cnt . '">';
                                                            echo "<div class='thumbnail'>
                                                                    <div class='Generic placeholder' style='background-image:URL("."$target_dir/$value"."); background-size:contain; height: 100px'>
                                                                        <button class='glyphicon glyphicon-trash' type='button' onclick=\"deleteImage('"."$target_dir/$value"."','"."mainImg".$cnt."')\"/>
                                                                    </div>																						
                                                                  </div>";
                                                            echo '</div>';								
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

                                                                    echo '<div class = "col-sm-7 col-md-4"  id="mainImg' . $cnt . '">';
                                                                    echo "<div class='thumbnail'>
                                                                                <div class='Generic placeholder' style='background-image:URL("."$target_dir/$name"."); background-size:contain; height: 100px'>
                                                                                    <button class='glyphicon glyphicon-trash' type='button' onclick=\"deleteImage('"."$target_dir/$name"."','"."mainImg".$cnt."')\"/>
                                                                                </div>																						
                                                                            </div>";
                                                                    echo '</div>';								
                                                                    $cnt = $cnt + 1;																				
                                                                }
                                                            }
                                                            echo "<script>$('#edit_description').modal('show');</script>";
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
                            <div >
                                <div class="row">
                                    <div>
                                        <h4 class="modal-title">Add Amenity</h4>
                                    </div>
                                </div>
                                <div class="row thumbnail">
                                    <text style="font-weight: bold">Service Icon: </text>
                                    <div id="serviceiconlist" style="height: 20%; overflow: scroll; max-height: 200px">
                                        <!--<input type="file" id="amenityImageFile" name="amenityImageFile" />-->
                                    </div>
                                    <input id="hdnFoaClass" name="hdnFoaClass" type="hidden" />
                                </div>
                                <div class="row">
                                    <div>
                                        <text style="font-weight: bold">Service Name: </text>
                                        <input name="amenityname" id="amenityname" type="text"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <text style="font-weight: bold">Service Image: </text>
                                        <input type="file" id="amenityImageFile" name="amenityImageFile" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <text style="font-weight: bold">Service Description: </text>
                                        <input name="descDataFld" id="descDataFld" type="hidden"/>
                                        <textarea id="description_editor" class="form-control">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <input type="submit" id="amenity_submit" name="amenity_submit" value="Accept"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
        <!---------------------------------------------------->

        <!--------------- About edit dialog ----------------->
        <div class="modal fade" id="edit_about" role="dialog">
           <!-- Modal content-->
            <div class="modal-dialog">
                <div class="well">
                    <div>
                        <form action="#" method="post" enctype="multipart/form-data" id="about_form">
                            <div >
                                <div class="row">
                                    <div>
                                        <input type="file" id="aboutFile" name="aboutFile" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <input name="aboutDesc" id="aboutDesc" type="hidden"/>
                                        <textarea id="about_description_editor" class="form-control">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <input type="submit" id="amenity_submit" name="amenity_submit" value="Accept"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
       <!--------------------------------------------------->
        
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
                            <div >
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
                                        <span style="font-family:Arial;font-size:13px;font-weight:300;">Document Heading :</span>&emsp;<input name="docName" id="docName" type="text"/><br><br>
                                        <span style="font-family:Arial;font-size:13px;font-weight:300;">Document Description :</span>&emsp;<input name="docDesc" id="docDesc" type="text"/><br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <input type="submit" id="amenity_submit" name="amenity_submit" value="Accept"/>
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
        CKEDITOR.replace('about_description_editor');
        CKEDITOR.replace('enq_mailtext');
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.20&sensor=true&key=AIzaSyCYKHARqf-KwLQ5pJG6xVHHa_E2dt9wNJA&libraries=places&callback=initMap" type="text/javascript">

    </script>

    <!-- Custom Theme JavaScript -->
    <script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#],[data-toggle],[data-target],[data-slide])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
    //#to-top button appears after scrolling
    var fixed = false;
    $(document).scroll(function() {
        if ($(this).scrollTop() > 250) {
            if (!fixed) {
                fixed = true;
                // $('#to-top').css({position:'fixed', display:'block'});
                $('#to-top').show("slow", function() {
                    $('#to-top').css({
                        position: 'fixed',
                        display: 'block'
                    });
                });
            }
        } else {
            if (fixed) {
                fixed = false;
                $('#to-top').hide("slow", function() {
                    $('#to-top').css({
                        display: 'none'
                    });
                });
            }
        }
    });
    // Disable Google Maps scrolling
    // See http://stackoverflow.com/a/25904582/1607849
    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function(event) {
        var that = $(this);
        that.on('click', onMapClickHandler);
        that.off('mouseleave', onMapMouseleaveHandler);
        that.find('iframe').css("pointer-events", "none");
    }
    var onMapClickHandler = function(event) {
            var that = $(this);
            // Disable the click handler until the user leaves the map area
            that.off('click', onMapClickHandler);
            // Enable scrolling zoom
            that.find('iframe').css("pointer-events", "auto");
            // Handle the mouse leave event
            that.on('mouseleave', onMapMouseleaveHandler);
        }
        // Enable map zooming with mouse scroll when the user clicks the map
    $('.map').on('click', onMapClickHandler);
    </script>
    
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
    
    
   <script src="js/textEditor.js" type="text/javascript"></script>
   <script type="text/javascript">
              CreateEditor();
   </script>
</body>

</html>
