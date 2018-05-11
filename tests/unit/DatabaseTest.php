<?php

use Tony\DB\Exception\InvalidArgumentException;
use Tony\DB\Exception\ConnectionException;
use Tony\DB\DbFactory;

class DatabaseTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Tony\DB\Database $pdo
     */
    private $pdo;


    protected function _before()
    {
        $this->pdo = DbFactory::getDb(getDbConfig());
    }

    protected function _after()
    {
    }

    // 测试数据库连接
    public function testConnection()
    {
        $res = $this->pdo->fetchRow('SELECT * FROM player');

        $this->assertNotNull($res);
    }

    // 测试slim/pdo的builder是否可以用
    public function testSqlBuilder()
    {
        $selectStatement = $this->pdo->select()
            ->from('player');
        //->where('id', '=', 1234);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        $this->assertNotNull($data);
    }

    /**
     * 测试错误参数连接
     * @expectedException InvalidArgumentException
     * @throws ConnectionException
     */
    public function testInvalidArgument()
    {
        DbFactory::getDb(['dsn' => 'mysql:host=192.168.1.216;dbname=rog_db_1', 'user' => 'root']);
    }

    /**
     * 测试连接错误
     * @expectedException ConnectionException
     * @throws ConnectionException
     */
    public function testConnectionFailed()
    {
        DbFactory::getDb(['dsn' => 'mysql:host=192.168.1.216;dbname=fail', 'user' => 'root', 'password' => '123456']);
    }

    /**
     * 相同连接的两次调用是否返回的同一个对象
     * @throws ConnectionException
     */
    public function testSameObject()
    {
        $db1 = DbFactory::getDb(getDbConfig());
        $db2 = DbFactory::getDb(getDbConfig());

        static::assertSame($db1, $db2);
    }

    /**
     * 不同连接的两次调用是否返回的不同对象
     * @throws ConnectionException
     */
    public function testDiffObject()
    {
        $db1 = DbFactory::getDb(['dsn' => 'mysql:host=127.0.0.1;dbname=test', 'user' => 'root', 'password' => '123456']);
        $db2 = DbFactory::getDb(['dsn' => 'mysql:host=127.0.0.1;dbname=youhao', 'user' => 'root', 'password' => '123456']);

        static::assertNotSame($db1, $db2);
    }
}