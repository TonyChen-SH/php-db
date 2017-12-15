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
     * @param       $dsn
     * @param null  $usr
     * @param null  $pwd
     * @param array $options
     */
    public function __construct($dsn, $usr = null, $pwd = null, array $options = [])
    {
        parent::__construct($dsn, $usr, $pwd, $options);
    }

    /**
     * 获取单行数据，返回的是一个一维数组
     * @param      $sql
     * @param null $params
     * @return mixed
     */
    public function fetchRow($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * 获取数组数据, 返回的是一个二维数组
     * @param      $sql
     * @param null $params
     * @return mixed
     */
    public function fetchAll($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 获取单字段数据
     * SELECT COUNT(account_name) FROM player WHERE account_name='xxxx', 只会返回字段的值：1
     * @param      $sql
     * @param null $params
     * @return mixed
     */
    public function fetchSingle($sql, $params = null)
    {
        $statement = $this->prepare($sql);
        $statement->execute($params);

        return $statement->fetchColumn(0);
    }

    /**
     * 执行update/delete/insert语句
     * 只会返回执行结果为bool值
     * @param      $sql
     * @param bool $isMultiSql 是否执行多条SQL语句. 比如这样的一次性执行两条:INSERT INTO `admin_role` VALUES ('1','2');
     *                                                                        INSERT INTO `admin_role` VALUES ('xx','yy');
     * @param null $params
     * @return mixed
     */
    public function execute($sql, $isMultiSql = false, $params = null)
    {
        if ($isMultiSql) {
            // 用来支持一次执行多跳SQL语句，不然会报语法错误
            // 启用或禁用预处理语句的模拟。
            $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        }
        $statement = $this->prepare($sql);

        return $statement->execute($params);
    }
}