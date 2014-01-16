<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
require_once('appvars.php');
include_once ("./db_helper.php");
include_once ("./graph_helper.php");

function generate_where_clause($final_search_words, $column) {
    // Generate a WHERE clause using all of the search keywords
    $where_list = array();

    foreach ($final_search_words as $word) {
        $where_list[] = "$column LIKE '%$word%'";
    }

    return implode(' OR ', $where_list);
}

function build_query($user_search, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM relation";
    } else {
        $search_query = "SELECT * FROM relation";
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
        $subject = generate_where_clause($final_search_words, 'subject');
        $object = generate_where_clause($final_search_words, 'object');
        $predicate = generate_where_clause($final_search_words, 'predicate');
        $where_clause = $subject . ' OR ' . $predicate . ' OR ' . $object;
        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }
    }




    $search_query .= " ORDER BY value desc, distance, frequency desc";

    return $search_query;
}

// This function builds navigational page links based on the current page and the number of pages
function generate_page_links($db_name, $user_search, $cur_page, $num_pages) {
    $page_links = '';

    echo '<ul class="pagination">';

    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&page=' . (1) . '">首页</a></li>';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
        $page_links .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&page=' . ($cur_page - 1) . '">上一页</a></li>';
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
            $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&page=' . $i . '"> ' . $i . '</a></li>';
        }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
        $page_links .= ' <li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&page=' . ($cur_page + 1) . '">下一页</a></li>';
    } else {
        $page_links .= ' <li class="disabled"><a>下一页</a></li>';
    }

    echo $page_links;
    echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_name . '&keywords=' . $user_search . '&page=' . ($num_pages) . '">尾页</a></li>';

    echo '</ul>';
}

function get_total($keywords, $dbc) {
    $query = build_query($keywords, true);
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result);
    $total = $row['count'];
    return $total;
}

$keywords = $_GET['keywords'];
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
$results_per_page = 10;  // number of results per page
$skip = (($cur_page - 1) * $results_per_page);
$total = get_total($keywords, $dbc);
$num_pages = ceil($total / $results_per_page);
?>
<p></p>

<div class="container">
    <img width ="100%" src ="img/sad_workspace_logo.jpg"></img>
    
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php echo $db_labels[$db_name]; ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!--
                    <li><a href="basic.php?action=create&type=期刊文献"><span class="glyphicon glyphicon-list"></span>&nbsp;导出Excel</a></li>               
                    <li><a href="upload.php"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp;导出RDF</a></li>               
                    -->
                </ul>

                <form class="navbar-form navbar-left" role="search" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" id="keywords" name ="keywords" value="<?php echo $keywords; ?>" placeholder="输入关键词...">
                        <input type="hidden" class="form-control" id="db_name" name ="db_name" value="<?php echo $db_name; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;搜索</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">切换知识库 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php
                            foreach ($db_labels as $db_id => $db_label) {
                                echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?db_name=' . $db_id . '">' . $db_label . '</a></li>';
                            }
                            ?>
                            <!--
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>-->
                        </ul>
                    </li>

                    <li><a href="#" ><span class="glyphicon glyphicon-home"></span>&nbsp;返回首页</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <p><font color="gray">从文献中获取约 <?php echo $total; ?> 条关系。</font></p>

        <table class="table table-hover">
            <tbody>
                <tr class="info">
                    <td>#</td>
                    <td ><strong>主体</strong></td>
                     <!--<td><strong>谓词</strong></td>-->
                    <td><strong>客体</strong></td>
                    <!--<td><strong>赋值</strong></td>
                    <td><strong>距离</strong></td>
                    <td><strong>频数</strong></td> -->                
                    <td><strong>操作</strong></td>

                </tr>

                <?php
                $user_id = $_SESSION[id];

                //$query = "SELECT * FROM relation ORDER BY value DESC LIMIT 0,100";
                $query = build_query($keywords) . " LIMIT $skip, $results_per_page";

                //$query = build_query($keywords) . ' LIMIT 0,100';

                $data = mysqli_query($dbc, $query);

                $row_num = 1;

                while ($row = mysqli_fetch_array($data)) {


                    //$subject_ids = get_ids($dbc, $row['SUBJECT']);
                    //$object_ids = get_ids($dbc, $row['OBJECT']);
                    // if ((count($subject_ids) != 0) && (count($object_ids) != 0)) {
                    echo '<tr>';
                    echo '<td width = "3%">' . $row_num++ . '</td>';
                    //$subject_id = $subject_ids[0];
                    //$subject_type = get_type($dbc, $db_name . ':o' . $subject_id);                
                    //$object_id = $object_ids[0];                    
                    //$object_type = get_type($dbc, $db_name . ':o' . $object_id);  
                    //$class_links = get_class_links($dbc, $subject_type, $object_type) ;
                    //$class_links = get_candidate_properties($dbc, $db_name . ':o' . $subject_id, $db_name . ':o' . $object_id);

                    echo '<td width = "35%">' . render_word($dbc, $db_name, $row['SUBJECT'], true) . '</td>';
                    /*
                      if (count($class_links) != 0){
                      echo '<td width = "15%">' . implode(',', $class_links) . '</td>';
                      }else{
                      echo '<td width = "15%">' . $row['PREDICATE'] . '</td>';
                      } */

                    echo '<td width = "35%">' . render_word($dbc, $db_name, $row['OBJECT'], true) . '</td>';
                    //echo '<td width = "5%">' . $row['VALUE'] . '</td>';
                    //echo '<td width = "5%">' . $row['DISTANCE'] . '</td>';
                    //echo '<td width = "5%">' . $row['FREQUENCY'] . '</td>';
                    echo '<td width = "12%">';
                    echo '<a class="btn btn-primary btn-xs" href="relation.php?db_name=' . $db_name . '&id=' . $row['id'] . '"><span class="glyphicon glyphicon-search"></span>&nbsp;查看</a>';
                    echo '&nbsp;';

                    $link_for_delete = $_SERVER['PHP_SELF'] . '?deleted_file=' . $row['id'];
                    echo '<a class="btn btn-danger btn-xs" href="' . $link_for_delete . '"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a></td></tr>';


                    //return render_value($dbc, $db_name, $db_name . ':o' . $id, $with_def);
                    //}
                }
                ?>
            </tbody>
        </table>
        <?php
        if ($num_pages > 1) {
            generate_page_links($db_name, $keywords, $cur_page, $num_pages);
        }
        ?>

   
</div> 
<?php
include_once ("./foot.php");
?>