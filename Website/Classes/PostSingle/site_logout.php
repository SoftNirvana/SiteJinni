<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
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
        <meta charset="UTF-8">
        <title>Logout</title>
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/landing-page.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/jquery.js"></script>
    </head>
    <body>
        <div class="row" style="height: 15px"></div>
        <div class="row">
            <div class="col-lg-3"></div>
                <div class="col-lg-7">
                       <div class="well well-sm">
                           <div class="row">
                               <div class="col-lg-1"></div>
                               <div class="col-lg-10">
                                   <div style="left: 10px"> SiteJinni logo</div>
                               </div>
                               <div class="col-lg-1">
                                   <div style="left: 10px"><a href="http://localhost:8080"><span class="glyphicon glyphicon-home"></span> Home</a></div>
                               </div>
                           </div>
                           <hr>
                           <div class="row">
                               <div class="col-lg-3"></div>
                               <div class="col-lg-9">
                               <p> You have successfully logged out.
                                <bold>Thank You for using SiteJinni.</bold> </p>  
                               </div>
                           </div>
                           <div class="row" style="height: 150px">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6"></div>
                           </div>
                       </div>
                </div>
        </div>
    </body>
</html>
