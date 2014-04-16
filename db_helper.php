<?php

include_once ("./db_array.php");

if (!isset($db_name)) {
    if (isset($_POST['db_name'])) {
        $db_name = trim($_POST['db_name']);
    } elseif (isset($_GET['db_name'])) {
        $db_name = trim($_GET['db_name']);
    } else {
        $db_name = 'tcmls';
    }
}

$db = $dbs["$db_name"];
$dbc = mysqli_connect($db[0], $db[1], $db[2], $db[3]) or die('Error connecting to MySQL server:' . implode(',', $db));
define('PREFIX', $db_name . ':o');
define('DEFAULT_DB_NAME', 'tcmlm');
$db_label = $db_labels["$db_name"];

Class DB_Manager {
            public$db_labels;

    function DB_Manager($db_labels) {
        $this->db_labels = $db_labels;
    }

    function render_db_list() {
        foreach ($this->db_labels as $db => $label) {
            echo "<li><a href='resource_manager.php?db_name=$db'>$label</a></li>";
        }
        echo '<li class="divider"></li>';
        echo '<li><a href="db_manager.php">更多>></a></li>';
    }

}

$db_manager = new DB_Manager($db_labels);
?>
