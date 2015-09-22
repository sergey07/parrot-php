<?php

require_once __DIR__ . '/autoload.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);

$controllerClassName = !empty($pathParts[1]) ? ucfirst($pathParts[1]) : 'Article';
$controllerClassName = 'Application\\Controllers\\' . $controllerClassName;
$action = !empty($pathParts[2]) ? ucfirst($pathParts[2]) : 'All';

try {
  $controller = new $controllerClassName;
  $method = 'action' . $action;
  $controller->$method();
}
catch (Exception $ex) {
  //die('Что-то пошло не так: ' . $ex->getMessage());
  $view = new View();
  $view->error = $ex->getMessage();
  $view->display('error.php');
}