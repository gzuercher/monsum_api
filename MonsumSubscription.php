<?php

class MonsumSubscription extends MonsumAPI
{
    protected $sub_data = null;

    public function __construct() {
    }

    public function loadSubscriptionByID($subid) {
        $this->sub_data = null;
        $query = array("SERVICE" => "subscription.get",
                       "FILTER" => array("SUBSCRIPTION_ID" => $invid),
                       "LIMIT" => 1);

        if($this->api_call($query, true))
            $this->sub_data = $this->api_data->SUBSCRIPTIONS[0];
    }

    public function getID() {
        return (isset($this->sub_data) ? $this->sub_data->SUBSCRIPTION_ID : "");
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

    public function getProductID() {
        return (isset($this->sub_data) ? $this->sub_data->ARTICLE_ID : "");
    }

    public function getProductNumber() {
        return (isset($this->sub_data) ? $this->sub_data->ARTICLE_NUMBER : "");
    }

    public function getQuantity() {
        return (isset($this->sub_data) ? $this->sub_data->QUANTITY : "");
    }

}

?>