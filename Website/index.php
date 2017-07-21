<?php

    include '/Classes/DataAccess.php';
    include '/Classes/Entities/EntityBase.php';
    include '/Classes/Entities/User.php';
    include '/Classes/Entities/Client.php';
    include '/Classes/Entities/Service.php';
    include '/Classes/Entities/ServiceType.php';
    include '/Classes/Entities/Cart.php';
    include '/Classes/Entities/CartItem.php';
    include '/Classes/Entities/BillItem.php';
    include '/Classes/PageDesignData.php';
    include '/Classes/FunctionClasses/CartFunctionsClass.php';

    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
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
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
    </head>
    <body>
        <?php
            
            // put your code here
            //echo "<script>alert('".$_SESSION["user"]."');</script>";
            
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


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">
            <div class="row" style="height: 30px"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1 style="color: crimson">Micro Market CMS</h1>
                        <h3 style="color: crimson">Design your own micro-site in the blink of an eye</h3>
                        <hr class="intro-divider">
                        <div type="button" class="btn btn-info btn-lg" style="right: 50%;background-color: transparent; border-color: transparent; padding: 4px">
                            <a href="microsite/selection.php">
                                <div class="row" style="margin: 0px; padding: 0px">
                                    <div class="thumbnail show text-center"  style="margin: 0px; padding: 0px; background-color: transparent; border-color: transparent">
                                            <img  src="Images/jinnilamp.png" style="height: 100px; width: 150px; background-color: transparent; border-color: transparent"/>
                                    </div>                                
                                </div>
                                <div class="row" style="padding: 0px">
                                    <h4 style="color: black; margin: 0px">Build Webste</h4>
                                </div>
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <hr>
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Services</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Free Microsite</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Domain Registration</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Digital Marketing</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
                <div class="col-md-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Website Design</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
                </div>
            </div>
        </div>
    </section>

    <hr>
    <!-- Page Content -->

   
    <a  name="contact"></a>
    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-10">
                    <h2 style="color: crimson">Micro Market CMS</h2>
                
                    <ul class="list-inline">
                        <li>
                            <a href="microsite/selection.php"><i class="fa fa-beer" > <span class="network-name" style="color: crimson; font-weight: bolder">Microsite</span> </i></a>
                        </li>
                        <li>
                            <a href="domain/selection.php"><i class="fa fa-binoculars" > <span class="network-name" style="color: crimson; font-weight: bolder">Domain</span> </i></a>
                        </li>
                        <li>
                            <a href="digimart/selection.php"><i class="fa fa-facebook-square" > <span class="network-name" style="color: crimson; font-weight: bolder">Digital Marketing</span> </i></a>
                        </li>
                        <li>
                            <a href="webdesign/selection.php"><i class="fa fa-android" > <span class="network-name" style="color: crimson; font-weight: bolder">Website Design</span> </i></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->
    <hr>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <ul class="list-inline">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#about">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy; Your Company 2014. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>