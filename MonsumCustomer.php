<?php

class MonsumCustomer
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

    public function dump() {
        if(isset($this->cst_data))
            print_r($this->cst_data);
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

    public function getDaysForPayment() {
        return (isset($this->cst_data) ? $this->cst_data->DAYS_FOR_PAYMENT : "");
    }

    public function getCreated() {
        return (isset($this->sub_data) ? strtotime($this->cst_data->CREATED) : "");
    }

    public function getCustomerType() {
        return (isset($this->cst_data) ? $this->cst_data->CUSTOMER_TYPE : "");
    }

    public function getCreditBalance() {
        return (isset($this->cst_data) ? $this->cst_data->CREDIT_BALANCE : "");
    }

    public function getInvoiceDeliveryMethod() {
        return (isset($this->cst_data) ? $this->cst_data->INVOICE_DELIVERY_METHOD : "");
    }
}

?>