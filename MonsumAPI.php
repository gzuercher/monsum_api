<?php

class MonsumAPI
{
    const MONSUM_API_CACHE      = 0;
    const MONSUM_API_CACHE_DIR  = 1;
    const MONSUM_API_CACHE_AGE  = 2;
    const MONSUM_API_DEBUG      = 3;
    const MONSUM_API_LOGFILE    = 4;
    const MONSUM_API_TIMEZONE   = 5;
    const MONSUM_API_URL        = 6;
    const MONSUM_API_KEY        = 7;
    const MONSUM_API_EMAIL      = 8;

    private $api_response = null;
    private $api_config = array(self::MONSUM_API_CACHE     => false,
                                self::MONSUM_API_CACHE_DIR => "../cache",
                                self::MONSUM_API_CACHE_AGE => 60,
                                self::MONSUM_API_DEBUG     => false,
                                self::MONSUM_API_LOGFILE   => "../log/monsum_api.log",
                                self::MONSUM_API_TIMEZONE  => "Europe/Zurich",
                                self::MONSUM_API_URL       => "https://app.monsum.com/api/1.0/api.php",
                                self::MONSUM_API_KEY       => "",  
                                self::MONSUM_API_EMAIL     => "");

    public function __construct($apicfg) {
        $this->api_config = $apicfg;
        date_default_timezone_set($this->get_config(self::MONSUM_API_TIMEZONE));
    }

    public function api_call($query, $cache = false)
    {
        if(!isset($query))
            return false;

        $this->api_response = null;
        $sjson = json_encode($query);
        $sjson_hash = md5($sjson);
        $cache_file = $this->cache_filename($sjson_hash);
        $cache_hit = false;

        if($this->get_config(self::MONSUM_API_CACHE) && $cache && file_exists($cache_file)) {
            if(time()-filemtime($cache_file) < $this->get_config(self::MONSUM_API_CACHE_AGE)) {
                $this->api_response = unserialize(file_get_contents($cache_file));
                $cache_hit = true;
            }
        }
        
        if(!$cache_hit) {
            $this->api_response = \Httpful\Request::post($this->get_config(self::MONSUM_API_URL))
            ->authenticateWith($this->get_config(self::MONSUM_API_EMAIL), $this->get_config(self::MONSUM_API_KEY))
            ->sendsJson()
            ->body($sjson)
            ->expectsJson()
            ->send();
        }

        if($this->get_config(self::MONSUM_API_DEBUG)) {
            $this->log("DEBUG: api_call(): JSON: " . $sjson . "\n");
            if($cache_hit)
                $this->log("\t\t\tCACHE HIT: " . $sjson_hash . "\n");
        }

        if($this->api_response->hasErrors()) {
            $this->log("ERROR: HTTP_CODE: " . strval($this->api_response));
        } 
        else {
            if($this->api_response->hasBody()) {
                if($this->get_config(self::MONSUM_API_CACHE)) {
                    file_put_contents($cache_file, serialize($this->api_response));
                }
                return true;
            }
        }

        $this->api_response = null;
        return false;
    }

    public function has_data() {
        return isset($this->api_response->body->RESPONSE);
    }

    public function get_data() {
        return (isset($this->api_response->body->RESPONSE) ? $this->api_response->body->RESPONSE : null);
    }

    public function log($msg) {
        error_log(date(DATE_RFC822) . " " . $msg, 3, $this->get_config(self::MONSUM_API_LOGFILE));
    }

    public function log_data() {
        $this->log("DUMP_DATA: \n" . print_r($this->api_response->body->RESPONSE, true));
    }

    public function log_response() {
        $this->log("DUMP_RESPONSE: \n" . print_r($this->api_response, true));
    }
    
    private function get_config($cfgval) {
        return $this->api_config[$cfgval];
    }

    private function cache_filename($json_hash) {
        return $this->get_config(self::MONSUM_API_CACHE_DIR) . "/" . $json_hash . ".cache";
    }
}

?>