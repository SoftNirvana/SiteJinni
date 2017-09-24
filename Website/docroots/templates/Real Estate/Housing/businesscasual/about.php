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
<!DOCTYPE html>
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
	
    <META name="GENERATOR" content="WDL-Website-Builder">     <!-- Bootstrap Core CSS -->
    <LINK href="css/bootstrap.min.css" rel="stylesheet">     <!-- Custom CSS -->
    <LINK href="css/business-casual.css" rel="stylesheet">     <!-- Fonts -->
    <LINK href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <LINK href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
			// You can tweak with other background properties too (ie: background-image)...
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
		
        function initMap() {
            var locationLoaded = true;  //@Model.LocationPoint.Lat != 999 && @Model.LocationPoint.Lng != 999;
            var loc = { lat: 37.0625, lng: -95.677068 };
            var editmode = true;
            map = new google.maps.Map(document.getElementById('map-content-company'), {
                center: loc,
                zoom: 13
            });
            service = new google.maps.places.PlacesService(map);


            //if (locationLoaded) {
                var latt = 37.0625; //@Model.LocationPoint.Lat;
                var longg = -95.677068; //@Model.LocationPoint.Lng;
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
				//google.maps.event.addListener(infowindow, 'domready', fixInfoWindowScrollbars);

                //infowindow.setContent(div);

                marker.addListener('click', function () {
                    infowindow.open(map, marker);
                });

            //}

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
											'<form action="about.php" method="post" id="compmapEditForm">'+
												'Company Address: <input name="compAddress" id="compAddress" type="text"><br/><br/>' +
												'Company Ph. Number: <input name="compNumber" id="compNumber" type="text"><br/><br/>' +
												'Company Email: <input name="compEmail" id="compEmail" type="text"><br/><br/>' +
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
		function placeMarkerAndPanTo(latLng, map) {
			var marker = new google.maps.Marker({
				position: latLng,
				map: map
			});
			map.setCenter(latLng);
			selectedLocation = latLng;
			var contentstring = '<div style="width: 100%;padding-left:10px; padding-top:20px;padding-right:20px; height: 180px;float: left;line-height: 25px;border-radius:5px 5px 0px 0px;">' +
									'<form action="about.php" method="post" id="compmapEditForm">'+
										'Company Address: <input name="compAddress" id="compAddress" type="text"><br/><br/>' +
										'Company Ph. Number: <input name="compNumber" id="compNumber" type="text"><br/><br/>' +
										'Company Email: <input name="compEmail" id="compEmail" type="text"><br/><br/>' +
										'<input id="set_location" value="Set Location" type="button" onclick="setLocation()">' +
									'</form>' +
								'</div>';
			
			var infowindow = new google.maps.InfoWindow({content:contentstring});
			//google.maps.event.addListener(infowindow, 'domready', fixInfoWindowScrollbars);

			marker.addListener('click', function () {
				infowindow.open(map, marker);
			});

		}
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

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    var place = results[i];
                    createMarker(results[i]);
                }
            }
        }
	
		function refreshDiv()
		{
			$('#header_div').load(document.URL + "#header_div");
		}
		
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
		//-----------------button ajax events-------------------------
		$(document).ready(function () {
		    $('#edit_company_location').on('shown.bs.modal', function() {
		        google.maps.event.trigger(map, 'resize');
		    });
		});
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
		$(document).ready(function() {
			$("#project_form").submit(function(event)
			{
				//event.preventDefault();
				var descData = CKEDITOR.instances.project_description_editor.getData();
				var fld = document.getElementById("projDescFld");
				fld.value = descData;
				return true;
			});
		});
		
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
		function setLocation()
		{
			var latVal = selectedLocation.lat();
			var lngVal = selectedLocation.lng();
			var locAddress = document.getElementById("compAddress").value;
			var locNumber = document.getElementById("compNumber").value;
			var locEmail = document.getElementById("compEmail").value;
			
			$.ajax({
					type: "POST",
					url: "about.php",
					data: {compAddress: locAddress, compNumber: locNumber, compEmail: locEmail, complat: latVal, complng: lngVal},
					datatype: 'HTML',						
					cache: false,
					success: function(result){	
						$('#divMap').load(document.URL + " #divMap")	;
					}							
				});
		}
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
		
		
		
		$(document).ready(function(){
        $('#save_header').click(function (event) {

				var header = $("#header").val();
				var address1 = $("#address1").val();
				var address2 = $("#address2").val();
				var phonenum = $("#phonenum").val();
				var compname = $("#compname").val();
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'header1='+ header + '&address11='+ address1 + '&address21='+ address2 + '&phonenum1='+ phonenum + '&compname1='+ compname;
				if(header==''||address1==''||address2==''||phonenum==''||compname=='')
				{
					alert("Please Fill All Fields");
				}
				else
				{
					// AJAX Code To Submit Form.
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
    </script>
 <script src="js/recCustom.js"></script>
</HEAD>
<BODY>
    <?php
        include($locpath . 'htmlassets/datapost.php');
    ?>
    
    <DIV>
	 <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
             
             <div class="topnav container-fluid">
                   <!--<DIV id="sitejinninavbar"></DIV>-->
               <?php 
                    if(($isedit==true)&&($IsOpenFromSite==true)){
                         include( $locpath . "/htmlassets/sitejinniNavBar.php");
                    }

               ?>
             </div>
         </NAV>
        
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
                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                        </div>
                    </div>';
            }
        ?>
		<!--------------------------------------->
        <DIV class="row" id="header_div">
            <DIV class="brand"><?php echo $pageDesign->allParts['Header']->{'Header'}; ?></DIV>
            <DIV class="address-bar">
                <?php echo $pageDesign->allParts['Header']->Address1; ?> | <?php echo $pageDesign->allParts['Header']->Address2; ?> |
                <?php echo $pageDesign->allParts['Header']->Phonenum; ?>
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
             <DIV class="container">
				<!----- Edit button for about ----------->
				<?php
                                    if($isedit == TRUE)
                                    {
                                        echo '<div class="col-md-1 col-sm-1" style="position:absolute;background-color:transparent;z-index: 1">
                                                    <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_about" style="background-color:transparent;border:none">
                                                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                                    </div>
                                            </div>';
                                    }
                                ?>
				<DIV class="row">
					<DIV class="box">
						<DIV class="col-lg-12">
							<HR>
							<H2 class="intro-text text-center">
								About
								<STRONG><?php echo $pageDesign->allParts['Header']->CompanyName; ?></STRONG>
							</H2>
							<HR>
						</DIV>
						<DIV class="col-md-6"><IMG class="img-responsive img-border-left" alt="" src="<?php echo $pageDesign->allParts['About']->AboutImagePath; ?>"></DIV>
						<DIV class="col-md-6">
							<?php echo $pageDesign->allParts['About']->AboutDescription; ?>
						</DIV>
						<DIV class="clearfix"></DIV>
					</DIV>
				</DIV>
				<DIV class="row">
					<!----- Edit button for projects ---------->
					<?php
                                            if($isedit == TRUE)
                                            {
                                                echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                                                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_projects" style="background-color:transparent;border:none">
                                                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
					<!----------------------------------------->
					<DIV class="box">
						<DIV class="col-lg-12">
							<HR>
							<H2 class="intro-text text-center">
								Our
								<STRONG>Projects </STRONG>
							</H2>
							<HR>
						</DIV>
							<!------------ Projects Display ------------->
							<?php
								$allignments = array("img-left", "img-right");
								$textallignments = array("text-left", "text-right");
								$existingProjects = $pageDesign->allParts['Projects']->Projects;
								$cnt = 0;
								foreach ($existingProjects as $keyExPr => $valueExPr) {
									if (!in_array($valueExPr->imagePath,array(".",".."))) 
									{	
										if($valueExPr->imagePath != '' || $valueExPr->ProjectDescription != '')
										{
											if (!is_dir($valueExPr->imagePath))
											{
												echo '<div class="row">
													<a href="'.$valueExPr->ProjectURL.'" target="_blank">
														<DIV class="col-lg-12">
															<IMG style="height: 170px; width: 200px;margin:7px 7px 7px 7px;" class="img-responsive img-border '. $allignments[$cnt % 2] .'" alt="" src="'.$valueExPr->imagePath.'">
															<HR class="visible-xs">
															
															<div style="margin:7px 7px 7px 7px;">
															<H3 class="intro-text '.$textallignments[$cnt % 2] .'">
																<STRONG>'.$valueExPr->ProjectName.'</STRONG>
															</H3>
																<div class="'.$textallignments[$cnt % 2] .'">
																'.$valueExPr->ProjectDescription.'
																</div>
															</div>
														</DIV>
													</a>
												</div>';	
											}
										}
									}
									$cnt = $cnt + 1;
								}							
							?>
							<!------------------------------------------->
						<DIV class="clearfix"></DIV>
					</DIV>
				</DIV>
				<DIV class="row">
					<!----- Edit button for members ---------->
					<?php
                                            if($isedit == TRUE)
                                            {
                                                echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                                                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_members" style="background-color:transparent;border:none">
                                                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
					<!---------------------------------------->
					<DIV class="box">
						<DIV class="col-lg-12">
							<HR>
							<H2 class="intro-text text-center">
								Our
								<STRONG>Team</STRONG>
							</H2>
							<HR>
						</DIV>
							<!------------ Members Display ------------->
							<?php
								if($pageDesign->allParts['Members']->Members !=null) {
									foreach ($pageDesign->allParts['Members']->Members as $memberKey => $memberValue) {
										echo '<DIV class="col-sm-4 text-center">
											<IMG class="img-thumbnail" style="height:250px;" alt="" src="'.$memberValue->imagePath.'">
											<H3>
												'.$memberValue->MemberName.'                         <SMALL>'. $memberValue->MemberDesignation.'</SMALL>
											</H3>
										</DIV>';
									} 
								}
							?>
							<!------------------------------------------->
						<DIV class="clearfix"></DIV>
					</DIV>
				</DIV>
				<DIV class="row">
					<!----- Edit button for company location ---------->
					<?php
                                            if($isedit == TRUE)
                                            {
                                                echo '<div class="col-md-12 col-sm-12" style="position:absolute;background-color:transparent;z-index: 1">
                                                        <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_company_location" style="background-color:transparent;border:none">
                                                            <button class="glyphicon glyphicon-edit" style="fill-opacity:.5;" />
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
					<!--------------------------------------->
					<DIV class="box" id="divMap">
						<DIV class="col-lg-12">
							<HR>
							<H2 class="intro-text text-center">
								Contact
								<STRONG><?php echo $pageDesign->allParts['Header']->CompanyName;?></STRONG>
							</H2>
							<HR>
						</DIV>
						
						<DIV class="col-md-12">
							<DIV class="col-md-3 box" style="position: absolute; background-color: beige; padding:5px 5px 5px 5px;right:0;top: 50px; opacity:0.7;">
								<P>
									Phone:                         <STRONG><?php echo $pageDesign->allParts['CompanyLocation']->CompanyNumber;?></STRONG>
								</P>
								<P>
									Email:                         <STRONG>
										<A href="mailto:name@example.com"><?php echo $pageDesign->allParts['CompanyLocation']->CompanyEmail;?></A>
									</STRONG>
								</P>
								<P>
									Address:                         <STRONG>
										<?php echo $pageDesign->allParts['CompanyLocation']->CompanyAddress;?>
									</STRONG>
								</P>
							</DIV>
							<!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->
							<IFRAME width="100%" height="400" src="https://maps.google.com/maps/embed/v1/place?key=AIzaSyDvp8iqxZqSa_9YrjAcYlP5CvYvwNBomes&amp;q=<?php echo $pageDesign->allParts['CompanyLocation']->CompanyLat .','.$pageDesign->allParts['CompanyLocation']->CompanyLng ?>&amp;center=<?php echo $pageDesign->allParts['CompanyLocation']->CompanyLat .','.$pageDesign->allParts['CompanyLocation']->CompanyLng ?>&amp;zoom=13" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></IFRAME>
						</DIV>
						<DIV class="clearfix"></DIV>
					</DIV>
				</DIV>
				
				<!--------------- Header edit dialog ----------------->
				<div class="modal fade" id="edit_header" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Header</h4>
                                            </div>
                                            <div class="box">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <form action="about.php" method="post">
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
				 <!--------------------------------------------------->
				 
				 <!--------------- About edit dialog ----------------->
				 <div class="modal fade" id="edit_about" role="dialog">
                                        <!-- Modal content-->
					<div class="modal-dialog">
						<div class="well">
							<div>
								<form action="about.php" method="post" enctype="multipart/form-data" id="about_form">
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
				
				<!--------------- Projects edit dialog -------------->
				<div class="modal fade" id="edit_projects" role="dialog">
                                <!-- Modal content-->
					<div class="modal-dialog">
						<div class="well">
							<div>
								<form action="about.php" method="post" enctype="multipart/form-data" id="project_form">
									<div >
										<div class="row">
											<div>
												<h4 class="modal-title">Add Project</h4>
											</div>
										</div>
										<div class="row">
											<div>
												<input type="file" id="projectImageFile" name="projectImageFile" />
											</div>
										</div>
										<div class="row">
											<div>
												Project Name : <input name="projNameFld" id="projNameFld" type="text"/> <br>
												Project URL : <input name="projURLFld" id="projURLFld" type="text"/> <br>
												<input name="projDescFld" id="projDescFld" type="hidden"/>
												Description: <br>
												<textarea id="project_description_editor" class="form-control">
												</textarea>
											</div>
										</div>
										<div class="row">
											<div>
												<input type="submit" id="project_submit" name="project_submit" value="Accept"/>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
                                    </div>  
				<!--------------------------------------------------->
				
				<!--------------- Members edit dialog --------------->
				<div class="modal fade" id="edit_members" role="dialog">
                                <!-- Modal content-->
					<div class="modal-dialog">
						<div class="well">
							<div>
								<form action="about.php" method="post" enctype="multipart/form-data" id="member_form">
									<div >
										<div class="row">
											<div>
												<h4 class="modal-title">Add Member</h4>
											</div>
										</div>
										<div class="row">
											<div>
												<input type="file" id="memberImageFile" name="memberImageFile" />
											</div>
										</div>
										<div class="row">
											<div>
												<span style="font-family:Arial;font-size:13px;font-weight:300;">Member Name :</span>&emsp;<input name="memName" id="memName" type="text"/><br><br>
												<span style="font-family:Arial;font-size:13px;font-weight:300;">Member Desig. :</span>&emsp;<input name="memDesig" id="memDesig" type="text"/><br><br>
											</div>
										</div>
										<div class="row">
											<div>
												<input type="submit" id="member_submit" name="member_submit" value="Accept"/>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
                </div>  
				<!--------------------------------------------------->
				
				<!----------- Company Location edit dialog ---------->
				<div class="modal fade" id="edit_company_location" role="dialog" style="height:570px">				
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
                                <div id="map-content-company" style="height: 410px; width: 565px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<!--------------------------------------------------->
			</DIV>
			<FOOTER>
                <DIV class="container">
                    <DIV class="row">
                        <DIV class="col-lg-12 text-center">
                            <P>Copyright © Your Website 2014</P>
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
                CKEDITOR.replace('about_description_editor');
                CKEDITOR.replace('project_description_editor');				
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.20&sensor=true&key=AIzaSyCYKHARqf-KwLQ5pJG6xVHHa_E2dt9wNJA&libraries=places&callback=initMap" type="text/javascript">

            </script>
</BODY>
</HTML>
