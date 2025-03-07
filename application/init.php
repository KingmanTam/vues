<?php
require 'application/App.php';
require 'application/core/AppException.php';
require 'config/Domain.php';
require 'application/service/ErrorService.php';
require 'application/core/Db.php';
require 'application/common/Common.php';

@header('Content-Type:text/html;Charset=utf-8');
@date_default_timezone_set('Etc/GMT-8');
@ini_set('display_errors','On');
@error_reporting(8);
@ob_start();
App::$full_url = $_SERVER['HTTP_HOST'];
app::$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$domain = $_SERVER['HTTP_HOST'];
if(str_contains($domain, 'www.')){
    $domain = str_replace('www.', '' ,$domain);
}
Domain::setInfo($domain);