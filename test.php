session_start();
$d=date('d-m-Y');
define('FOLDER_CERTS', '../../../cockroach/certs');
$host = '77.95.133.210';
$port = 26257;
$db = 'mordash';
$sslrootcert = FOLDER_CERTS.'/root.crt';
$sslkey = FOLDER_CERTS.'/postgresql.key';
$sslcert = FOLDER_CERTS.'/postgresql.crt';
[<0;82;20M
try {
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=verify-ca;sslrootcert=$sslrootcert;sslkey=$sslkey;sslcert=$sslcert",
'root', null, array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_EMULATE_PREPARES => true,
));

mysql_select_db($db, $pdo);
$qr_result = mysql_query("select * from Mordash.roles ". $db_table_to_show);

 // выводим на страницу сайта заголовки HTML-таблицы
    echo '<style type="text/css" media="all"> body { margin: 0; padding: 0;} </style>';
    echo '<table border="1" cellspacing="0" cellpadding="0">';
  echo '<thead>';
  echo '<tr>';
  echo '<th><b>День недели</b></th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  
   // выводим в HTML-таблицу данные из таблицы MySQL 
  while($data = mysql_fetch_array($qr_result)){ 
      echo '<tr>';
      echo '<td>' . $data['Предмет'] . '<br>' . $data['Аудитория'] . '<br>' . $data['Преподаватель'] . '</td>'; // вместо "Предмет", "Аудитория" и "Преподаватель" - наименования столбцов в таблице БД с твоими данными
      echo '</tr>';
  }
        echo '</tbody>';
        echo '</table>';

        // закрываем соединение с сервером  базы данных
        mysql_close($pdo);
?>