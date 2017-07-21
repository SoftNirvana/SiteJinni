<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Description of clientAccount
 *
 * @author bishwaroop.mukherjee
 */
class clientAccount {
    //put your code here
    public $clientFirstName;
    public $cientLastName;
    public $clientOrganisation;
    public $clientAddressLine1;
    public $clientAddressLine2;
    public $clientAddressLine3;
    public $clientCity;
    public $clientState;
    public $clientCountry;
    public $clientZipCode;
    public $clientPhone1;
    public $clientPhone2;
    public $clientUniqueID;
    public $clientEncPwd;
    public $clientEncPwdKey;
    public $clientCreationDate;
    public $clientActivationDate;
    public $clientPricePackage;
    public $clientDomain;
    public $clientPaymentDetails;


    public function saveClientAccount() {
        
    }
    public function calculatePrice() {
        
    }
    public function calculateValidity() {
        
    }
    public function calculateDomainValidity() {
        
    }
}
