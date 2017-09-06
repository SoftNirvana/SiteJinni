<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    $path = $_SERVER['DOCUMENT_ROOT'];
    
    $locpath = str_replace(stristr($path, '/docroots'), '', $path) ;

    //include $locpath . '/Classes/DataAccess.php';
    //include $locpath . '/Classes/Entities/EntityBase.php';
    //include $locpath . '/Classes/Entities/User.php';
    //include $locpath . '/Classes/Entities/Client.php';
    //include $locpath . '/Classes/Entities/Service.php';
    //include $locpath . '/Classes/Entities/Cart.php';
    //include $locpath . '/Classes/Entities/CartItem.php';
    //include $locpath . '/Classes/Entities/BillItem.php';
    //include $locpath . '/Classes/PageDesignData.php';
    //include $locpath . '/Classes/FunctionClasses/CartFunctionsClass.php';

    $user = NULL;
    $client = NULL;
    $service = NULL;
    $cart = NULL;
    
    if(isset($_SESSION["user"]))
        $user = $_SESSION["user"];        
    
    if(isset($_SESSION["client"]))
        $client = $_SESSION["client"];
    
    if(isset($_SESSION["service"]))
        $service = $_SESSION["service"];
    
    if(isset($_SESSION["cart"]))
        $cart = $_SESSION["cart"];
   // $user = new User("billgates", "", "", "bill", "gates", "", "", "", "", "", "", "", "", "");
    //$client = new Client("cl1", "microsoft", "", "", "", "", "", "", "", "", "microsoft.sitejinni.com", "", "");
    
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--<html>
    <head>
        <title>nav bar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>-->
        <div class="collapse navbar-collapse" id="navdiv">
            
            <ul class="nav navbar-nav navbar-left">
                <LI><img src="/Images/site_jinni_logo.PNG" style="max-width: 100px; -webkit-filter: drop-shadow(1px 2px 2px rgba(0,0,0,0.4))"/></LI>
                <LI><a href="sitejinni.com">Home</a></LI>
                <li><a href="microsite/selection.php">Microsite</a>
                <LI><a href="#contact">Contact Info</a></LI>
                <LI><a href="#contact">About</a></LI>

                <?php 
                    if($user != NULL) {
                        include($locpath . "/htmlassets/servicessection.php");
                    }
                ?>
            </ul>
            
            <?php 
                if($user != NULL) {
                    include($locpath . "/htmlassets/cart_usersection.php");
                } else {
                    echo '<ul class="nav navbar-nav navbar-right">' .
                            '<li id="cartdiv">' .
                                '<a class="navbar-brand topnav" href="/loginPage.php">Login</a>' .
                            '</li>' .
                         '</ul>';
                }
            ?>
        </div>
    <!--</body>
</html>-->
