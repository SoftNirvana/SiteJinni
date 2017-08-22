<?php

    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';
    include './Classes/Entities/Service.php';
    include './Classes/Entities/ServiceType.php';
    include './Classes/Entities/Cart.php';
    include './Classes/Entities/CartItem.php';
    include './Classes/Entities/BillItem.php';
    include './Classes/PageDesignData.php';
    include './Classes/FunctionClasses/CartFunctionsClass.php';

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
        <script src="js/sitejinnijs.js"></script>
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
        <div class="container topnav" style="margin-top: 0px">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php 
                include("htmlassets/sitejinniNavBar.php");
            ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header" style="height: 100%">
        <div class="container">            
            <div class="row">
                <div class="col-lg-12" style="top: 0;">
                    <div class="intro-message" style="padding: 0">
                        <div style='opacity: 1; position: relative' class="col-lg-11 col-lg-offset-1">
                            <img src='Images/site_logo_B.png' style="height: 80%; width: 80%; left: 10%"/>
                        </div>
                        <div class="col-lg-12 text-center">
                            <hr class="intro-divider">
                        </div>
                        <div class="col-lg-12 text-center">
                            <form action="/Classes/PostSingle/searchresults.php" method="POST" name="searchparam" >
                                <div class="row input-group" id="adv-search"   style="box-shadow: 0 5px 5px 0 rgba(0,0,0,0.16),0 0 0 2px rgba(0,0,0,0.08);">
                                    <input type="text" name="searchparams" class="form-control" placeholder="Search SiteJinni websites"/>
                                    <div class="input-group-btn">
                                        <div class="btn-group" role="group">
                                            <button type="submit" name="searchsubmit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12 text-center">
                            <hr class="intro-divider">
                        </div>
                        <div class="col-lg-12 text-center" style="margin-top: 10%">
                            <div type="button" class="btn btn-info btn-lg" style="right: 50%;background-color: transparent; border-color: transparent; padding: 4px">
                                <p>
                                    <a href="microsite/selection.php">
                                        <div class="row" style="margin: 0px; padding: 0px">
                                            <div class="thumbnail show text-center"  style="margin: 0px; padding: 0px; background-color: transparent; border-color: transparent">
                                                <img  src="Images/jinnilamp.png" style="height: 100px; width: 150px; background-color: transparent; border-color: transparent"/>
                                            </div>                                
                                        </div>
                                        <div class="row" style="padding: 0px">
                                            <h4 style="color: orange; margin: 0px">Build your Website</h4>
                                        </div>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
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
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-1', 'servicedetails');">
                    <span style="height: 180px; width: 180px">
                        <img src="Images/site-jini-icon-1.jpg" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Free Microsite</h4>
                    <p class="text-muted">Setup your free website</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-2', 'servicedetails');">
                    <span style="height: 180px; width: 180px">
                        <img src="Images/site-jini-icon-2.jpg" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Domain</h4>
                    <p class="text-muted">Get a customized domain</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-3', 'servicedetails');">
                    <span  style="height: 180px; width: 180px">
                        <img src="Images/site-jini-icon-3.jpg" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Digimart</h4>
                    <p class="text-muted">Increase the share of visitors to your site</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-4', 'servicedetails');">
                    <span style="height: 180px; width: 180px">
                        <img src="Images/site-jini-icon-3.jpg" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Website Design</h4>
                    <p class="text-muted">Get a customized website designed with functionalities and all</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servicedetails">
        <div class="row setup-content step activeStepInfo" id="step-1">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <a href="microsite/selection.php" style="color: darkgray">
                        <h1>Free Microsite</h1>
                        <hr class="col-lg-offset-4 col-lg-4">
                        <br>
                        <div class="col-lg-offset-4 col-lg-1">
                            <img src="Images/site-jini-icon-1.jpg" style="height: 100%; width: 100%"/>
                        </div>
                        <div class="text-justify col-lg-3">
                            <p>Get a professional web-site just in 5 minutes. Don’t know how to? </p>
                            <p>No worries, the Jinni will guide you.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <a href="domain/selection.php" style="color: darkgray">
                        <h1>Domain Service</h1>
                        <hr class="col-lg-offset-4 col-lg-4">
                        <br>
                        <div class="col-lg-offset-4 col-lg-1">
                            <img src="Images/site-jini-icon-2.jpg" style="height: 100%; width: 100%"/>
                        </div>
                        <div class="text-justify col-lg-3">
                            <p>Buy a web-site name for yourself and unlock 3 premium designs.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-3">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <a href="digimart/selection.php" style="color: darkgray">
                        <h1>Digital Marketing</h1>
                        <hr class="col-lg-offset-4 col-lg-4">
                        <br>
                        <div class="col-lg-offset-4 col-lg-1">
                            <img src="Images/site-jini-icon-3.jpg" style="height: 100%; width: 100%"/>
                        </div>
                        <div class="text-justify col-lg-3">
                            <p>Go global with your web-site. Make it visible on search engines, social network, and other web-sites. 
                               Improve your search engine ranking with our Digimart service.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-4">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">
                    <a href="microsite/selection.php" style="color: darkgray">
                        <h1>Website Design</h1>
                        <hr class="col-lg-offset-4 col-lg-4">
                        <br>
                        <div class="col-lg-offset-4 col-lg-1">
                            <img src="Images/site-jini-icon-4.jpg" style="height: 100%; width: 100%"/>
                        </div>
                        <div class="text-justify col-lg-3">
                            <p>Greedy for more?</p>
                            <p>Get a customized professional web-site designed by our experts.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>        
    </section>
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
