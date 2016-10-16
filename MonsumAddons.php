<?php
/*
 * Monsum API Wrapper
 * Licensed under the MIT License (MIT)
 */

class MonsumAddons implements Iterator
{
    protected $api_obj;
    protected $api_limit;
    protected $api_offset;

    protected $data;

    public function __construct($api_obj, $api_limit=100) {
        $this->art_id = $art_id;
        $this->api_obj = $api_obj;
        $this->api_limit = $api_limit;
    }

    public function rewind() {
        $this->api_offset = 0;
        $this->data = null;
        $this->load();
    }

    public function current() {
        $obj = new MonsumAddon($api_obj);
        $obj->loadAddonFromData($this->data[0]);
        return $obj;
    }

    public function key() {
        return $this->data[0]->ARTICLE_NUMBER;
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

        $query = array("SERVICE" => "addon.get",
                       "LIMIT" => $this->api_limit,
                       "OFFSET" => $this->api_offset);

        if($this->api_obj->api_call($query, true)) {
            $this->data = $this->api_obj->get_data()->ADDONS;
            
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