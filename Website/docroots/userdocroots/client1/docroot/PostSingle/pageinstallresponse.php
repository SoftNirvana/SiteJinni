<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../FunctionClasses/FunctionsClass.php';
include '../DataAccess.php';
include '../Entities/EntityBase.php';
include '../Entities/Client.php';
include '../Entities/Service.php';
include '../Entities/Microsite.php';

if(session_status()!=PHP_SESSION_ACTIVE) session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {        
        
        if(isset($_POST["installpage"])) {
            if(!isset($_SESSION["client"])) { 
                $installpage = $_POST["installpage"];
                $sections = parse_url($installpage);
                $_SESSION["installpage"] = urlencode($sections['path']);
                $_SESSION["purpose"] = "install";
                echo "/loginPage.php";
            }  else if(isset($_SESSION["client"]) && isset($_SESSION["service"])) {
                
                $servid = $_POST["installpage"];
                $client = $_SESSION["client"];
                $service = $_SESSION["service"];
                
                $templatedirname = dirname($_POST["installpage"]);                                
                
                //this is temporary - template path should be replaced with template id when template search feature is implemented
                //finding the microsite object
                
                $site = Microsite::GetSitebyID($service->serviceid . "-SITE");
                
                if($site == NULL)
                {
                    $site = new Microsite($service->serviceid . "-SITE", $service->serviceid, $client->clientname, $client->clientmainURL, $templatedirname);
                    $site->AddEntity();
                }
                else
                {
                    $site->sitetemplate = $templatedirname;
                    $site->UpdateData();
                }
                $_SESSION["site"] = $site;
                
                $templatedir = ".." . (substr($templatedirname, 0, 1)=='/'?'/..':'/') . $templatedirname;
                
                $clientdirpath = "../../docroots/userdocroots/" . $client->clientname;
                $clientdocrootpath = $clientdirpath . "/docroot";
                if (!file_exists($clientdirpath)) {
                    mkdir($clientdirpath, 0777, true);
                }
                if (!file_exists($clientdocrootpath)) {
                    mkdir($clientdocrootpath, 0777, true);
                }
                FunctionsClass::clean_docroot($clientdocrootpath);
                FunctionsClass::recurse_copy($templatedir, $clientdocrootpath);
                copy('../../clientjson/header_data.json', $clientdocrootpath . '/header_data.json');
                
                echo "/installDisclaimerPage.php";
            } else {
                echo 'NIL';
            }
        }
        
        if(isset($_POST["gendemophrase"])) {
            echo FunctionsClass::getDemoCode();
        }
    }

?>