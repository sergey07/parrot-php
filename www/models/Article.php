<?php

namespace Application\Models;

/**
 * Класс модели для работы со статьями
 * @property $id
 * @property $title
 * @property $text
 */
class Article extends \AbstractModel {  
  protected static $table = 'articles';
}