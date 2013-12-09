<?php
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
//include_once ("./image_helper.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");
include_once ("./db_helper.php");

echo $db_name;

if (!isset($_GET['id']) || ($_GET['id'] == '')) {
    render_warning('无相关实体信息！');
}

$name = $_GET['id'];
?>
<div class="container">
      <form class="form-search" action="search.php" method="post" class="form-horizontal"
            enctype="multipart/form-data">
         <?php  include_once ("./search_form.php"); ?>
      </form>
    
    <?php
   

   

    $query = "SELECT * FROM resource where id ='$name'";
    $data = mysqli_query($dbc, $query);

    if ($row = mysqli_fetch_array($data)) {
        echo '<div class="container">';
        echo '<h1>' . $row['title'] . '</h1>';

        if ($row['file'] != '') {
            $file_name = iconv('utf-8', 'gb2312', $row['file']);
            if (is_file(GW_UPLOADPATH . $file_name))
                echo '&nbsp;<a class="btn btn-primary btn-xs" href="' . GW_UPLOADPATH . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span>下载</a>';
        }
        echo '&nbsp;';
        echo '<a class="btn btn-primary btn-xs" href="resource_editor.php?id=' . $name . '"><span class="glyphicon glyphicon-edit"></span>&nbsp;编辑</a>';
        echo '&nbsp;';
        echo '<a class="btn btn-success  btn-xs" href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;返回</a>';
        echo '</div>';
        echo '<p></p>';
        echo '<div class="container">';
        echo '<strong>录入时间:&nbsp;</strong>' . $row['create_time'];
        echo '<p><strong>摘要:&nbsp;</strong>' . $row['description'] . '</p>';
        echo '<p><strong>作者:</strong>' . $row['creator'] . '</p>';
        echo '<p><strong>类型:</strong>' . $row['type'] . '</p>';
        echo '<p><strong>来源:</strong>' . $row['source'] . '</p>';
        echo '<p><strong>主题:</strong>' . $row['subject'] . '</p>';
        echo '</div>';
        echo '<p></p>';
    }

//render_entity($dbc, $name, false);

    $query = "select * from metadata where subject ='$name'";
    //if (!$edit) $query .= " limit 10";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
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
