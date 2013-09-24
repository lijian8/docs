<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
require_once('appvars.php');

function build_query($user_search, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM resource";
    } else {
        $search_query = "SELECT * FROM resource";
    }

    //$search_query = "SELECT * FROM resource";
    // Extract the search keywords into an array
    $clean_search = str_replace(',', ' ', $user_search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
        foreach ($search_words as $word) {
            if (!empty($word)) {
                $final_search_words[] = $word;
            }
        }
    }

    if (count($final_search_words) > 0) {
        $title = generate_where_clause($final_search_words, 'title');
        $creator = generate_where_clause($final_search_words, 'creator');
        $description = generate_where_clause($final_search_words, 'description');
        $subject = generate_where_clause($final_search_words, 'subject');

        $where_clause = $title . ' OR ' . $creator . ' OR ' . $description . ' OR ' . $subject;

        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }
    }


    $search_query .= " ORDER BY title";

    return $search_query;
}

function generate_where_clause($final_search_words, $column) {
    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
        foreach ($final_search_words as $word) {
            $where_list[] = "$column LIKE '%$word%'";
        }
    }
    return implode(' OR ', $where_list);
}

function render_content($row) {
    $title = $row[title];
    $id = $row[id];
    $def = $row[description];
    echo "<p><a href=\"resource_viewer.php?id=$id\">$title</a></p>";

    echo tcmks_substr($def);

    echo "<hr>";
}

function render_entity($dbc, $keywords) {
    $query = "SELECT * FROM def where name = '$keywords'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {

        render_content($row);
    }
}

// This function builds navigational page links based on the current page and the number of pages
function generate_page_links($user_search, $cur_page, $num_pages) {
    $page_links = '';

    echo '<ul class="pagination">';

    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?keywords=' . $user_search . '&sort=' . $sort . '&page=' . (1) . '">首页</a></li>';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
        $page_links .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page - 1) . '">上一页</a></li>';
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
            $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?keywords=' . $user_search . '&sort=' . $sort . '&page=' . $i . '"> ' . $i . '</a></li>';
        }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
        $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($cur_page + 1) . '">下一页</a></li>';
    } else {
        $page_links .= ' <li class="disabled"><a>下一页</a></li>';
    }

    echo $page_links;
    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?keywords=' . $user_search . '&sort=' . $sort . '&page=' . ($num_pages) . '">尾页</a></li>';

    echo '</ul>';
}

function get_total($keywords, $dbc) {
    $query = build_query($keywords, true);
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result);
    $total = $row['count'];
    return $total;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    render_warning('无相关实体信息');
}

// Calculate pagination information
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$results_per_page = 10;  // number of results per page
$skip = (($cur_page - 1) * $results_per_page);
$total = get_total($keywords, $dbc);
$num_pages = ceil($total / $results_per_page);
?>
<div class="container">

    <?php
    $query = "SELECT * FROM relation where id ='$id'";
    $data = mysqli_query($dbc, $query);
    
    if ($row = mysqli_fetch_array($data)) {
        
        echo  '<div class="row">';
        echo  '<div class="col-md-3">';
        echo  '<img width="100%" class="media-object" src="img/logo.jpg" >';                    
        echo  '</div>';   

        echo  '<div class="col-md-9">';
        echo  '<h1>潜在语义关系:&nbsp;';
        echo $row['SUBJECT'] . '&nbsp;-&nbsp;' . $row['OBJECT'];                 
        echo  '</h1>';                   
        echo  '</div>';
        echo  '</div>';


        echo '<div class = "panel panel-default">';
        echo '<div class = "panel-heading">';
        echo '<strong>基本信息</strong>';
        echo '</div>';
        echo '<div class = "panel-body">';
        echo '<div class = "row">';

        echo '<div class = "col-md-1"><strong>主体:</strong></div>';
        echo '<div class = "col-md-11">' . $row['SUBJECT'] . '</div>';

        echo '<div class = "col-md-1"><strong>谓词:</strong></div>';
        echo '<div class = "col-md-11">' . $row['PREDICATE'] . '</div>';


        echo '<div class = "col-md-1"><strong>客体:</strong></div>';
        echo '<div class = "col-md-11">' . $row['OBJECT'] . '</div>';


        echo '<div class = "col-md-1"><strong>赋值:</strong></div>';
        echo '<div class = "col-md-11">' . $row['VALUE'] . '</div>';

        echo '<div class = "col-md-1"><strong>距离:</strong></div>';
        echo '<div class = "col-md-11">' . $row['DISTANCE'] . '</div>';

        echo '<div class = "col-md-1"><strong>频数:</strong></div>';
        echo '<div class = "col-md-11">' . $row['FREQUENCY'] . '</div>';



        echo '</div>';

        echo '</div>';
        echo '</div>';
    }
    ?>

    

       
          





            <hr> 



            <?php
//$query = "SELECT * FROM resource where title like '%$keywords%' or description like '%$keywords%' ORDER BY title ASC LIMIT 0,10";

            $query = build_query($keywords) . " LIMIT $skip, $results_per_page";


            $result = mysqli_query($dbc, $query) or die('Error querying database.');
            while ($row = mysqli_fetch_array($result)) {
                render_content($row);
            }

            if ($num_pages > 1) {
                generate_page_links($keywords, $cur_page, $num_pages);
            }
            ?>







            <p><font color="gray">获得约 <?php echo $total; ?> 条结果。</font></p>
            <hr>

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



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
