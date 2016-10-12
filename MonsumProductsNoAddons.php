<?php

class MonsumProductsNoAddons extends MonsumProducts implements Iterator
{
    public function next() {
        array_shift($this->data);

        while($this->data[0]->IS_ADDON)
            array_shift($this->data);
        
        if(count($this->data) == 0)
            $this->load();
    }

}

?>