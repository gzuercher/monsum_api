<?php

class MonsumInvoice
{
    protected $api_obj = null;
    protected $inv_data = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

    public function loadSubscriptionFromData($arr) {
        $this->inv_data = $arr;
    }

    public function loadInvoiceByID($invid) {
        $this->inv_data = null;
        $query = array("SERVICE" => "invoice.get",
                       "FILTER" => array("INVOICE_ID" => $invid),
                       "LIMIT" => 1);

        if($this->api_obj->api_call($query, true))
            $this->inv_data = $this->api_obj->get_data()->INVOICES[0];
    }

    public function loadInvoiceByNumber($invno) {
        $this->inv_data = null;
        $query = array("SERVICE" => "invoice.get",
                       "FILTER" => array("INVOICE_NUMBER" => $invno),
                       "LIMIT" => 1);

        if($this->api_obj->api_call($query, true))
            $this->inv_data = $this->api_obj->get_data()->INVOICES[0];
    }

    public function sendByEMail($recipient, $subject, $message) {
        if(!isset($this->inv_data))
            return false;

        $query = array("SERVICE" => "invoice.sendbyemail",
                       "DATA" => array("INVOICE_ID" => $this->getID(),
                                       "RECIPIENT" => array("TO" => $recipient),
                                       "SUBJECT" => $subject,
                                       "MESSAGE" => $message,
                                       "RECEIPT_CONFIRMATION " => 0));
        if($this->api_obj->api_call($query, false)) 
            return $this->api_obj->get_data()->STATUS == "success";

        if(MONSUM_API_DEBUG) {
            $this->log("FAILED: sendByEMail() INVOICE: " . $this->getID() . " RECPIENT: " . $recipient . "\n");
            $this->log_data();
        }
        return false;
    }

    public function dump() {
        if(isset($this->inv_data))
            print_r($this->inv_data);
    }

    public function getID() {
        return (isset($this->inv_data) ? $this->inv_data->INVOICE_ID : "");
    }

    public function getNumber() {
        return (isset($this->inv_data) ? $this->inv_data->INVOICE_NUMBER : "");
    }

    public function getTitle() {
        return (isset($this->inv_data) ? $this->inv_data->INVOICE_TITLE : "");
    }

    public function getCustomerID() {
        return (isset($this->inv_data) ? $this->inv_data->CUSTOMER_ID : "");
    }

    public function getCustomerNumber() {
        return (isset($this->inv_data) ? $this->inv_data->CUSTOMER_NUMBER : "");
    }

    public function getSubscriptionID() {
        return (isset($this->inv_data) ? $this->inv_data->SUBSCRIPTION_ID : "");
    }

    public function getInvoiceCountForSubscription() {
        return (isset($this->inv_data) ? $this->inv_data->SUBSCRIPTION_INVOICE_COUNTER : "");
    }

    public function getPaymentType() {
        return (isset($this->inv_data) ? $this->inv_data->PAYMENT_TYPE : "");
    }

    public function getDaysForPayment() {
        return (isset($this->inv_data) ? $this->inv_data->DAYS_FOR_PAYMENT : "");
    }

    public function getInvoiceDate() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->INVOICE_DATE) : "");
    }

    public function getDueDate() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->DUE_DATE) : "");
    }

    public function getPaidDate() {
        return (isset($this->sub_data) ? strtotime($this->sub_data->PAID_DATE) : "");
    }

    public function getLinkToPDF() {
        return (isset($this->inv_data) ? $this->inv_data->DOCUMENT_URL : "");
    }

    public function isCancelled() {
        if(isset($this->inv_data) && $this->inv_data->IS_CANCELED == 1)
            return true;
        return false;
    }

    public function getItems() {
        // IMPLEMENTATION MISSING
    }
}

?>