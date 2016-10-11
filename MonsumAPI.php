<?php

include_once("MonsumAPIConfig.php");
if(!defined("MONSUM_API_TIMEZONE"))
    die("Configuration not found.\n");

date_default_timezone_set(MONSUM_API_TIMEZONE);

class MonsumAPI 
{
    private $api_response = null;
    private $api_errors = null;
    protected $api_data = null;

    protected function log($msg) {
        error_log(date(DATE_RFC822) . " " . $msg, 3, MONSUM_API_LOGFILE);
    }

    protected function api_call($query, $cache = false)
    {
        if(!isset($query))
            return false;

        // make sure there is no data from previous call
        $this->api_response = null;
        $this->api_errors = null;
        $this->api_data = null;

        $sjson = json_encode($query);
        $sjson_hash = md5($sjson);
        $cache_file = $this->cache_filename($sjson_hash);
        $cache_hit = false;

        if(MONSUM_API_CACHE && $cache && file_exists($cache_file)) {
            if(time()-filemtime($cache_file) < MONSUM_API_CACHE_AGE) {
                $this->api_response = unserialize(file_get_contents($cache_file));
                $cache_hit = true;
            }
        }
        
        if(!$cache_hit) {
            $this->api_response = \Httpful\Request::post(MONSUM_API_URL)
            ->authenticateWith(MONSUM_API_EMAIL, MONSUM_API_KEY)
            ->sendsJson()
            ->body($sjson)
            ->expectsJson()
            ->send();
        }

        if(MONSUM_API_DEBUG) {
            $this->log("DEBUG: api_call(): JSON: " . $sjson . "\n");
            if($cache_hit)
                $this->log("\t\t\tCACHE HIT: " . $sjson_hash . "\n");
        }

        if($this->api_response->hasErrors()) {
            $this->log("ERROR: HTTP_CODE: " . strval($this->api_response));
            return false;
        }

        if($this->api_response->hasBody()) {
            $this->api_errors = $this->api_response->body->ERRORS;
            $this->api_data = $this->api_response->body->RESPONSE;

            if(MONSUM_API_CACHE) {
                file_put_contents($cache_file, serialize($this->api_response));
            }
            return true;
        }

        return false;
    }

    private function cache_filename($json_hash) {
        return MONSUM_API_CACHE_DIR . "/" . $json_hash . ".cache";
    }

    public function has_data() {
        return isset($this->api_data);
    }

    public function log_response() {
        $this->log("DUMP_RESPONSE: \n" . print_r($this->api_response, true));
    }

    public function log_errors() {
        $this->log("DUMP_ERRORS: \n" . print_r($this->api_errors, true));
    }

    public function log_data() {
        $this->log("DUMP_DATA: \n" . print_r($this->api_data, true));
    }

}

include "MonsumCustomer.php";
include "MonsumProduct.php";
include "MonsumAddon.php";
include "MonsumSubscription.php";
include "MonsumInvoice.php";

//include "MonsumCustomers.php";
include "MonsumProducts.php";
//include "MonsumAddons.php";
include "MonsumSubscriptions.php";
//include "MonsumInvoices.php";

?>