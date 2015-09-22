<?php

/**
 * Description of AbstractModel
 *
 * @author Sergey Ivanov
 */
abstract class AbstractModel {
  protected static $table;
  protected $data = [];
  
  public function __set($name, $value) {
    $this->data[$name] = $value;
  }
  
  public function __get($name) {
    return $this->data[$name];
  }
  
  public function __isset($name) {
    return isset($this->data[$name]);
  }
  
  public static function findAll() {
    $sql = 'SELECT * FROM ' . static::$table;
    $db = new Db();
    $db->setClassName(get_called_class());
    return $db->query($sql);
  }
  
  public static function findOneById($id) {
    $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
    $db = new Db();
    $db->setClassName(get_called_class());
    $res = $db->query($sql, ['id' => $id]);
    if (empty($res)) {
      throw new ModelException('Ничего не найдено!');
    }
    return $res;
  }
  
  public static function findOneByField($fieldName, $value) {
    $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $fieldName . '=:' . $fieldName;
    $db = new Db();
    $db->setClassName(get_called_class());
    $res = $db->query($sql, [$fieldName => $value]);
    if (empty($res)) {
      throw new ModelException('Ничего не найдено!');
    }
    return $res;
  }
  
  protected function insert() {
    $cols = array_keys($this->data);
    $data = [];
    foreach ($cols as $col) {
      $data[':' . $col] = $this->data[$col];
    }
    
    // INSERT INTO table_name (col_name, ...) VALUES (:col_name, ...)
    $sql = '
      INSERT INTO ' . static::$table . '
      (' . implode(', ', $cols) . ')
      VALUES
      (' . implode(', ', array_keys($data)) . ')
    ';
    
    $db = new Db();
    $res = $db->execute($sql, $data);
    if (false === $res) {
      return false;
    }
    $this->id = $db->lastInsertId();
    return true;
  }
  
  protected function update() {
    $set = [];
    foreach ($this->data as $key => $value) {
      $data[':' . $key] = $value;
      if ('id' === $key) {
        continue;
      }
      $set[] = $key . '=:' . $key;
    }
    
    // UPDATE table_name SET col_name=:col_name, ... WHERE id=:id
    $sql = '
      UPDATE ' . static::$table . '
      SET ' . implode(', ', $set) . '
      WHERE id=:id
    ';
    
    $db = new Db();
    return $db->execute($sql, $data);
  }
  
  public function save() {
    if (!isset($this->id)) {
      $res = $this->insert();
    }
    else {
      $res = $this->update();
    }
    return $res;
  }
  
  // DELETE FROM table_name WHERE id=:id
  public function delete() {
    $data = [':id' => $this->id];
    $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
    $db = new Db();
    return $db->execute($sql, $data);
  }
}
