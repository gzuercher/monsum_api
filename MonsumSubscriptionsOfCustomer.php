<?php

class MonsumSubscriptionsOfCustomer implements Iterator
{
    protected $api_obj = null;
    protected $cst_id = null;
    protected $offset;
    protected $current;

    public function __construct($api_obj, $cst_id) {
        $this->api_obj = $api_obj;
        $this->cst_id = $cst_id;
    }

    private function load() {
        $this->current = null;
        $query = array("SERVICE" => "subscription.get",
                       "FILTER" => array("CUSTOMER_ID" => $this->cst_id),
                       "LIMIT" => 1,
                       "OFFSET" => $this->offset);

        if($this->api_obj->api_call($query, true))
            $this->current = $this->api_obj->get_data()->SUBSCRIPTIONS[0];
    }

    public function rewind() {
        $this->offset = 0;
        $this->load();
    }

    public function current() {
        $obj = new MonsumSubscription($this->api_obj);
        $obj->loadSubscriptionFromIterator($this->current);
        return $obj;
    }

    public function key() {
        return $this->current->SUBSCRIPTION_ID;
    }

    public function next() {
        $this->offset++;
        $this->load();
  }

    public function valid() {
        return isset($this->current);
    }

}

?>