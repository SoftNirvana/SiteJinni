<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServiceType
 *
 * @author bishwaroop.mukherjee
 */
class ServiceType{
    public $servicetypeid;
    public $servicetypename;
    public $description;
    public $pricetag;
    public $url;
    public function __construct($servtypeid, $servname, $desc, $price, $servurl) {
        $this->servicetypeid = $servtypeid;
        $this->servicetypename = $servname;
        $this->description = $desc;
        $this->pricetag = $price;
        $this->url = $servurl;
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE SERVICETYPE SET servicetypename = ?, description = ?, pricetag = ?, url = ? " . 
                       "WHERE servicetypeid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssss", $this->servicetypename,  $this->description, $this->pricetag, $this->url, $this->servicetypeid);
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
                $sql = "INSERT INTO SERVICETYPE (servicetypeid, servicetypename, description, pricetag, url) VALUES (?,?,?,?,?)";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssss", $this->servicetypeid, $this->servicetypename,  $this->description, $this->pricetag, $this->url);
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
    public static function GetServiceTypebyID($servid) {
        try {
            $conn = DataAccess::connect();
            $srvtp = null;
            if($conn != NULL) {
                $sql = "SELECT servicetypeid, servicetypename, description, " . 
                       "pricetag, url FROM SERVICETYPE WHERE servicetypeid='".$servid."'";
               
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                        $row = $result->fetch_assoc();

                        $srvtp = new ServiceType($row["servicetypeid"],$row["servicetypename"],
                                                 $row["description"], $row["pricetag"],$row["url"]);
                }
            }
            $conn->close();
            
            return $srvtp;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();            
        }

    }
    public static function GetAllServiceTypes() {
        try {
            $srvtps = array();
            $conn = DataAccess::connect();
            $srvtp = null;
            if($conn != NULL) {
                $sql = "SELECT servicetypeid, servicetypename, description, pricetag, url FROM SERVICETYPE";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $srvtp = new ServiceType($row["servicetypeid"],$row["servicetypename"],$row["description"],$row["pricetag"],$row["url"]);
                            array_push($srvtps, $srvtp);
                        }
                }
            }
            $conn->close();

            return $srvtps;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }

}
