<?php

class MonsumAddon extends MonsumAPI
{
    protected $ado_data = null;

    public function __construct() {
    }

    public function loadAddonByID($addonid = "") {
        $this->ado_data = null;
        $query = array("SERVICE" => "addon.get",
                       "FILTER" => array("ARTICLE_NUMBER" => $addonid),
                       "LIMIT" => 1);

        if($this->api_call($query, true))
            $this->ado_data = $this->api_data->ADDONS[0];
    }

    public function getNumber() {
        return (isset($this->ado_data) ? $this->ado_data->ARTICLE_NUMBER : "");
    }

    public function getTitle() {
        return (isset($this->ado_data) ? $this->ado_data->TITLE : "");
    }

    public function getDescription() {
        return (isset($this->ado_data) ? $this->ado_data->DESCRIPTION : "");
    }

    public function getUnitPrice() {
        return (isset($this->ado_data) ? $this->ado_data->UNIT_PRICE : "");
    }

    public function getSetupFee() {
        return (isset($this->ado_data) ? $this->ado_data->SETUP_FEE : "");
    }

    public function allowMultiple() {
        if(isset($this->ado_data->ALLOW_MULTIPLE) && $this->ado_data->ALLOW_MULTIPLE == 1)
            return true;
        return false;        
    }

    public function isDigital() {
        if(isset($this->ado_data->IS_DIGITAL) && $this->ado_data->IS_DIGITAL == 1)
            return true;
        return false;
    }

}

?>