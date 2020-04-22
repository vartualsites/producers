<?php
const LOCAL_URI = '/producers/';

//require_once '.env';
//error_reporting(E_ALL);
require_once 'autoload.php';

use Isystems\Vendor;
use Isystems\Controllers;

$endpoints = Vendor\Input::getRequestEndpoints();
$view = new Vendor\View();

if($endpoints->class === 'producers' && in_array($endpoints->method, array('', 'add'/*, 'get'*/))) {
    new Controllers\Producers();
} else if(in_array($endpoints->class, array('', 'producers'))) {
    $view->renderTemplate('main.php');
} else {
    Vendor\Output::setCode(404);
    $view->renderTemplate('notFound.php');

}
exit();