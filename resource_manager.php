<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
require_once('appvars.php');
include_once ("./db_helper.php");

if (isset($_GET['deleted_file'])) {

    $deleted_file = get_title_by_id($dbc, $_GET['deleted_file']);

    delete_resource($dbc, $db_name, $_GET['deleted_file']);

    //echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
    //echo '文献"' . $deleted_file . '"已被删除!</div>';
    render_success('文献"' . $deleted_file . '"已被删除!');
}
?>
<p></p>
<div class="container">
    <?php    include_once ('resource_header.php'); ?>
    <table class="table table-hover">
        <tbody>
            <tr class="info">
                <td>#</td>
                <td ><strong>创建者</strong></td>
                <td><strong>题名</strong></td>
                <td><strong>类型</strong></td>
                <td><strong>出处</strong></td>
                <td><strong>主题</strong></td>
                <td><strong>上传时间</strong></td> 
                <td><strong>删除</strong></td>

            </tr>

            <?php
            $user_id = $_SESSION[id];
            //$user_id = 2;
            $query = "SELECT * FROM resource where user_id ='$user_id' ORDER BY title ASC LIMIT 0,100";
            $data = mysqli_query($dbc, $query);

            $row_num = 1;
            $color = true;
            while ($row = mysqli_fetch_array($data)) {
                if ($color) {
                    echo '<tr>';
                } else {
                    echo '<tr class="info">';
                }
                $color = !$color;
                echo '<td width = "3%">' . $row_num++ . '</td>';
                echo '<td width = "15%">' . $row['creator'] . '</td>';

                echo '<td width = "32%">';
                //echo '<a class="btn-link" href="basic.php?action=update&file_id=' . $row[id] . '">' . $row['title'] . '</a>';
                echo '<a class="btn-link" href="resource_editor.php?db_name=' . $db_name . '&id=' . $row[id] . '">' . $row['title'] . '</a>';


                if ($row['file'] != '') {
                    $file_name = iconv('utf-8', 'gb2312', $row['file']);
                    if (is_file(GW_UPLOADPATH . $db_name . '/' . $file_name))
                        echo '<a class="btn-link" href="' . GW_UPLOADPATH . $db_name . '/' . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span></a>';
                }
                echo '</td>';

                echo '<td width = "5%">' . $row['type'] . '</td>';

                echo '<td width = "20%">' . $row['source'] . '</td>';
                echo '<td width = "10%">' . $row['subject'] . '</td>';

                echo '<td width = "10%">' . $row['create_time'] . '</td>';
                //$file_name = iconv('utf-8', 'gb2312', $row['file']);
                echo '<td width = "5%">';
                $link_for_delete = $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&deleted_file=' . $row['id'];
                echo '<a class="btn-link" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
            }
            ?>
        </tbody>
    </table>


</div> 
<?php
include_once ("./foot.php");
?>