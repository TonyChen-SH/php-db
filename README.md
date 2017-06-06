### 数据库类库
> 基于slim-pdo做的一个pdo数据库类

[![StyleCI](https://styleci.io/repos/92577033/shield?branch=master)](https://styleci.io/repos/92577033)
[![Build Status](https://travis-ci.org/TonyChen-SH/php-db.svg?branch=master)](https://travis-ci.org/TonyChen-SH/php-db)

### Install
```php
  // 把下面的代码片段，加入到composer.json文件里面
  // 由于tony这个命名空间在packagist已经有人用了，我的加不进去，暂代用直连方式
  "require": {
    "tony/php-db": "0.1"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/TonyChen-SH/php-db.git"
    }
  ]
```

### Usage

```php
require_once 'vendor/autoload.php';

$pdo = \Tony\DB\DbFactory::getInstance(['dsn' => 'mysql:host=192.168.1.11;dbname=test;charset=utf8','user'=>'root', 'password' => '123456']);

// 使用原生
$res = $pdo->fetchRow('SELECT * FROM player');

//------------------------使用sql builder---------------------------//

// SELECT * FROM users WHERE id = ?
$selectStatement = $pdo->select()
                       ->from('users')
                       ->where('id', '=', 1234);

$stmt = $selectStatement->execute();
$data = $stmt->fetch();

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $pdo->insert(array('id', 'usr', 'pwd'))
                       ->into('users')
                       ->values(array(1234, 'your_username', 'your_password'));

$insertId = $insertStatement->execute(false);

// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $pdo->update(array('pwd' => 'your_new_password'))
                       ->table('users')
                       ->where('id', '=', 1234);

$affectedRows = $updateStatement->execute();

// DELETE FROM users WHERE id = ?
$deleteStatement = $pdo->delete()
                       ->from('users')
                       ->where('id', '=', 1234);

$affectedRows = $deleteStatement->execute();
```
### [slim-pdo documentation](https://github.com/FaaPz/Slim-PDO/tree/master/docs)

