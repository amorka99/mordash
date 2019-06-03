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
  try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=verify-ca;sslrootcert=$sslrootcert;sslkey=$sslkey;sslcert=$sslcert",
    'root', null, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => true,
    ));
    $sql = "SELECT role FROM mordash.roles  WHERE login = ? AND password= ?";
    $stmt = $pdo->prepare($sql); 
    $stmt->execute([$login,$pass]);
    $num_row=$stmt->rowCount();//fetchColumn();
  } catch (Exception $e) {
    print $e->getMessage() . "\r\n";
    exit(1);
  }
  if($num_row==1){
    $_SESSION['login']=$login;
    $row=$stmt->fetch();
    $_SESSION['check']=$row['role'];
    if($row['role']==0){
    header("Location: dashboard.php");
    } elseif($row['role']==1){
      header("Location: teacher.php");
    } else {
      header("Location: student.php");
    }
  } else {
    header("login.php");
    echo $login;
    echo " ";
    echo $pass;
    echo ' Wrong!!!';}
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Авторизация</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  </head>
<body class="bg-gradient-primary">

  <div class="container">



    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Авторизация</h1>
                  </div>
 <form class="form-signin" action="login.php" method="POST">
                            <div class="form-group">

                      <input type="email"id="inputEmail"  name="login" class="form-control"   placeholder="Enter Email Address..." >
                    </div>
                    <div class="form-group">
  <input type="password" id="inputPassword"  name ="pass" class="form-control"  placeholder="Password">
                    </div>
                    <div class="form-group">
                      
                    </div>
<button class="btn btn-primary btn-user btn-block" name="ok" type="submit">Войти</button>
                    
  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
      
    
  </body>
</html>