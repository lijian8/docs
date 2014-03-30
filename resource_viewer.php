<?php
require_once('appvars.php');
include_once ("./header.php");
include_once ("./messages.php");
include_once ("./entity_helper.php");
include_once ("./functions.php");
include_once ("./db_helper.php");

if (!isset($_GET['id']) || ($_GET['id'] == '')) {
    render_warning('无相关实体信息！');
}

function render_entity_value($dbc, $db_name, $name, $with_def = false) {

    if (strpos($name, $db_name . ':o') === 0) {
        $id = str_replace($db_name . ':o', "", $name);
        $query = "select * from def where id ='$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
        if ($row = mysqli_fetch_array($result)) {
            $name = $row[name];
            $def = $row[def];
            $result = get_entity_link($id, $name, $db_name);
            if ($with_def) {
                if ($def != '') {
                    $result .= '&nbsp;<em><small>(' . $def . ')' . '</small></em>';
                }
            }
        } else {
            $result = $name;
        }
    } else {
        $result = $name;
    }

    return $result;
}

function get_topics($subject, $count = 5) {
    $topics = explode(' ', $subject);
    return array_slice($topics, 0, $count);
}

function get_labels($dbc, $db_name, $identifier, $title) {
    $identifier = $db_name . ':o' . $identifier;
    $query = "select value from graph where subject ='$identifier' and property='标签'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $labels = array();

    while ($row = mysqli_fetch_array($result)) {
        if (isset($row[value]) && ($row[value] != '') && ($row[value] != $title))
            $labels[] = $row[value];
    }
    return $labels;
}

function get_metadata($dbc, $db_name, $identifier) {
    $identifier = $db_name . ':o' . $identifier;
    $query = "select * from metadata where subject ='$identifier'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $metadata = array();

    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];

        $value = render_entity_value($dbc, $db_name, $row[value]) . '&nbsp;';
        if (isset($row[description]) && ($row[description] != ""))
            $value .= '(注释:&nbsp;' . $row[description] . ')';

        if (array_key_exists($property, $metadata)) {
            $metadata[$property] = $metadata[$property] . " " . $value;
        } else {
            $metadata[$property] = $value;
        }
    }
    return $metadata;
}

function render_metadata($dbc, $db_name, $identifier) {
    $metadata = get_metadata($dbc, $db_name, $identifier);
    echo '<table class="table table-bordered">';
    foreach ($metadata as $property => $value) {

        echo '<tr>';
        echo '<td><strong>' . $property . '</strong></td>';
        echo '<td>' . $value . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

$tab = 'abstract';
$name = $_GET['id'];
?>
<div class="container">
    <form class="form-search" action="search.php" method="post" class="form-horizontal"
          enctype="multipart/form-data">
    <?php include_once ("./search_form.php"); ?>
    </form>
    <?php
    $query = "SELECT * FROM resource where id ='$name'";
    $data = mysqli_query($dbc, $query);

    if ($row = mysqli_fetch_array($data)) {
        ?>
        <div class="container">
    <?php echo '<p class="lead"><font color="silver">' . $row['type'] . '</font></p> '; ?>
            <h1><font face = "微软雅黑"><strong><?php echo $row['title']; ?></strong></font></h1>
        </div>

        <div class="row">

            <div class="col-lg-9">
                <!--
                
                <ul class="nav nav-tabs">
                    <li <?php if ($tab == 'abstract') echo 'class="active"'; ?>><a href="sn_list.php" >简介</a></li>

                    <li <?php if ($tab == 'citations') echo 'class="active"'; ?>><a href="sn_profile.php?db_name=tcmls" >相关文献</a></li>   
                    <li <?php if ($tab == 'related') echo 'class="active"'; ?>><a href="sn_profile.php?db_name=tcmct" >引文</a></li>   

                </ul>-->
                <div class="container">

                    <?php
                    $labels = get_labels($dbc, $db_name, $name, $row['title']);
                    if (count($labels) != 0) {
                        echo '<p><font color="silver">别名： ' . implode(', ', $labels) . '</font></p>';
                    }
                    echo '<br>';



                    //echo '<font color="silver">作者: ' . $row['creator'] . '</font> ';
                    //if (isset($row['source'])) echo '<p><strong>来源:</strong> ' . $row['source'] . '</p>';
                    echo '<p><strong>简介：</strong></p>';
                    echo '<p>' . $row['description'] . '</p>';

                    echo '<br> ';
                    echo '<p><strong>文献元数据：</strong></p>';
                    render_metadata($dbc, $db_name, $name);
                    ?>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- <div class="panel panel-default">
                    <div class = "panel-body" >-->

                <ul class="nav nav-pills nav-stacked">
                    <?php
                    echo '<li><strong>相关操作:</strong></li>';
                    echo '<li><a  href="resource_editor.php?db_name=' . $db_name . '&id=' . $name . '"><span class="glyphicon glyphicon-edit"></span>&nbsp;编辑文献元数据</a></li>';
                    echo '<li><a  href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;返回检索结果页</a></li>';
                    if ($row['file'] != '') {
                        $file_name = iconv('utf-8', 'gb2312', $row['file']);
                        if (is_file(GW_UPLOADPATH . $db_name . '/' . $file_name)) {
                            echo '<li><a class="btn btn-link " href="' . GW_UPLOADPATH . $db_name . '/' . $row['file'] . '"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp; 下载原文</a></li>';
                        } else {
                            echo '<li class="disabled"><a><span class="glyphicon glyphicon-cloud-download"></span>下载原文</a>';
                        }
                    } else {
                        echo '<li class="disabled"><a><span class="glyphicon glyphicon-cloud-download"></span>下载原文</a>';
                    }
                    echo '<hr>';
                    echo '<li><strong>相关主题:</strong></li> ';

                    foreach (get_topics($row['subject']) as $topic) {
                        if ($topic != '')
                            echo '<li><a href="#">' . $topic . '</a></li>';
                    }


                    echo '<hr>';
                    echo '<li><strong>录入时间:&nbsp;</strong></li>';
                    echo '<li>' . $row['create_time'] . '</li>';
                    ?>
                </ul>

            </div>






            <?php
        }
        ?>
    </div>
    <?php
    include_once ("./foot.php");
    ?>
