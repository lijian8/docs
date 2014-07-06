<?php
$db_name = "clan";
include_once ("./header.php");
include_once ("./functions.php");

function render_triples($dbc, $property, $verb) {
    /*
      $query = "SELECT * FROM verbs WHERE property like '%$property%' and verb = '$verb' ";
      $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

      echo '<table class="table table-bordered" >';
      while ($row = mysqli_fetch_array($result)) {
      echo '<tr>';
      echo '<td>' . $row[subject] . '</td>';
      echo '<td>' . $row[verb] . '</td>';
      echo '<td>' . $row[object] . '</td>';
      echo '<td>' . $row[text] . '</td>';
      echo '</tr>';
      }
      echo '</table>';
     */
    $query = "SELECT * FROM verbs WHERE property like '%$property%' and verb = '$verb' ";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<p>';
        echo '<a href="#">' . $row[subject] . '</a>&nbsp;&nbsp;<font color = "green" >' . $row[verb] . '</font>&nbsp;&nbsp;<a href="#">' . $row[object] . '</a>';
        echo '</font></br>';
        render_full_text($dbc, $row[text], array($row[subject], $row[object]), array($row[verb]));
        echo '</p>';
    }
    //echo '<hr>';
}

function get_colored_text($text, $keywords, $color) {
    foreach ($keywords as $keyword) {
        $text = str_replace($keyword, '<font color = "' . $color . '" ><strong>' . $keyword . '</strong></font>', $text);
    }
    return $text;
}

function render_full_text($dbc, $text, $keywords, $verbs) {
    $query = "SELECT * FROM resource WHERE description like '%$text%' ";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    //echo "<p>" . $text . "</p>";

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            //echo "<p>" . $row[description] . "</p>";
            $id = $row[id];
            $index = mb_strpos($row[description], $text, 0, 'utf-8');
            $description = mb_substr($row[description], max(0, $index - 200), 200 + strlen($text), 'utf-8');
            //$description = str_replace( $text, '<font color = "red">' . $text . '</font>', $row[description]);
            $colored_text = get_colored_text($text, $verbs, 'green');
            $colored_text = get_colored_text($colored_text, $keywords, 'red');

            $description = str_replace($text, '<font  style="background-color:yellow;">' . $colored_text . '</font>', $description);

            $remained_keywords = array();
            foreach ($keywords as $keyword) {
                // echo $text . $keyword . mb_strpos($text, $keyword, 0, 'utf-8');
                if (mb_strpos($text, $keyword, 0, 'utf-8') === false) {
                    $remained_keywords[] = $keyword;
                }
            }
            $description = get_colored_text($description, $remained_keywords, 'red');
            echo '<blockquote>......' . $description . '...... <a href="annotation.php?text_id=' . $id . '"><span class="glyphicon glyphicon-search"></span></a>' . '</blockquote><br>';
            //echo strrpos ($row[description], $text);
        }
    } else {
        echo '<blockquote>......' . $text . '</blockquote>';
    }
}

function get_relation_def($dbc, $name) {
    $query = "SELECT def FROM relations WHERE name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    if ($row = mysqli_fetch_array($result)) {
        return $row[def];
    }
}

function get_verbs($dbc, $property) {
    $query = "SELECT verb, count(*) FROM verbs WHERE property like '%$property%' group by verb order by count(*) desc";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $verbs = array();
    while ($row = mysqli_fetch_array($result)) {
        $verbs[] = $row[verb];
    }
    return $verbs;
}

function render_properties($dbc, $active_property) {
    $query = "SELECT * FROM verbs";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $property_array = array();
    while ($row = mysqli_fetch_array($result)) {
        foreach (explode("$", $row[property]) as $cur_property) {
            if (array_key_exists($cur_property, $property_array)) {
                $property_array[$cur_property] = $property_array[$cur_property] + 1;
            } else {
                $property_array[$cur_property] = 1;
            }
        }
    }
    arsort($property_array);
    foreach ($property_array as $property => $count) {
        echo '<li ';
        if ($property == $active_property) {
            echo 'class = "active"';
        }
        echo '><a href = "' . $_SERVER[PHP_SELF] . '?';
        echo 'active_property=' . $property . '">' . $property . '</a></li>';
    }
}

if (isset($_GET['active_property']) && ($_GET['active_property'] != '')) {
    $active_property = $_GET['active_property'];
} else {
    $active_property = '位于';
}
?>
<div class="container">    
    <?php
    $page_name = 'relations';
    include_once ("./classics_header.php");
    ?>


    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">
                     <font class="lead">中医古籍中的语义关系</font> 
                 </div>-->
                <div class="panel-body">                    
                    <h1><font face="微软雅黑">语义关系：</font></h1>
                    <hr>
                    <ul class="nav nav-pills">
                        <?php
                        render_properties($dbc, $active_property);
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9" role="main">     

            <div >  
                <?php
                if (isset($active_property)) {

                    echo '<h1 id = "title"><font face="微软雅黑">' . $active_property . '</font></h1>';
                    echo '<hr>';

                    $def = get_relation_def($dbc, $active_property);
                    if (isset($def) && ($def != '')) {
                        //echo '<blockquote><p>位置、场所，一个实体的位置或一个过程的场所。</p></blockquote>';
                        //echo '<blockquote><p>The position, site, or region of an entity or the site of a process.</p></blockquote>';
                        echo '<blockquote><p>' . $def . '</p></blockquote>';                        
                        echo '<hr>';
                    }
                    
                    $verbs = get_verbs($dbc, $active_property);
                    echo '<div class = "panel panel-default"><div class = "panel-heading">';
                    echo '<font class = "lead">相关谓词：</font>';
                    echo '</div>';
                    echo '<div class = "panel-body">';
                    echo '<ul class = "nav nav-pills">';
                    foreach ($verbs as $verb) {
                        echo '<li><a  href="#' . $verb . '">' . $verb . '</a></li>';
                    }

                    echo '</ul></div></div>';

                    echo '<br>';


                    //echo '<div class = "panel panel-default"><div class = "panel-heading">';
                    //echo '<font class="lead">“' . $active_property . '”的相关表述:</font>';
                    //echo '</div>';
                    //echo '<div class = "panel-body">';
                    //echo '<div class = "container">';
                    foreach ($verbs as $verb) {
                        echo '<p class="lead" id="' . $verb . '"><font face="微软雅黑" color="green">' . $verb . '</font><a class="btn btn-link pull-right" href="#title">回到顶端</a></p>';
                        echo '<hr>';
                        render_triples($dbc, $active_property, $verb);
                    }
                    //echo '</div></div></div>';
                } else {
                    render_warning('<<请在右侧选择关系以查看相关陈述');
                }
                ?>
            </div>
        </div>    
    </div>
</div>
<?php
include_once ("./foot.php");
?>