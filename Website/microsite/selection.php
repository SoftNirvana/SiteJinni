<?php
    include '../Classes/DataAccess.php';
    include '../Classes/Entities/EntityBase.php';
    include '../Classes/Entities/User.php';
    include '../Classes/Entities/Client.php';
    include '../Classes/Entities/Service.php';
    include '../Classes/Entities/ServiceType.php';
    include '../Classes/Entities/Cart.php';
    include '../Classes/Entities/CartItem.php';
    include '../Classes/Entities/BillItem.php';
    include '../Classes/PageDesignData.php';
    include '../Classes/FunctionClasses/CartFunctionsClass.php';
    
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
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["logout"])) {
            if(isset($_SESSION["user"])) {
                unset($_SESSION["user"]);
            }
            if(isset($_SESSION["client"])) {
                unset($_SESSION["client"]);
            }
            if(isset($_SESSION["service"])) {
                unset($_SESSION["service"]);
            }
            if(isset($_SESSION["installpage"])) {
                unset($_SESSION["installpage"]);
            }
            if(isset($_SESSION["purpose"])) {
                unset($_SESSION["purpose"]);
            }
            if(isset($_SESSION["cart"])) {
                unset($_SESSION["cart"]);
            }
        }

        if(isset($_POST["selservid"])) {
            $servid = $_POST["selservid"];
            $service = Service::GetServicebyID($servid);
            $_SESSION["service"] = $service;
        }               
    }
    
    $target_dir = "../docroots/templates";
    $templatearray = array();
    $cnt = 0;
    $existinIndustries = scandir($target_dir);

    foreach ($existinIndustries as $key => $value) {
        $industryarray = array();
        if (!in_array($value,array(".","..",".DS_Store"))) 
        {	
            $subindustryarray = array();
            if (is_dir("$target_dir/$value"))
            {
                $existingSubIndustries = scandir("$target_dir/$value");
                foreach ($existingSubIndustries as $key1=> $value1) {
                    $stylearray = array();
                    if (!in_array($value1,array(".","..",".DS_Store"))) 
                    {	
                        $existingStyles = scandir("$target_dir/$value/$value1");
                        foreach ($existingStyles as $key2=> $value2) {
                            if (!in_array($value2,array(".","..",".DS_Store"))) 
                            {	
                                if (is_dir("$target_dir/$value/$value1/$value2"))
                                {
                                    array_push($stylearray,[$value2,"$target_dir/$value/$value1/$value2"]);
                                }

                            }
                        }
                        array_push($subindustryarray, [$value1, $stylearray]);
                    }
                }
                array_push($industryarray, [$value,$subindustryarray]);
            }
        }
        array_push($templatearray, $industryarray);
    }            
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <META charset="utf-8">
        <META http-equiv="X-UA-Compatible" content="IE=edge">
        <META name="viewport" content="width=device-width, initial-scale=1">
        <META name="description" content="">
        <META name="author" content="">
        <TITLE>            
        </TITLE>

        <META name="GENERATOR" content="WDL-Website-Builder">

        <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="../vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/landing-page.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
	<script src="https://www.hanewin.net/encrypt/aes/aes-enc.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        <style type="text/css">
            div.buttontype {
                display:inline-block;
                -webkit-appearance:button;
                padding:3px 8px 3px 8px;
                font-size:13px;
                position:relative;
                cursor:context-menu;
            }
        </style>
        <script type="text/javascript">
            function makeid()
            {
                var text = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                for( var i=0; i < 5; i++ )
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                return text;
            }
            function fillPagePreview(page) {       
                $.ajax({
                    type: "POST",
                    url: "../Classes/PostSingle/pageinstallresponse.php",
                    cache: false,
                    data: {gendemophrase: page},
                    success: function (response, textStatus, jqXHR) {
                        alert(page + "?" + response);
                        var key = makeid();
                        //var div = document.getElementById("previewFrame");
                        
                        //var encryptedAES = CryptoJS.AES.encrypt(response, key);

                        window.open(page + "?" + response, "_blank");
                    }
                });
            }
            
            function closeModal()
            {
                $("#show_preview").hide();
                $(".modal-backdrop").hide();
                $("#show_preview").click();
            }
        </script>
            
    </head>
    <body>
        
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="container topnav" style="margin-top: 0px">
                <!-- Brand and toggle get grouped for better mobile display -->
                <?php 
                    include("../htmlassets/sitejinniNavBar.php");
                ?>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        
        <!-- Header -->
        <a name="about"></a>
        <header class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center" style="-webkit-filter: drop-shadow(1px 2px 2px rgba(0,0,0,0.7))">
                        <h1 style="color: darkorange; font-weight: bolder">Microsite Service</h1>
                        <h3 style="color: darkorange; font-weight: bolder">Do it yourself marketing microsite kit</h3>
                    </div>
                </div>

            </div>
        <!-- /.container -->
        </header>

        
        <!-- /.intro-header -->
        <div class="box" style="padding: 30px;">
            <div class="row">
                <h2>Select your template</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                        foreach ($templatearray as $key => $value) {
                            if($value != null)
                            {
                                echo '<div class="row">';
                                echo '<div class="col-md-12">';                                        
                                if(count($value)>0)
                                {
                                    foreach ($value as $key1 => $industry) {
                                        if($industry[1] != null)
                                        {
                                            echo '<div class="row">';
                                            echo '<div class="panel panel-default col-md-12">';                                            
                                            echo '<div class="panel-heading row"><a data-toggle="collapse" href="#collapsible'.str_replace(" ", "-", $industry[0]).'"><h3>' . $industry[0] . '</h3></a></div>';
                                            echo '<div id="collapsible'.str_replace(" ", "-", $industry[0]).'" class="panel-body panel-collapse collapse">';
                                            if(count($industry[1])>0)
                                            {
                                                foreach ($industry[1] as $key2 => $subindustry) {
                                                    if($subindustry[1] != null)
                                                    {
                                                        
                                                        echo '<div class="row">';
                                                        echo '<div class="panel panel-default col-md-12">'; 
                                                        echo '<div class="panel-heading row" style="background-color: #cccccc;"><h4>' . $subindustry[0] . '</h4></div>';
                                                        echo '<div class="panel-body">';
                                                        echo '<ul class="list-inline">';
                                                        if(count($subindustry[1])>0)
                                                        {
                                                            foreach ($subindustry[1] as $key2 => $style) {
                                                                echo '<li >';
                                                                echo    '<div class="box">
                                                                                <div class="row">                                                                            
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                        <div class="button" style="margin:20px;">
                                                                                            <div class="row">
                                                                                                <div class="thumbnail show" style="margin:0px">
                                                                                                    <img style="width: 250px;height: 200px;" src="'. $style[1] . '/' . $style[0] . '.png' .'"/>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row" style="text-align:center">
                                                                                                <h5 style=" vertical-align: top; margin:0px">'.$style[0].'</h5>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                        <div type="button" class="btn btn-info btn-lg" style="background-color:transparent;border:none;color: darkblue; width: 100%">
                                                                                            <button type="button" id="showpreview" onclick="fillPagePreview(\''. $style[1] . '/index.php\')" style="width:100%; text-align: center" >Preview</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>';
                                                                echo '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                        echo '</div>';
                                                        echo '</div>';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }
                                }
                                echo '</div>';
                                echo '</div>';
                            }

                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="modal fade modal-dialog" id="show_preview" role="modal" 
            style="width: 80%; height: 70%; background-color: whitesmoke; border-radius: 7px;position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);background-color: activeborder;">            
            <div class="row" style="height: 5%; width: 100%; margin: 0px; padding: 0px">
                <div class="col-lg-12" style="border: 1px darkgrey solid; margin: 0px; padding: 0px; border-radius: 7px;width: 100%; height: 100%;background-color: aliceblue; text-align: right;">
                    <button class="button glyphicon glyphicon-collapse-down" style="position: relative; margin: 0px; background: transparent; border: none;right: 0px" type="button" onclick="closeModal()"/>
                </div>
            </div>
            <div class="row" style="height: 95%; width: 100%; margin: 0px; padding: 0px">
                <iframe id="previewFrame" style="height: 100%; width: 100%" src="#">
                </iframe>
            </div>
        </div>

        
        <!--
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div type="button" class="btn btn-info btn-lg" style="background-color:transparent;border:none;color: darkblue; width: 100%">
                <button type="button" id="installtemplate" onclick="installPage(\''. $style[1] . '/index.php\')" style="width:100%; text-align: center" >Install</button>
            </div>
        </div>
        -->

        <!-- jQuery -->
    <!--<script src="../vendor/twbs/bootstrap/dist/js/jquery.js"></script>-->

    <!-- Bootstrap Core JavaScript -->
    <!--<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>-->
    </body>
     
</html>
