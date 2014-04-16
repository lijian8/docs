<?php
$query = "SELECT * FROM resource where id ='$file_id'";
$data = mysqli_query($dbc, $query);

if ($row = mysqli_fetch_array($data)) {
    echo '<div class = "container">';
    echo '<p class="lead"><font color="silver">' . $row['type'] . '</font></p> ';
    echo '<h1><font face = "微软雅黑"><strong>' . $row['title'] . '</strong></font></h1>';
    echo '</div>';
    echo '<br>';
}
?>
<ul class = "nav nav-tabs">
    <li <?php if ($tab =='editor') echo 'class="active"'; ?>><a href = "resource_editor.php?db_name=<?php echo $db_name; ?>&id=<?php echo $file_id; ?>" >编辑文献基本信息</a></li>
    <li <?php if ($tab == "update") echo 'class="active"'; ?>><a href = "resource_update.php?db_name=<?php echo $db_name; ?>&id=<?php echo $file_id; ?>" >修改文献元信息</a></li>
    <li <?php if ($tab == "extend") echo 'class="active"'; ?>><a href = "resource_extend.php?db_name=<?php echo $db_name; ?>&id=<?php echo $file_id; ?>" >添加文献元信息</a></li>
    
</ul>
