<?php
require_once('sdk.php');

$key_id = 'CLOUDSTACK_API_KEY';
$sec_key = 'CLOUDSTACK_SECRET_KEY';

$cs = new CloudStack($key_id, $sec_key);

$param = array();
$param['apiKey']    = $key_id;
$param['command']   = 'listVirtualMachines';
$param['response']  = 'json';

$cs->set_param($param);
$cs->call();

