<?php

use Tony\DB\Exception\InvalidArgumentException;
use Tony\DB\DbFactory;
use Tony\DB\Exception\ConnectionException;

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
        $this->pdo = DbFactory::getInstance(getDbConfig());

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

    // 测试错误参数连接
    public function testInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        \Tony\DB\DbFactory::getInstance(getDbConfig());
    }

    // 测试连接错误
    public function testConnectionFailed()
    {
        $this->expectException(ConnectionException::class);

        DbFactory::getInstance(getDbConfig());
    }
}