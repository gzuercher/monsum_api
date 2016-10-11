<?php

class MonsumProduct extends MonsumAPI
{
    protected $art_data = null;

    public function __construct() {
    }

    public function loadProductByID($artid) {
        $this->art_data = null;
        $query = array("SERVICE" => "article.get",
                       "FILTER" => array("ARTICLE_NUMBER" => $artid),
                       "LIMIT" => 1);

        if($this->api_call($query, true))
            $this->art_data = $this->api_data->ARTICLES[0];
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

    public function isAddon() {
        if(isset($this->art_data->IS_ADDON) && $this->art_data->IS_ADDON == 1)
            return true;
        return false;
    }

}

?>