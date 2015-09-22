<?php

/**
 * Description of View
 *
 * @author Sergey Ivanov
 */
class View implements Iterator {
  protected $data = [];
  
  public function __set($name, $value) {
    $this->data[$name] = $value;
  }
  
  public function __get($name) {
    return $this->data[$name];
  }
  
  public function render($template) {
    foreach ($this->data as $key => $value) {
      $$key = $value;
    }
    
    ob_start();
    include  __DIR__ . '/../views/' . $template;
    $content = ob_get_contents();
    ob_end_clean();
    
    return $content;
  }
  
  public function display($template) {
    echo $this->render($template);
  }

  public function current() {
    return current($this->data);
  }

  public function key() {
    return key($this->data);
  }

  public function next() {
    next($this->data);
  }

  public function rewind() {
    reset($this->data);
  }

  public function valid() {
    $key = key($this->data);
    return $key !== null && $key != false;
  }
}