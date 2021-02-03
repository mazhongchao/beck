<?php
class Xdb
{
    private $pdo = null;
    private $dsn = '';
    private $type;

    public function __construct($options){
        if (isset($options['db_type'])) {
            $this->type = strtolower($options['db_type']);
            if ($this->type === 'mariadb') {
                $this->type = 'mysql';
            }
        }
        $pdo_option = isset($options['pdo_option']) ? $options['pdo_option'] : [];
        $commands = (isset($options['command']) && is_array($options['command'])) ? $options['command'] : [];

        switch ($this->type)
        {
            case 'mysql':
                $commands[] = 'SET SQL_MODE=ANSI_QUOTES';
                break;

            case 'mssql':
                $commands[] = 'SET QUOTED_IDENTIFIER ON';
                $commands[] = 'SET ANSI_NULLS ON';
                break;
        }
        if (isset($options['pdo'])) {
            if(!$options['pdo'] instanceof PDO) {
                throw new InvalidArgumentException('Invalid POD object')
            }

            $this->pdo = $options[ 'pdo' ];

            foreach ($commands as $value)
            {
                $this->pdo->exec($value);
            }
            return;
        }
        if (isset($options['dsn'])) {
            if (is_array($options['dsn']) && isset($options['dsn']['driver'])) {
                $attr = $options[ 'dsn' ];
            }
            else if (is_string($option['dsn'])) {
                //
            }
            else {
                throw new InvalidArgumentException('Invalid DSN');
            }
        }
        else {
            if (isset($options['port']) && is_int($options['port']*1) && $options['port']*1 > 0) {
                $port = $options['port'];
            }

            $has_port = isset($port);

            switch($this->type) {
                case 'mysql':
                    $attr = [
                        'driver' => 'mysql',
                        'dbname' => $options['db_name']
                    ];
                    if (isset($options['socket'])) {
                        $attr['unix_socket'] = $options['socket'];
                    }
                    else {
                        $attr['host'] = $options['host'];
                        if ($has_port) {
                            $attr['port'] = $port;
                        }
                    }
                    break;

                case 'pgsql':
                    $attr = [
                        'driver' => 'pgsql',
                        'host' => $options['host'],
                        'dbname' => $options['db_name']
                    ];
                    if ($has_port) {
                        $attr['port'] = $port;
                    }
                    break;

                case 'oracle':
                    $attr = [
                        'driver' => 'oci',
                        'dbname' => $options['host'] ? '//'.$options['host'].($has_port ? ':'.$port:':1521').'/'.$options['db_name']:$options['db_name']
                    ];
                    if (isset($options['charset'])) {
                        $attr['charset'] = $options['charset'];
                    }
                    break;

                case 'mssql':
                    if(isset($options['driver']) && $options['driver'] == 'dblib') {
                        $attr = [
                            'driver' => 'dblib',
                            'host' => $options['server'].($has_port ? ':'.$port : ''),
                            'dbname' => $options['db_name']
                        ];

                        if (isset($options['appname'])) {
                            $attr['appname'] = $options['appname'];
                        }
                        if (isset($options['charset'])) {
                            $attr['charset'] = $options['charset'];
                        }
                    }
                    //driver = 'sqlsrv'
                    else {
                        //TODO....
                    }
                    break;

                case 'sqlite':
                    $attr = [
                        'driver' => 'sqlite',
                        $options['db_file']
                    ];
                    break;
            }
        }
        if (!isset(attr)) {
            throw new InvalidArgumentException('Incorrect connection options');
        }

        $arr = [];
        $driver = $attr['driver'];
        foreach ($attr as $key => $value) {
            $arr[] = $key.'='.$value;
        }
        $dsn = $driver.':'.implode(';', $arr);

        if (in_array($this->type, ['mysql', 'pgsql', 'mssql']) && isset($options['charset'])) {
            $commands[] = "SET NAMES '{$options['charset']}'".(
                        $this->type == 'mysql' && isset(['collation']) ?
                        " COLLATE '{$option['collation']}'" : ''
            );
        }
        $this->dsn = $dsn;

        try {
            $this->pdo = new PDO(
                $dsn,
                isset($options['username']) ? $options['username'] : null,
                isset($options['password']) ? $options['password'] : null,
                $option
            );

            foreach ($commands as $value) {
                $this->pdo->exec($value);
            }
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}

