<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';
    include './Classes/Entities/Service.php';
    
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    /*
    if(!isset($_SESSION["user"])) {
        
        try {
            $url = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";            
            $_SESSION["destpage"] = $url;
            header("Location: /loginPage.php");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        
    }*/
    if(isset($_SESSION["user"]) && $_SESSION["user"] != NULL)
    {
        $clientsforuser = NULL;   
        $clientsforuser = Client::GetClientbyUser($_SESSION["user"]);
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
        <link rel="shortcut icon" href="Images/favicon.ico" />

        <META name="GENERATOR" content="WDL-Website-Builder">
        
        <!--<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/landing-page.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>

        <style >
            
            a.selectable-row {
                color: darkblue;
            }
            a.active-row {
                color: crimson;
            }
            label.uname {
                overflow-wrap: normal;
                font: x-large/110% "Arial", serif;
            }
            input.cinput {
                width: 100%;
                overflow-wrap: normal;
            }
        </style>
        <script type="text/javascript">
            function reconcileURLwithName()
            {
               var val = document.getElementById("clientname").value;
               var URL = document.getElementById("clientURL");
               URL.value = val + ".sitejinni.com";
            }
            function openServices(clid)
            {
                var method="post"; 

                var form = document.createElement("form");
                form.setAttribute("method", method);
                form.setAttribute("action", "Classes/PostSingle/ClientWebsiteCreation.php");

                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "clid");
                hiddenField.setAttribute("value", clid);

                form.appendChild(hiddenField);

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    </head>
    <body>
       <?php
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
                if(session_status()==PHP_SESSION_ACTIVE) 
                    $_SESSION["client"] = Client::GetClientbyID($_POST["clid"]);
            }

            if(isset($_POST["clearclid"])) {
                if(session_status()==PHP_SESSION_ACTIVE && isset($_SESSION["client"])) 

                    unset ($_SESSION["client"]);
            }

            if(isset($_POST["clientEditSave"])) {

                $clientid = $_POST["clientid"];
                $clientname = $_POST["clientname"];
                $clientURL = $_POST["clientURL"];
                $clientmail = $_POST["clientmail"];
                $clientaddress1 = $_POST["clientaddress1"];
                $clientaddress2 = $_POST["clientaddress2"];
                $clientaddress3 = $_POST["clientaddress3"];
                $clientzipcode = $_POST["clientzipcode"];
                $clientnumber1 = $_POST["clientnumber1"];
                $clientnumber2 = $_POST["clientnumber2"];
                $clientcity = $_POST["clientcity"];
                $clientobj = NULL;
                $clientexisttest = NULL;
                if($clientid != NULL)
                    $clientexisttest = Client::GetClientbyID($clientid);

                if($clientexisttest == NULL)
                {
                    if(($clientid == NULL || $clientid == "") && isset($_SESSION["user"]))
                    {
                        $clients = Client::GetClientbyUser($_SESSION["user"]);
                        $clientnum = 0;
                        if($clients != NULL)
                            $clientnum = count($clients);
                        else
                            $clientnum = 0;
                        $clientnum = $clientnum +1;
                        $clientid = $_SESSION["user"]->userid . "-CLNT-" . $clientnum ;
                    }
                    $clientobj = new Client($clientid, $clientname, $clientnumber1, $clientnumber2, $clientaddress1, $clientaddress2, 
                                $clientaddress3, $clientcity, $clientzipcode, $clientmail, $clientURL, 0, $_SESSION["user"]->userid);
                    $clientobj->AddEntity();
                }
                else
                {
                    $clientobj = new Client($clientid, $clientname, $clientnumber1, $clientnumber2, $clientaddress1, $clientaddress2, 
                                $clientaddress3, $clientcity, $clientzipcode, $clientmail, $clientURL, 0, $_SESSION["user"]->userid);
                    $clientobj->UpdateData();
                }

                if(isset($_SESSION["installpage"]) && isset($_SESSION["purpose"]) && $_SESSION["purpose"] == "install") {
                    var_dump($clientid);
                    $clientobj = Client::GetClientbyID($clientid);

                    $_SESSION["client"] = $clientobj;

                    echo "<script>openServices('" . $clientid . "');</script>";
                }
            }
        }
       ?>
        <!-- Navigation -->
       <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
                <div class="container topnav">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <?php 
                        include("htmlassets/sitejinniNavBar.php");
                    ?>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
        </nav>
        
        <div class="container" id="clientFormContDiv" style="margin-top: 7%">
            <header>
                <h2>Website Details</h2>
                <hr>
            </header>
            <div class="row" style="margin-top: 2%">
                    
                <div class="col-lg-12" >
                    <div class="box form">
                        <form  method="POST" action="FirstClientCreationPage.php" id="cientEditForm" name="cientEditForm">

                            <div id="clientFormDiv" class="row text-left">
                                <?php
                                    $isClientAvailable = FALSE;
                                    $clienttoedit = NULL;
                                    if(session_status()==PHP_SESSION_ACTIVE && isset($_SESSION["client"])) 
                                    {
                                        $clienttoedit = $_SESSION["client"] ;
                                        $isClientAvailable = TRUE;
                                    }
                                ?>
                                <div class="col-lg-12 form-group">
                                    <input type="hidden" name="clientid" class="form-control" id="clientid" value="<?php if($isClientAvailable) echo $clienttoedit->clientid; ?>"/>
                                    <label for="clientname" class="uname form-control-static" data-icon="u">Website Name</label>
                                    <span style="color: red">*</span>
                                    <input id="clientname" name="clientname" oninput="reconcileURLwithName()" class="cinput form-control" required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientname; ?>"/>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="clientURL" class="uname form-control-static" data-icon="u">Website URL</label>
                                    <span style="color: red">*</span>
                                    <input id="clientURL" name="clientURL" readonly="readonly" class="cinput form-control" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientmainURL; ?>"/>
                                </div>
                            </div>
                            <hr>

                            <header>
                                <h2>Website Contact Details</h2>
                                <hr>
                            </header>
                            <div id="clientFormDiv" class="row text-left">
                                <div class="col-lg-12 form-group">
                                    <label for="clientmail" class="uname form-control-static" data-icon="u">Email</label>
                                    <span style="color: red">*</span>
                                    <input id="clientmail" name="clientmail" class="cinput form-control" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientmailaddress; ?>"/>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label for="clientaddress1" class="uname form-control-static" data-icon="u">Address</label>
                                    <span style="color: red">*</span>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <input id="clientaddress1" name="clientaddress1" class="cinput form-control " required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline1; ?>"/>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <input id="clientaddress2" name="clientaddress2" class="cinput form-control" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline2; ?>"/>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <input id="clientaddress3" name="clientaddress3" class="cinput form-control" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline3; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label for="clientcity" class="uname form-control-static" data-icon="u">City</label>
                                            <span style="color: red">*</span>
                                            <input id="clientcity" name="clientcity" class="cinput form-control" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientcity; ?>"/>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label for="clientzipcode" class="uname form-control-static" data-icon="u">Zip Code</label>
                                            <span style="color: red">&NonBreakingSpace;&NonBreakingSpace;</span>
                                            <input id="clientzipcode" name="clientzipcode" class="cinput form-control"  type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientzipcode; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label for="clientnumber1" class="uname form-control-static" data-icon="u">Phone Number</label>
                                            <span style="color: red">*</span>
                                            <input id="clientnumber1" name="clientnumber1" class="cinput form-control" required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientcontactnumber1; ?>"/>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            <label for="clientnumber2" class="uname form-control-static" data-icon="u">Alt. Phone Number</label>
                                            <span style="color: red">&NonBreakingSpace;&NonBreakingSpace;</span>
                                            <input id="clientnumber2" name="clientnumber2" class="cinput form-control" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientcontactnumber2; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group text-right">
                                    <div class="row form-group">
                                        <div class="col-lg-offset-9 col-lg-3 col-md-offset-9 col-md-3 col-sm-offset-9 col-sm-3 form-group">
                                            <input type="submit" id="addSaveClient" class="form-control" value="Save Details" name="clientEditSave"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
