<?php
include_once ("./header.php");
include_once ("./db_helper.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "select name from def where id ='$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $name = $row[name];
    }
} else if (isset($_GET['name'])) {
    $name = $_GET['name'];
} else if (isset($_POST['name'])) {

    $name = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];
    $description = $_POST['description'];

    if (($name != '') && ($property != '') && ($value != '')) {
        $user_id = $_SESSION[id];
        $property_escape = mysql_escape_string($property);
        $value_escape = mysql_escape_string($value);
        $description_escape = mysql_escape_string($description);

        $query = "insert into graph (subject, property, value, description, user_id, date) values ('$name','$property_escape','$value_escape', '$description_escape', '$user_id', NOW()) ";

        mysqli_query($dbc, $query) or die('Error querying database:' . $query);

        render_warning('实体信息('. $name .','.$property.','.$value.')添加成功！');
    } else {
        render_warning('请补全实体信息！');
    }
} else {
    render_warning('无相关实体信息！');
}

if (isset($name) && $name != '') {
    ?>


    <div class="container">  
        <h1><?php echo $name; ?></h1>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">请添加实体信息:</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                      enctype="multipart/form-data">

                    <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="property">实体属性:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="property" name="property" value = "<?php if (isset($property)) echo $property; ?>" placeholder="请输入实体的属性名称">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="value">实体取值:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"  id="value" name="value" row="6" placeholder="请输入实体的属性取值"><?php if (isset($value)) echo $value; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">注释:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description"  placeholder="请输入注释" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                            <a class="btn btn-large btn-success" href="entity.php?name=<?php echo $name; ?>">返回</a>
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
