<?php

class MonsumProducts extends MonsumAPI
{
    protected $api_obj = null;
    protected $art_list = null;

    public function __construct($api_obj) {
        $this->api_obj = $api_obj;
    }

}

?>