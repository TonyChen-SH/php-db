<?php
/**
 * User: Tony Chen
 * Date: 2017/5/31
 */

namespace Tony\DB;

use Tony\DB\Exception\ConnectionException;
use Tony\DB\Exception\InvalidArgumentException;

/**
 * Class DbFactory
 * @package Tony\DB
 */
class DbFactory
{
    /**@var array $dbPool */
    private static $dbPool;

    private function __construct()
    {
    }

    /**
     * 获取数据库操作实例
     * @param array $connection ['dsn'=>'mysql:host=localhost;dbname=test','user'=>'root','password'=>'12345']
     * @return Database
     * @throws ConnectionException
     */
    public static function getDb(array $connection)
    {
        if (count(array_keys($connection)) !== 3)
        {
            throw new InvalidArgumentException('Connection param count is Invalid');
        }

        $hashKey = md5(json_encode($connection));
        // 同一种配置的数据库对象,只会被创建一次
        if (!isset(self::$dbPool[$hashKey]))
        {
            try
            {
                self::$dbPool[$hashKey] = new Database($connection['dsn'], $connection['user'], $connection['password']);
            } catch (\PDOException $exception)
            {
                throw new ConnectionException('mysql connect failed', $exception);
            }
        }

        // 返回数据库对象
        return self::$dbPool[$hashKey];
    }

    /**
     *
     * @param array $connection
     * @return Database
     * @throws ConnectionException
     *
     * @deprecated since version 1.0. Use DbFactory::getDb instead.
     */
    public static function getInstance(array $connection)
    {
        return self::getDb($connection);
    }
}