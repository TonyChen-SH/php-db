<?php
/**
 * Created by PhpStorm.
 * User: chendan
 * Date: 2017/5/27
 * Time: 下午4:39
 */

namespace Tony\DB\Exception;

class ConnectionException extends \Exception
{
    /**
     *
     * ConnectionException constructor.
     * @param string $message 异常信息格式是数据库配置，格式: $dsn="mysql:host=127.0.0.1;port=3306;dbname=admin&&user&&password";
     * @param \PDOException|null $pdoException
     */
    public function __construct($message = "", \PDOException $pdoException = null)
    {
        parent::__construct($message, 0, $pdoException);
    }
}