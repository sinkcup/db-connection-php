<?php
/*
 * 例子
 * 使用步骤：
 * 1、composer update
 * 2、php PDO.php
 */
require_once __DIR__ . '/vendor/autoload.php';

$conf = array(
    //mysql or pgsql
    'product' => 'mysql',
    //pdo mysqli or pgsql
    'api' => 'pdo',
    //'unix_domain_socket = '/tmp/mysql.sock',
    'host' => '127.0.0.1',
    //mysql default 3306 pgsql default 5432
    'port' => 3306,
    'dbname' => 'test',
    'username' => 'root',
    'password' => '1',
    'charset' => 'utf8',
);

$c = new \DB\Connection\PDO($conf);

$sql = 'INSERT INTO `users` (name) values(\'jim\');';
$r = $c->insertRow($sql);
var_dump($r);

$sql = 'SELECT * FROM `users` LIMIT 1';
$r = $c->selectRow($sql);
var_dump($r);
