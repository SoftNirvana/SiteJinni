<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FunctionsClass
 *
 * @author bishwaroop.mukherjee
 */
class FunctionsClass {
    //put your code here
    public static function getDemoCode() {
        $key = "bcb04b7e103a0cd81234325431234543";
    
        # show key size use either 16, 24 or 32 byte keys for AES-128, 192
        # and 256 respectively
        $key_size =  strlen($key);
      

        $plaintext = "DEMO_PAGE_PREV_1";

        # create a random IV to use with CBC encoding
        //$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        //$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $iv="SoftNirvana_yolo";
        //$iv = mcrypt_create_iv(16);
        //$iv = substr($iv, 0, 16)
        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential 
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                     $plaintext, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
    
        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);
        $iv_base64 = base64_encode($iv);
        
        return 'str=' . $ciphertext_base64 . '&key=' . $key . '&iv=' . $iv;
    }
    
    public static function recurse_copy($src,$dst) { 
        $dir = opendir($src); 
        if(!file_exists($dst))
            @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' ) && ($file != 'header_data.json')) { 
                if ( is_dir($src . '/' . $file) ) { 
                    FunctionsClass::recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    } 
    
    public static function clean_docroot($dir) { 
        if(!file_exists($dir))
            return;
        $dir = opendir($dir); 
        
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' ) && ($file != 'header_data.json') ) { 
                if(file_exists($dir . '/' . $file)) {
                    if ( is_dir($dir . '/' . $file) ) { 
                        FunctionsClass::clean_docroot($dir . '/' . $file);
                        rmdir($dir . '/' . $file) ;
                    } 
                    else { 
                        unlink($dir . '/' . $file);
                    } 
                }
            } 
        } 
        closedir($dir); 
    } 
    
    public static function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }
          
    public static function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        try {
            $response = curl_exec($curl);
            var_dump($response);
            curl_close($curl);
            return $response;    
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return FALSE;
        }
    }
}
