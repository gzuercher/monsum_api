<?php

class MonsumAddonsOfProduct extends MonsumAddons implements Iterator
{
    protected $art_id;

    public function __construct($api_obj, $art_id, $api_limit=100) {
        parent::__construct($api_obj, $api_limit);
        $this->art_id = $art_id;
    }

/* TODO: FINISH THIS. Internal ID instead of external

    public function next() {
        array_shift($this->data);

        print "looking FOR: " . $this->art_id . " IN: " . print_r($this->data[0]->CONNECTED_ARTICLES, true) . "\n";
        while(in_array($this->art_id, $this->data[0]->CONNECTED_ARTICLES)) {
            print "skipping: " . $this->data[0]->ARTICLE_NUMBER . "\n";
            array_shift($this->data);
            die();
        }

        if(count($this->data) == 0)
            $this->load();
    }
*/
}

?>