<?php
include_once ("./db_array.php");

if (isset($_POST['db_name'])) {
    $db_name = trim($_POST['db_name']);    
}elseif (isset($_GET['db_name'])) {
    $db_name = trim($_GET['db_name']);  
}else{
    $db_name = 'tcmls';
}
//echo $db_name;
$db = $dbs["$db_name"];
$dbc = mysqli_connect($db[0], $db[1], $db[2], $db[3]) or die('Error connecting to MySQL server:' . implode(',', $db));
define('PREFIX', $db_name .':o');
?>
