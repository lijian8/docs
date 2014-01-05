<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
include_once ("./search_helper.php");
include_once ("./entity_helper.php");
require_once('appvars.php');
include_once ("./db_helper.php");

// This function builds navigational page links based on the current page and the number of pages
function generate_page_links($db_name, $user_search, $cur_page, $num_pages) {
    $page_links = '';

    echo '<ul class="pagination">';

    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&sort=' . $sort . '&page=' . (1) . '">首页</a></li>';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
        $page_links .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page - 1) . '">上一页</a></li>';
    } else {
        $page_links .= '<li class="disabled"><a>上一页</a></li> ';
    }

    $start = 1;
    $end = $num_pages;

    if ($num_pages > 10) {

        if ($cur_page <= 5) {
            $start = 1;
            $end = 10;
        } elseif ($num_pages - $cur_page < 4) {
            $start = $num_pages - 9;
            $end = $num_pages;
        } else {
            $start = $cur_page - 5;
            $end = $cur_page + 4;
        }
    }


    // Loop through the pages generating the page number links
    for ($i = $start; $i <= $end; $i++) {
        if ($cur_page == $i) {
            $page_links .= ' <li class="active"><a>' . $i . '</a></li>';
        } else {
            $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&sort=' . $sort . '&page=' . $i . '"> ' . $i . '</a></li>';
        }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
        $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page + 1) . '">下一页</a></li>';
    } else {
        $page_links .= ' <li class="disabled"><a>下一页</a></li>';
    }

    echo $page_links;
    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($num_pages) . '">尾页</a></li>';

    echo '</ul>';
}

function get_total($keywords, $dbc) {
    $query = build_query($keywords, true);
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result);
    $total = $row['count'];
    return $total;
}

if (isset($_POST['submit'])) {
    $keywords = $_POST['keywords'];
}

if (isset($_GET['keywords'])) {
    $keywords = $_GET['keywords'];
}

// Calculate pagination information
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$results_per_page = 10;  // number of results per page
$skip = (($cur_page - 1) * $results_per_page);
$total = get_total($keywords, $dbc);
$num_pages = ceil($total / $results_per_page);
?>
<div class="container">

    <form class="form-search" action="search.php" method="get" class="form-horizontal"
          enctype="multipart/form-data">

        <div class="container" >
            <?php include_once ("./search_form.php"); ?>
           
            <div class="row">
                <div class="col-md-8">



                    <?php
//$query = "SELECT * FROM resource where title like '%$keywords%' or description like '%$keywords%' ORDER BY title ASC LIMIT 0,10";

                    $query = build_query($keywords) . " LIMIT $skip, $results_per_page";


                    $result = mysqli_query($dbc, $query) or die('Error querying database.');
                    while ($row = mysqli_fetch_array($result)) {
                        $title = $row[title];
                        $id = $row[id];
                        $def = $row[description];
                        echo "<p><a href=\"resource_viewer.php?db_name=$db_name&id=$id\">$title</a></p>";

                        echo tcmks_substr($def);

                        echo "<hr>";
                    }

                    if ($num_pages > 1) {
                        generate_page_links($db_name, $keywords, $cur_page, $num_pages);
                    }
                    ?>







                    <p><font color="gray">获得约 <?php echo $total; ?> 条结果。</font></p>
                   

                    <!--
                    <div class="col-md-1">
        
        echo '<p><font color="red">' . $keywords . '</font>的相关搜索:</p>';
        echo '<p><a  href=\"#\">四君子汤</a></p>';
        echo '<p><a  href=\"#\">人参</a></p>';
        echo '<p><a  href=\"#\">补阳</a></p>';
        echo '<p><a  href=\"#\">石杉碱甲</a></p>';
        echo '<p><a  href=\"#\">大黄</a></p>';
        echo '<p><a  href=\"#\">肾</a></p>';
        echo '<p><a  href=\"#\">李时珍</a></p>';
        echo '<p><a  href=\"#\">孙思邈</a></p>';
        echo '<p><a  href=\"#\">汤剂</a></p>';
        echo '<p><a  href=\"#\">牛黄</a></p>';
        
                    </div>
                    -->
                </div>
                <div class="col-md-4">
                    <?php
                    $entity_id = get_id($dbc, $keywords);

                    if ($entity_id != '') {
                        ?>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo "<a href='entity.php?db_name=$db_name&id=$entity_id'>$keywords</a>"; ?>的知识图谱</h3>
                            </div>
                            <div class="panel-body" align="center">
                                <?php
                                $image_file = 'img/' . $keywords . '.jpg';
                                if (is_file(iconv('utf-8', 'gb2312', $image_file))) {
                                    echo "<a class='thumbnail' href='entity.php?db_name=$db_name&id=$entity_id'>";
                                    echo '<img width="' . $width . '" class="img-thumbnail" src="' . $image_file . '" alt="' . $keywords . '" >';
                                    echo $keywords;
                                    echo '</a>';
                                }
                                ?>   
                            </div>

                            <table class="table">
                                <tbody>

                                    <?php
                                    // echo "<tr><td width='10%'>代码:</td><td>" . $id . "</td></tr>";
                                    //  echo "<tr><td width='10%'>类型:</td><td>" . implode(',', get_types($dbc, $name, $id)) . "</td></tr>";



                                    $s = '';
                                    $names = array('英文正名', '英文异名', '中文异名', '中文正名', '异名', '汉语拼音', '英文名', '别名');
                                    $type_labels = array('类型');
                                    foreach ($names as $name_property) {
                                        $s .= render_info_by_property($dbc, $db_name, PREFIX . $entity_id, $name_property, false);
                                    }
                                    if ($s != '')
                                        echo "<tr><td width='30%'>相关术语:</td><td>$s</td></tr>";

                                    $values = get_links($dbc, $db_name, PREFIX . $entity_id);
                                    $values = array_slice($values, 0, 4);

                                    foreach ($values as $property => $value) {
                                        echo "<tr><td width='10%'>" . $property . ":</td><td>";
                                        echo $value;
                                        echo "</td></tr>";
                                    }

                                    $filter = array_merge($type_labels, $names);

                                    $values = get_literals($dbc, $db_name, PREFIX . $entity_id, $filter) + get_literals($dbc, $db_name, $keywords, $filter);
                                     foreach ($values as $property => $value) {
                                        if (mb_strlen($value, 'UTF-8') > 100)   unset($values[$property]);                                       
                                    }
                                   
                                    $values = array_slice($values, 0, 4);

                                    foreach ($values as $property => $value) {
                                        //echo "<p><strong>$property</strong>$value</p>";
                                        echo "<tr><td width='10%'>" . $property . ":</td><td>";
                                        echo $value;
                                        echo "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <?php
                    }
                    ?>
                </div>   
            </div>
    </form>   
</div>
 <hr>


<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
