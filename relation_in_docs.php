<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
require_once('appvars.php');
include_once ("./db_helper.php");
include_once ("./graph_helper.php");
include_once ("./function.php");

function build_query($docs, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM resource";
    } else {
        $search_query = "SELECT * FROM resource";
    }

    $final_docs = explode('|', $docs);

    $first = true;
    foreach ($final_docs as $final_doc) {
        if ($final_doc != '') {
            if ($first) {
                $search_query .= " WHERE id=" . $final_doc;
                $first = false;
            } else {
                $search_query .= " OR id=" . $final_doc;
            }
        }
    }



    $search_query .= " ORDER BY title";

    //echo $search_query;
    return $search_query;
}

function render_content($row) {
    $title = $row[title];
    $id = $row[id];
    $def = $row[description];
    echo "<p><a href=\"resource_viewer.php?id=$id\">$title</a></p>";

    //echo tcmks_substr($def);
    echo $def;

    echo "<hr>";
}

// This function builds navigational page links based on the current page and the number of pages
function generate_page_links($id, $cur_page, $num_pages) {
    $page_links = '';

    echo '<ul class="pagination">';

    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '&page=' . (1) . '">首页</a></li>';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
        $page_links .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '&page=' . ($cur_page - 1) . '">上一页</a></li>';
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
            $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '&page=' . $i . '"> ' . $i . '</a></li>';
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

function get_total($docs, $dbc) {
    $query = build_query($docs, true);
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
?>
<div class="container">

    <?php
    $relation_tab_id = 'docs';
    include_once ("./relation_header.php");
//$query = "SELECT * FROM resource where title like '%$keywords%' or description like '%$keywords%' ORDER BY title ASC LIMIT 0,10";
// Calculate pagination information
    $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $results_per_page = 10;  // number of results per page
    $skip = (($cur_page - 1) * $results_per_page);
    $total = get_total($docs, $dbc);
    $num_pages = ceil($total / $results_per_page);

    echo '<p></p>';

    echo '<p><font color="gray">该语义关系出现于如下' . $total . '篇文献之中:</font></p>';
    echo '<hr>';
    $query = build_query($docs) . " LIMIT $skip, $results_per_page";


    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    while ($row = mysqli_fetch_array($result)) {
        render_content($row);
    }

    if ($num_pages > 1) {
        generate_page_links($id, $cur_page, $num_pages);
    }
    ?>

</div>
<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
