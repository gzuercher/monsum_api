<?php

class MonsumSubscriptions extends MonsumAPI
{
    protected $api_obj = null;§
    protected $sub_list = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

    public function loadAllSubscriptions() {
        $this->sub_list = null;

        $offset = 0;
        while(true) {
            $query = array("SERVICE" => "subscription.get",
                           "FILTER" => array(),
                           "LIMIT" => MONSUM_API_MAX_LIMIT,
                           "OFFSET" => $offset);

            $this->api_call($query, true);
            

            $offset = $offset + MONSUM_API_MAX_LIMIT;
        }

        print "SUBSCRIPTIONS: ". strval(count($this->sub_list)) . "\n";
    }

}

?>