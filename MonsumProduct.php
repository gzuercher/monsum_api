<?php
/*
 * Monsum API Wrapper
 * Licensed under the MIT License (MIT)
 */

class MonsumProduct
{
    protected $api_obj = null;
    protected $art_data = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

    public function loadProductFromData($arr) {
        $this->art_data = $arr;
    }

    public function loadProductByID($artid) {
        $this->art_data = null;
        $query = array("SERVICE" => "article.get",
                       "FILTER" => array("ARTICLE_NUMBER" => $artid),
                       "LIMIT" => 1);

        if($this->api_obj->api_call($query, true))
            $this->art_data = $this->api_obj->get_data()->ARTICLES[0];
    }
    
    public function dump() {
        if(isset($this->art_data))
            print_r($this->art_data);
    }

    public function getID() {
        return (isset($this->art_data) ? $this->art_data->ARTICLE_ID : "");
    }

    public function getNumber() {
        return (isset($this->art_data) ? $this->art_data->ARTICLE_NUMBER : "");
    }

    public function getTitle() {
        return (isset($this->art_data) ? $this->art_data->TITLE : "");
    }

    public function getDescription() {
        return (isset($this->art_data) ? $this->art_data->DESCRIPTION : "");
    }

    public function getTags() {
        return (isset($this->art_data) ? $this->art_data->TAGS : "");
    }

    public function isGross() {
        if(isset($this->art_data->IS_ADDON) && $this->art_data->IS_GROSS == 1)
            return true;
        return false;
    }

    public function getUnitPrice() {
        return (isset($this->art_data) ? $this->art_data->UNIT_PRICE : "");
    }

    public function getSetupFee() {
        return (isset($this->art_data) ? $this->art_data->SETUP_FEE : "");
    }

    public function allowMultiple() {
        if(isset($this->art_data->ALLOW_MULTIPLE) && $this->art_data->ALLOW_MULTIPLE == 1)
            return true;
        return false;        
    }

    public function getCurrencyCode() {
        return (isset($this->art_data) ? $this->art_data->CURRENCY_CODE : "");
    }

    public function isDigital() {
        if(isset($this->art_data->IS_DIGITAL) && $this->art_data->IS_DIGITAL == 1)
            return true;
        return false;
    }

    public function getVATPercent() {
        return (isset($this->art_data) ? $this->art_data->VAT_PERCENT : "");
    }

    public function getSubscriptionInterval() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_INTERVAL : "");
    }

    public function getSubscriptionNumberEvents() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_NUMBER_EVENTS : "");
    }

    public function getSubscriptionTrial() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_TRIAL : "");
    }

    public function getSubscriptionDuration() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_DURATION : "");
    }

    public function getSubscriptionDurationFollow() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_DURATION_FOLLOW : "");
    }

    public function getSubscriptionCancellation() {
        return (isset($this->art_data) ? $this->art_data->SUBSCRIPTION_CANCELLATION : "");
    }

    public function isAddon() {
        if(isset($this->art_data->IS_ADDON) && $this->art_data->IS_ADDON == 1)
            return true;
        return false;
    }

    public function getAddons() {
        // return a list of Addon Objects
    }

}

?>