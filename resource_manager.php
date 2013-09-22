<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
require_once('appvars.php');

if (isset($_GET['deleted_file'])) {

    $deleted_file = get_title_by_id($dbc, $_GET['deleted_file']);

    delete_resource($dbc, $_GET['deleted_file']);

    //echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
    //echo '文献"' . $deleted_file . '"已被删除!</div>';
    render_success('文献"' . $deleted_file . '"已被删除!');
}
?>
<p></p>
<div class="container">
    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">文献管理</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">

                <li><a href="upload_file.php?action=create&type=期刊文献"><span class="glyphicon glyphicon-list"></span>&nbsp;录入</a></li>               
                <li><a href="upload.php"><span class="glyphicon glyphicon-cloud-upload"></span>&nbsp;上传</a></li>               

            </ul>

            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>&nbsp;搜索</button>
            </form>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" >返回首页</a></li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>

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
            //$user_id = $_SESSION[id];
            $user_id = 2;
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
                echo '<a class="btn-link" href="upload_file.php?action=update&file_id=' . $row[id] . '">' . $row['title'] . '</a>';

                if ($row['file'] != '') {
                    $file_name = iconv('utf-8', 'gb2312', $row['file']);
                    if (is_file(GW_UPLOADPATH . $file_name))
                        echo '<a class="btn-link" href="' . GW_UPLOADPATH . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span></a>';
                }
                echo '</td>';

                echo '<td width = "5%">' . $row['type'] . '</td>';

                echo '<td width = "20%">' . $row['source'] . '</td>';
                echo '<td width = "10%">' . $row['subject'] . '</td>';

                echo '<td width = "10%">' . $row['create_time'] . '</td>';
                //$file_name = iconv('utf-8', 'gb2312', $row['file']);
                echo '<td width = "5%">';
                $link_for_delete = $_SERVER['PHP_SELF'] . '?deleted_file=' . $row['id'];
                echo '<a class="btn-link" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
            }
            ?>
        </tbody>
    </table>


</div> 
<?php
include_once ("./foot.php");
?>