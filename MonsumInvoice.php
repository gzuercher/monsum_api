<?php

class MonsumInvoice extends MonsumAPI
{
    protected $inv_data = null;

    public function __construct() {
    }

    public function loadInvoiceByID($invid) {
        $this->inv_data = null;
        $query = array("SERVICE" => "invoice.get",
                       "FILTER" => array("INVOICE_ID" => $invid),
                       "LIMIT" => 1);

        if($this->api_call($query, true))
            $this->inv_data = $this->api_data->INVOICES[0];
    }

    public function loadInvoiceByNumber($invno) {
        $this->inv_data = null;
        $query = array("SERVICE" => "invoice.get",
                       "FILTER" => array("INVOICE_NUMBER" => $invno),
                       "LIMIT" => 1);

        if($this->api_call($query, true))
            $this->inv_data = $this->api_data->INVOICES[0];
    }

    public function sendByEMail($recipient, $subject, $message) {
        if(!$this->has_data())
            return false;

        $query = array("SERVICE" => "invoice.sendbyemail",
                       "DATA" => array("INVOICE_ID" => $this->getID(),
                                       "RECIPIENT" => $recipient,
                                       "SUBJECT" => $subject,
                                       "MESSAGE" => $message,
                                       "RECEIPT_CONFIRMATION " => 0));
        if($this->api_call($query, false)) 
            return $this->api_data->STATUS == "success";

        if(MONSUM_API_DEBUG) {
            $this->log("FAILED: sendByEMail() INVOICE: " . $this->getID() . " RECPIENT: " . $recipient . "\n");
            $this->log_data();
        }

        return false;
    }

    public function getID() {
        return (isset($this->inv_data) ? $this->inv_data->INVOICE_ID : "");
    }

    public function getNumber() {
        return (isset($this->inv_data) ? $this->inv_data->INVOICE_NUMBER : "");
    }

    public function getLinkToPDF() {
        return (isset($this->inv_data) ? $this->inv_data->DOCUMENT_URL : "");
    }

    public function isCancelled() {
        if(isset($this->inv_data) && $this->inv_data->IS_CANCELED == 1)
            return true;
        return false;
    }
}

?>