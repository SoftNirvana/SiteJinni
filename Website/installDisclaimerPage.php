<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';      
    include './Classes/Entities/Service.php';
    include './Classes/Entities/Cart.php';
    include './Classes/Entities/CartItem.php';
    include './Classes/Entities/BillItem.php';
    include './Classes/Entities/ServiceType.php';
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    
    $clientsforuser = NULL;   
    $client = NULL;  
    $service = NULL;
    if(!isset($_SESSION["user"])) {
        
        try {
            $url = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";            
            $_SESSION["destpage"] = $url;
            header("Location: /loginPage.php");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        
    }
    if(isset($_SESSION["user"]) && $_SESSION["user"] != NULL) {
        $clientsforuser = Client::GetClientbyUser($_SESSION["user"]);
    }
    
    if(isset($_SESSION["client"]) && $_SESSION["client"] != NULL) {
        $client = $_SESSION["client"];
    }
    
    if(isset($_SESSION["service"]) && $_SESSION["service"] != NULL) {
        $service = $_SESSION["service"];
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
                        include("./htmlassets/sitejinniNavBar.php");
                    ?>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
        </nav>
        
        <div class="container">
            <div class="row" style="height: 80px">

            </div>
            <div class="row" >
                <div class="well col-lg-12">
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-1 text-center">
                            <header>
                                <h2>Your Sitejinni Website is ready.</h2>
                            </header>                        
                        </div>
                        <div class="col-lg-10 col-lg-offset-1 text-center">
                            <div class="row">
                                <h3>Sitejinni is ready to complete the procedures and create the domain for you. <br>
                                    Please checkout additional services from below</h3><br>
                            </div>
                            <div class="row text-justify">
                                <h5>Please read and accept the terms and conditions below to continue</h5>
                                <span style="font-size: 10px">
                                    <p >                            
                                        <ul>
                                            <li>
                                                The website will be online for a lock-in period of 3 days while the contents will 
                                                be put to compliance scrutiny for points like - Plagiarism, nudity etc. 
                                                (please read terms and conditions page for a full list). You will be notified through mail by tomorrow. If the contents are not
                                                changed to follow the requirements by the end of the lock-in period, the website will be taken down.
                                            </li>
                                            <li>
                                                In case you have allowed advertisements, 20% of the Sitejinni's revenue from the ad 
                                                placed on your website will be shared with you for as long as the website is active.
                                            </li>
                                            <li>
                                                You can make changes later when you login as site admin. The compliance 
                                                terms will be applicable for all changes made to the website.
                                            </li>
                                            <li>
                                                You can change the template easily whenever you like. If you select a paid
                                                template appropriate charges will be applicable. The starting date of the 
                                                charges will be when you install the template
                                            </li>
                                        </ul>
                                    </p>
                                </span>
                            </div>
                        </div>                                                
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 text-center">
                            <form id='createdomainstart' name='createdomainstart' method="POST" action="Classes/PostSingle/cpanel_subdomains.php">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="submit" name='acceptsubdomain' value="Accept"/>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="submit" name='rejectsubdomain' value="Reject"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
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
    </body>
</html>
