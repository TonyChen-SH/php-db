<?php
/**
 * User: Tony Chen
 * Date: 2017/5/31
 */

namespace Tony\DB;


use Tony\DB\Exception\ConnectionException;
use Tony\DB\Exception\InvalidArgumentException;

class DbFactory
{
    private function __construct()
    {
    }

    /**
     * 获取数据库操作实例
     * @param array $config ['dsn'=>'mysql:host=localhost;dbname=test','user'=>'root','password'=>'12345']
     * @return Database
     * @throws ConnectionException
     */
    public static function getInstance(array $config)
    {
        if (count(array_keys($config)) != 3) {
            throw new InvalidArgumentException('Config param count is Invalid');
        }

        try {
            return new Database($config['dsn'], $config['user'], $config['password']);
        } catch (\PDOException $exception) {
            throw new ConnectionException('mysql connect failed', $exception);
        }
    }
}