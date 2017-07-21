<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service
 *
 * @author bishwaroop.mukherjee
 */
class Service implements EntityBase {
    public $serviceid;
    public $servicetype;
    public $clientid;
    public $servicename;
    public $servicestartdate;
    public $serviceisactive;
    public $servicelastintactdate;
    public $servicelastextactdate;
    public $servicedomain;
    public $serviceissubdomain;
    public $servicedetails;
    public $serviceisfree;
    public $isadallowed;
    
    public function __construct($servid, $servtype, $clid, $servname, $servstdt, $servisactive, $servlastintactdt, 
                                $servlastextactdt, $servdomain, $servissubdomain, $servdetails, $servisfree, $isad) {
        $this->serviceid = $servid;
        $this->servicetype = $servtype;
        $this->clientid = $clid;
        $this->servicename = $servname;
        $this->servicestartdate = $servstdt;
        $this->serviceisactive = $servisactive;
        $this->servicelastintactdate = $servlastintactdt;
        $this->servicelastextactdate = $servlastextactdt;
        $this->servicedomain = $servdomain;
        $this->serviceissubdomain = $servissubdomain;
        $this->servicedetails = $servdetails;
        $this->serviceisfree = $servisfree;
        $this->isadallowed = $isad;
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE SERVICE SET servicetype = ?, clientid = ?, servicename = ?, servicestartdate = ?, " . 
                       "serviceisactive = ?, servicelastintactdate = ?, servicelastextactdate = ?, servicedomain = ?, serviceissubdomain = ?, servicedetails = ?, " .
                       "serviceisfree = ?, isadallowed = ? WHERE serviceid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssssssssssss", $this->servicetype,  $this->clientid, $this->servicename, $this->servicestartdate,
                $this->serviceisactive, $this->servicelastintactdate, $this->servicelastextactdate, $this->servicedomain, $this->serviceissubdomain, $this->servicedetails,
                $this->serviceisfree, $this->isadallowed, $this->serviceid);
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
                $sql = "INSERT INTO SERVICE (serviceid, servicetype, clientid, servicename, servicestartdate, " . 
                       "serviceisactive, servicelastintactdate, servicelastextactdate, servicedomain, serviceissubdomain, servicedetails, " .
                       "serviceisfree, isadallowed) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $query = $conn->prepare($sql);
                $query->bind_param("sssssdsssdsdd",$this->serviceid, $this->servicetype,  $this->clientid, $this->servicename, $this->servicestartdate,
                $this->serviceisactive, $this->servicelastintactdate, $this->servicelastextactdate, $this->servicedomain, $this->serviceissubdomain, $this->servicedetails,
                $this->serviceisfree, $this->isadallowed);
                $result = $query->execute();

                $error = mysqli_error($conn);
                
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
    public static function GetServicebyID($service) {
        try {
            $conn = DataAccess::connect();
            $srvc = null;
            if($conn != NULL) {
                $sql = "SELECT serviceid, servicetype, clientid, servicename, servicestartdate, " . 
                       "serviceisactive, servicelastintactdate, servicelastextactdate, servicedomain, serviceissubdomain, servicedetails, " .
                       "serviceisfree, isadallowed FROM SERVICE WHERE serviceid='".$service."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $srvc = new Service($row["serviceid"],$row["servicetype"],$row["clientid"],$row["servicename"],$row["servicestartdate"],
                                        $row["serviceisactive"],$row["servicelastintactdate"],$row["servicelastextactdate"],$row["servicedomain"],$row["serviceissubdomain"],$row["servicedetails"],
                                        $row["serviceisfree"], $row["isadallowed"]);
                }
            }
            $conn->close();

            return $srvc;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetServicebyClient($client) {
        try {
            $services = array();
            $conn = DataAccess::connect();
            $srvc = null;
            if($conn != NULL) {
                $sql = "SELECT serviceid, servicetype, clientid, servicename, servicestartdate, " . 
                       "serviceisactive, servicelastintactdate, servicelastextactdate, servicedomain, serviceissubdomain, servicedetails, " .
                       "serviceisfree, isadallowed FROM CLIENT WHERE clientid='".$user->client."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $srvc = new Service($row["serviceid"],$row["servicetype"],$row["clientid"],$row["servicename"],$row["servicestartdate"],
                                        $row["serviceisactive"],$row["servicelastintactdate"],$row["servicelastextactdate"],$row["servicedomain"],$row["serviceissubdomain"],$row["servicedetails"],
                                        $row["serviceisfree"], $row["isadallowed"]);
                            array_push($services, $srvc);
                        }
                }
            }
            $conn->close();

            return $services;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }

}
