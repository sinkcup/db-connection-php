<?php
require_once __DIR__ . '/../../autoload.php';
class PDOTest extends PHPUnit_Framework_TestCase
{
    private $c;
    private $conf = array(
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

    public function setUp()
    {
        $this->c = new \DB\Connection\PDO($this->conf);
    }

    public function testInsertRow()
    {
        echo __FUNCTION__ . "\n";
        $sql = 'INSERT INTO `users` (name) values(\'jim\');';
        $r = $this->c->insertRow($sql);
        var_dump($r);
        $this->assertEquals(true, isset($r[0]));
    }

    public function testSelectRow()
    {
        echo __FUNCTION__ . "\n";
        $sql = 'SELECT * FROM `users` LIMIT 1';
        $r = $this->c->selectRow($sql);
        var_dump($r);
        $this->assertEquals(true, isset($r['id']));
    }

    public function testSelectRows()
    {
        echo __FUNCTION__ . "\n";
        $sql = 'SELECT * FROM `users` LIMIT 3';
        $r = $this->c->selectRows($sql);
        var_dump($r);
        $this->assertEquals(true, isset($r[0]));
    }
}
