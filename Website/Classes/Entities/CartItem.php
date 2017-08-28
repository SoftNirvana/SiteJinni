<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartItem
 *
 * @author bishwaroop.mukherjee
 */
class CartItem {
    public $cartitemid;
    public $cartitemname;
    public $cartid;
    public $servicetypeid;
    public $description;
    public $offerid;
    
    public $items;
    public $deleted;
    
    public function __construct($crtitid,$crtitname,$crtid,$srvtyp,$desc,$offer) {
        $this->cartitemid = $crtitid;
        $this->cartitemname = $crtitname;
        $this->cartid = $crtid;
        $this->servicetypeid = $srvtyp;
        $this->description = $desc;
        $this->offerid = $offer;
        
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE CARTITEM SET cartitemname = ?, cartid = ?, servicetypeid = ?, " . 
                       "description = ?, offerid = ? WHERE cartitemid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("ssssss", $this->cartitemname,  $this->cartid, $this->servicetypeid, $this->description,
                $this->offerid, $this->cartitemid);
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
                $sql = "INSERT INTO CARTITEM (cartitemid, cartitemname, cartid, servicetypeid, description, " . 
                       "offerid) VALUES (?,?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("ssssss", $this->cartitemid, $this->cartitemname,  $this->cartid, $this->servicetypeid, 
                $this->description, $this->offerid);
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
    
    public function Save() {
        $cart = CartItem::GetCartItembyID($this->cartitemid);
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
    
    function RemoveEntity() {
        if($conn != NULL) {
            
        }
    }
    
    public function AddBillItem($item) {
        if($this->items == NULL) 
            $this->items = array();
        
        array_push($this->items, $item);
    }
            
    public function RemoveBillItem($item) {
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
    
    public static function GetCartItembyID($crtitid) {
        try {
            $conn = DataAccess::connect();
            $cartit = null;
            if($conn != NULL) {
                $sql = "SELECT cartitemid, cartitemname, cartid, servicetypeid, description, " . 
                       "offerid FROM CARTITEM WHERE cartitemid='".$crtitid."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $cartit = new CartItem($row["cartitemid"],$row["cartitemname"],$row["cartid"],$row["servicetypeid"],
                                               $row["description"],$row["offerid"]);
                } else {
                    $conn->close();
                    return NULL;
                }
            }
            $conn->close();
            
            $billitems = BillItem::GetBillbyCartItem($cartit->cartitemid);
            $cartit->items = $billitems;
            
            return $cartit;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetCartItembyCart($crtid) {
        try {
            $cartits = array();
            $conn = DataAccess::connect();
            $cartit = null;
            if($conn != NULL) {
                $sql = "SELECT cartitemid, cartitemname, cartid, servicetypeid, description, " . 
                       "offerid FROM CARTITEM WHERE cartid='".$crtid."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $cartit = new CartItem($row["cartitemid"],$row["cartitemname"],$row["cartid"],$row["servicetypeid"],
                                               $row["description"],$row["offerid"]);
                            array_push($cartits, $cartit);
                        }
                }
            }
            $conn->close();
            if($cartits != NULL && count($cartits) > 0) {
                foreach ($cartits as $key => $item) {
                    $billitems = BillItem::GetBillbyCartItem($item->cartitemid);
                    $item->items = $billitems;
                }
            }
            return $cartits;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
            
}
