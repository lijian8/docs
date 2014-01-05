<?php
include_once ("./header.php");
include_once ("./appvars.php");
include_once ("./entity_helper.php");
include_once ("./db_helper.php");

function build_query($user_search, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM def";
    } else {
        $search_query = "SELECT * FROM def";
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
        $name = generate_where_clause($final_search_words, 'name');
        $def = generate_where_clause($final_search_words, 'def');

        $where_clause = $name . ' OR ' . $def;

        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }
    }


    $search_query .= " ORDER BY name";

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

function render_item($dbc, $row, $db_name) {
    $id = $row[id];
    $name = $row[name];
    $def = $row[def];

    echo '<p>' . get_entity_link($id, $name, $db_name) . '</p>';

    if ($def != '') {
        echo $def;
    } else {
        echo get_summary($dbc, $db_name, PREFIX . $id);
    }
    echo '<br>';
    /*
      echo '<a class="btn btn-link" href="#" role="button">功效&nbsp; &raquo;</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-link" href="#" role="button">化学成分&nbsp; &raquo;</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-link" href="#" role="button">药理作用&nbsp; &raquo;</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-link" href="#" role="button">化学实验&nbsp; &raquo;</a>';
      echo '&nbsp;';
      echo '<a class="btn btn-link" href="#" role="button">来源处方&nbsp; &raquo;</a>';
     */
    echo "<hr>";
}

function render_related($dbc, $db_name, $keywords) {

    $query = "SELECT * FROM def where name = '$keywords'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {

        $id = $row[id];
        $name = PREFIX . $id;
        $query = "select * from graph where subject ='$name' and value like '" . PREFIX . "%' limit 20";
        $result = mysqli_query($dbc, $query) or die('Error querying database2.');

        if (mysqli_num_rows($result) != 0) {
            echo '<p><font color="red">' . $keywords . '</font>的相关搜索:</p>';
            while ($row = mysqli_fetch_array($result)) {
                $value = $row[value];
                echo '<p>' . render_value($dbc, $db_name, $value, false) . '</p>';
            }
        }
    }
}

// This function builds navigational page links based on the current page and the number of pages
function generate_page_links($url, $cur_page, $num_pages) {
    $page_links = '';

    echo '<ul class="pagination">';

    echo '<li><a href="' . $url . '&page=' . (1) . '">首页</a></li>';

    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
        $page_links .= '<li><a href="' . $url . '&page=' . ($cur_page - 1) . '">上一页</a></li>';
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
            $page_links .= ' <li><a href="' . $url . '&page=' . $i . '"> ' . $i . '</a></li>';
        }
    }

    // If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
        $page_links .= ' <li><a href="' . $url . '&page=' . ($cur_page + 1) . '">下一页</a></li>';
    } else {
        $page_links .= ' <li class="disabled"><a>下一页</a></li>';
    }

    echo $page_links;
    echo '<li><a href="' . $url . '&page=' . ($num_pages) . '">尾页</a></li>';

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
$url = $_SERVER['PHP_SELF'] . '?keywords=' . $keywords . '&db_name=' . $db_name;
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form class="form-search" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="form-horizontal"
              enctype="multipart/form-data">
            <input type="hidden" id ="db_name" name ="db_name" value ="<?php if (isset($db_name)) echo $db_name; ?>">
            <div class="container" >
                <div class="row">
                    <div class="col-md-3">
                        <img width="100%" class="media-object" src="img/logo.jpg" >                    
                    </div>   
                    <div class="col-md-9">
                        <br>
                        <ul class="nav nav-pills" align="center">
                            <?php
                            foreach ($db_labels as $db => $db_label) {
                                echo '<li ' . (($db == $db_name) ? 'class="disabled"' : '') . '><a href="' . $_SERVER['PHP_SELF'] . "?keywords=$keywords&db_name=" . $db . '">' . $db_label . '</a></li>';
                            }
                            ?>  
                            <li><a href="#">更多>></a></li>
                        </ul>


                        <!--
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox1" value="option1"> 单味药
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox2" value="option2"> 化学成分
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="option3"> 实验方法
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="option3"> 药理作用
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="option3"> 方剂
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="option3"> 学者 
                        </label>
                        !-->
                    </div>
                </div>
                <p></p>
                <div class="input-group">
                    <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......"  value ="<?php if (isset($keywords)) echo $keywords; ?>">
                    <span class="input-group-btn">
                        <button name ="submit" type="submit" class="btn btn-primary  btn-lg"><span class="glyphicon glyphicon-search"></span></button>
                    </span> 
                </div> 
                <p></p>



                <hr> 
                <div class="row">
                    <div class="col-md-10">


                        <?php
                        $query = "SELECT * FROM def where name = '$keywords'";
                        $result = mysqli_query($dbc, $query) or die('Error querying database.');
                        if ($row = mysqli_fetch_array($result)) {
                            render_item($dbc, $row, $db_name);
                        }

                        //$query = "SELECT * FROM def where name like '%$keywords%' or def like '%$keywords%' ORDER BY name ASC LIMIT 0,10";
                        $query = build_query($keywords) . " LIMIT $skip, $results_per_page";


                        $result = mysqli_query($dbc, $query) or die('Error querying database.');
                        while ($row = mysqli_fetch_array($result)) {
                            render_item($dbc, $row, $db_name);
                        }

                        if ($num_pages > 1) {
                            generate_page_links($url, $cur_page, $num_pages);
                        }
                        ?>
                        <p><font color="gray">获得约<?php echo $total; ?>条结果。</font></p>
                        <hr>
                    </div>
                    <div class="col-md-2">
                        <?php
                        render_related($dbc, $db_name, $keywords);
                        ?>
                    </div>

                </div>
            </div>
        </form>   
    </div>

</div>


<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>

