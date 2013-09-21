<?php
include_once ("./header.php");
/*
  function render_graph($dbc, $name) {
  $query = "select * from graph where subject ='$name'  limit 100";

  $result = mysqli_query($dbc, $query) or die('Error querying database2.');
  while ($row = mysqli_fetch_array($result)) {
  $property = $row[property];
  $value = $row[value];

  $id = $row[id];
  echo "<p><strong>$property</strong>:&nbsp;$value";

  echo '<a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&delete_triple_id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>';

  echo "</p>";
  }
  } */

function render_info_by_property($dbc, $name, $property) {
    $query = "select * from graph where subject ='$name' and property = '$property'  limit 100";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {

        $value = $row[value];
        $id = $row[id];
        echo "<p><strong>$property</strong>:&nbsp;$value";
        echo '<a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&delete_triple_id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>';
        echo "</p>";
    }
}

function render_graph_by_property($dbc, $name, $property) {
    $query = "select * from graph where subject ='$name' and property='$property' limit 100";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    if (mysqli_num_rows($result) != 0) {
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title">' . $property . '</h3>';
        echo '</div>';
        echo '<div class="panel-body">';
        while ($row = mysqli_fetch_array($result)) {
            //$property = $row[property];
            $value = $row[value];
            $id = $row[id];
            //echo "<p><strong>$property</strong>:&nbsp;$value";
            echo $value;

            echo '<a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&delete_triple_id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>';

            echo "</p>";
        }
        echo '</div></div>';
    }
}

function render_graph($dbc, $name, $ontology) {
    $types = get_types($dbc, $name);
    foreach ($types as $type) {
        $properties = $ontology[$type];
        foreach ($properties as $property) {
            render_graph_by_property($dbc, $name, $property);
        }
    }
}

function get_types($dbc, $name) {
    $query = "select * from graph where subject = '$name' and property = 'a'";
    $types = array();
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[value];
        array_push($types, $value);
    }
    return $types;
}

$formula = array("分类", "组成", "功用", "主治", "用法", "化裁");
$ontology = array("方剂" => $formula);
//print_r($ontology["方剂"]); 

if (isset($_GET['delete_triple_id'])) {
    $query = "DELETE FROM graph WHERE id = '" . $_GET['delete_triple_id'] . "'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query = "select name from def where id ='$id'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    if ($row = mysqli_fetch_array($result)) {
        $name = $row[name];
        //$def = $row[def];
    }
} else if (isset($_GET['name'])) {
    $name = $_GET['name'];
} else if (isset($_POST['name'])) {
    //$id = $_POST['id'];
    $name = $_POST['name'];
    $property = $_POST['property'];
    $value = $_POST['value'];
    $description = $_POST['description'];

    if (($name != '') && ($property != '') && ($value != '')) {
        //$user_id = $_SESSION[id];
        $user_id = 2;
        $property_escape = mysql_escape_string($property);
        $value_escape = mysql_escape_string($value);
        $description_escape = mysql_escape_string($description);

        $query = "insert into graph (subject, property, value, description, user_id, date) values ('$name','$property_escape','$value_escape', '$description_escape', '$user_id', NOW()) ";

        mysqli_query($dbc, $query) or die('Error querying database.');

        render_warning('实体信息添加成功！');
    } else {
        render_warning('请补全实体信息！');
    }
} else {
    render_warning('无相关实体信息！');
}

if (isset($name) && $name != '') {
    ?>


    <div class="container">

        <?php
        $query = "select * from def where name ='$name'";
        $result = mysqli_query($dbc, $query) or die('Error querying database2.');
        if ($row = mysqli_fetch_array($result)) {
            $def = $row[def];
        } else {
            $def = $name;
        }

        $width = 200;


        echo '<div class="media">';

        $image_file = 'img/' . $name . '.jpg';
        if (is_file(iconv('utf-8', 'gb2312', $image_file))) {
            //$image_file = 'img/NA.jpg';
            echo '<a class="pull-left" href="search.php?keywords=' . $name . '">';
            echo '<img width="' . $width . '" class="media-object" src="' . $image_file . '" data-src="holder.js/64x64">';
            echo '</a>';
        }


        echo '<div class="media-body"  align ="left">';
        echo '<h2>' . $name . '</h2>';
        echo '<h4>' . $def . '</h4>';

        echo '<strong>类型</strong>:&nbsp;' . implode(',', get_types($dbc, $name));

        render_info_by_property($dbc, $name, '定义');
        render_info_by_property($dbc, $name, '注释');
        echo '</div></div></div>';

        echo '<p></p>';
        echo '<div class ="container">';
        if (isset($name)) {
            render_graph($dbc, $name, $ontology);
        }
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">请添加实体信息:</h3>
            </div>
            <div class="panel-body">

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                      enctype="multipart/form-data">

                    <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="property">实体属性:</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="property" name="property" value = "<?php if (isset($property)) echo $property; ?>" placeholder="请输入实体的属性名称">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="value">实体取值:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"  id="value" name="value" row="6" placeholder="请输入实体的属性取值"><?php if (isset($value)) echo $value; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">注释:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description"  placeholder="请输入注释" rows="6"><?php if (isset($description)) echo $description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                            <a class="btn btn-large btn-success" href="search.php?keywords=<?php echo $name; ?>">返回首页</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <?php
}
include_once ("./foot.php");
?>
