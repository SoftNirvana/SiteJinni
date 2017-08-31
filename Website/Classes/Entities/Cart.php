<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cart
 *
 * @author bishwaroop.mukherjee
 */
class Cart {
    public $cartid;
    public $clientid;
    public $userid;
    public $ispaid;
    public $cartdescription;
    
    public $items;
    public $deleted;

    public function __construct($crtid,$clntid,$usrid,$ispd,$desc) {
        $this->cartid = $crtid;
        $this->clientid = $clntid;
        $this->userid = $usrid;
        $this->ispaid = $ispd;
        $this->cartdescription = $desc;
        
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE CART SET clientid = ?, userid = ?, ispaid = ?, " . 
                       "cartdescription = ? WHERE cartid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssss", $this->clientid,  $this->userid, $this->ispaid, $this->cartdescription,
                $this->cartid);
                $result = $query->execute();
            }
            $conn->close();       
            if($this->items != NULL && count($this->items) > 0) {
                foreach ($this->items as $key => $item) {
                    $item->Save();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    function AddEntity() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "INSERT INTO CART (cartid, clientid, userid, ispaid, " . 
                       "cartdescription) VALUES (?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssss", $this->cartid, $this->clientid,  $this->userid, $this->ispaid, 
                $this->cartdescription);
                $result = $query->execute();
            }
            $conn->close();   
            if($this->items != NULL && count($this->items) > 0) {
                foreach ($this->items as $key => $item) {
                    $item->Save();
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

                
    }
    
    function AddCartItem($item) {
        if($this->items == NULL)
            
            $this->items = array();
        
        array_push($this->items, $item);
    }
    
    public function Save() {
        $cart = Cart::GetCartbyID($this->cartid);
        if($cart == NULL) {
            $this->AddEntity();
        } else {
            $this->UpdateData();
        }
        
        if($this->deleted!=NULL) {
            while (count($this->deleted)>0) {
                $item = array_pop($this->deleted);
                if($item!=NULL)
                    $item->RemoveEntity();                    
            }
        }
    }
    
    function RemoveCartItem($item) {
        if($this->items != NULL && count($this->items)>0) {
            $temparr = array();
            foreach ($this->items as $key => $tempitem) {
                if($tempitem != $item)
                    array_push ($temparr, $tempitem);
                else {
                    if($this->deleted==NULL)
                        $this->deleted = array();
                    
                    array_push ($this->deleted, $tempitem);
                }
            }
            $this->items = $temparr;
        }
    }
    function RemoveEntity() {
        if($conn != NULL) {
            
        }
    }
    public static function GetCartbyID($crtid) {
        try {
            $conn = DataAccess::connect();
            $cart = null;
            if($conn != NULL) {
                $sql = "SELECT cartid, clientid, userid, ispaid, " . 
                       "cartdescription FROM CART WHERE cartid='".$crtid."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $cart = new Cart($row["cartid"],$row["clientid"],$row["userid"],$row["ispaid"],
                                               $row["cartdescription"]);
                } else {
                    $conn->close();                            
                    return NULL;
                }
            }
            $conn->close();
            
            $cartitems = CartItem::GetCartItembyCart($cart->cartid);
            
            $cart->items = $cartitems;
            
            return $cart;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetCartbyClient($clntid) {
        try {
            $carts = array();
            $conn = DataAccess::connect();
            $cart = null;
            if($conn != NULL) {
                $sql = "SELECT cartid, clientid, userid, ispaid, " . 
                       "cartdescription FROM CART WHERE clientid='".$clntid."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $cart = new Cart($row["cartid"],$row["clientid"],$row["userid"],$row["ispaid"],
                                                   $row["cartdescription"]);
                            array_push($carts, $cart);
                        }
                }
            }
            $conn->close();
            if($carts != NULL && count($carts)>0) {
                foreach ($carts as $key => $item) {
                    $cartitems = CartItem::GetCartItembyCart($item->cartid);
                    $item->items = $cartitems;
                }
            }
            return $carts;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
    public static function GetCartbyUser($usrid) {
        try {
            $carts = array();
            $conn = DataAccess::connect();
            $cart = null;
            if($conn != NULL) {
                $sql = "SELECT cartid, clientid, userid, ispaid, " . 
                       "cartdescription FROM CART WHERE userid='".$usrid."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $cart = new Cart($row["cartid"],$row["clientid"],$row["userid"],$row["ispaid"],
                                                   $row["cartdescription"]);
                            array_push($carts, $cart);
                        }
                }
            }
            $conn->close();
            
            if($carts != NULL && count($carts)>0) {
                foreach ($carts as $key => $item) {
                    $cartitems = CartItem::GetCartItembyCart($item->cartid);
                    $item->items = $cartitems;
                }
            }

            return $carts;            
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }        

}
