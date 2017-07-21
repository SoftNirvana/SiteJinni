<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../FunctionClasses/FunctionsClass.php';
include '../DataAccess.php';
include '../Entities/EntityBase.php';
include '../Entities/User.php';
include '../Entities/Client.php';  
include '../Entities/Service.php';
include '../Entities/ServiceType.php';  

if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if(isset($_POST["clid"])) {
    $clientid = $_POST["clid"];
    $client = Client::GetClientbyID($clientid);
    $_SESSION["client"] = $client;
    
    $servtypeid = 1;
    $servid = $client->clientid . "-" . $servtypeid;
    $servtype = ServiceType::GetServiceTypebyID($servtypeid);

    $serv = Service::GetServicebyID($servid);
    
    if($serv == NULL) {
        $serv = new Service($servid, $servtypeid, $client->clientid, $servtype->servicetypename, date("Y/m/d"), 1, date("Y/m/d"), 
                                            date("Y/m/d"), $client->clientmainURL, 1, $servtype->description, 1, 1);
        $serv->AddEntity();
    }
    $_SESSION["service"] = $serv;
    if(isset($_SESSION["installpage"]) && isset($_SESSION["purpose"]) && $_SESSION["purpose"] == "install")
        FunctionsClass::Redirect("/Classes/FunctionClasses/InstallPageFunction.php");
    else
        FunctionsClass::Redirect("../../" . $servtype->url);
    
}