<?php
namespace DB\Connection;

class PDO
{
    private $connection;
    
    public function __construct($conf)
    {
        //PDO官方DSN有个很诡异的地方：mysql使用username，pgsql使用user，很不方便。这里进行屏蔽，哪个都行。
        $username = isset($conf['username']) ? $conf['username'] : $conf['user'];
        switch($conf['product']) {
            case 'mysql':
                $dsn = 'mysql:';
                if (isset($conf['unix_domain_socket']) && !empty($conf['unix_domain_socket'])) {
                    $dsn .= 'unix_socket=' . $conf['unix_domain_socket'] . ';';
                } else {
                    $dsn .= 'host=' . $conf['host'] . ';port=' . $conf['port'] . ';';
                }
                $dsn .= 'dbname=' . $conf['dbname'];
                $this->connection = new \PDO($dsn, $username, $conf['password']);
                if (isset($conf['charset']) && !empty($conf['charset'])) {
                    $this->connection->query('SET NAMES '. $conf['charset']);
                }
                break;
            case 'pgsql':
                $dsn = 'pgsql:host=' . $conf['host'] . ';port=' . $conf['port']
                . ';dbname=' . $conf['dbname'] . ';user=' . $username
                . ';password=' . $conf['password'];
                $this->connection = new \PDO($dsn);
                break;
        }
        //http://php.net/manual/en/pdo.setattribute.php
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return true;
    }

    public function delete($sql)
    {
        return $this->connection->exec($sql); //todo delete 是幂等的？
    }

    public function getConnection()
    {
        return $this->connection;
    }
    
    public function insertRow($sql)
    {
        $this->connection->exec($sql);
        return $this->connection->lastInsertId(); //todo
    }
    
    public function insertRows($sql)
    {
        return $this->connection->exec($sql);
    }

    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    public function selectCount($sql)
    {
        $r = $this->connection->query($sql);
        return intval($r->fetchColumn());
    }
    
    public function selectRow($sql)
    {
        $r = $this->selectRows($sql);
        return empty($r) ? array() : $r[0];
    }
    
    public function selectRows($sql)
    {
        $r = $this->connection->query($sql);
        $r->setFetchMode(\PDO::FETCH_ASSOC);
        return $r->fetchAll();
    }
    
    public function update($sql)
    {
        return $this->connection->exec($sql);
    }
    
    public function quote($str)
    {
        return $this->connection->quote($str);
    }
}
