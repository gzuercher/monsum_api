<?php

class MonsumSubscription
{
    protected $api_obj = null;
    protected $sub_data = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

    public function loadSubscriptionFromData($arr) {
        $this->sub_data = $arr;
    }

    public function loadSubscriptionByID($subid) {
        $this->sub_data = null;
        $query = array("SERVICE" => "subscription.get",
                       "FILTER" => array("SUBSCRIPTION_ID" => $subid),
                       "LIMIT" => 1);

        if($this->api_obj->api_call($query, true))
            $this->sub_data = $this->api_obj->get_data()->SUBSCRIPTIONS[0];
    }

    public function dump() {
        if(isset($this->sub_data))
            print_r($this->sub_data);
    }

    public function getID() {
        return (isset($this->sub_data) ? $this->sub_data->SUBSCRIPTION_ID : "");
    }

    public function getTitle() {
        return (isset($this->sub_data) ? $this->sub_data->SUBSCRIPTION_TITLE : "");
    }

    public function getStart() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->START) : "");
    }

    public function getLastEvent() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->LAST_EVENT) : "");
    }

    public function getNextEvent() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->NEXT_EVENT) : "");
    }

    public function getCancellation() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->CANCELLATION_DATE) : "");
    }

    public function getExpiration() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->EXPIRATION_DATE) : "");
    }

    public function getStatus() {
        return (isset($this->sub_data) ? $this->sub_data->STATUS : "");
    }

    public function isActive() {
        if(isset($this->sub_data) && $this->sub_data->STATUS == "active")
            return true;
        return false;
    }

    public function getProductNumber() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->ARTICLE_NUMBER : "");
    }

    public function getProductTitle() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->TITLE : "");
    }

    public function getProductUnitPrice() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->UNIT_PRICE : "");
    }

    public function getProductVATPercent() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->VAT_PERCENT : "");
    }

    public function getProductDescription() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->DESCRIPTION : "");
    }

    public function getQuantity() {
        return (isset($this->sub_data) ? $this->sub_data->PLAN->QUANTITY : "");
    }

    public function getCancellationNote() {
        return (isset($this->sub_data) ? $this->sub_data->CANCELLATION_NOTE : "");
    }

    public function getAddons() {
        // IMPLEMENTATION MISSING
    }

}

?>