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
                window.location.reload();
            }
        });
    }
    
    function gotochangetemplate() {
        window.location.href = "/microsite/selection.php";
    }

    function resetActive(event, percent, step, jumpto) {
        $(".progress-bar").css("width", percent + "%").attr("aria-valuenow", percent);
        $(".progress-completed").text(percent + "%");

        $("div").each(function () {
            if ($(this).hasClass("activestep")) {
                $(this).removeClass("activestep");
            }
        });

        if (event.target.className == "col-md-2") {
            $(event.target).addClass("activestep");
        }
        else {
            $(event.target.parentNode).addClass("activestep");
        }

        hideSteps();
        showCurrentStepInfo(step);
        window.location.href = "#" + jumpto;
    }

    function hideSteps() {
        $("div").each(function () {
            if ($(this).hasClass("activeStepInfo")) {
                $(this).removeClass("activeStepInfo");
                $(this).addClass("hiddenStepInfo");
            }
        });
    }

    function showCurrentStepInfo(step) {        
        var id = "#" + step;
        $(id).addClass("activeStepInfo");
    }
    
    function checkoutfinal(){
        $.ajax({
            type: "POST",
            url: "/Classes/PostSingle/pageinstallresponse.php",
            cache: false,
            data: {cartchkoutfinal: true},
            success: function (response, textStatus, jqXHR) {                
                alert(response);
                window.location.href = response;
            }
        });
    }
    function goToLogin() {
     window.location = "http://localhost:8080/loginPage.php?u=" + document.URL;
    }