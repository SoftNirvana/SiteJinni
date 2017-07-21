<?php
    include '../FunctionClasses/FunctionsClass.php';
    include '../DataAccess.php';
    include '../Entities/EntityBase.php';
    include '../Entities/Client.php';
    include '../Entities/Service.php';
    include '../Entities/Microsite.php';

    if(session_status()!=PHP_SESSION_ACTIVE) session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {        

        if(isset($_POST["acceptsubdomain"])) {
            if(isset($_SESSION["client"]) && isset($_SESSION["service"])) {
                $client = $_SESSION["client"];
                $service = $_SESSION["service"];
                
                $clientdocrootpath = "/public_html/docroots/userdocroots/" . $client->clientname . "/docroot/";
                
                $retval = "";
                $subd = $client->clientname;
                $rootd = "sitejinni.com";
                $docroot = $clientdocrootpath;
                $addordel = "+";
                
                $filename = "../../subdomains.lst";
                
                $shouldAdd = TRUE;
                $writestr = $subd . ";" . $rootd . ";" . $docroot . ";" . $addordel . "\n";
                
                if (!file_exists($filename)) {
                    $creatingfile = fopen($filename, "w");
                    fclose($creatingfile);
                }
                
                if (file_exists($filename)) {
                    $lines = file($filename);
                    $shouldAdd = !in_array($writestr, $lines);
                }
                $subdomainfile = fopen($filename, "a+") or die("Unable to open file!");
                if($shouldAdd) {                 
                    if (flock($subdomainfile,LOCK_EX)) {
                        fwrite($subdomainfile,$writestr);
                        
                        $service->serviceisactive = TRUE;
                        $service->UpdateData();
                        flock($subdomainfile,LOCK_UN);
                    } else {
                        echo "Error locking file!";
                    }
                }
                
                

                fclose($subdomainfile);
                if(isset($_SESSION["installpage"])) {
                    unset($_SESSION["installpage"]);
                }
                if(isset($_SESSION["purpose"])) {
                    unset($_SESSION["purpose"]);
                }
                FunctionsClass::Redirect("../../docroots/userdocroots/" . $client->clientname . "/docroot/index.php");
            }
        }
        if(isset($_POST["rejectsubdomain"])) {
            if(isset($_SESSION["client"])) {
                $retval = NULL;
                $subd = "";
                $rootd = "sitejinni.com";
                $docroot = "";
                $addordel = "+";
                $subdomainfile = fopen("./subdomains.lst", "w+") or die("Unable to open file!");

                if (flock($subdomainfile,LOCK_EX)) {
                    $writestr = $subd . ";" . $rootd . ";" . $docroot . ";" . $addordel . "\n";
                    fwrite($subdomainfile,$writestr);
                    // release lock
                    flock($subdomainfile,LOCK_UN);
                } else {
                    echo "Error locking file!";
                }

                fclose($subdomainfile);
            }
        }
        if(isset($_POST["removesubdomain"])) {
            if(isset($_SESSION["client"])) {
                $retval = NULL;
                $subd = $_POST["removesubdomain"];
                $rootd = "sitejinni.com";
                $docroot = "";
                $addordel = "-";
                $subdomainfile = fopen("./subdomains.lst", "w+") or die("Unable to open file!");

                if (flock($subdomainfile,LOCK_EX)) {
                    $writestr = $subd . ";" . $rootd . ";" . $docroot . ";" . $addordel . "\n";
                    fwrite($subdomainfile,$writestr);
                    // release lock
                    flock($subdomainfile,LOCK_UN);
                } else {
                    echo "Error locking file!";
                }

                fclose($subdomainfile);
            }
        }
    }
    
?>
