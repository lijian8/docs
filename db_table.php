<?php
include_once ("./db_array.php");
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>文献资源库</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($db_labels as $db_id => $db_label) {
            echo '<tr>';
            echo '<td>' . $db_label . '</td>';
            echo '<td>' . $db_descs[$db_id] . '</td>';
            echo '<td width="30%"><a class="btn btn-xs btn-default" href="index.php?db=' . $db_id . '"><span class="glyphicon glyphicon-search"></span> 文献检索</a>&nbsp;&nbsp; <a class="btn btn-xs btn-default" href="entity_search.php?db_name=' . $db_id . '"><span class="glyphicon glyphicon-search"></span> 知识检索</a>&nbsp;&nbsp;   <a class="btn btn-xs btn-default" href="resource_manager.php?db_name=' . $db_id . '"><span class="glyphicon glyphicon-edit"></span> 文献管理</a></td>';
            
            
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
