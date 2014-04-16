<?php
require_once('appvars.php');

include_once ("./header.php");
include_once ("./messages.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");
include_once ("./db_helper.php");
include_once ("./metadata_helper.php");

if (isset($_GET['id'])) {
    $file_id = $_GET['id'];
} else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $file_id = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];
    $description = $_POST['description'];

    //$property_escape = mysql_escape_string($property);
    //$value_escape = mysql_escape_string($value);

    $query = "update metadata set ";

    $query .= "subject = '" . mysql_escape_string($file_id) . "',";
    $query .= "property='" . mysql_escape_string($property) . "',";
    $query .= "value='" . mysql_escape_string($value) . "',";
    $query .= "description='" . mysql_escape_string($description) . "'";
    $query .= " where id = '$id'";

    mysqli_query($dbc, $query) or die('Error querying database.');
    render_warning('实体信息添加成功！');


    $id = '';
    //$name = '';
    $property = '';
    $value = '';
} else if (isset($_POST['name'])) {
    //$id = $_POST['id'];
    $file_id = $_POST['name'];

    if (isset($_POST['property'])) {
        $property = $_POST['property'];
    } else {
        $property = $_POST['extraproperty'];
    }

    $value = $_POST['value'];
    $description = $_POST['description'];



    //$query = "select * from def where id ='$id'";
    //$result = mysqli_query($dbc, $query) or die('Error querying database3.');



    if (($file_id != '') && ($property != '') && ($value != '')) {
        $user_id = $_SESSION[id];
        $property_escape = mysql_escape_string($property);
        $value_escape = mysql_escape_string($value);
        $description_escape = mysql_escape_string($description);

        $query = "insert into metadata (subject, property, value, description, user_id, date) values ('$file_id','$property_escape','$value_escape', '$description_escape', '$user_id', NOW()) ";
        mysqli_query($dbc, $query) or die('Error querying database.');
        render_warning('实体信息添加成功！');
        //$name = '';
        $property = '';
        $value = '';
        $description = '';
    } else {
        render_warning('请补全实体信息！');
    }
} else {
    render_warning('无相关实体信息！');
}

if (isset($file_id) && $file_id != '') {
    ?>
    <div class="container">
        <?php
        include_once ('resource_header.php');     
        $tab = "update";
        include_once ('resource_title.php');
        echo '<br>';
        $model->render_entity($file_id, true);
        ?>
    </div>
    <?php
}
include_once ("./foot.php");
?>
