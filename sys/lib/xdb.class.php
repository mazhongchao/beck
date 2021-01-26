<?php
class Xdb
{
    private $pdo = null;
    private $dns = '';
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
    }

    // public static function getInstance()
    // {
    //     if(empty(self::$instance)){
    //         self::$instance = new Xdb();
    //     }
    //     return self::$instance;
    // }

}

