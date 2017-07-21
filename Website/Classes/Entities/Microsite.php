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
class Microsite{
    public $siteid;
    public $serviceid; 
    public $sitename;
    public $siteurl;
    public $sitetemplate;
    
    public function __construct($sid, $servid, $sname, $surl, $stemplate) {
        $this->siteid = $sid;
        $this->serviceid = $servid;
        $this->sitename = $sname;
        $this->siteurl = $surl;
        $this->sitetemplate = $stemplate;
        
    }
    
    function UpdateData() {
        $result = NULL;
        $query = NULL;
        try {
            $conn = DataAccess::connect();
            if($conn != NULL) {
                $sql = "UPDATE MICROSITE SET serviceid = ?, sitename = ?, siteurl = ?, " . 
                       "sitetemplate = ? WHERE siteid = ?";
 
                $query = $conn->prepare($sql);
                $query->bind_param("sssss",  $this->serviceid, $this->sitename, $this->siteurl,$this->sitetemplate, $this->siteid);
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
                $sql = "INSERT INTO MICROSITE (siteid, serviceid, sitename, siteurl, sitetemplate) VALUES (?,?,?,?,?)";
                $query = $conn->prepare($sql);
                $query->bind_param("sssss", $this->siteid,  $this->serviceid, $this->sitename, $this->siteurl, $this->sitetemplate);
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
    public static function GetSitebyID($sitename) {
        try {
            $conn = DataAccess::connect();
            $site = null;
            if($conn != NULL) {
                $sql = "SELECT siteid, serviceid, sitename, siteurl, sitetemplate FROM MICROSITE WHERE siteid='".$sitename."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {                
                    $row = $result->fetch_assoc();
                    $site = new Microsite($row["siteid"],$row["serviceid"],$row["sitename"],$row["siteurl"],$row["sitetemplate"]);
                }
            }
            $conn->close();

            return $site;            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return NULL;
        }

    }
    public static function GetSitebyURL($url) {
        try {
            $sites = array();
            $conn = DataAccess::connect();
            $site = NULL;
            $retsite = NULL;
            if($conn != NULL) {
                $sql = "SELECT siteid, serviceid, sitename, siteurl, sitetemplate FROM MICROSITE WHERE siteurl='".$url."'";
                $result = $conn->query($sql);
                
                if ($result != NULL && $result->num_rows > 0) {
                // output data of each row
                        while($row = $result->fetch_assoc()) {

                            $site = new Microsite($row["siteid"],$row["serviceid"],$row["sitename"],$row["siteurl"],$row["sitetemplate"]);
                            array_push($sites, $site);
                        }
                }
                if(count($sites)>0)
                    $retsite = $sites[0];
                    
            }
            $conn->close();

            return $retsite;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }

}
