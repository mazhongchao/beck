<?php
class Db
{
    public $pdo = null;
    protected $dsn = '';
    protected $driver = '';
    protected $statement = null;
    protected $err_info;


    public function __construct($settings)
    {
        if(!is_array($settings)) {
            throw new InvalidArgumentException('Incorrect connection settings');
        }

        if(isset($settings['dsn'])) {
            if (is_array($settings['dsn'])) {
                $dsn = $this->_dsn($settings['dsn']);
            }
            else if (is_string($settings['dsn'])) {
                $dsn = $settings['dsn'];
            }
        }
        else {
            $dsn = $this->_dsn($settings);
        }

        if (empty($dsn)) {
            throw new InvalidArgumentException('Invalid DSN');
        }

        try {
            $this->pdo = new PDO(
                $dsn,
                isset($settings['username']) ? $settings['username'] : null,
                isset($settings['password']) ? $settings['password'] : null,
                isset($settings['options'])? $settings['options'] : null
            );

            $commands = [];
            if (in_array($this->driver, ['mysql', 'pgsql']) && isset($settings['charset'])) {
                $commands[] = "SET NAMES '{$settings['charset']}'" . (
                    $this->driver === 'mysql' && isset($settings['collation']) ?
                    " COLLATE '{$options['collation']}'" : ''
                );
            }

            foreach ($commands as $value) {
                $this->pdo->exec($value);
            }

            $this->dsn = $dsn;
        }
        catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function select()
    {
        //
    }

    public function insert()
    {
        //
    }

    public function delete()
    {
        //
    }

    public function update()
    {
        //
    }
    public function replace()
    {
        //
    }

    public function create()
    {
        //
    }

    public function drop()
    {
        //
    }

    public function query($query)
    {
        $this->statement = null;
        $statement = $this->pdo->prepare($query);

        if (!$statement)
		{
			$this->err_info = $this->pdo->errorInfo();
			$this->statement = null;
			return false;
        }

        $this->statement = $statement;
    }

    public function test()
    {
        $data = $this->pdo->query('select 1', PDO::FETCH_NUM);
        print"<pre>";
        var_dump($data);
    }

    private function _dsn($meta = [])
    {
        $dsn = '';

        if (isset($meta['driver'])) {
            $driver = $meta['driver'];

            //if (!in_array($driver, PDO::getAvailableDrivers()))
            if (!in_array($driver, ['mysql', 'mariadb', 'pgsql', 'sqlite'])) {
                throw new InvalidArgumentException("Unsupported PDO driver: {$driver}");
            }

            if ($driver === 'mariadb') {
                $driver = 'mysql';
            }

            if (isset($meta['port']) && is_int($meta['port']*1) && $meta['port']*1 > 0) {
                $port = $meta['port'];
            }
            $has_port = isset($port);

            switch($driver) {
                # mysql:host=localhost;port=3307;dbname=testdb
                # mysql:unix_socket=/tmp/mysql.sock;dbname=testdb
                case 'mysql':
                    $dsn_meta = ['driver' => 'mysql'];

                    if (isset($meta['socket'])) {
                        $dsn_meta['unix_socket'] = $meta['socket'];
                    }
                    else {
                        $dsn_meta['host'] = $meta['host'];
                        if ($has_port) {
                            $dsn_meta['port'] = $port;
                        }
                    }

                    $dsn_meta['dbname'] = $meta['dbname'];
                    break;

                # pgsql:host=localhost;port=5432;dbname=testdb
                case 'pgsql':
                    $dsn_meta = [
                        'driver' => 'pgsql',
                        'host' => $meta['host'],
                    ];
                    if ($has_port) {
                        $dsn_meta['port'] = $port;
                    }
                    $dsn_meta['dbname'] = $meta['dbname'];
                    break;

                # sqlite:/opt/databases/mydb.sq3
                case 'sqlite':
                    $dsn_meta = [
                        'driver' => 'sqlite',
                        $meta['db_file']
                    ];
                    break;
            } //switch

            $driver = $dsn_meta['driver'];
            unset($dsn_meta[ 'driver' ]);

            $arr = [];
            foreach ($dsn_meta as $key => $value) {
                $arr[] = is_int($key) ? $value : $key . '=' . $value;
            }

            $dsn = $driver . ':' . implode(';', $arr);
            $this->driver = $driver;
        }

        return $dsn;
    }
}
