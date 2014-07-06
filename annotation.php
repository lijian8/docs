<?php
$db_name = "clan";
include_once ("./header.php");
include_once ("./functions.php");

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function preprocess_description($db_name, $description, $keywords, $predicates) {
    if (startsWith($description, "ZZ")) {
        $description = '<p>' . substr($description, 2) . '</p>';
    } elseif (startsWith($description, "PP") || startsWith($description, "JJ")) {
        $description = '<p class="lead">' . substr($description, 2) . '</p>';
    } else {
        $description = '<p>' . $description . '</p>';
    }
    foreach ($predicates as $predicate) {
        $description = str_replace($predicate, "<font color='green'>" . $predicate . "</font>", $description);
    }
    foreach ($keywords as $keyword) {
        //$rep = '<a href="#" data-container="body" data-toggle="popover" data-placement="bottom" data-content="' . $def . '">' . $keyword . '</a>';
        $description = str_replace($keyword, "<a href='entity.php?db_name=$db_name&name=$keyword' >" . $keyword . "</a>", $description);
        //$description = str_replace($keyword, $rep, $description);
    }


    return $description;
}

function get_predicates($dbc, $id) {
    $query = "SELECT * FROM relation WHERE docs=$id";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $keywords = array();
    while ($row = mysqli_fetch_array($result)) {


        if (($row["PREDICATE"] != '') && (!in_array($row["PREDICATE"], $keywords))) {
            $keywords[] = $row["PREDICATE"];
        }
    }

    return $keywords;
}

function get_keywords($dbc, $id) {
    $query = "SELECT * FROM relation WHERE docs=$id";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $keywords = array();
    while ($row = mysqli_fetch_array($result)) {
        if (($row["SUBJECT"] != '') && (!in_array($row["SUBJECT"], $keywords))) {
            $keywords[] = $row["SUBJECT"];
        }

        if (($row["OBJECT"] != '') && (!in_array($row["OBJECT"], $keywords))) {
            $keywords[] = $row["OBJECT"];
        }
    }

    return $keywords;
}

function get_def($dbc, $name) {
    $query = "select def from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    if (($row = mysqli_fetch_array($result)) && ($row["def"] != '')) {
        return $row["def"];
    } else {
        return '...';
    }
}

function render_entities($dbc, $id) {
    $keywords = get_keywords($dbc, $id);
    foreach ($keywords as $keyword) {
        echo '<a href="#" >' . $keyword . '</a><br>';
        echo '<p>' . get_def($dbc, $keyword) . '</p>';
        //echo '<br>';
    }
}

function render_relations($dbc, $id) {
    $query = "SELECT * FROM relation WHERE docs=$id";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

    if (mysqli_num_rows($result) != 0) {
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr><td>主体</td><td>谓词</td><td>客体</td></tr>';
        echo '<thead>';
        $row_no = 0;
        while ($row = mysqli_fetch_array($result)) {
            if ($row_no == 20) {
                break;
            } else {
                echo "<tr>" . "<td>" . $row["SUBJECT"] . "</td>" . "<td>" . $row["PREDICATE"] . "</td>" . "<td>" . $row["OBJECT"] . '</td><td><a href="#"><span class="glyphicon glyphicon-search"></span></td></tr>';
                $row_no++;
            }
        }
        echo '</table>';
    }
}

function identify($dbc, $name) {

    $query = "select id, def from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $ids = array();
    while ($row = mysqli_fetch_array($result)) {
        $ids[] = $row[id];
    }
    return $ids;
}

function get_title($title) {
    $title_parts = explode("\\", str_replace(array("\JJ", "\PP"), "\\", $title));
    if ((count($title_parts) === 4) && ($title_parts[0] === $title_parts[1])) {
        $title_parts = array_shift($title_parts);
    }

    $non_empty_title_parts = array();
    foreach ($title_parts as $title_part) {
        if ($title_part != '') {
            $non_empty_title_parts[] = $title_part;
        }
    }
    return implode(' / ', $non_empty_title_parts);
}

function process_keywords($keywords) {
    $delimiters = array(",", " ", '；', ';', '，', "、", ".", "。");
    $keywords = preg_replace('/\\r?\\n|\\r/', '$', $keywords);
    foreach ($delimiters as $delimiter) {
        $keywords = str_replace($delimiter, '$', $keywords);
    }
    $keyword_array = explode('$', $keywords);
    $clean_keyword_array = array();
    foreach ($keyword_array as $keyword) {
        $keyword = str_replace('$', '', $keyword);
        if (($keyword != '') && (!in_array($keyword, $clean_keyword_array))) {
            $clean_keyword_array[] = $keyword;
        }
    }
    return $clean_keyword_array;
}

$text_id = 5;
if (isset($_POST['text_id']) && ($_POST['text_id'] !== '')) {
    $text_id = $_POST['text_id'];
} elseif (isset($_GET['text_id']) && ($_GET['text_id'] !== '')) {
    $text_id = $_GET['text_id'];
}

if (isset($_POST['submit'])) {
    $keywords = $_POST['keywords'];
    $keyword_array = process_keywords($keywords);
}

$query = "select * from resource where id = '$text_id'";
$result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

while ($row = mysqli_fetch_array($result)) {
    $id = trim($row["id"]);
    $title = trim($row["title"]);
    $description = trim($row["description"]);
}
?>
<div class="container">

    <?php
    $page_name = 'annotation';
    include_once ("./classics_header.php");
    ?>
 
    <div class="row">

        <div class="col-lg-6">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#view" data-toggle="tab">查看古籍原文</a></li>
                <li><a href="#edit" data-toggle="tab">编辑古籍原文</a></li>
            </ul>
            <br>
            <p class="lead"><font face="微软雅黑"><?php echo '医学纲目 / ' . get_title($title); ?></font></p>
            
            <div class="tab-content">
                <div class="tab-pane active" id="view">
                    <div class="panel"  style="height:600px; overflow-y:auto;">
                        <?php
                        $keywords = get_keywords($dbc, $text_id);
                        $predicates = get_predicates($dbc, $text_id);
                        echo preprocess_description($db_name, $description, $keywords, $predicates);
                        ?>
                    </div>
                </div>
                <div class="tab-pane" id="edit">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                          enctype="multipart/form-data">
                        <div class="container">
                            <input  type="hidden" id="db_name" name="db_name" value = "<?php if (isset($db_name)) echo $db_name; ?>" >
                            <div class="form-group">
                                <a href="subontology.php" class="btn btn-default ">更新</a>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="baidu.htm">中医药学语言系统</a>
                                    <div class="pull-right btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li> <a  href="#">中医古籍语言系统</a></li>
                                            <li><a class="btn btn-default" href="#">中医临床术语集</a></li>
                                        </ul>
                                    </div>

                                </div>   

                                <input class="pull-right btn btn-primary" type="submit" name="submit" value="匹配" />             

                            </div>
                        </div>
                        <textarea class="form-control"  id="keywords" name="keywords"  placeholder="请输入词汇列表" rows="30">hehe<?php if (isset($description)) echo $description; ?></textarea>
                    </form>
                </div>
            </div>

        </div>

        <div class="col-lg-6">



            <?php
            $found = array();

            $id_array = array();

            $unfound = array();
            foreach ($keyword_array as $keyword) {
                $ids = identify($dbc, $keyword);

                foreach ($ids as $id) {
                    $found[] = get_entity_link($id, $keyword, $db_name);
                    $id_array[] = $id;
                }

                if (count($ids) == 0) {
                    $unfound[] = $keyword;
                }
            }
            ?>

            <div class="container">


                <div class="btn-group pull-right">

                    <form role="form" action="export_ontology.php" method="post" 
                          enctype="multipart/form-data">
                        <input  type="hidden" id="keyword_array" name="keyword_array" value = "<?php echo implode("$", $id_array); ?>" >
                        <input  type="hidden" id="db_name" name="db_name" value = "<?php if (isset($db_name)) echo $db_name; ?>" >

                        <div class="btn-group">
                            <input class="btn btn-default" type="submit" name="submit" value="导出TTL文件"/>  
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li> <input  class="btn btn-link" type="submit" name="submit" value="导出OWL文件"/>   </li>
                                <li>  <input class="btn btn-link" type="submit" name="submit" value="导出RDF/XML文件"/>   </li>
                                <li>  <input class="btn btn-link" type="submit" name="submit" value="导出CSV文件"/>   </li>
                            </ul>
                        </div>
                    </form>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">概念</a></li>
                    <li><a href="#profile" data-toggle="tab">语义关系</a></li>
                </ul>
                <br>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <div class="panel"  style="height:600px; overflow-y:auto;">
                            <?php
                            render_entities($dbc, $id);
                            ?>                      
                        </div>
                    </div>
                    <div class="tab-pane" id="profile">
                        <div class="panel"  style="height:600px; overflow-y:auto;">
                            <ul class="nav nav-pills"> 
                                <?php
                                render_relations($dbc, $id);
                                ?>                      
                            </ul>
                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>
    <hr>
</div>

<?php
include_once ("./foot.php");
?>
