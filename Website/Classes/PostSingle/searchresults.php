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
        <style type="text/css">
            .collage {                
                float: none;
                position: relative;
                padding: 1px;
            }
            
            .collage > div {
                position: absolute;
                margin: 1px;
                width: 50%;
                height: 50%;
                border: white 2px solid;
                -webkit-box-shadow: 2px 2px 0px 0px;
                box-shadow: 2px 2px 0px 0px;
            }
            
            .collage > .collage-left {
                left: 0;
            }
            
            .collage > .collage-center {
                left: 25%;
                top: 25%;
                z-index: 100;
            }
            
            .collage > .collage-right {
                left: 50%;
            }
            
            .collage > .collage-bottom {
                top: 50%;
            }
            
            .collage > .collage-top {
                top: 0;
            }
            
            .collage > .collage-vertical {
                height: 100%;
            }
            .collage > .collage-horizontal {
                width: 100%;
            }
        </style>
    </head>
    <body>
        <?php
            $clnt_arr = array();
            $searchparam = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["searchsubmit"])) {
                    $searchparam = $_POST["searchparams"];
                    $params = str_getcsv($searchparam, " ");
                    
                    $clnts = Client::GetAllClients();
                    
                    foreach ($clnts as $key => $clientitem) {                         
                        $descfile = "../../docroots/userdocroots/" . $clientitem->clientname . "/docroot/SiteJinni.txt";
                        if(file_exists($descfile)) {
                            $desc = file_get_contents($descfile);   
                            $strsize = strlen($desc);
                            if($params != NULL && count($params)) {
                                $paramcount = count($params);                                
                                $currentidx = 0;
                                $lastidx = -1;
                                $lastpos = 0;                                
                                $curpos = 0;
                                $totscore = 0;
                                $posarr = array();
                                for($i=0;$i<$paramcount;$i++) {
                                    $arrPos = array();
                                    $lastpos = 0;
                                    while($curpos = strpos($desc, $params[$i], $lastpos)) {
                                        array_push($arrPos, $curpos);
                                        $lastpos = $curpos + 1;
                                    }
                                    array_push($posarr, $arrPos);
                                    
                                }                 
                                $findscore = 0;
                                $orderscore = 0;
                                $distancescore = 0;
                                if($posarr != NULL && count($posarr)>0) {
                                    for ($j = 0;$j<count($posarr);$j+=1) {
                                        $arpos = $posarr[$j];
                                        if($arpos != NULL && count($arpos)>0) {
                                            $findscore += 1 * count($arpos);
                                            $addordscr = 0;
                                            $adddistscr = 0;
                                            if(count($posarr)>=$j+2) {
                                                for($k =0; $k < count($posarr[$j]); $k++) {
                                                    if($posarr[$j + 1] != NULL && count($posarr[$j + 1]) > 0) {
                                                        $mindiff = abs($posarr[$j + 1][0] - $posarr[$j][$k]);
                                                        for($l = 0; $l < count($posarr[$j + 1]); $l++) {
                                                            $diff = $posarr[$j + 1][$l] - $posarr[$j][$k];
                                                            if($diff > 0)
                                                                $addordscr += 2;
                                                            else
                                                                $addordscr -= 2;

                                                            $diff = abs($diff);

                                                            if($diff < $mindiff)
                                                                $mindiff = $diff;

                                                            $adddistscr = $strsize/$mindiff;
                                                        }
                                                    }
                                                }
                                            }
                                            $orderscore += $addordscr;
                                            $distancescore += $adddistscr;
                                            
                                            echo '<br>';
                                        }
                                    }                                    
                                }    
                                $totscore = $findscore + $orderscore + $distancescore;
                                array_push($clnt_arr, [$clientitem, $totscore]);                                
                            }
                            for($first = 0;$first < count($clnt_arr); $first++) {
                                for($second = $first + 1; $second < count($clnt_arr); $second ++) {
                                    if($clnt_arr[$first][1]<$clnt_arr[$second][1]) {
                                        $temp = $clnt_arr[$first];
                                        $clnt_arr[$first] = $clnt_arr[$second];
                                        $clnt_arr[$second] = $clnt_arr[$first];
                                    }
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
                    <h2 class="lead"><strong class="text-danger"><?php echo count($clnt_arr); ?></strong> results were found for the search for <strong class="text-danger"><?php echo $searchparam; ?></strong></h2>								
                </hgroup>

                <section class="col-xs-12 col-sm-6 col-md-12">
                    <?php 
                        foreach ($clnt_arr as $key => $value) {
                            $descdir = "../../docroots/userdocroots/" . $value[0]->clientname . "/docroot/mainimages/";
                            $images = scandir($descdir);
                            $actualimages = array();
                            for($cntimg = 0;$cntimg < 7; $cntimg++) {
                                $idx = $cntimg % count($images);
                                if($images[$idx] != '.' && $images[$idx] != '..') {
                                    array_push($actualimages, $images[$idx]);
                                }
                            }
                            
                            echo '<article class="search-result row">
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <a href="http://'.$value[0]->clientmainURL.'" title="'.$value[0]->clientname.'" class="thumbnail" style="height: 150px; width: auto; border: none;">
                                            <div class="collage" style="height: 100%; width: 100%;">
                                                <div class="collage-left" >
                                                    <img src="'.'../../docroots/userdocroots/' . $value[0]->clientname . '/docroot/mainimages/'.$actualimages[0].'" style="height: 100%; width: 100%" alt="Lorem ipsum" />
                                                </div>                
                                                <div class="collage-center" >
                                                    <img src="'.'../../docroots/userdocroots/' . $value[0]->clientname . '/docroot/mainimages/'.$actualimages[1].'" style="height: 100%; width: 100%" alt="Lorem ipsum" />
                                                </div>
                                                <div class="collage-bottom collage-right" >
                                                    <img src="'.'../../docroots/userdocroots/' . $value[0]->clientname . '/docroot/mainimages/'.$actualimages[2].'" style="height: 100%; width: 100%" alt="Lorem ipsum" />
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                            <ul class="meta-search">
                                                <li>' . 
                                                    '<i class="glyphicon glyphicon-home">' . 
                                                    '</i>' . 
                                                    '<span>' . 
                                                        '<div>' . $value[0]->clientaddressline1 . 
                                                            '<p>' . $value[0]->clientaddressline2 . 
                                                            '<p>' . $value[0]->clientaddressline3 . 
                                                            '<p>' . $value[0]->clientcity . ' - ' . $value[0]->clientzipcode . 
                                                        '</div>' . 
                                                    '</span>' . 
                                                '</li>
                                                <li><i class="glyphicon glyphicon-envelope"></i> <span>' . $value[0]->clientmailaddress . '</span></li>
                                                <li><i class="glyphicon glyphicon-phone"></i> <span>' . $value[0]->clientcontactnumber1 . ' / ' . $value[0]->clientcontactnumber2 . '</span></li>
                                            </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                                        <h3><a  href="http://'.$value[0]->clientmainURL.'"  title="">' . $value[0]->clientname . '</a></h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>						
                                        <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
                                    </div>
                                    <span class="clearfix borda"></span>
                                </article>';
                        }
                    
                    ?>
                    		
                </section>
            </div>
        </div>
    </body>
</html>
