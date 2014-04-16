<?php
include_once ("./db_array.php");
?>

<div class="row" align="center" >

    <?php
    $i = 0;
    foreach ($db_labels as $db_id => $db_label) {
        if ($i == 3) {
            break;
        } else {
            $i++;
        }
        echo '<div class="col-sm-4">';
        echo '<p class="lead"><a href="index.php?db=' . $db_id . '">' . $db_label . '</a><p>';
        echo '<p>' . $db_descs[$db_id] . '</p>';
        echo '<a class="btn btn-xs btn-default" href="index.php?db=' . $db_id . '"><span class="glyphicon glyphicon-search"></span> 文献检索</a>&nbsp;&nbsp; <a class="btn btn-xs btn-default" href="entity_search.php?db_name=' . $db_id . '"><span class="glyphicon glyphicon-search"></span> 知识检索</a>&nbsp;&nbsp;   <a class="btn btn-xs btn-default" href="resource_manager.php?db_name=' . $db_id . '"><span class="glyphicon glyphicon-edit"></span> 文献管理</a>';
        echo '<br>';
        echo '</div>';
    }
    ?>


</div>
<hr>
<a href="db_manager.php">更多资源>></a>