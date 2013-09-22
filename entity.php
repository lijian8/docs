<?php
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
//include_once ("./image_helper.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");

if (isset($_GET['delete_triple_id'])) {
    delete_triple($dbc, $_GET['delete_triple_id']);
}

if (isset($_GET['id'])) {

    $name = $_GET['id'];
} else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];

    //$property_escape = mysql_escape_string($property);
    //$value_escape = mysql_escape_string($value);

    $query = "update graph set ";

    $query .= "subject = '" . mysql_escape_string($name) . "',";
    $query .= "property='" . mysql_escape_string($property) . "',";
    $query .= "value='" . mysql_escape_string($value) . "'";
    $query .= " where id = '$id'";
    echo $query;
    mysqli_query($dbc, $query) or die('Error querying database.');
    render_warning('实体信息添加成功！');


    $id = '';
    //$name = '';
    $property = '';
    $value = '';
} else if (isset($_POST['name'])) {
    //$id = $_POST['id'];
    $name = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];
    $description = $_POST['description'];



    //$query = "select * from def where id ='$id'";
    //$result = mysqli_query($dbc, $query) or die('Error querying database3.');



    if (($name != '') && ($property != '') && ($value != '')) {
        //$user_id = $_SESSION[id];
        $user_id = 2;
        $property_escape = mysql_escape_string($property);
        $value_escape = mysql_escape_string($value);
        $description_escape = mysql_escape_string($description);

        $query = "insert into graph (subject, property, value, description, user_id, date) values ('$name','$property_escape','$value_escape', '$description_escape', '$user_id', NOW()) ";
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

if (isset($name) && $name != '') {
    ?>
    <div class="container">
        <?php
        $user_id = 2;
        $query = "SELECT * FROM resource where id ='$name'";
        $data = mysqli_query($dbc, $query);

        if ($row = mysqli_fetch_array($data)) {
            echo '<h1>' . $row['title'] . '</h1>';
            echo '<a class="btn-link" href="upload_file.php?action=update&file_id=' . $row[id] . '">' . 编辑元信息 . '</a>';
            if ($row['file'] != '') {
                $file_name = iconv('utf-8', 'gb2312', $row['file']);
                if (is_file(GW_UPLOADPATH . $file_name))
                    echo '<a class="btn-link" href="' . GW_UPLOADPATH . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span></a>';
            }
                    $link_for_delete = $_SERVER['PHP_SELF'] . '?deleted_file=' . $row['id'];
            
            echo '<a class="btn-link" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span></a>';
    

            echo '<p><strong>创建者</strong>' . $row['creator'] . '</p>';
            echo '<p><strong>类型</strong>' . $row['type'] . '</p>';
            echo '<p><strong>来源</strong>' . $row['source'] . '</p>';
            echo '<p><strong>主题</strong>' . $row['subject'] . '</p>';

            echo '<p><strong>录入时间</strong>' . $row['create_time'] . '</p>';



        }
        ?>
        <div class ="well">
            <?php render_entity($dbc, $name, true); ?>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>添加文献元信息</strong>
            </div>
            <div class="panel-body">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                      enctype="multipart/form-data">

                    <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="property">属性:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="property" name="property" value = "<?php if (isset($property)) echo $property; ?>" placeholder="请输入实体的属性名称">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="value">取值:</label>
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
                            <a class="btn btn-large btn-success" href="search.php?keywords=<?php echo $name; ?>">返回首页</a>
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
