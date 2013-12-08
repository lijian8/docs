<?php
include_once ("./db_array.php");
?>
<div class="container">
    <h1>该系统已集成了如下的文献资源库：</h1>
    <hr>
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
                echo '<td>'. $db_label . '</td>';
                echo '<td>' . $db_descs[$db_id] . '</td>';                
                echo '<td><a class="btn-link" href="#"><span class="glyphicon glyphicon-search"></span>检索</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
