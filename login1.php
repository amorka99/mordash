<?php
session_start();
$d=date('d-m-Y');
define('FOLDER_CERTS', '../../../cockroach/certs');
$host = '77.95.133.210';
$port = 26257;
$db = 'mordash';
$sslrootcert = FOLDER_CERTS.'/root.crt';
$sslkey = FOLDER_CERTS.'/postgresql.key';
$sslcert = FOLDER_CERTS.'/postgresql.crt';
if(isset($_POST['ok'])) {
   $login = $_POST['login'];
   $pass = $_POST['pass'];
 $_SESSION['login']=$login;
try {
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=verify-ca;sslrootcert=$sslrootcert;sslkey=$sslkey;sslcert=$sslcert",
'root', null, array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_EMULATE_PREPARES => true,
));
$sql = "SELECT role  FROM mordash.roles WHERE login = ? AND password= ?";

$stmt = $pdo->prepare($sql); 
$stmt->execute([$login,$pass]);

$num_row=$stmt->rowCount();//fetchColumn();
} catch (Exception $e) {
print $e->getMessage() . "\r\n";
exit(1);
}
if($num_row==1){

$row=$stmt->fetch();

$_SESSION['check']=$row['role'];

if($row['role']==0){
header("Location: dashboard.php");

}
elseif($row['role']==1){
header("Location: teacher.php");
}
else
{
header("Location: student.php");
}
}

else {
 header("login1.php");

echo $login;
echo " ";
echo $pass;
echo ' Wrong!!!';}
}
<!doctype html>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Авторизация</title>
 <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="te
 <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,4

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  </head>

 <body class="text-center">
    <form class="form-signin"action="login1.php" method="POST">
     <!-- <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
       <img class="mb-4" src="https://cs8.pikabu.ru/post_img/2016/03/30/7/1459335471159744122.jpg" alt="" width="82" height="82">
      <h1 class="h3 mb-3 font-weight-normal">Пожалуйста, войдите</h1>
      <label for="inputEmail" class="sr-only">Адрес электронной почты</label>
      <input type="email" id="inputEmail" name="login" class="form-control" placeholder="Адрес электронной почты" required autofocus>
      <label for="inputPassword" class="sr-only">Пароль</label>
      <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Пароль" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Запомнить меня
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="ok" type="submit">Войти</button>
      <p class="mt-5 mb-3 text-muted">&copy;<?php echo  $d;?> <!-- 2017-2018 --> </p>
    </form>
  </body>
</html>

