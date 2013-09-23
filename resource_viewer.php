<?php
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
//include_once ("./image_helper.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");



if (!isset($_GET['id']) || ($_GET['id'] == '')) {
    render_warning('无相关实体信息！');
}

$name = $_GET['id'];
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
        echo '&nbsp;';
        echo '<a class="btn btn-primary btn-xs" href="resource_editor.php?id=' . $name .'"><span class="glyphicon glyphicon-edit"></span>&nbsp;编辑</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-success  btn-xs" href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;返回</a>';
        echo '<p></p><strong>录入时间:&nbsp;</strong>' . $row['create_time'];
        echo '<p>';
        echo '<strong>摘要:&nbsp;</strong>' . $row['description'];
        echo '</p>';
        echo '</div>';
        echo '<p></p>';


        echo '<div class = "panel panel-default">';
        echo '<div class = "panel-heading">';
        echo '<strong>文献基本信息</strong>';
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

//render_entity($dbc, $name, false);

    $query = "select * from graph where subject ='$name'";
    //if (!$edit) $query .= " limit 10";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];
        $value = $row[value];
        //if (!$edit)  $value = tcmks_substr($value);
        $id = $row[id];
        $description = $row[description];



        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo '<strong>' . $property . '</strong>';

        echo '</div>';
        echo '<div class="panel-body">';
        echo $value . '&nbsp;(注释:&nbsp;' . $description . ')';

    
        echo '</div>';
        echo '</div>';
    }
    ?>





</div>
<?php
include_once ("./foot.php");
?>
