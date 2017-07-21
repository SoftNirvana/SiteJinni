<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';      
    include './Classes/Entities/Service.php';
    
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
    $userid = "";
    $userpasswd = "";
    $usermail = "";
    $userfirstname = "";
    $userlastname = "";
    $userbilladdressl1 = "";
    $userbilladdressl2 = "";
    $usercity = "";
    $userzipcode = "";
    $userstate = "";
    $usercountry = "";
    $userphone1 = "";
    $ismailverified = "";
    $isphoneverified = "";
    $useruniqueidtype = "";
    $useruniqueid = "";
    if(isset($_SESSION["user"]) && $_SESSION["user"] != NULL)
    {
        $clientsforuser = NULL;   
        $clientsforuser = Client::GetClientbyUser($_SESSION["user"]);
        $user = $_SESSION["user"];
        $userid = $user->userid;
        $userpasswd = $user->userpasswd;
        $usermail = $user->usermail;
        $userfirstname = $user->userfirstname;
        $userlastname = $user->userlastname;
        $userbilladdressl1 = $user->userbilladdressl1;
        $userbilladdressl2 = $user->userbilladdressl2;
        $usercity = $user->usercity;
        $userzipcode = $user->userzipcode;
        $userstate = $user->userstate;
        $usercountry = $user->usercountry;
        $userphone1 = $user->userphone1;
        $ismailverified = $user->ismailverified;
        $isphoneverified = $user->isphoneverified;
        $useruniqueidtype = $user->useruniqueidtype;
        $useruniqueid = $user->useruniqueid;
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
            }
            input.cinput {
                width: 100%;
                overflow-wrap: normal;
            }
        </style>
        <script type="text/javascript">
            var clientid = null;
            function closeModal()
            {
                $("#edit_header").hide();
                $(".modal-backdrop").hide();
                $("#edit_header").click();
            }
            function reconcileURLwithName()
            {
               var val = document.getElementById("clientname").value;
               var URL = document.getElementById("clientURL");
               URL.value = val + ".sitejinni.com";
            }
            function asssignClientIDonSubmit() {
                var idfld = document.getElementById("clientid");
                idfld.value = clientid;
            }
            function submitClearClientForm() 
            {
                $.ajax({
                    type: "POST",
                    url: "userPortfolioPage.php",
                    cache: false,
                    data: {clearclid: "clear"},
                    success: function (response, textStatus, jqXHR) {
                        $("#clientFormContDiv").load(" #clientFormContDiv");
                        //$('#clientname').on("input", reconcileURLwithName);
                        $('#cientEditForm').on("submit", asssignClientIDonSubmit);
                        $('#clearClient').on('click', submitClearClientForm);
                    }
                });
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
            $(document).ready(function () {                                
                $('#clientstable').on('click','.selectable-row', function(event) {
                    var clidField = $(this).children().find("input");
                    clientid = clidField[0].value;
                    
                    $('.active-row').addClass('selectable-row');
                    $('.active-row').removeClass('active-row');
                    $(this).addClass('active-row').removeClass('selectable-row');
                    
                    $.ajax({
                        type: "POST",
                        url: "userPortfolioPage.php",
                        cache: false,
                        data: {clid: clientid},
                        success: function (response, textStatus, jqXHR) {                            
                            $("#clientFormContDiv").load(" #clientFormContDiv");
                            //$('#clientname').on("input", reconcileURLwithName);
                            $('#cientEditForm').on("submit", asssignClientIDonSubmit);
                            $('#clearClient').on('click', submitClearClientForm);
                        }
                    });
                });
                //$('#clientname').on("input", reconcileURLwithName);
                $('#cientEditForm').on("submit", asssignClientIDonSubmit);
                $('#addClient').on('click', submitClearClientForm);
                
            });

        </script>
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

        
        <div class="container" style="height: 95%; width: 90%">
            <div class="row" style="height: 30px"></div>
            <div class="row well-lg" style="height: 95%;">
                <div class="col-lg-3 col-md-5 col-sm-6" style="margin: 10px; height: 100%; box-shadow: 10px 10px 5px #DDDDDD; border: 1px solid #DDDDDD; padding: 0px;">
                    <div style="background:url(./images/banner-bg.jpg);opacity: 0.1;width: 100%; height: 100%; margin: 0px;z-index: 0; position: absolute">
                        
                    </div>
                    <div class="box" style="z-index: 1; position: absolute; height: 100%; width: 100%">
                        <div class="row" style="height: 100%; width: 100%; overflow: scroll">
                            <div class="col-lg-12" style="margin: 10px">
                                <h4><?php echo $userfirstname . " " . $userlastname; ?></h4>
                                <br>
                                <hr style="color: #448044; margin-right: 14px; border: 1px #448044 solid">                                
                            </div>
                            <div class="col-lg-12" style="margin: 10px">
                                <h5><?php echo $userbilladdressl1 . "<br>" . $userbilladdressl2 . "<br>" . $usercity . " - " . $userzipcode . "<br>" . $userstate . ", " . $usercountry; ?></h5>
                            </div>
                            <div class="col-lg-12" style="margin: 10px">
                                <h5><?php echo $usermail; ?></h5>
                            </div>
                            <div class="col-lg-12" style="margin: 10px">
                                <h5><?php echo $userphone1; ?></h5>
                            </div>
                            <div class="col-lg-12" style="margin: 10px">
                                <h5><?php echo $useruniqueidtype . ": Unique ID: " . $useruniqueid; ?></h5>
                            </div>
                            <div class="col-lg-12" style="margin: 10px;width: 100%; color: #008000">
                                <div class="row">
                                    <div class="col-lg-9" >
                                        <span><hr style="border: 1px #000099 solid"></span>
                                    </div>
                                    <div class="col-lg-2" style="margin: 5px">
                                        <a href="#" ><span class="button glyphicon glyphicon-edit"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-6" style="margin: 10px; height: 100%; box-shadow: 10px 10px 5px #DDDDDD; border: 1px solid #DDDDDD; padding: 0px;">
                    <div style="background:url(./images/business-1012761_1920.jpg);opacity: 0.1;width: 100%; height: 100%; margin: 0px;z-index: 0; position: absolute">
                    </div>
                    <div style="background-color: #DCDCA4;opacity: 0.7;width: 100%; height: 100%; margin: 0px;z-index: 2; position: absolute">
                    </div>
                    <div class="box" style="z-index: 2; position: absolute; width: 100%; height: 100%;">
                        <div class="row" style="margin: 10px; height: 85%; width: 100%">
                            <div class="col-lg-12" style="border: 1px darkgrey solid; padding: 2px 20px 20px 20px; margin: 10px; border-radius: 7px;width: 90%; height: 100%;">
                                <div class="row" style="height: 25%;">
                                    <div class="box col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 5px; background-color: #a6e1ec">
                                                <h3>Clients</h3>
                                            </div>
                                        </div>
                                        <div class="row" style="background-color: #e4e4e4">
                                            <div class="col-lg-3" style="padding: 5px"><h4>Name</h4></div>
                                            <div class="col-lg-3" style="padding: 5px"><h4>URL</h4></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="height: 75%; overflow: scroll">
                                    <div id="clientstable" class="box col-lg-12 col-md-12 col-sm-12" style="width: 100%; height: 100%;margin: 0px">
                                            <?php
                                                if(isset($_SESSION["user"]))
                                                {
                                                    $colors = ['#DDDDDD','#CCCCDD'];
                                                    $user = $_SESSION["user"];
                                                    $clients = Client::GetClientbyUser($user);
                                                    $cnt = 0;
                                                    foreach ($clients as $key => $client) {
                                                        echo '<a href="#" class="selectable-row">
                                                                <div class="row" style="background-color: '.$colors[$cnt % 2].'; padding: 5px; display: block" >
                                                                  <div class="col-lg-3" style="padding: 5px"><h5>'.$client->clientname.'</h5></div>
                                                                  <div class="col-lg-3" style="padding: 5px"><h5>'.$client->clientmainURL.'</h5></div>
                                                                  <div class="col-lg-3" style="width:0px; padding: 5px">
                                                                      <input name="clidFld" type="hidden" value="'.$client->clientid.'"/>
                                                                  </div>
                                                                  <div class="col-lg-3" style="right: 0px; padding:10px; height: 100%">
                                                                      <button class="button glyphicon glyphicon-arrow-right" style="padding:5px; height: 95%" type="button" onclick="openServices(\''.$client->clientid.'\')"> Services</button>
                                                                  </div>
                                                                </div>
                                                              </a>';
                                                        $cnt = $cnt + 1;
                                                    }
                                                }
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px;width: 90%;">
                            <div style="margin: 10px; width: 100%; background-color: appworkspace">
                                <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_header" style="background-color:transparent;border:none;color: darkblue">
                                    <button type="button" id="addClient" class="glyphicon glyphicon-plus-sign"></button>
                                </div>
                                <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_header" style="background-color:transparent;border:none;color: darkblue">
                                    <button type="button" id="remClient" class="glyphicon glyphicon-minus-sign" ></button>
                                </div>
                                <div type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#edit_header" style="background-color:transparent;border:none;color: darkblue">
                                    <button type="button" id="editClient" class="glyphicon glyphicon-edit" ></button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal fade modal-dialog" id="edit_header" role="dialog" 
                 style="width: 80%; height: 70%; background-color: whitesmoke; border-radius: 7px;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);background-color: activeborder;">
                <div class="row" style="margin: 10px; height: 100%; width: 100%" id="clientFormContDiv">
                    <div class="col-lg-12" style="border: 1px darkgrey solid; margin: 10px; padding: 0px 20px 20px 20px; border-radius: 7px;width: 95%; height: 5%;background-color: aliceblue; text-align: right;">
                        <button class="button glyphicon glyphicon-collapse-down" style="position: relative; margin: 4px; background: transparent; border: none" type="button" onclick="closeModal()"/>
                    </div>
                    <div class="col-lg-12" style="border: 1px darkgrey solid; padding: 20px 20px 20px 20px; margin: 10px; border-radius: 7px;width: 95%; height: 80%;background-color: aliceblue">
                        <div class="box" style="height: 100%; overflow: scroll">
                            <form class="form-inline" method="POST" action="userPortfolioPage.php" id="cientEditForm" name="cientEditForm">

                                <div class="row">
                                    <div id="clientFormDiv" class="col-md-6 col-lg-6 col-sm-6">
                                        <?php
                                            $isClientAvailable = FALSE;
                                            $clienttoedit = NULL;
                                            if(session_status()==PHP_SESSION_ACTIVE && isset($_SESSION["client"])) 
                                            {
                                                $clienttoedit = $_SESSION["client"] ;
                                                $isClientAvailable = TRUE;
                                            }
                                        ?>
                                        <p>
                                            <input type="hidden" name="clientid" id="clientid" value="<?php if($isClientAvailable) echo $clienttoedit->clientid; ?>"/>
                                            <label for="clientname" class="uname" data-icon="u">Client Name</label>
                                            <span style="color: red">*</span>
                                            <input id="clientname" name="clientname" oninput="reconcileURLwithName()" class="cinput" required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientname; ?>"/>
                                        </p>
                                        <p>
                                            <label for="clientmail" class="uname" data-icon="u">Client Email</label>
                                            <span style="color: red">*</span>
                                            <input id="clientmail" name="clientmail" class="cinput" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientmailaddress; ?>"/>
                                        </p>
                                        <p>
                                            <label for="clientaddress1" class="uname" data-icon="u">Client Address</label>
                                            <span style="color: red">*</span>
                                            <input id="clientaddress1" name="clientaddress1" class="cinput" required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline1; ?>"/>
                                            <input id="clientaddress2" name="clientaddress2" class="cinput" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline2; ?>"/>
                                            <input id="clientaddress3" name="clientaddress3" class="cinput" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientaddressline3; ?>"/>
                                        </p>
                                        <p>
                                            <label for="clientcity" class="uname" data-icon="u">Client City</label>
                                            <span style="color: red">*</span>
                                            <input id="clientcity" name="clientcity" class="cinput" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientcity; ?>"/>
                                        </p>
                                        <p>
                                            <label for="clientzipcode" class="uname" data-icon="u">Zip Code</label>
                                            <span style="color: red">&NonBreakingSpace;&NonBreakingSpace;</span>
                                            <input id="clientzipcode" name="clientzipcode" class="cinput"  type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientzipcode; ?>"/>
                                        </p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <p>
                                            <label for="clientURL" class="uname" data-icon="u">Client URL</label>
                                            <span style="color: red">*</span>
                                            <input id="clientURL" name="clientURL" readonly="readonly" class="cinput" required="required" type="text" placeholder="mysuperusername690"  value="<?php if($isClientAvailable) echo $clienttoedit->clientmainURL; ?>"/>
                                        </p>
                                        <p>
                                            <label for="clientnumber1" class="uname" data-icon="u">Client Phone Number</label>
                                            <span style="color: red">*</span>
                                            <input id="clientnumber1" name="clientnumber1" class="cinput" required="required" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientcontactnumber1; ?>"/>
                                            <label for="clientnumber2" class="uname" data-icon="u">Client Alt. Phone Number</label>
                                            <span style="color: red">&NonBreakingSpace;&NonBreakingSpace;</span>
                                            <input id="clientnumber2" name="clientnumber2" class="cinput" type="text" placeholder="mysuperusername690" value="<?php if($isClientAvailable) echo $clienttoedit->clientcontactnumber2; ?>"/>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                        <input type="submit" id="addSaveClient" value="Save" name="clientEditSave"/>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        
    </body>
</html>
