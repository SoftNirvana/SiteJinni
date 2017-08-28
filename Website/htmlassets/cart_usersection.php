<ul class="nav navbar-nav navbar-right">
    <li  class="dropdown">
        
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
            
            <div id="cartdiv">
                <span class="glyphicon glyphicon-shopping-cart">
                </span> 
            
                <?php echo ($cart != NULL && $cart->items!=NULL? count($cart->items):0); ?> 
            
                <span class="caret"></span>
            </div>
        </a>
        <ul class="dropdown-menu dropdown-cart" role="menu" >
            <?php
                if($cart != NULL) {
                    $cartcount = count($cart->items);
                    //var_dump($cart);
                    if($cartcount > 0) {
                        if($cart->items != NULL && count($cart->items)) {
                            foreach ($cart->items as $key => $item) {
                                $serv = ServiceType::GetServiceTypebyID($item->servicetypeid);

                                echo' <li>
                                           <span class="item">
                                               <span class="item-left">
                                                   <span class="item-info">
                                                       <span>'. $serv->servicetypename . ' ' . $serv->pricetag . '</span>
                                                   </span>
                                               </span>

                                           </span>
                                       </li>';
                            }
                        }
                    }
                }

            ?>
            <li class="divider"></li>
            <li><a class="text-center" href="/CartCheckOut.php" >Check Out Cart</a></li>
        </ul>
        <!--</div> -->
    </li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user"></span> 
            <strong><?php echo $user->userid; ?></strong>

            <span class="glyphicon glyphicon-chevron-down"></span>
        </a>
        <ul class="dropdown-menu" style="width: 400px">
            <li>
                <div class="navbar-login">
                    <div class="row">
                        <div class="col-lg-2" style="margin: 5px">
                            <p class="text-center">
                                <span class="glyphicon glyphicon-user icon-size"></span>
                            </p>
                        </div>
                        <div class="col-lg-8" style="margin: 5px">
                            <form class="form-inline" method="POST" action="/Classes/PostSingle/site_logout.php">
                                <p class="text-left"><strong><?php echo $user->userfirstname ." ". $user->userlastname; ?></strong></p>
                                <p class="text-left small"<?php echo $user->usermail; ?></p>
                                <p class="text-left">
                                    <input type="submit" name="logout" value="Log Out" class="btn btn-primary btn-block btn-sm"/>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </li>                                
        </ul>
    </li>

</ul>