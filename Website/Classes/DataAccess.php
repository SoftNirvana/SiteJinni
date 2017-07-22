<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataAccess
 *
 * @author bishwaroop.mukherjee
 */
class DataAccess {
    private static $conn = NULL;
    //put your code here
    public static function connect(){
        //SoftNirvana
        //$servername = "182.50.133.84";
        //$username = "bishwaroopm";
        //$password = "Soft.Nirvana@1";
        //$port = "3306";
        //$dbname = "CMSDBMAIN";
        
        //SiteJinni
        $servername = "localhost";
        $username = "iamjinni_service";
        $password = "SN.sitejinni@1";
        $port = "3306";
        $dbname = "iamjinni_CMSDBMAIN";

        //Dev
        //$servername = "localhost";
        //$username = "root";
        //$password = "";
        //$port = "3306";
        //$dbname = "CMSDBMAIN";
        
        DataAccess::$conn = new mysqli($servername, $username, $password, $dbname, $port, "");

                
        if (DataAccess::$conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        return DataAccess::$conn;
    }
    
    public static function savedatawithquery($query)
    {
        if(DataAccess::$conn != NULL)
        {
            DataAccess::$conn->query($query);
        }
    }      
    public static function getdatabyquery($query)
    {
        $result = NULL;
        DataAccess::connect();
        if(DataAccess::$conn != NULL)
        {
            $result = DataAccess::$conn->query($query);
        }
        DataAccess::close();
        return $result;
    }      

    public static function close() {
        if(DataAccess::$conn !=  NULL)
            DataAccess::$conn->close();
    }
}
