<?php
include_once ("./header.php");
include_once ("./search_helper.php");
include_once ("./functions.php");
//include_once ("./onto_array.php");
include_once ("./appvars.php");
include_once ("./entity_helper.php");
include_once ("./db_helper.php");



$names = array('英文正名', '标签', '英文异名', '中文异名', '中文正名', '异名', '汉语拼音', '英文名', '别名');
$type_labels = array('类型');

if (isset($_GET['delete_triple_id'])) {
    $query = "DELETE FROM graph WHERE id = '" . $_GET['delete_triple_id'] . "'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "select name, def from def where id ='$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $file_id = $row[name];
        $def = $row[def];
    } else {
        //render_warning('无相关实体信息！');
    }
} else if (isset($_GET['name'])) {
    $file_id = $_GET['name'];
    $query = "select id, def from def where name ='$file_id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $id = $row[id];
        $def = $row[def];
    } else {
        //  render_warning('无相关实体信息！');
    }
} else {
    //render_warning('无相关实体信息！');
}


if (isset($_GET['type'])) {
    $entity_type = $_GET['type'];
    $types_string = $entity_type;
} else {
    $types = get_types($dbc, $id);
    $entity_type = $types[0];
    $types_string = implode(',', $types);
}
$keywords = $file_id;
?>


<div class="container">
    <?php include_once ('entity_search_form.php');
    ?>





    <div class="panel">
        <ul class="nav nav-pills pull-right">    
            <li><a class='pull-right' href='#'><span class='glyphicon glyphicon-pencil'></span> 编辑词条</a></li>
            <li><a  href="editor.php?db_name=<?php echo $db_name; ?>&name=<?php echo $file_id; ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;添加信息</a></li>
        </ul>
    </div>
    <h1>  
        <font face="微软雅黑"><strong>
            <?php echo $file_id . '(' . $types_string . ')'; ?>       
        </strong>
        </font>


    </h1>

    <?php
    if (isset($file_id) && $file_id != '' && isset($id) && $id != '') {
        echo '<p><em>' . $def . '</em></p>';
        include_once ("./entity_lit_graph.php");
    } else {
        render_warning('该库中无相关实体信息！');
    }
    ?>

    <?php
    include_once ("./foot.php");
    ?>
