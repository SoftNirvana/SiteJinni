<?php
    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';  
    include './Classes/Entities/Service.php';
    include './Classes/Entities/ServiceType.php';        
    
    $client = NULL;
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
        
        if(isset($_POST["servtype"])) {
            if(isset($_SESSION["client"]) && $_SESSION["client"] != NULL) {
                $servtypeid = $_POST["servtype"];
                $client = $_SESSION["client"];
                $servid = $client->clientid . "-" . $servtypeid;
                $servtype = ServiceType::GetServiceTypebyID($servtypeid);
                $serv = Service::GetServicebyID($servid);
                
                if($serv == NULL) {
                    
                    $service = new Service($servid, $servtypeid, $client->clientid, $servtype->servicetypename, date("Y/m/d"), 1, date("Y/m/d"), 
                                            date("Y/m/d"), $client->clientmainURL, 1, $servtype->description, 1, 1);
                    $service->AddEntity();
                    echo 'Service successfully added';
                } else {
                    echo 'Service already exists';
                }
            }
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
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        
        <script type="text/javascript">
            function addService(servTypeID) {
                $.ajax({
                    type: "POST",
                    url: "serviceSelectionPage.php",
                    cache: false,
                    data: {servtype: servTypeID},
                    success: function (response, textStatus, jqXHR) {
                        alert(response);
                        $("#servicesForm").load(" #servicesForm");
                        
                    }
                });
            }
        </script>
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
            <div class="well-lg">
                <div class="row" style="height: 45px"></div>
                <div class="row" style="background-color: #05B2D2;">
                    <h3>Add Services</h3>
                </div>
                <div class="row">
                    <!--<text class="glyphicon glyphicon-ok-sign" style="height: 15px; width: 15px"/>-->
                    <div id="servicesForm" class="box col-lg-12" style="padding: 0px;">

                        <?php
                            $colors = ['#DDDDDD','#CCCCDD'];
                            $headercolors = ['#BBBBBB','#AAAABB'];
                            if($client == NULL)
                                $client = $_SESSION["client"];
                            //--------------------
                            $sql = "SELECT st.*, s.servicetype , s.serviceid
                                    FROM 
                                    (SELECT * FROM SERVICE WHERE clientid='".$client->clientid."') s
                                    RIGHT JOIN SERVICETYPE st ON s.servicetype = st.servicetypeid ";
                            $result = DataAccess::getdatabyquery($sql);
                            $values = array();
                            if ($result != NULL && $result->num_rows > 0) {
                            // output data of each row
                                    while($row = $result->fetch_assoc()) {

                                        $srvtp = new ServiceType($row["servicetypeid"],$row["servicetypename"],$row["description"],$row["pricetag"],$row["url"]);
                                        array_push($values, [$srvtp,$row["servicetype"], $row["serviceid"]]);
                                    }
                            }

                            $servicetypes = ServiceType::GetAllServiceTypes();
                            //--------------------
                            $cnt = 0;
                            if($servicetypes != NULL && count($servicetypes)>0)
                            {
                                foreach ($values as $key => $value) {
                                    $visibility = NULL;
                                    if($value[1] == NULL)
                                        $visibility = "hidden";
                                    else
                                        $visibility = "visible";
                                    echo '<div class="row" style="background-color: '.$colors[$cnt % 2].'; margin: 10px 0px 10px 0px; padding: 10px">
                                            <div class="col-lg-12 col-md-12 col-sm-12" style="background-color: '.$headercolors[$cnt % 2].'">
                                                <h4>'.$value[0]->servicetypename.'</h4>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h5>'.$value[0]->description.'</h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h5>'.$value[0]->pricetag.'</h5>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <button class="button glyphicon glyphicon-plus" style="height: 25px; margin: 5px" type="button" onclick="addService('.$value[0]->servicetypeid.')"> Add Service</button>
                                                <button class="button glyphicon glyphicon-minus" style="height: 25px; margin: 5px" type="button" onclick="delService('.$value[0]->servicetypeid.')"> Remove Service</button>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4" style="text-align: center; visibility: '.$visibility.'">
                                                <form method="POST" action="'.$value[0]->url.'" name="manageServiceForm" id="manageServiceForm">
                                                    <div class="row" >
                                                        <input type="hidden" name="selservid" value="'.$value[2].'"/>
                                                        <text class="glyphicon glyphicon-ok-sign"/>
                                                        <input type="submit" value="Manage Service" style="marging: 10px"/>
                                                    </div>
                                                </form>
                                            </div>
                                          </div>';
                                    $cnt = $cnt + 1;
                                }
                            }
                        ?>
                    </div>
                    <div class="box col-lg-12" style="padding: 0px">
                        <input type="submit" value="Save and Edit Services" id="btnServiceSubmit" name="servicesubmit"/>
                    </div>
                </div>
            </div>
        </div>
        
        
    </body>
</html>
