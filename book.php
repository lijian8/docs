<?php
$db_name = "clan";
include_once ("./header.php");
include_once ("./functions.php");

/*
  function get_chapters($dbc) {
  $query = "select title from resource";
  $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
  $ids = array();

  $chapters = array();
  while ($row = mysqli_fetch_array($result)) {
  $title = $row[title];
  $title = str_replace(array("\JJ", "\PP"), " ", $title);
  $title_parts = explode(" ", $title);
  if (($title_parts[1] != '') &&(!in_array($title_parts[1], $chapters)) )
  $chapters[] = $title_parts[1] ;
  }

  return $chapters;

  }

  $chapters = get_chapters($dbc) ; */

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function render_relations($dbc, $id) {
    $query = "SELECT * FROM relation WHERE docs=$id";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

    if (mysqli_num_rows($result) != 0) {
        /*
          echo '<a data-toggle = "collapse" data-toggle = "collapse"  href = "#relation' . $id . '">语义关系<span class="caret"></a>';
          echo '<div id="relation' . $id . '" class="panel-collapse collapse">';
          echo '<div class = "panel-body">';
          while ($row = mysqli_fetch_array($result)) {
          echo "<a class='btn btn-xs btn-default' href = '#'>" . $row["SUBJECT"] . " " . $row["PREDICATE"] . " " . $row["OBJECT"] . "</a>&nbsp;&nbsp;";
          }
          echo '</div>';
          echo '</div>'; */


        echo '<div class = "dropdown">';

        echo '<a class = "dropdown-toggle" id = "dLabel"  data-toggle = "dropdown" data-target = "#" href = "/page.html">语义关系<span class = "caret"></span></a>';
        //    echo '<a class = "dropdown-toggle" data-toggle = "dropdown" href="' . $_SERVER["PHP_SELF"] . '?db_name=' . $db_name . '&type=' . $object_type . '&name=' . $value . '">' . $value . '</a>';

        echo '<ul class = "dropdown-menu" role = "menu" aria-labelledby = "dLabel">';
        echo '<div class="container">';

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
        echo '</div>';
        /*
          echo '<li><a href="#">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> 查看更多&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>'; */

        echo '<li><a href="#">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> 查看更多</a></li>';
        echo '</ul>';

        echo '</div>';
    }
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

function get_def($dbc, $name) {
    $query = "select def from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    if (($row = mysqli_fetch_array($result)) && ($row["def"] != '')) {
        return $row["def"];
    } else {
        return '...';
    }
}

function render_paragraphs($dbc, $db_name, $title) {

    $keywords = mysql_escape_string($title);

    $query = "select * from resource where title = '$keywords'";

//echo $title;
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

    while ($row = mysqli_fetch_array($result)) {
        $id = trim($row["id"]);
        $description = trim($row["description"]);

        echo "<div class='row'>";
        echo "<div class='col-sm-8'>";
        $keywords = get_keywords($dbc, $id);
        $predicates = get_predicates($dbc, $id);

        $description = preprocess_description($db_name, $description, $keywords, $predicates);
        echo $description;



        echo "</div>";
        echo "<div class='col-sm-4'>";

        if (count($keywords) != 0) {           
         
            echo '<small>相关概念：</small>';
            
            foreach ($keywords as $keyword) {
                //echo '<p>' . $keyword . ": " . $def . '</p>';
                echo '<button type="button" class="btn btn-xs btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-content="' . get_def($dbc, $keyword) . '">';
                echo $keyword;
                echo '</button>&nbsp;&nbsp;';
            }
           
            echo '<small> ';
            render_relations($dbc, $id);
            echo '</small>';         
           
        }
        echo "</div>";
        echo "</div>";
        
    }
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

function render_sections($dbc, $chapter, $section) {
    $query = "select distinct title, level from resource where title like '%$chapter%'";

    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);

    while ($row = mysqli_fetch_array($result)) {
        $title = $row[title];

        $title_parts = explode(" ", str_replace(array("\JJ", "\PP"), " ", $title));

        $href = "book.php?chapter=$chapter&section=$title";

        if ($row[level] == 3) {
            $Indentation = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        } else {
            $Indentation = '&nbsp;&nbsp;&nbsp;&nbsp;';
        }

        if ($title != $section) {
            echo '<p>' . $Indentation . '<a href="' . $href . '">' . $title_parts[count($title_parts) - 1] . '</a></p>';
        } else {
            echo '<p>' . $Indentation . $title_parts[count($title_parts) - 1] . '</p>';
        }
    }
}

$chapter = isset($_GET["chapter"]) ? $_GET["chapter"] : "曹序";
$section = isset($_GET["section"]) ? $_GET["section"] : "\JJ曹序";

$chapters = array("曹序", "自序", "序例", "卷之一·阴阳脏腑部", "卷之二·阴阳脏腑部", "卷之三·阴阳脏腑部", "卷之四·阴阳脏腑部", "卷之五·阴阳脏腑部", "卷之六·阴阳脏腑部", "卷之七·阴阳脏腑部", "卷之八·阴阳脏腑部", "卷之九·阴阳脏腑部", "卷之十·肝胆部", "卷之十一·肝胆部", "卷之十二·肝胆部", "卷之十三·肝胆部", "卷之十四·肝胆部", "卷之十五·肝胆部", "卷之十六·心小肠部", "卷之十七·心小肠部", "卷之十八·心小肠部", "卷之十九·心小肠部", "卷之二十·心小肠部", "卷之二十一·脾胃门", "卷之二十二·脾胃部", "卷之二十三·脾胃部", "卷之二十四·脾胃部", "卷之二十五·脾胃部", "卷之二十六·肺大肠部", "卷之二十七·肺大肠部", "卷之二十八·肾膀胱部", "卷之二十九·肾膀胱部", "卷之三十·伤寒部", "卷之三十一·伤寒部", "卷之三十二·伤寒部", "卷之三十三·伤寒部", "卷之三十四·妇人部", "卷之三十五·妇人部", "卷之三十六·小儿部", "卷之三十七·小儿部", "卷之三十八·小儿部", "卷之三十九·小儿部", "卷之四十·《内经》运气类注", "运气占候");
//print_r($chapters);
?>
<br>
<div class="container">
    <h1><font face="微软雅黑">医学纲目</font></h1>
    <p class="lead">作者：楼英（明） 年份：公元1565年</p>
    <hr>
    <div class = "row">

        <div class ="col-sm-3">
            <div class="panel panel-default">
                <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" class="scrollspy-example-long">


                    <div class="panel-group" id="accordion">
                        <?php
                        foreach ($chapters as $chapter_no => $cur_chapter) {
                            echo '<div class="panel">';
                            echo '<div class="panel-heading">';
                            echo '<h4 class="panel-title">';
                            echo '<a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $chapter_no . '">';
                            echo $cur_chapter;
                            echo '</a>';
                            echo '</h4>';
                            echo '</div>';
                            echo '<div id="collapse' . $chapter_no . '" class="panel-collapse collapse ' . ((isset($chapter) && ($chapter == $cur_chapter)) ? "in" : "") . ' ">';
                            echo '<div class="panel-body">';
                            render_sections($dbc, $cur_chapter, $section);
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class ="col-sm-9">

            <?php
            render_paragraphs($dbc, $db_name, $section);
            ?>            
        </div> 
    </div> 
    <hr>
</div>

<?php
include_once ("./foot.php");
?>
