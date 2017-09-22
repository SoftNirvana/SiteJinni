/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
 
 