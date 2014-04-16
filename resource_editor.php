<?php
require_once('appvars.php');

include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./functions.php");
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
include_once ("./entity_helper.php");
include_once ("./db_helper.php");
include_once ("./metadata_helper.php");

echo '<p></p>';

if (isset($_GET['delete_triple_id'])) {
    $model->delete_triple($_GET['delete_triple_id']);
}


if (isset($_POST['submit'])) {
    $file_id = $_POST['id'];

    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        $file_name = upload_file($db_name, $file_id);
    }

    $title = $_POST['title'];
    $creator = $_POST['creator'];
    $publisher = $_POST['publisher'];
    $description = $_POST['description'];
    $identifier = $_POST['identifier'];

    $source = $_POST['source'];

    $type = $_POST['type'];
    $subject = $_POST['subject'];

    $query = "update resource set ";

    $query .= "title = '" . mysql_escape_string($title) . "',";

    if ('' != $file_name) {
        $query .= "file = '$file_name',";
    }

    $query .= "source='" . mysql_escape_string($source) . "',";
    $query .= "creator='" . mysql_escape_string($creator) . "',";
    //$query .= "description = '".tcmks_substr(mysql_escape_string($description),1000)."',";
    $query .= "description = '" . mysql_escape_string($description) . "',";
    $query .= "publisher = '" . mysql_escape_string($publisher) . "', ";
    $query .= "identifier = '" . mysql_escape_string($identifier) . "', ";
    $query .= "subject = '" . mysql_escape_string($subject) . "' ";

    $query .= " where id = '$file_id'";

    //echo $query;
    //$query = "INSERT INTO resource VALUES ('$file_id', '$title', '$file_name', '$creator', '$journal', '$pages', '$year', '$publisher',NULL)";
    mysqli_query($dbc, $query);

    echo '<div class="alert alert-success">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo '<h4>文献录入成功!</h4>';
    echo '文献信息如下：';
    echo '<dl class="dl-horizontal">';
    echo "<dt>文献题目:</dt><dd>" . $title . '</dd>';
    echo "<dt>文献类型:</dt><dd>" . $type . '</dd>';
    if ('' != $file_name) {
        echo "<dt>文件名称:</dt><dd>" . $file_name . "</dd>";
        echo "<dt>文件类型:</dt><dd>" . $_FILES["file"]["type"] . "</dd>";
        echo "<dt>文件尺寸:<dt><dd>" . ($_FILES["file"]["size"] / 1024) . "Kb</dd>";
    } else {
        echo '您没有上传原文！';
    }
    echo '</dl></div>';
} else {
    /*
      if ($_GET['action'] == 'create') {
      //echo 'create new resource!';

      $type = isset($_GET['type']) ? $_GET['type'] : '其他资源';

      $file_id = init_resource($dbc, $type);
      } elseif ($_GET['action'] == 'update') {
     * 
     */
    $file_id = $_GET['id'];
    $query = "SELECT * FROM resource WHERE id = '$file_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {
        $title = $row['title'];
        $creator = $row['creator'];
        $publisher = $row['publisher'];
        $source = $row['source'];
        $description = $row['description'];
        $type = $row['type'];
        $subject = $row['subject'];
        $identifier = $row['identifier'];
        //$file_name = $row['file'];
        if ($row['file'] != '') {
            $file_name = iconv('utf-8', 'gb2312', $row['file']);
        }
    }
}
?>

<div class="container">

    <?php
    include_once ('resource_header.php');
    $tab = 'editor';
    include_once ('resource_title.php');
    echo '<br>';
    ?>
    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
          enctype="multipart/form-data">


        <input  type="hidden" id="id" name="id" value = "<?php if (isset($file_id)) echo $file_id; ?>" >
        <input  type="hidden" id="type" name="type" value = "<?php if (isset($type)) echo $type; ?>" >
        <input  type="hidden" id="db_name" name="db_name" value = "<?php if (isset($db_name)) echo $db_name; ?>" >

        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">题名:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="title" name="title" value = "<?php if (isset($title)) echo $title; ?>" placeholder="请输入文献的题目">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="identifier">标识:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="identifier" name="identifier" value = "<?php if (isset($identifier)) echo $identifier; ?>" placeholder="请输入文献的标识">
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-2 control-label" for="creator">创建者:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="creator" name="creator" value = "<?php if (isset($creator)) echo $creator; ?>" placeholder="请输入作者">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="source">出处:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="source" name="source" value = "<?php if (isset($source)) echo $source; ?>" placeholder="请输入出处">

            </div>
        </div>               

        <div class="form-group">
            <label class="col-sm-2 control-label" for="publisher">出版者:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="publisher" name="publisher" value = "<?php if (isset($publisher)) echo $publisher; ?>" placeholder="请输入出版者">

            </div>
        </div>               

        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject">主题:</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" id="subject" name="subject" value = "<?php if (isset($subject)) echo $subject; ?>" placeholder="请输入主题">

            </div>
        </div>               


        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">描述:</label>
            <div class="col-sm-8">
                <textarea class="form-control" id="description" name="description"  placeholder="请输入描述" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="file">上传原文:</label>
            <div class="col-sm-8">
                <input class="form-control" type="file" name="file" id="file" /> 

            </div>
            
                <?php
                //if ($row['file'] != '') {
                //$file_name = iconv('utf-8', 'gb2312', $row['file']);
                if ((isset($file_name)) && ($file_name != '') && (is_file(GW_UPLOADPATH . $db_name . '/' . $file_name))) {
                    echo '<a class="btn btn-primary" href="' . GW_UPLOADPATH . $db_name . '/' . $file_name . '">下载原文</a>';
                }
                //}
                ?>
           


        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input class="btn btn-primary" type="submit" name="submit" value="确认修改" />    
                <?php
                echo '&nbsp;&nbsp;<a class="btn btn-danger" href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&deleted_file=' . $row['id'] . '">删除本文</a>';
                ?>

            </div>
        </div>

    </form>


</div>

<?php
include_once ("./foot.php");
?>
