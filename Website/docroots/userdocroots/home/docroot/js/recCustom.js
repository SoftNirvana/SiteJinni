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
//-----------------------------------------------
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

//---------------------------------------------------------------
//Install function
function installPage() {      
    var page = document.baseURI;
    var arr = page.split("?");
    page = arr[0];
    $.ajax({
         type: "POST",
         url: "/Classes/PostSingle/pageinstallresponse.php",
         cache: false,
         data: {installpage: page},
         success: function (response, textStatus, jqXHR) {
             if(response != "NIL")
                 window.open(response,"_self");
         }
     });
 }
//---------------------------------------------------------------

