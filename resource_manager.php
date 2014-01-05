<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
require_once('appvars.php');
include_once ("./db_helper.php");

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

function build_query($user_search, $user_id, $count_only = false) {

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
            $search_query .= " WHERE (user_id = '$user_id') and ($where_clause)";
        }
    }


    $search_query .= " ORDER BY title";

    return $search_query;
}

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

function get_total($keywords, $user_id, $dbc) {
    $query = build_query($keywords, $user_id, true);
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

$user_id = $_SESSION[id];
// Calculate pagination information
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$results_per_page = 3;  // number of results per page
$skip = (($cur_page - 1) * $results_per_page);
$total = get_total($keywords, $user_id, $dbc);
$num_pages = ceil($total / $results_per_page);

if (isset($_GET['deleted_file'])) {

    $deleted_file = get_title_by_id($dbc, $_GET['deleted_file']);

    delete_resource($dbc, $db_name, $_GET['deleted_file']);

    //echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
    //echo '文献"' . $deleted_file . '"已被删除!</div>';
    render_success('文献"' . $deleted_file . '"已被删除!');
}
?>
<p></p>
<div class="container">
    <?php include_once ('resource_header.php'); ?>
    <table class="table table-hover">
        <tbody>
            <tr class="info">
                <td>#</td>
                <td ><strong>创建者</strong></td>
                <td><strong>题名</strong></td>
                <td><strong>类型</strong></td>
                <td><strong>出处</strong></td>
                <td><strong>主题</strong></td>
                <td><strong>上传时间</strong></td> 
                <td><strong>删除</strong></td>

            </tr>

            <?php
            //$query = "SELECT * FROM resource where user_id ='$user_id' ORDER BY title ASC LIMIT 0,100";
            $query = build_query($keywords, $user_id) . " LIMIT $skip, $results_per_page";
            $data = mysqli_query($dbc, $query);

            $row_num = 1;
            $color = true;
            while ($row = mysqli_fetch_array($data)) {
                if ($color) {
                    echo '<tr>';
                } else {
                    echo '<tr class="info">';
                }
                $color = !$color;
                echo '<td width = "3%">' . $row_num++ . '</td>';
                echo '<td width = "15%">' . $row['creator'] . '</td>';

                echo '<td width = "32%">';
                //echo '<a class="btn-link" href="basic.php?action=update&file_id=' . $row[id] . '">' . $row['title'] . '</a>';
                echo '<a class="btn-link" href="resource_editor.php?db_name=' . $db_name . '&id=' . $row[id] . '">' . $row['title'] . '</a>';


                if ($row['file'] != '') {
                    $file_name = iconv('utf-8', 'gb2312', $row['file']);
                    if (is_file(GW_UPLOADPATH . $db_name . '/' . $file_name))
                        echo '<a class="btn-link" href="' . GW_UPLOADPATH . $db_name . '/' . $row['file'] . '"> <span class="glyphicon glyphicon-cloud-download"></span></a>';
                }
                echo '</td>';

                echo '<td width = "5%">' . $row['type'] . '</td>';

                echo '<td width = "20%">' . $row['source'] . '</td>';
                echo '<td width = "10%">' . $row['subject'] . '</td>';

                echo '<td width = "10%">' . $row['create_time'] . '</td>';
                //$file_name = iconv('utf-8', 'gb2312', $row['file']);
                echo '<td width = "5%">';
                $link_for_delete = $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&deleted_file=' . $row['id'];
                echo '<a class="btn-link" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
            }
            ?>
        </tbody>
    </table>
    <?php
    if ($num_pages > 1) {
        generate_page_links($db_name, $keywords, $cur_page, $num_pages);
    }
    ?>
    <p><font color="gray">获得约 <?php echo $total; ?> 条结果。</font></p>
    <hr>


</div> 
<?php
include_once ("./foot.php");
?>