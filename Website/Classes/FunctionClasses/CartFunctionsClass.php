<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartFunctionsClass
 *
 * @author bishwaroop.mukherjee
 */

//include '../FunctionClasses/FunctionsClass.php';
//include '../FunctionClasses/CartFunctionsClass.php';
//include '../DataAccess.php';
//include '../Entities/EntityBase.php';
//include '../Entities/Client.php';
//include '../Entities/Service.php';
//include '../Entities/Microsite.php';
//include '../Entities/User.php';
//include '../Entities/Cart.php';
//include '../Entities/BillItem.php';
//include '../Entities/CartItem.php';

class CartFunctionsClass {
    //put your code here
    public static function CreateCart($user,$client) {
        $cart = NULL;
        if(!isset($_SESSION["user"]) || !isset($_SESSION["client"]) )
            return;
        if(!isset($_SESSION["cart"]) || $_SESSION["cart"] == NULL) {
            $user = $_SESSION["user"];
            $client = $_SESSION["client"];
                       
            $cartidpr = $user->userid . "-" . $client->clientid . "-CART" ;
            $cartid = uniqid($cartidpr, TRUE);
            $cart = new Cart($cartid, $client->clientid, $user->userid, FALSE, 
                             $user->userid . ": cart " . date("Y-m-d-H-i-s"));
            
            $_SESSION["cart"] = $cart;
        }
        $cart = $_SESSION["cart"];
        return $cart;
    }
    
    public static function CreateCartItem($cart, $service, $billtype) {
        $cartits = CartItem::GetCartItembyCart($cart->cartid);
        
        $cartitemidpr = $cart->cartid . "-IT";
        $cartitemid = uniqid($cartitemidpr,TRUE);
        $cartitem = new CartItem($cartitemid, $cart->cartid . " " . $service->servicetype, 
                                 $cart->cartid, $service->servicetype, "", "");
        if($service->servicetype == "MICROSITE" ) {
            if($billtype != NULL && count($billtype)> 0) {
                foreach ($billtype as $key => $btype) {
                    if($btype == "MS") {
                        $billidpr = $cartitemid . "-BL-" . $btype;
                        $billid = uniqid($cartitemidpr,TRUE);
                        $billitem = new BillItem($billid, $cart->cartid . " " . $service->servicetype . " " . $btype, $cartitemid, date("M-d-Y"), 
                                                 1, 0, 0, 0, 0, 0, 12, "", "");
                        $cartitem->AddBillItem($billitem);
                    } else if($btype == "TM") {
                        $billidpr = $cartitemid . "-BL-" . $btype;
                        $billid = uniqid($cartitemidpr,TRUE);
                        $billitem = new BillItem($billid, $cart->cartid . " " . $service->servicetype . " " . $btype, $cartitemid, date("M-d-Y"), 
                                                 1, 0, 0, 0, 0, 0, 12, "", "");
                        $cartitem->AddBillItem($billitem);
                        
                    }
                }
            }
        } else {
            $billidpr = $cartitemid . "-BL-" . "OT";
            $billid = uniqid($cartitemidpr,TRUE);
            $billitem = new BillItem($billid, $cart->cartid . " " . $service->servicetype . " " . "OT", $cartitemid, date("M-d-Y"), 
                                     1, 0, 0, 0, 0, 0, 12, "", "");
            $cartitem->AddBillItem($billitem);
        }

        $cart->AddCartItem($cartitem);
        return $cartitem;
    }

    public static function AddCartItem($usr, $clnt, $service, $billtype) {
        $cart = NULL;
        if(!isset($_SESSION["cart"]) || $_SESSION["cart"] == NULL) {
            $cart = CartFunctionsClass::CreateCart($usr, $clnt);
        }
        
        $cart = $_SESSION["cart"];
        
        CartFunctionsClass::CreateCartItem($cart, $service, $billtype);
    }
    
    public static function  SaveCart() {
    }
}

