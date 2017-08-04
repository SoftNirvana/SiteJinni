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
        
        if(isset($_POST["installpage"])) {
            if(!isset($_SESSION["client"])) { 
                $installpage = $_POST["installpage"];
                $sections = parse_url($installpage);
                $_SESSION["installpage"] = rawurldecode($sections['path']);
                //var_dump($_SESSION["installpage"]);
                $_SESSION["purpose"] = "install";
                echo "/loginPage.php";
            }  else if(isset($_SESSION["client"]) && isset($_SESSION["service"])) {
                
                $tempdir = $_POST["installpage"];
                
                $client = $_SESSION["client"];
                $user = $_SESSION["user"];
                $service = $_SESSION["service"];
                
                $sections = parse_url($tempdir);
                $tempdir = $sections['path'];
                $templatedirname = rawurldecode(dirname($tempdir));                                
                
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

                $templatedir = ".." . ($templatedirname[0]=='/'?'/..':'/') . $templatedirname;
                
                $clientdirpath = "../../docroots/userdocroots/" . $client->clientname;
                $clientdocrootpath = $clientdirpath . "/docroot";
                if (!file_exists($clientdirpath)) {
                    mkdir($clientdirpath, 0777, true);
                }
                if (!file_exists($clientdocrootpath)) {
                    mkdir($clientdocrootpath, 0777, true);
                }
                FunctionsClass::clean_docroot($clientdocrootpath);
                //var_dump($templatedir);
                FunctionsClass::recurse_copy($templatedir, $clientdocrootpath);
                copy('../../clientjson/header_data.json', $clientdocrootpath . '/header_data.json');
                
                $sitejinnifile = fopen($clientdocrootpath . '/SiteJinni.txt', "a");
                foreach ($client as $key => $value) {
                    fwrite($sitejinnifile, $value .",");
                }
                fwrite($sitejinnifile, "#-:sj:-#");
                fclose($sitejinnifile);                
                CartFunctionsClass::AddCartItem($user, $client, $service, ["MS", "TM"]);

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