<?php
namespace DB\Connection;

class Mysqli
{
    private $connection;
    
    public function __construct($conf)
    {
        try {
            $this->connection = new \mysqli($conf['host'], $conf['username'], $conf['password'], $conf['dbname'], $conf['port']);
            if ($this->connection->connect_error) {
                throw new \Exception($this->connection->connect_error, $this->connection->connect_errno);
            }
            $this->connection->set_charset($conf['charset']);
        } catch (\Exception $e) {
            throw new \Exception($connection->error);
        }
        return true;
    }
    
    public function delete($sql)
    {
        return $this->connection->query($sql);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function insertRow($sql)
    {
        $this->connection->query($sql);
        return $this->connection->insert_id;
    }
    
    public function insertRows($sql)
    {
        return $this->connection->query($sql);
    }
    
    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    public function selectCount($sql)
    {
        $r = $this->connection->query($sql);
        $r1 = $r->fetch_row();
        return $r1[0];
    }
    
    public function selectRow($sql)
    {
        $r = $this->selectRows($sql);
        return empty($r) ? array() : $r[0];
    }
    
    public function selectRows($sql)
    {
        $r = $this->connection->query($sql);
        return $r->fetch_all(MYSQLI_ASSOC);
    }
    
    public function update($sql)
    {
        return $this->connection->query($sql);
    }
}
