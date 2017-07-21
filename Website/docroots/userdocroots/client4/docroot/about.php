<?php
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    $locpath = str_replace(stristr($path, '/docroots'), '', $path) ;
    
    include $locpath . '/Classes/DataAccess.php';
    include $locpath . '/Classes/Entities/EntityBase.php';
    include $locpath . '/Classes/Entities/User.php';
    include $locpath . '/Classes/Entities/Client.php';      
    include $locpath . '/Classes/Entities/Service.php';
    include $locpath . '/Classes/PageDesignData.php';
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();

    $clientsforuser = NULL;   
    $client = NULL;  
    $service = NULL;
    if(isset($_SESSION["user"]) && $_SESSION["user"] != NULL)
    {
        $clientsforuser = Client::GetClientbyUser($_SESSION["user"]);
    }
    if(isset($_SESSION["client"]) && $_SESSION["client"] != NULL)
    {
        $client = $_SESSION["client"];
    }
    
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
    }
    $isedit = TRUE;
    if($val == "DEMO_PAGE_PREV_1" || !isset($_SESSION["user"]) || !isset($_SESSION["client"]))
        $isedit = FALSE;
     
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

</HEAD>
<BODY>
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
		"Projects"=>$projects);
		//-----------------------------------------------------------------
		
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
			//----------------------------------------------------------------------------------------------
						
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
			//----------------------------------------------------------------------------
			
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
    <DIV>
	
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
