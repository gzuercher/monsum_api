<?php
/*
 * Monsum API Wrapper
 * Licensed under the MIT License (MIT)
 */

class MonsumInvoicesOfCustomer implements Iterator
{
    protected $cst_id;
    protected $api_obj;
    protected $api_limit;
    protected $api_offset;

    protected $data;

    public function __construct($api_obj, $cst_id, $api_limit=100) {
        $this->cst_id = $cst_id;
        $this->api_obj = $api_obj;
        $this->api_limit = $api_limit;
    }

    public function rewind() {
        $this->api_offset = 0;
        $this->data = null;
        $this->load();
    }

    public function current() {
        $obj = new MonsumInvoice($api_obj);
        $obj->loadInvoiceFromData($this->data[0]);
        return $obj;
    }

    public function key() {
        return $this->data[0]->INVOICE_ID;
    }

    public function next() {
        array_shift($this->data);
        if(count($this->data) == 0)
            $this->load();
    }

    public function valid() {
        return count($this->data) > 0;
    }

    protected function load() {
        if($this->api_offset == -1)
            return;

        $query = array("SERVICE" => "invoice.get",
                       "FILTER" => array("CUSTOMER_ID" => $this->cst_id),
                       "LIMIT" => $this->api_limit,
                       "OFFSET" => $this->api_offset);

        if($this->api_obj->api_call($query, true)) {
            $this->data = $this->api_obj->get_data()->INVOICES;

            if(count($this->data) == $this->api_limit)
                $this->api_offset = $this->api_offset + count($this->data);
            else
                $this->api_offset = -1;
        }
        else {
            throw new Exception("Cannot load from API. Rewinding.");
            rewind();
        }
    }

}

?>