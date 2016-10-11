<?php

class MonsumCustomer extends MonsumAPI
{
    protected $api_obj = null;
    protected $cst_data = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

    public function loadCustomerByID($cstid = "") {
        $this->cst_data = null;
        $query = array("SERVICE" => "customer.get",
                       "FILTER" => array("CUSTOMER_ID" => $cstid),
                       "LIMIT" => 1);

        if($this->api_obj->api_call($query, true))
            $this->cst_data = $this->api_obj->get_data()->CUSTOMERS[0];
    }

    public function getID() {
        return (isset($this->cst_data) ? $this->cst_data->CUSTOMER_ID : "");
    }

    public function getNumber() {
        return (isset($this->cst_data) ? $this->cst_data->CUSTOMER_NUMBER : "");
    }

    public function getOrganization() {
        return (isset($this->cst_data) ? $this->cst_data->ORGANIZATION : "");
    }

    public function getFirstname() {
        return (isset($this->cst_data) ? $this->cst_data->FIRST_NAME : "");
    }

    public function getLastname() {
        return (isset($this->cst_data) ? $this->cst_data->LAST_NAME : "");
    }

    public function getCity() {
        return (isset($this->cst_data) ? $this->cst_data->CITY : "");
    }

    public function getEMail() {
        return (isset($this->cst_data) ? $this->cst_data->EMAIL : "");
    }

}

?>