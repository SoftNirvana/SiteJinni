<?php

    require 'vendor/autoload.php';

    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';   
    include './Classes/FunctionClasses/FunctionsClass.php';

    use GuzzleHttp\Client as GuzzleClient;
    
    
    
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    
    if(!isset($_SESSION["user"])) {
        
        try {
            $url = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";            
            $_SESSION["destpage"] = $url;
            header("Location: /loginPage.php");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        
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
        <title></title>
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/landing-page.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    </head>
    <body>
           <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php 
                include("/htmlassets/sitejinniNavBar.php");
            ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
        <div class="container">
            <div class="row" style="height: 80px">

            </div>
            <div class="row" >
            <div class="row" style="margin: 10px">
                <div class="box col-lg-12" style="border: 1px solid lightgray; box-shadow:-1px -1px darkgray;">
                    <div class="row" style="background-color: gold;">
                        <h5 style="margin: 2px 5px 5px 5px">Get a domain of your choice</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <span style="font-weight: normal; font-size: 12px">Powered by GoDaddy</span>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center box">
                                <i style="font-weight: normal; font-size: 12px">Rs. 128.00 / mo</i><br>
                                <i style="font-weight: normal; font-size: 12px">Save upto Rs. 71.00 /mo</i>
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <button type="button" class="fa fa-2x fa-shopping-cart" style="margin: 4px"/>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin: 10px">
                <div class="box col-lg-12" style="border: 1px solid lightgray; box-shadow:-1px -1px darkgray;">
                    <div class="row" style="background-color: gold;">
                        <h5 style="margin: 2px 5px 5px 5px">Optimize search engine visibility</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fa fa-2x fa-google" style="margin: 4px"></div>
                            <div class="fa fa-2x fa-yahoo" style="margin: 4px"></div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center box">
                                <i style="font-weight: normal; font-size: 12px">Rs. 128.00 / mo</i><br>
                                <i style="font-weight: normal; font-size: 12px">Save upto Rs. 71.00 /mo</i>
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <button type="button" class="fa fa-2x fa-shopping-cart" style="margin: 4px"/>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row" style="margin: 10px">
                <div class="box col-lg-12" style="border: 1px solid lightgray; box-shadow:-1px -1px darkgray;">
                    <div class="row" style="background-color: gold;">
                        <h5 style="margin: 2px 5px 5px 5px">Get a profdessional and functional website designed</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <span style="font-weight: normal; font-size: 12px">Website Design, Development and publishing.<br> Add functionalities, database, e-commerce ...</span>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center box">
                                <i style="font-weight: normal; font-size: 12px">Price to be decided on<br>the basis of requirements</i>
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <button type="button" class="fa fa-2x fa-list" style="margin: 4px"/>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </body>
</html>
