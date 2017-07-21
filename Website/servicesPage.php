<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';        
    
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
        
        if(isset($_POST["clid"])) {
            $clientid = $_POST["clid"];
            $client = Client::GetClientbyID($clientid);
            $_SESSION["client"] = $client;
        }
    }
?>
<!DOCTYPE html>
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
        
        <!--<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
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
        <!-- Navigation -->
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

        
        <div class="container" style="height: 100%; width: 100%">
            <div class="well-lg" style="height: 100%; width: 100%">
                <div class="row" style="height: 5%; width: 100%"> 
                </div>
                <div class="row" style="height: 95%; width: 100%"> 
                    <div class="col-lg-2">
                        <a href="microsite/selectionwoheader.php" target="templatelistdiv">
                            Microsite Service
                        </a>
                    </div>
                    <div id="templatelistdiv" class="col-lg-8" style="height: 100%;">
                        <header>
                            <div class="banner">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h1 style="color: crimson; font-weight: bolder">Microsite Service</h1>
                                            <h3 style="color: crimson; font-weight: bolder">Do it yourself marketing microsite kit</h3>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <!-- /.container -->
                        </header>
                        <div class="row" style="height: 60%; overflow: scroll;">
                            <?php
                                include('./microsite/selectionwoheader.php');                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jQuery -->
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
    </body>
</html>
