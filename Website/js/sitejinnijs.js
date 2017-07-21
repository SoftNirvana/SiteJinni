/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function addCartItem(servtype, div){
    $.ajax({
            type: "POST",
            url: "/Classes/PostSingle/CartAjaxPost.php",
            cache: false,
            data: {cartadd: servtype},
            success: function (response, textStatus, jqXHR) {                
                $("#"+div).load(" #" + div);
            }
        });
}