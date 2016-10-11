<?php

class MonsumProducts extends MonsumAPI
{
    protected $art_list = null;

    public function __construct() {
    }

    public function loadAllProducts() {
        $this->art_list = null;
        $query = array("SERVICE" => "article.get",
                       "FILTER" => array(),
                       "LIMIT" => MONSUM_API_MAX_LIMIT,
                       "OFFSET" => 0);

        $this->api_call($query, true);

        $this->dump_data();
        print "PRODUCTS: ". strval(count($this->api_data->ARTICLES)) . "\n";
    }

}

?>