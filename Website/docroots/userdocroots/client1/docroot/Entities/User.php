<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author bishwaroop.mukherjee
 */
class User implements EntityBase {
    //put your code here
    public $userid;
    public $userpasswd;
    public $usermail;
    public $userfirstname;
    public $userlastname;
    public $userbilladdressl1;
    public $userbilladdressl2;
    public $usercity;
    public $userzipcode;
    public $userstate;
    public $usercountry;
    public $userphone1;
    public $ismailverified;
    public $isphoneverified;
    public $useruniqueid;
    public $useruniqueidtype;
    
    function __construct($uid,$upwd,$umail,$ufname,$ulname,$ubladdl1,$ubladdl2,$ucity,$uzipcd,$ustate,$ucntry,$uphone,$uuniqueidtype, $uuniqueid){
        $this->userid = $uid;
        $this->userpasswd = $upwd;
        $this->usermail = $umail;
        $this->userfirstname = $ufname;
        $this->userlastname = $ulname;
        $this->userbilladdressl1 = $ubladdl1;
        $this->userbilladdressl2 = $ubladdl2;
        $this->usercity = $ucity;
        $this->userzipcode = $uzipcd;
        $this->userstate = $ustate;
        $this->usercountry = $ucntry;
        $this->userphone1 = $uphone;
        $this->useruniqueid = $uuniqueid;
        $this->ismailverified = FALSE;
        $this->isphoneverified = FALSE;
        $this->useruniqueidtype = $uuniqueidtype;
    }
            
    function UpdateData() {
        if($conn != NULL) {
            
        }
    }
    
    function AddEntity() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "INSERT INTO USER (userid, userpasswd, usermail, userfirstname, userlastname, " . 
                       "userbilladdressl1, userbilladdressl2, usercity, userzipcode, userstate, usercountry, " .
                       "userphone1, useruniqueidtype, useruniqueid, ismailverified, isphoneverified) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("ssssssssssssssss",$this->userid, $this->userpasswd,  $this->usermail, $this->userfirstname, $this->userlastname,
                $this->userbilladdressl1,$this->userbilladdressl2, $this->usercity, $this->userzipcode, $this->userstate, $this->usercountry,
                $this->userphone1, $this->useruniqueidtype, $this->useruniqueid, $this->ismailverified, $this->isphoneverified);
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
    
    public static function GetUserbyID($userid) {
        try {
            $conn = DataAccess::connect();
            $usr = null;
            if($conn != NULL) {
                $sql = "SELECT userid, userpasswd, usermail, userfirstname, userlastname, " . 
                       "userbilladdressl1, userbilladdressl2, usercity, userzipcode, userstate, usercountry, " .
                       "userphone1, useruniqueidtype, useruniqueid, ismailverified, isphoneverified FROM USER WHERE userid='".$userid."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $usr = new User($row["userid"],$row["userpasswd"],$row["usermail"],$row["userfirstname"],$row["userlastname"],
                                        $row["userbilladdressl1"],$row["userbilladdressl2"],$row["usercity"],$row["userzipcode"],$row["userstate"],$row["usercountry"],
                                        $row["userphone1"], $row["useruniqueidtype"], $row["useruniqueid"]);
                }
            }
            $conn->close();

            return $usr;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetUserbyEMail($email) {
        try {
            $conn = DataAccess::connect();
            $usr = null;
            if($conn != NULL) {
                $sql = "SELECT userid, userpasswd, usermail, userfirstname, userlastname, " . 
                       "userbilladdressl1, userbilladdressl2, usercity, userzipcode, userstate, usercountry, " .
                       "userphone1, useruniqueidtype, useruniqueid, ismailverified, isphoneverified FROM USER WHERE WHERE usermail='".$email."'";
                $result = $conn->query($sql);

                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $usr = new User($row["userid"],$row["userpasswd"],$row["usermail"],$row["userfirstname"],$row["userlastname"],
                                        $row["userbilladdressl1"],$row["userbilladdressl2"],$row["usercity"],$row["userzipcode"],$row["userstate"],$row["usercountry"],
                                        $row["userphone1"], $row["useruniqueidtype"],$row["useruniqueid"]);
                }
            }
            $conn->close();

            return $usr;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
}
