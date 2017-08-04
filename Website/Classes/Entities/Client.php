<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author bishwaroop.mukherjee
 */
class Client {
    public $clientid;
    public $clientname;
    public $clientcontactnumber1;
    public $clientcontactnumber2;
    public $clientaddressline1;
    public $clientaddressline2;
    public $clientaddressline3;
    public $clientcity;
    public $clientzipcode;
    public $clientmailaddress;
    public $clientmainURL;
    public $clientnumofservices;
    public $userid;
    
    public function __construct($cid, $cname, $ccnumber1, $ccnumber2, $caddl1, $caddl2, $caddl3, $ccity, $czipcd, $cmailadd, $cmainURL, $cnumserv, $cusrid) {
        $this->clientid = $cid;
        $this->clientname = $cname;
        $this->clientcontactnumber1 = $ccnumber1;
        $this->clientcontactnumber2 = $ccnumber2;
        $this->clientaddressline1 = $caddl1;
        $this->clientaddressline2 = $caddl2;
        $this->clientaddressline3 = $caddl3;
        $this->clientcity = $ccity;
        $this->clientzipcode = $czipcd;
        $this->clientmailaddress = $cmailadd;
        $this->clientmainURL = $cmainURL;
        $this->clientnumofservices = $cnumserv;
        $this->userid = $cusrid;
    }
            
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE CLIENT SET clientname = ?, clientcontactnumber1 = ?, clientcontactnumber2 = ?, clientaddressline1 = ?, " . 
                       "clientaddressline2 = ?, clientaddressline3 = ?, clientcity = ?, clientzipcode = ?, clientmailaddress = ?, clientmainURL = ?, " .
                       "clientnumofservices = ? WHERE clientid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("ssssssssssss", $this->clientname,  $this->clientcontactnumber1, $this->clientcontactnumber2, $this->clientaddressline1,
                $this->clientaddressline2,$this->clientaddressline3, $this->clientcity, $this->clientzipcode, $this->clientmailaddress, $this->clientmainURL,
                $this->clientnumofservices, $this->clientid);
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
                $sql = "INSERT INTO CLIENT (clientid, clientname, clientcontactnumber1, clientcontactnumber2, clientaddressline1, " . 
                       "clientaddressline2, clientaddressline3, clientcity, clientzipcode, clientmailaddress, clientmainURL, " .
                       "clientnumofservices, userid) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssssssssssss",$this->clientid, $this->clientname,  $this->clientcontactnumber1, $this->clientcontactnumber2, $this->clientaddressline1,
                $this->clientaddressline2,$this->clientaddressline3, $this->clientcity, $this->clientzipcode, $this->clientmailaddress, $this->clientmainURL,
                $this->clientnumofservices, $this->userid);
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
    public static function GetClientbyID($client) {
        try {
            $conn = DataAccess::connect();
            $clnt = null;
            if($conn != NULL) {
                $sql = "SELECT clientid, clientname, clientcontactnumber1, clientcontactnumber2, clientaddressline1, " . 
                       "clientaddressline2, clientaddressline3, clientcity, clientzipcode, clientmailaddress, clientmainURL, " .
                       "clientnumofservices, userid FROM CLIENT WHERE clientid='".$client."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $clnt = new Client($row["clientid"],$row["clientname"],$row["clientcontactnumber1"],$row["clientcontactnumber2"],$row["clientaddressline1"],
                                        $row["clientaddressline2"],$row["clientaddressline3"],$row["clientcity"],$row["clientzipcode"],$row["clientmailaddress"],$row["clientmainURL"],
                                        $row["clientnumofservices"], $row["userid"]);
                }
            }
            $conn->close();

            return $clnt;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    
    public static function GetAllClients() {
        try {
            $clients = array();
            $conn = DataAccess::connect();
            $clnt = null;
            if($conn != NULL) {
                $sql = "SELECT clientid, clientname, clientcontactnumber1, clientcontactnumber2, clientaddressline1, " . 
                       "clientaddressline2, clientaddressline3, clientcity, clientzipcode, clientmailaddress, clientmainURL, " .
                       "clientnumofservices, userid FROM CLIENT";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                        $clnt = new Client($row["clientid"],$row["clientname"],$row["clientcontactnumber1"],$row["clientcontactnumber2"],$row["clientaddressline1"],
                                    $row["clientaddressline2"],$row["clientaddressline3"],$row["clientcity"],$row["clientzipcode"],$row["clientmailaddress"],$row["clientmainURL"],
                                    $row["clientnumofservices"], $row["userid"]);
                        array_push($clients, $clnt);
                    }
                }
            }
            $conn->close();

            return $clients;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public static function GetClientbyUser($user) {
        try {
            $clients = array();
            $conn = DataAccess::connect();
            $clnt = null;
            if($conn != NULL) {
                $sql = "SELECT clientid, clientname, clientcontactnumber1, clientcontactnumber2, clientaddressline1, " . 
                       "clientaddressline2, clientaddressline3, clientcity, clientzipcode, clientmailaddress, clientmainURL, " .
                       "clientnumofservices, userid FROM CLIENT WHERE userid='".$user->userid."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $clnt = new Client($row["clientid"],$row["clientname"],$row["clientcontactnumber1"],$row["clientcontactnumber2"],$row["clientaddressline1"],
                                        $row["clientaddressline2"],$row["clientaddressline3"],$row["clientcity"],$row["clientzipcode"],$row["clientmailaddress"],$row["clientmainURL"],
                                        $row["clientnumofservices"], $row["userid"]);
                            array_push($clients, $clnt);
                        }
                }
            }
            $conn->close();

            return $clients;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }

}
