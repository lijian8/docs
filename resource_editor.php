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
    $description = $_POST['description'];

    //$property_escape = mysql_escape_string($property);
    //$value_escape = mysql_escape_string($value);

    $query = "update graph set ";

    $query .= "subject = '" . mysql_escape_string($name) . "',";
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
    $name = $_POST['name'];

    if (isset($_POST['property'])) {
        $property = $_POST['property'];
    } else {
        $property = $_POST['extraproperty'];
    }

    $value = $_POST['value'];
    $description = $_POST['description'];



    //$query = "select * from def where id ='$id'";
    //$result = mysqli_query($dbc, $query) or die('Error querying database3.');



    if (($name != '') && ($property != '') && ($value != '')) {
        $user_id = $_SESSION[id];
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
            echo '<div class="well">';
            echo '<h1>' . $row['title'] . '</h1>';

            if ($row['file'] != '') {
                $file_name = iconv('utf-8', 'gb2312', $row['file']);
                if (is_file(GW_UPLOADPATH . $file_name))
                    echo '&nbsp;<a class="btn btn-primary btn-xs" href="' . GW_UPLOADPATH . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span>下载</a>';
            }
            $link_for_delete = $_SERVER['PHP_SELF'] . '?deleted_file=' . $row['id'];
            echo '&nbsp;';
            echo '<a class="btn btn-primary  btn-xs" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a>';
            echo '&nbsp;';
            echo '<a class="btn btn-success  btn-xs" href="#"><span class="glyphicon glyphicon-home"></span>&nbsp;返回</a>';
            echo '<p></p><strong>录入时间:&nbsp;</strong>' . $row['create_time'];
            echo '<p>';
            echo '<strong>摘要:&nbsp;</strong>' . $row['description'];
            echo '</p>';
            echo '</div>';
            echo '<p></p>';


            echo '<div class = "panel panel-default">';
            echo '<div class = "panel-heading">';
            echo '<strong>文献基本信息</strong>';
            echo '<a class="btn btn-link pull-right" href="basic.php?action=update&file_id=' . $row[id] . '">&nbsp;' . 编辑 . '</a>';
            echo '</div>';
            echo '<div class = "panel-body">';
            echo '<div class = "row">';

            echo '<div class = "col-md-1"><strong>作者:</strong></div>';
            echo '<div class = "col-md-11">' . $row['creator'] . '</div>';

            echo '<div class = "col-md-1"><strong>类型:</strong></div>';
            echo '<div class = "col-md-11">' . $row['type'] . '</div>';


            echo '<div class = "col-md-1"><strong>来源:</strong></div>';
            echo '<div class = "col-md-11">' . $row['source'] . '</div>';


            echo '<div class = "col-md-1"><strong>主题:</strong></div>';
            echo '<div class = "col-md-11">' . $row['subject'] . '</div>';



            echo '</div>';

            echo '</div>';
            echo '</div>';
        }

        render_entity($dbc, $name, true);
        ?>


        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>添加文献元信息</strong>
            </div>
            <div class="panel-body">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                      enctype="multipart/form-data">

                    <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="property">属性:</label>
                        <div class="col-sm-10">
                            <label>
                                <input type="radio" id="property" name="property" value="贡献者" >
                                贡献者
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="格式" >
                                格式
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="出版地点" >
                                出版地点
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="印刷地点" >
                                印刷地点
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="印刷地点" >
                                日期
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="历代医家" >
                                历代医家
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="各家学说" >
                                各家学说
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="数据来源" >
                                数据来源
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="覆盖范围" >
                                覆盖范围
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="语言" >
                                语言
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="存储地点" >
                                存储地点
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="收藏历史" >
                                收藏历史
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="文献破损级别" >
                                破损级别
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="文献资源珍稀程度" >
                                珍稀程度
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="权限" >
                                权限
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" id="property" name="property" value="保存方式" >
                                保存方式
                            </label>
                            &nbsp;

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
