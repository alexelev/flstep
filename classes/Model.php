<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.12.2014
 * Time: 14:35
 */

abstract class Model {
    const TABLE = '';

    protected $id;
    protected static $fields_description = array(); // Описание полей модели. Модель может содержать поля не только из своей таблицы.
    protected $fields = array(); // Значения всех полей текущей модели
    protected static $links_description = array(); // Описание связей с другими моделями
    protected $models = array(); // Модели связанные с текущей

    public function getId(){
        return $this->id;
    }

    // Если передаем id, модель загружается из базы.
    public function __construct($id = null) {
        // Создаем ключи в массиве полей.
        foreach (array_keys(static::$fields_description) as $field) {
            $this->fields[$field] = null;
        }

        // Создаем ключи в массиве связанных моделей. .
        foreach (static::$links_description as $link_name => $description) {
            if ($description['type'] != DbLinkType::FOREIGN_KEY) {
                $this->models[$link_name] = array(); // для связей-списков (PRIMARY_KEY, TABLE) создаем массив.
            } else {
                $this->models[$link_name] = null;
            }
        }

        if ($id) {
            // Загружаем текущую модель. Выбираем только те поля, которые указаны в описании
            if ($row = Db::getRow('SELECT `' . implode('`, `', array_keys(static::$fields_description)) . '` FROM `' .
                static::TABLE . '` WHERE `id` = ' . $id)) {
                $this->id = $id;

                foreach ($row as $field => $value) {
                    $this->fields[$field] = $value;
                }
            }
        }
    }

    private function loadLink($link_name) {
        if (isset(static::$links_description[$link_name])) {
            $link = static::$links_description[$link_name]; // Укорот
            $model_name = $link['model'];
            //TODO: класс Application
            Application::loadModelClass($model_name); // Загружаем класс связанной модели

            // Для каждого типа связи разные запросы
            switch ($link['type']) {
                case DbLinkType::PRIMARY_KEY : // Один ко многим (получение объявлений пользователя)
                    $query = 'SELECT `id`, `' . implode('`, `', array_keys($model_name::$fields_description)) . '` ';
                    $query .= 'FROM `' . $model_name::TABLE . '` ';
                    $query .= 'WHERE `' . $link['field'] . '` = ' . $this->id;

                    foreach ($rows = Db::getTable($query) as $row) {
                        $model = new $model_name();
                        $model->id = $row['id'];
                        foreach (array_keys($model_name::$fields_description) as $field) {
                            $model->fields[$field] = $row[$field];
                        }

                        $this->models[$link_name][] = $model;
                    }
                    break;

                case DbLinkType::FOREIGN_KEY : // Один ко многим наоборот (получение пользователя разместившего объявление)
                    $query = 'SELECT `t1`.`id`, `t1`.`' . implode('`, `t1`.`', array_keys($model_name::$fields_description)) . '` ';
                    $query .= 'FROM `' . static::TABLE . '` AS `t0` ';
                    $query .= 'LEFT JOIN `' . $model_name::TABLE . '` AS `t1` ON `t1`.`id` = `t0`.`' . $link['field'] . '` ';
                    $query .= 'WHERE `t0`.`id` = ' . $this->id;

                    $row = Db::getRow($query);
                    $model = new $model_name();
                    $model->id = $row['id'];
                    foreach (array_keys($model_name::$fields_description) as $field) {
                        $model->fields[$field] = $row[$field];
                    }

                    $this->models[$link_name] = $model;
                    break;

                case DbLinkType::TABLE : // Многие ко многим (связь через таблицу)
                    $query = 'SELECT `t2`.`id`, `t2`.`' . implode('`, `t2`.`', array_keys($model_name::$fields_description)) . '` ';
                    $query .= 'FROM `' . static::TABLE . '` AS `t0` ';
                    $query .= 'LEFT JOIN `' . $link['table']['name'] . '` AS `t1` ON `t0`.`id` = `t1`.`' . $link['table']['field1'] . '` ';
                    $query .= 'LEFT JOIN `' . $model_name::TABLE . '` AS `t2` ON `t2`.`id` = `t1`.`' . $link['table']['field2'] . '` ';
                    $query .= 'WHERE `t0`.`id` = ' . $this->id;

                    foreach ($rows = Db::getTable($query) as $row) {
                        $model = new $model_name();
                        $model->id = $row['id'];
                        foreach (array_keys($model_name::$fields_description) as $field) {
                            $model->fields[$field] = $row[$field];
                        }

                        $this->models[$link_name][] = $model;
                    }
                    break;
            }
        }

    }

    public function __get($field){
        if (array_key_exists($field, $this->fields)) {
            return $this->fields[$field];
        } elseif (array_key_exists($field, $this->models)) {
            if (empty($this->models[$field]) && $this->id) {
                $this->loadLink($field);
            }

            return $this->models[$field];
        }
        return null;
    }

    public function __set($field, $value){
        if (array_key_exists($field, static::$fields_description)) {
            $this->fields[$field] = $value;
        }
    }

    public function save(){
        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
            $this->id = Db::getInsertId();
        }
    }

    private function update(){
        $query = 'UPDATE `' . static::TABLE . '` SET ';
        foreach (static::$fields_description as $field => $description) {
            $query .= "`$field` = '{$this->fields[$field]}', ";
        }
        $query = rtrim($query, ', '); //убираем запятую в конце
        $query .= " WHERE `id` = {$this->id}";
        // echo '<pre>'; echo($query); echo '</pre>'; die();
        Db::query($query);
    }

    private function insert(){
        $query = "INSERT INTO `".static::TABLE."` (";
        $query .= '`' . implode('`, `', array_keys(static::$fields_description)) . '`';
        $query .= ') VALUES (';
        $query .= "'" . implode("', '", $this->fields) . "')";
        // echo $query;
        Db::query($query);
    }

    protected function fillFromArray($array)
    {
        if(isset($array['id'])){
            $this->id = $array['id'];
        }
        foreach (static::$fields_description as $field => $description) {
            if (isset($array[$field])) {
                $this->field = $array[$field];
            }
        }

    }
}