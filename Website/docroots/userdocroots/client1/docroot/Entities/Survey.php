<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Survey
 *
 * @author bishwaroop.mukherjee
 */
class Survey{
    public $Id;
    public $personname;
    public $personplace;
    public $professionField;
    public $industryField;
    public $doescreate;
    public $creativetypeField;
    public $localreach;
    public $cityreach;
    public $statereach;
    public $nationalreach;
    public $globalreach;
    public $globalreachTypeField;
    public $needwebsite;
    public $wantsmicrosite;
    public $wantsfullwebsite ;
    public $subdomain;
    public $fulldomain ;
    public $diy;
    public $diywithtraining;
    public $webdesigner;
    public $nodiy ;
    public $nodigimart  ;
    public $digimart  ;
    public $nomarketing  ;
    public $wantads  ;
    public $wantthemedtemplates ;
    public $norecommend ;
    public $willrecommendfree ;
    public $willrecommendall ;
    public $willrecommendforreturn ;
    public $cantsay ;
    public $noadonpage ;
    public $adonpagefree ;
    public $adonpagediscount ;
    public $adonpageprofit ;
    public $adonpagead ;
    public $adonpagespace ;
    public $adonpagedisply ;
    public $adonpageok ;
    public $suggestions;
    
    public function __construct($__Id,$__personname,$__personplace,$__professionField,$__industryField,$__doescreate,$__creativetypeField,$__localreach,$__cityreach,$__statereach,$__nationalreach,$__globalreach,$__globalreachTypeField,
                                $__needwebsite,$__wantsmicrosite,$__wantsfullwebsite,$__subdomain,$__fulldomain,$__diy,$__diywithtraining,$__webdesigner,$__nodiy,$__nodigimart ,$__digimart,$__nomarketing,$__wantads,$__wantthemedtemplates, $__norecommend, 			 
                                $__willrecommendfree, $__willrecommendall, $__willrecommendforreturn, $__cantsay,  $__noadonpage,   $__adonpagefree, $__adonpagediscount,  $__adonpageprofit,        
                                $__adonpagead,  $__adonpagespace, $__adonpagedisply,$__adonpageok,$__suggestions){
        $this->Id = $__Id;
        $this->personname = $__personname;
        $this->personplace = $__personplace;
        $this->professionField = $__professionField;
        $this->industryField = $__industryField;
        $this->doescreate = $__doescreate;
        $this->creativetypeField = $__creativetypeField;
        $this->localreach = $__localreach;
        $this->cityreach = $__cityreach;
        $this->statereach = $__statereach;
        $this->nationalreach = $__nationalreach;
        $this->globalreach = $__globalreach;
        $this->globalreachTypeField = $__globalreachTypeField;
        $this->needwebsite = $__needwebsite;
        $this->wantsmicrosite = $__wantsmicrosite;
        $this->wantsfullwebsite = $__wantsfullwebsite;
        $this->subdomain = $__subdomain;
        $this->fulldomain  = $__fulldomain;
        $this->diy = $__diy;
        $this->diywithtraining = $__diywithtraining;
        $this->webdesigner = $__webdesigner;
        $this->nodiy  = $__nodiy;
        $this->nodigimart = $__nodigimart;
        $this->digimart = $__digimart;
        $this->nomarketing = $__nomarketing;
        $this->wantads = $__wantads;
        $this->wantthemedtemplates = $__wantthemedtemplates;
        $this->norecommend = $__norecommend;
        $this->willrecommendfree = $__willrecommendfree;
        $this->willrecommendall = $__willrecommendall;
        $this->willrecommendforreturn  = $__willrecommendforreturn;
        $this->cantsay = $__cantsay;
        $this->noadonpage = $__noadonpage;
        $this->adonpagefree = $__adonpagefree;
        $this->adonpagediscount = $__adonpagediscount;
        $this->adonpageprofit = $__adonpageprofit;
        $this->adonpagead = $__adonpagead;
        $this->adonpagespace = $__adonpagespace;
        $this->adonpagedisply = $__adonpagedisply;
        $this->adonpageok = $__adonpageok;
        $this->suggestions=$__suggestions;
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
                $sql = "INSERT INTO SURVEY ( personname , personplace , professionField , industryField , doescreate ,
                         creativetypeField , localreach , cityreach , statereach , nationalreach , globalreach , globalreachTypeField ,
                         needwebsite , wantsmicrosite , wantsfullwebsite  , subdomain , fulldomain  , diy ,
                         diywithtraining , webdesigner , nodiy ,  nodigimart  ,digimart,  nomarketing, wantads,   wantthemedtemplates, norecommend, 			 
                        willrecommendfree, willrecommendall, willrecommendforreturn, cantsay,  noadonpage,   adonpagefree, adonpagediscount,  adonpageprofit,        
                        adonpagead,  adonpagespace, adonpagedisply,adonpageok,suggestions) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
           
		$query = $conn->prepare($sql);
                $query->bind_param("ssssssssssssssssssssssssssssssssssssssss",$this->personname, $this->personplace, $this->professionField, $this->industryField, $this->doescreate,
                $this->creativetypeField,$this->localreach, $this->cityreach, $this->statereach, $this->nationalreach, $this->globalreach, $this->globalreachTypeField, $this->needwebsite,
                $this->wantsmicrosite, $this->wantsfullwebsite , $this->subdomain, $this->fulldomain , $this->diy, $this->diywithtraining, $this->webdesigner, $this->nodiy, 
                $this->nodigimart ,$this->digimart,  $this->nomarketing, $this->wantads,   $this->wantthemedtemplates, $this->norecommend,  $this->willrecommendfree, 
                $this->willrecommendall, $this->willrecommendforreturn, $this->cantsay,  $this->noadonpage, $this->adonpagefree, $this->adonpagediscount,  $this->adonpageprofit, 
                $this->adonpagead,  $this->adonpagespace, $this->adonpagedisply,$this->adonpageok,$this->suggestions);
                
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
    
    
}