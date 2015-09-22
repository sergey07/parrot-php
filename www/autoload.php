<?php

function __autoload($class) {
  require __DIR__ . '/../vendor/autoload.php';
  
  $controllerClassPath = __DIR__ . '/controllers/' . $class . '.php';
  $modelClassPath = __DIR__ . '/models/' . $class . '.php';
  
  if (file_exists($controllerClassPath)) {
    require $controllerClassPath;
  }
  elseif (file_exists($modelClassPath)) {
    require $modelClassPath;
  }
  elseif (file_exists(__DIR__ . '/classes/' . $class . '.php')) {
    require __DIR__ . '/classes/' . $class . '.php';
  }
  else {
    $classParts = explode('\\', $class);
    $classParts[0] = __DIR__;
    $path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
    if (file_exists($path)) {
      require $path;
    }
  }
}

// spl_autoload_register(callable $autoload_function);
