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
        <link rel="shortcut icon" href="Images/favicon.ico" />
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
        <script type="text/javascript">
            var section = 1;
            
            function scrollToAnchor(variable){
                //var aTag = $("a[name='"+ variable +"']");
                //$('html,body').animate({scrollTop: aTag.offset().top},'slow');
                window.location.href= variable;
            }
            $(function(){
                var lastScroll = 0;
                var numscroll = 0;
                $(window).scroll(function() {
                    var st = $(this).scrollTop();
                    //Determines up-or-down scrolling
                    if (st > lastScroll ){
                       //Going down
                        section = section + 1;
                        scrollToAnchor('#services');
                        lastScroll = st;
                    } else if(st < lastScroll ){
                       //Going up
                        section = section - 1;
                        scrollToAnchor('#home');
                        lastScroll = st;
                    }
                    //Updates scroll position
                    lastScroll = st;
                });
            });
        </script>
    </head>
    <body style="background-color: #EFEFEF">
        <section id="home"></section>
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
    <div class="intro-header" style="height: 100%;">
        <!--
        <div class="col-lg-12 col-md-12 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" style="position: absolute; padding: 0">
            <img src="Images/jinni-icon.png" class="col-lg-offset-6"
                 style="width: 30%; height: 60%;
                        -webkit-filter: drop-shadow(1px 2px 2px rgba(0,0,0,0.4)); 
                        opacity: .5; right: 0;
                        -webkit-transform: rotate(15deg);
                        -moz-transform: rotate(15deg);
                        -o-transform: rotate(15deg);
                        -ms-transform: rotate(15deg);
                        transform: rotate(15deg);">
        </div>
        -->
        <div class="container">            
            <div class="row">
                <div class='col-lg-2 col-xs-1'></div>
                <div class="col-lg-8  col-md-6 col-sm-6  col-xs-10">
                    <div class="row">
                        <div class="intro-message text-center" style="padding-top: 20%"  >
                            <div style='opacity: 1; position: relative; height: 80%; width: 80%;' class="col-lg-6 col-lg-offset-1 col-xs-12">
                                <img src='Images/site_logo_B_Only Text.png' style="height: 80%; width: 100%; opacity: 1;-webkit-filter: drop-shadow(3px 4px 4px rgba(0,0,0,0.5)); margin-left: 10px"/>
                            </div>
                            <!--
                            <div class="col-lg-6 col-lg-offset-3 col-xs-12 text-center">
                                <hr class="intro-divider">
                            </div>
                            -->
                            <div class="col-lg-8 col-lg-offset-2 col-xs-12 text-center" style="padding-top: 4%;">
                                <form action="/Classes/PostSingle/searchresults.php" method="POST" name="searchparam" >
                                    <div class="row input-group" id="adv-search"   style=" -webkit-filter: drop-shadow(3px 4px 4px rgba(0,0,0,0.25)); width: 100%; margin: 0">
                                        <input type="text" name="searchparams" class="form-control" placeholder="Search SiteJinni websites"/>
                                        <div class="input-group-btn">
                                            <div class="btn-group" role="group">
                                                <button type="submit" name="searchsubmit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--
                            <div class="col-lg-6 col-lg-offset-3 col-xs-12 text-center">
                                <hr class="intro-divider">
                            </div>
                            -->
                            <div class="col-lg-6 col-lg-offset-3 text-center" style="margin-top: 5%">
                                <div type="button" class="btn btn-info btn-lg" style="right: 50%;background-color: transparent; border-color: transparent; padding: 4px">
                                    <p>
                                        <a href="microsite/selection.php">
                                            <div class="row" style="margin: 0px; padding: 0px">
                                                <div class="thumbnail show text-center"  style="margin: 0px; padding: 0px; background-color: transparent; border-color: transparent">
                                                    <img  src="Images/jinnilamp.png" style="height: 50px; width: 75px; 
                                                                                            background-color: transparent; 
                                                                                            border-color: transparent;
                                                                                            -webkit-filter: drop-shadow(3px 4px 4px rgba(0,0,0,0.5));"/>
                                                </div>                                
                                            </div>
                                            <div class="row" style="padding: 0px">
                                                <h5 style="color: orange; margin: 0px; -webkit-filter: drop-shadow(3px 4px 4px rgba(0,0,0,0.25));">Build your Website</h5>
                                            </div>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                 <div class='col-lg-2 col-xs-1'></div>
            </div>

        </div>
    </div>
    <hr class="intro-divider">
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
                        <img src="Images/a.png" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Free Microsite</h4>
                    <p class="text-muted">Setup your free website</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-2', 'servicedetails');">
                    <span style="height: 180px; width: 180px">
                        <img src="Images/b.png" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Domain</h4>
                    <p class="text-muted">Get a customized domain</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-3', 'servicedetails');">
                    <span  style="height: 180px; width: 180px">
                        <img src="Images/c.png" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Digimart</h4>
                    <p class="text-muted">Increase the share of visitors to your site</p>
                </div>
                <div class="col-md-3" onclick="javascript: resetActive(event, 0, 'step-4', 'servicedetails');">
                    <span style="height: 180px; width: 180px">
                        <img src="Images/d.png" style="height: 180px; width: 180px"/>
                    </span>
                    <h4 class="service-heading">Website Design</h4>
                    <p class="text-muted">Get a customized website designed with functionalities and all</p>
                </div>
            </div>
        </div>
    </section>
    <section id="servicedetails">
        <div class="row setup-content step activeStepInfo" id="step-1">
            <div class="col-xs-12 col-lg-6 col-lg-offset-3" style="background-image: url('Images/footer_a.png'); background-repeat: no-repeat; background-size: 100%; padding-top: 30px; min-height: 350px">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 " style="background-color: transparent">
                        <a href="microsite/selection.php" style="color: darkorange">
                            <h1>Free Microsite</h1>
                            <hr class="col-lg-12">
                            <br>
                            <!--
                            <div class="col-lg-offset-4 col-lg-1">
                                <img src="Images/site-jini-icon-1.jpg" style="height: 100%; width: 100%"/>
                            </div>
                            -->
                            <div class="text-justify col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                                <p>Get a professional web-site just in 5 minutes. Don’t know how to? </p>
                                <p>No worries, the Jinni will guide you.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-2">
            <div class="col-xs-12 col-lg-6 col-lg-offset-3" style="background-image: url('Images/footer_a.png'); background-repeat: no-repeat; background-size: 100%; padding-top: 30px; min-height: 350px">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 " style="background-color: transparent">
                        <a href="microsite/selection.php" style="color: darkorange">
                            <h1>Domain Service</h1>
                            <hr class="col-lg-12">
                            <br>
                            <!--
                            <div class="col-lg-offset-4 col-lg-1">
                                <img src="Images/site-jini-icon-1.jpg" style="height: 100%; width: 100%"/>
                            </div>
                            -->
                            <div class="text-justify col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                                <p>Buy a web-site name for yourself and unlock 3 premium designs.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-3">
            <div class="col-xs-12 col-lg-6 col-lg-offset-3" style="background-image: url('Images/footer_a.png'); background-repeat: no-repeat; background-size: 100%; padding-top: 30px; min-height: 350px">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 " style="background-color: transparent">
                        <a href="microsite/selection.php" style="color: darkorange">
                            <h1>Digital Marketing</h1>
                            <hr class="col-lg-12">
                            <br>
                            <!--
                            <div class="col-lg-offset-4 col-lg-1">
                                <img src="Images/site-jini-icon-1.jpg" style="height: 100%; width: 100%"/>
                            </div>
                            -->
                            <div class="text-justify col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                                <p>Go global with your web-site. Make it visible on search engines, social network, and other web-sites. 
                               Improve your search engine ranking with our Digimart service.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>    
            
        </div>
        <div class="row setup-content step hiddenStepInfo" id="step-4">
            <div class="col-xs-12 col-lg-6 col-lg-offset-3" style="background-image: url('Images/footer_a.png'); background-repeat: no-repeat; background-size: 100%; padding-top: 30px; min-height: 350px">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6 " style="background-color: transparent">
                        <a href="microsite/selection.php" style="color: darkorange">
                            <h1>Website Design</h1>
                            <hr class="col-lg-12">
                            <br>
                            <!--
                            <div class="col-lg-offset-4 col-lg-1">
                                <img src="Images/site-jini-icon-1.jpg" style="height: 100%; width: 100%"/>
                            </div>
                            -->
                            <div class="text-justify col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                                <p>Greedy for more?</p>
                                <p>Get a customized professional web-site designed by our experts.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>                
        </div>        
    </section>
    <hr  class="intro-divider">
    <!-- Footer -->
    <footer style="background-color: #EFEFEF">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <ul class="list-inline">
                        <li>
                            <a href="#home">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
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
