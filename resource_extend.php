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
        $tab = "extend";
        include_once ('resource_title.php');
        echo '<br>';
        ?>
        <div class="panel panel-default">

            <div class="panel-body">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                      enctype="multipart/form-data">

                    <input  type="hidden" id="name" name="name" value = "<?php echo $file_id; ?>" >
                    <input  type="hidden" id="db_name" name="db_name" value = "<?php echo $db_name; ?>" >

                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="property">属性:</label>
                        <div class="col-sm-11">
                            <?php
                            foreach ($model->get_all_properties() as $p) {
                                echo '<label>';
                                echo '<input type="radio" id="property" name="property" value="' . $p . '" > ';
                                echo $p;
                                echo '</label>&nbsp;&nbsp; ';
                            }
                            ?>                       
                            <input class="form-control" id="extraproperty" name="extraproperty" type="text"  value = "<?php if (isset($property)) echo $property; ?>" placeholder="其他属性...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="value">取值:</label>
                        <div class="col-sm-11">

                            <textarea class="form-control"  id="value" name="value" row="2" placeholder="请输入取值..."><?php if (isset($value)) echo $value; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="description">注释:</label>
                        <div class="col-sm-11">
                            <textarea class="form-control" id="description" name="description"  placeholder="请输入注释" rows="2"><?php if (isset($description)) echo $description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php
}
include_once ("./foot.php");
?>


