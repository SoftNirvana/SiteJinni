<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BillItem
 *
 * @author bishwaroop.mukherjee
 */
class BillItem {
    //put your code here
    public $itemid;
    public $itemname;
    public $cartitemid;
    public $billdate;
    public $itemqty;
    public $itemrate;
    public $itemdiscount;
    public $itemstax;
    public $itemgtax;
    public $itemtotal;
    public $itemrenewfreq;
    public $itemdescription;
    public $itemnotes;
    
    public function __construct($itmid,$itmname,$crtitmid,$billdt,$itmqty,$itmrate,$itmdiscount,$itmstax,$itmgtax,
                                $itmtotal,$itmrenewfreq,$itmdescription,$itmnotes) {
        $this->itemid = $itmid;
        $this->itemname = $itmname;
        $this->cartitemid = $crtitmid;
        $this->billdate = $billdt;
        $this->itemqty = $itmqty;
        $this->itemrate = $itmrate;
        $this->itemdiscount = $itmdiscount;
        $this->itemstax = $itmstax;
        $this->itemgtax = $itmgtax;
        $this->itemtotal = $itmtotal;
        $this->itemrenewfreq = $itmrenewfreq;
        $this->itemdescription = $itmdescription;
        $this->itemnotes = $itmnotes;
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE CLIENT SET itemname = ?, cartitemid = ?, billdate = ?, itemqty = ?, " . 
                       "itemrate = ?, itemdiscount = ?, itemstax = ?, itemgtax = ?, itemtotal = ?, itemrenewfreq = ?, " .
                       "itemdescription = ?, itemnotes = ? WHERE itemid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssssssssssss", $this->itemname,  $this->cartitemid, $this->billdate, $this->itemqty,
                $this->itemrate,$this->itemdiscount, $this->itemstax, $this->itemgtax, $this->itemtotal, $this->itemrenewfreq,
                $this->itemdescription,$this->itemnotes, $this->itemid);
                $result = $query->execute();
            }
            $conn->close();        
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
                $sql = "INSERT INTO BILLITEM (itemid, itemname, cartitemid, billdate, itemqty, " . 
                       "itemrate, itemdiscount, itemstax, itemgtax, itemtotal, itemrenewfreq, " .
                       "itemdescription, itemnotes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssssssssssss", $this->itemid, $this->itemname,  $this->cartitemid, $this->billdate, 
                $this->itemqty, $this->itemrate,$this->itemdiscount, $this->itemstax, $this->itemgtax, $this->itemtotal, 
                $this->itemrenewfreq, $this->itemdescription,$this->itemnotes);
                $result = $query->execute();
            }
            $conn->close();        
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

                
    }
    
    function RemoveEntity() {
        if($conn != NULL) {
            
        }
    }
    public function Save() {
        $cart = BillItem::GetBillItembyID($this->itemid);
        if($cart == NULL) {
            $this->AddEntity();
        } else {
            $this->UpdateData();
        }
        
       
    }
    public static function GetBillItembyID($billid) {
        try {
            $conn = DataAccess::connect();
            $bill = null;
            if($conn != NULL) {
                $sql = "SELECT itemid, itemname, cartitemid, billdate, itemqty, " . 
                       "itemrate, itemdiscount, itemstax, itemgtax, itemtotal, itemrenewfreq, " .
                       "itemdescription, itemnotes FROM BILLITEM WHERE itemid='".$billid."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $bill = new BillItem($row["itemid"],$row["itemname"],$row["cartitemid"],$row["billdate"],$row["itemqty"],
                                             $row["itemrate"],$row["itemdiscount"],$row["itemstax"],$row["itemgtax"],$row["itemtotal"],
                                             $row["itemrenewfreq"],$row["itemdescription"], $row["itemnotes"]);
                }
            }
            $conn->close();

            return $bill;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetBillbyCartItem($cartitem) {
        try {
            $bills = array();
            $conn = DataAccess::connect();
            $bill = null;
            if($conn != NULL) {
                $sql = "SELECT itemid, itemname, cartitemid, billdate, itemqty, " . 
                       "itemrate, itemdiscount, itemstax, itemgtax, itemtotal, itemrenewfreq, " .
                       "itemdescription, itemnotes FROM BILLITEM WHERE cartitemid='".$cartitem."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $bill = new BillItem($row["itemid"],$row["itemname"],$row["cartitemid"],$row["billdate"],$row["itemqty"],
                                             $row["itemrate"],$row["itemdiscount"],$row["itemstax"],$row["itemgtax"],$row["itemtotal"],
                                             $row["itemrenewfreq"],$row["itemdescription"], $row["itemnotes"]);
                            array_push($bills, $bill);
                        }
                }
            }
            $conn->close();

            return $bills;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
}
