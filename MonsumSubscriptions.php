<?php

class MonsumSubscriptions extends MonsumAPI
{
    protected $sub_list = null;

    public function __construct() {
    }

    public function loadAllSubscriptions() {
        $this->sub_list = null;
        $query = array("SERVICE" => "subscription.get",
                       "FILTER" => array(),
                       "LIMIT" => 0,
                       "OFFSET" => 0);

        $this->api_call($query, true);
//        $this->dump_data();
        print "SUBSCRIPTIONS: ". strval(count($this->api_data->SUBSCRIPTIONS)) . "\n";
    }

}

?>