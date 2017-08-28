<?php

    include './Classes/DataAccess.php';
    include './Classes/Entities/EntityBase.php';
    include './Classes/Entities/User.php';
    include './Classes/Entities/Client.php';
    include './Classes/Entities/Service.php';
    include './Classes/Entities/ServiceType.php';
    include './Classes/Entities/Cart.php';
    include './Classes/Entities/CartItem.php';
    include './Classes/Entities/BillItem.php';
    include './Classes/PageDesignData.php';
    include './Classes/FunctionClasses/CartFunctionsClass.php';

    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    
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
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/landing-page.css" rel="stylesheet">
        <link href="css/checkout.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="js/sitejinnijs.js"></script>
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
            }
        ?>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="container topnav" style="margin-top: 0px">
                <!-- Brand and toggle get grouped for better mobile display -->
                <?php 
                    include("htmlassets/sitejinniNavBar.php");
                ?>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <div class="container">            
            <div class="row">
                <div class="col-lg-12" style="top: 0;">
                    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
                    <div class="container">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:50%">Product</th>
                                    <th style="width:10%">Price</th>
                                    <th style="width:8%">Quantity</th>
                                    <th style="width:22%" class="text-center">Subtotal</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($cart != NULL) {
                                        $cartcount = count($cart->items);
                                        $carttotalprice = 0;
                                        //var_dump($cart);
                                        if($cartcount > 0) {
                                            if($cart->items != NULL && count($cart->items)) {
                                                foreach ($cart->items as $key => $item) {
                                                    $serv = ServiceType::GetServiceTypebyID($item->servicetypeid);
                                                    echo '<tr>
                                                            <td data-th="Product">
                                                                <div class="row">
                                                                    <div class="col-sm-2 hidden-xs"><img src="http://placehold.it/100x100" alt="..." class="img-responsive"/></div>
                                                                    <div class="col-sm-10">
                                                                        <h4 class="nomargin">' . $serv->servicetypename . '</h4>
                                                                        <p>' . $serv->description . '</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td data-th="Price">' . $serv->pricetag . '</td>
                                                            <td data-th="Quantity">
                                                                <input type="number" class="form-control text-center" value="1" readonly="true">
                                                            </td>
                                                            <td data-th="Subtotal" class="text-center">' . $serv->pricetag . '</td>
                                                            <td class="actions" data-th="">
                                                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>								
                                                            </td>
                                                        </tr>';
                                                    $carttotalprice += $serv->pricetag;
                                                }
                                            }
                                        }
                                    }
                                ?>
                                
                            </tbody>
                            <tfoot>
                                <tr class="visible-xs">
                                    <td class="text-center"><strong>Total <?php echo $carttotalprice; ?></strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-block btn-info dropdown-toggle" data-toggle="dropdown" >
                                              Add Service <i class="fa fa-plus" style="margin: 0px 0px 0px 10px"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-cart " role="menu" style="width: auto">
                                                <li>
                                                    <div class="container" style="width:450px;font-size: 10px">
                                                        <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 5px">
                                                            <div style="border-bottom:  1px solid black; ">
                                                                <div class="row" style="padding: 5px;margin:3px;">
                                                                       <div class="col-lg-12">Custom Domain Service</div>
                                                                </div>
                                                                <div class="row" style="padding: 5px; Margin:1px;">
                                                                       <div class="col-lg-12">
                                                                            Lorem ipsum Exercitation culpa qui dolor consequat exercitation fugiat laborum ex ea eiusmod ad do
                                                                            aliqua occaecat nisi ad irure sunt id.
                                                                       </div>
                                                                </div>
                                                                <div class="row" style="padding: 5px">
                                                                       <div class="col-lg-4 col-md-4" style="left:35%">
                                                                           <button type="button" class="btn btn-info btn-sm" onclick="addCartItem('2','navdiv')">
                                                                                <span class="glyphicon glyphicon-plus"></span> Add
                                                                            </button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 5px">
                                                            <div style="border-bottom:  1px solid black; ">
                                                            <div class="row" style="padding: 5px;margin:3px;">
                                                                       <div class="col-lg-12">Digi-Mart Service</div>
                                                                </div>
                                                                <div class="row" style="padding: 5px; Margin:1px;">
                                                                <div class="col-lg-3"></div>
                                                                       <div class="col-lg-6">
                                                                          <img src="projectimages/google-ic.png" hieght="32px" width="32px" alt=""/>
                                                                          <img src="projectimages/bing-ic.png" hieght="32px" width="32px" alt=""/>
                                                                          <img src="projectimages/yahoo-ic.png" hieght="32px" width="32px" alt=""/>
                                                                       </div>
                                                                       <div class="col-lg-3"></div>
                                                                </div>
                                                                 <div class="row" style="padding: 5px; Margin:1px;">
                                                                       <div class="col-lg-12">
                                                                            Laborum ex ea eiusmod ad do
                                                                            aliqua occaecat nisi ad irure sunt id.
                                                                       </div>
                                                                </div>
                                                                <div class="row" style="padding: 5px">
                                                                       <div class="col-lg-4 col-md-4" style="left:35%">
                                                                            <button type="button" class="btn btn-info btn-sm" onclick="addCartItem('3','navdiv')">
                                                                                <span class="glyphicon glyphicon-plus"></span> Add
                                                                            </button>
                                                                        </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 5px">
                                                            <div style="border-bottom:  1px solid black; ">
                                                                <div class="row" style="padding: 5px;margin:3px;">
                                                                           <div class="col-lg-12">Change Template</div>
                                                                    </div>
                                                                    <div class="row" style="padding: 5px; Margin:1px;">
                                                                           <div class="col-lg-12">
                                                                                Lorem ipsum Exercitation culpa qui dolor consequat exercitation fugiat laborum ex ea eiusmod ad do
                                                                                aliqua occaecat nisi ad irure sunt id.
                                                                           </div>
                                                                    </div>
                                                                    <div class="row" style="padding: 5px">
                                                                           <div class="col-lg-4 col-md-4" style="left:35%">
                                                                                <button type="button" class="btn btn-info btn-sm" onclick="addCartItem('4','navdiv')">
                                                                                    <span class="glyphicon glyphicon-plus"></span> Go to Preview
                                                                                </button>
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td colspan="2" class="hidden-xs"></td>
                                    <td class="hidden-xs text-center"><strong>Total $<?php echo $carttotalprice; ?></strong></td>
                                    <td><a href="#" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right" style="margin: 0px 0px 0px 10px"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- jQuery -->
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>
