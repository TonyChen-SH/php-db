<?php
/**
 * User: Tony Chen
 * Date: 2017/5/31
 */

namespace Tony\DB;

/**
 * 集成Database类，加一些其他常用的方法
 * Class Database
 * @package Tony\DB
 */
class Database extends \Slim\PDO\Database
{
    /**
     * Database constructor.
     * @param $dsn
     * @param null $usr
     * @param null $pwd
     * @param array $options
     */
    public function __construct($dsn, $usr = null, $pwd = null, array $options = array())
    {
        parent::__construct($dsn, $usr, $pwd, $options);
    }


    public function fetchRow($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchSingle($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetchColumn(0);
    }

    public function execute($sql, $params = null)
    {
        $statement = $this->prepare($sql);

        return $statement->execute($params);
    }
}