<?php

class User extends Model{
    const TABLE = 'users';

    protected static $fields_description = array(
        'type' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'login' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'email' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'tel' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
    );

    protected static $links_description = array(

    );

    public static function getByLoginPassword($login, $password){
        $password = md5($password);
        $query = "SELECT * FROM `".self::TABLE."`
				WHERE `login` = '$login' AND `password` = '$password'";
        $row = Db::getRow($query);
        if ($row){
            $user = new self();
            $user->fillFromArray($row);
            return $user;
        }
        return null;
    }

    //для девелоперов
    public function getTasks(){
        $query = "SELECT * FROM `tasks` AS `t`
		LEFT JOIN `devs` AS `d` ON `d`.`id` = `t`.`id_dev`
		WHERE `d`.`id` = {$this->id}";
        $array = Db::getTable($query);
        $tasks = array();
        foreach ($array as $row) {
            //TODO: описать класс Task
            $task = new Task();
            $task->fillFromArray($row);
            $tasks[] = $task;
        }
        return $tasks;
    }

    //для заказчиков
    public function getOrders(){
        $query = "SELECT * FROM `contest` as `c` WHERE `id_customer` = {$this->id}";
        $array = Db::getTable($query);
        $orders = array();
        foreach ($array as $row) {
            $order = new Order();
            $order->fillFromArray($row);
            $orders[] = $order;
        }
        return $orders;
    }
}