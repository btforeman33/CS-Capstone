<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
     session_start();
}

//PDO Setup
$host = '127.0.0.1';
$db = 'phpclass';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;";
$options = [
PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$username = $_POST['user'];
$password = $_POST['pass'];

$statement = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$statement->execute([$username]);
$account = $statement->fetch();

$date = date('Y/m/d H:i:s');
$statement = $pdo->prepare("INSERT INTO login_log VALUES (Null,?,?)");
$statement->execute([$username,$date]);

$hash = $account['password'];
if(password_verify($password,$account['password']) == 1){
    $_SESSION['username'] = $account['username'];
    $_SESSION['accesslevel'] = $account['accessLevel'];
    echo '1';
}
else
    echo "<a style='color:red'>Username/Password Invalid!</a>";
