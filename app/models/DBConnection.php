<?php
use Medoo\Medoo;

class DB extends Medoo{

    public $medoo;

    public function __construct(){
        $this->medoo = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'homie',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ]);
    }
}