<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../FunctionClasses/FunctionsClass.php';
include '../FunctionClasses/CartFunctionsClass.php';
include '../DataAccess.php';
include '../Entities/EntityBase.php';
include '../Entities/Client.php';
include '../Entities/Service.php';
include '../Entities/ServiceType.php';
include '../Entities/Microsite.php';
include '../Entities/User.php';
include '../Entities/Cart.php';
include '../Entities/BillItem.php';
include '../Entities/CartItem.php';  

if(session_status()!=PHP_SESSION_ACTIVE) session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST);
    if(isset($_POST["cartadd"])) {
        try {
            $servtypeid = $_POST["cartadd"];
            $service = new Service("", $servtypeid, "", "", "", "", "", "", "", "", "", "", "");
            CartFunctionsClass::AddCartItem($_SESSION["user"], $_SESSION["client"], $service, "OT");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}



