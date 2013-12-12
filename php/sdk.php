<?php

class CloudStack {
    private $cs_key_id;
    private $cs_sec_key;
    private $param;
    private $base_string;
    private $signature;

    const BASE_URL = 'BASE_URL';

    public function __construct($key_id, $sec_key) {
        if ($key_id == null || $sec_key == null) {
            echo 'Input API_KEY or API_SECRET_KEY';
            exit;
        }
        $this->param        = array();
        $this->cs_key_id    = '';
        $this->cs_sec_key   = '';
        $this->base_string  = '';
        $this->signature    = '';

        $this->cs_key_id  = $key_id;
        $this->cs_sec_key = $sec_key;
    }

    public function call() {
        echo self::BASE_URL . '?' . $this->base_string . '&signature=' . $this->signature;
    }

    public function set_param($param_array=array()) {
        foreach ($param_array as $key => $val) {
            $this->param[$key] = $val;
        }
        uksort($this->param, 'strnatcasecmp');


        $this->set_base_string();
        $this->set_signature();
    }

    private function set_base_string() {
        $base_string    = '';
        $param_length   = count($this->param);
        $cnt            = 0;

        foreach ($this->param as $key => $val) {
            $cnt = $cnt + 1;
            $base_string = $base_string . $key . '=' . $val;
            if ($cnt < $param_length) {
                $base_string = $base_string . '&';
            }
        }

        $this->base_string = $base_string;
    }

    private function set_signature() {
        $hash      = hash_hmac('sha1', strtolower($this->base_string), $this->cs_sec_key, true);
        $signature = base64_encode($hash);

        $this->signature  = str_replace(array('+', '/', '='), array('%2B', '%2F', '%3D'), $signature);
    }
}
