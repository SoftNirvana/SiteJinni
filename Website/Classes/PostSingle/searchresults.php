<?php

    include '../../Classes/DataAccess.php';
    include '../../Classes/Entities/EntityBase.php';
    include '../../Classes/Entities/User.php';
    include '../../Classes/Entities/Client.php';
    include '../../Classes/Entities/Service.php';
    include '../../Classes/Entities/ServiceType.php';
    include '../../Classes/Entities/Cart.php';
    include '../../Classes/Entities/CartItem.php';
    include '../../Classes/Entities/BillItem.php';
    include '../../Classes/PageDesignData.php';
    include '../../Classes/FunctionClasses/CartFunctionsClass.php';

    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/landing-page.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="/js/sitejinnijs.js"></script>
    </head>
    <body>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["searchsubmit"])) {
                    $searchparam = $_POST["searchparams"];
                    $params = str_getcsv($searchparam, " ");
                    $clnts = Client::GetAllClients();
                    foreach ($clnts as $key => $clientitem) {
                        $clientitem = new Client($cid, $cname, $ccnumber1, $ccnumber2, $caddl1, $caddl2, $caddl3, $ccity, $czipcd, $cmailadd, $cmainURL, $cnumserv, $cusrid);
                        $descfile = "../../docroots/userdocroots/" . $clientitem->clientname . "/docroot/SiteJinni.txt";
                        if(file_exists($descfile)) {
                            $desc = file_get_contents($descfile);
                            $posarr = array();
                            if($params != NULL && count($params)) {
                                foreach ($params as $key => $param) {
                                    $pos = strpos($desc, $param);
                                    array_push($posarr, $pos);
                                }
                                
                            }
                        }
                    }
                }
            }
        ?>
        
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
            <div class="container topnav" style="margin-top: 0px">
                <!-- Brand and toggle get grouped for better mobile display -->
                <?php 
                    include("../../htmlassets/sitejinniNavBar.php");
                ?>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        
        <div class="container">
            <form action="/Classes/PostSingle/searchresults.php" method="POST" name="searchparam">
                <div class="row input-group" id="adv-search">
                    <input type="text" name="searchparams" class="form-control" placeholder="Search SiteJinni websites" />
                    <div class="input-group-btn">
                        <div class="btn-group" role="group">
                            <button type="submit" name="searchsubmit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="container">
                <hgroup class="mb20">
                    <h1>Search Results</h1>
                    <h2 class="lead"><strong class="text-danger">3</strong> results were found for the search for <strong class="text-danger">Lorem</strong></h2>								
                </hgroup>

                <section class="col-xs-12 col-sm-6 col-md-12">
                    <article class="search-result row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                                <a href="#" title="Lorem ipsum" class="thumbnail"><img src="http://lorempixel.com/250/140/people" alt="Lorem ipsum" /></a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                                <ul class="meta-search">
                                        <li><i class="glyphicon glyphicon-calendar"></i> <span>02/15/2014</span></li>
                                        <li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
                                        <li><i class="glyphicon glyphicon-tags"></i> <span>People</span></li>
                                </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                            <h3><a href="#" title="">Voluptatem, exercitationem, suscipit, distinctio</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>						
                            <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
                        </div>
                        <span class="clearfix borda"></span>
                    </article>

                    <article class="search-result row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <a href="#" title="Lorem ipsum" class="thumbnail"><img src="http://lorempixel.com/250/140/food" alt="Lorem ipsum" /></a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <ul class="meta-search">
                                <li><i class="glyphicon glyphicon-calendar"></i> <span>02/13/2014</span></li>
                                <li><i class="glyphicon glyphicon-time"></i> <span>8:32 pm</span></li>
                                <li><i class="glyphicon glyphicon-tags"></i> <span>Food</span></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7">
                            <h3><a href="#" title="">Voluptatem, exercitationem, suscipit, distinctio</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>						
                            <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
                        </div>
                        <span class="clearfix borda"></span>
                    </article>

                    <article class="search-result row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                                <a href="#" title="Lorem ipsum" class="thumbnail"><img src="http://lorempixel.com/250/140/sports" alt="Lorem ipsum" /></a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                                <ul class="meta-search">
                                        <li><i class="glyphicon glyphicon-calendar"></i> <span>01/11/2014</span></li>
                                        <li><i class="glyphicon glyphicon-time"></i> <span>10:13 am</span></li>
                                        <li><i class="glyphicon glyphicon-tags"></i> <span>Sport</span></li>
                                </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7">
                            <h3><a href="#" title="">Voluptatem, exercitationem, suscipit, distinctio</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>						
                            <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
                        </div>
                        <span class="clearfix border"></span>
                    </article>			
                </section>
            </div>
        </div>
    </body>
</html>
