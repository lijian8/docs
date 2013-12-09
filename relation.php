<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
require_once('appvars.php');
include_once ("./db_helper.php");
include_once ("./graph_helper.php");

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

function render_entity($dbc, $keywords) {
    $query = "SELECT * FROM def where name = '$keywords'";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    if ($row = mysqli_fetch_array($result)) {

        render_content($row);
    }
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
    $query = "SELECT * FROM relation where id ='$id'";
    $data = mysqli_query($dbc, $query);


    if ($row = mysqli_fetch_array($data)) {
        $docs = $row['DOCS'];
        $subject = $row['SUBJECT'];
        $predicate = $row['PREDICATE'];
        $predicates = array();
        $can_preds = explode('|', $predicate);

        foreach ($can_preds as $can_pred) {
            if ($can_pred != '') {
                $predicates[] = $can_pred;
            }
        }


        $object = $row['OBJECT'];
        $value = $row['VALUE'];
        $distance = $row['DISTANCE'];
        $frequency = $row['FREQUENCY'];
    }
    ?>
    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">语义关系:&nbsp;
                <?php
                echo $subject . '&nbsp;-&nbsp;' . $object;
                ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <!-- 
            <ul class="nav navbar-nav">
                
                <li><a class href="basic.php?action=create&type=期刊文献"><span class="glyphicon glyphicon-list"></span>&nbsp;录入TCMLS</a></li>               
                <li><a href="upload.php"><span class="glyphicon glyphicon-cloud-download"></span>&nbsp;下载RDF文件</a></li>               
            </ul>
            -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="relation_manager.php?keywords=<?php echo $subject . '+' . $object; ?>" ><span class="glyphicon glyphicon-home"></span>&nbsp;返回首页</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>




    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#docs" data-toggle="tab"><span class="glyphicon glyphicon-book"></span>&nbsp;文献来源</a></li>          
            <li><a href="#graph" data-toggle="tab"><span class="glyphicon glyphicon-search"></span>&nbsp;查看语言系统</a></li> 
            <li><a href="#tcmls" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span>&nbsp;加入语言系统</a></li>  
            <li><a href="#baidu" data-toggle="tab"><span class="glyphicon glyphicon-search"></span>&nbsp;百度搜索</a></li>    
            <li><a href="#params" data-toggle="tab"><span class="glyphicon glyphicon-list"></span>&nbsp;相关参数</a></li>    


        </ul>


        <div class="tab-content">



            <div class="tab-pane fade in active" id="docs">
                <?php
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


            <div class="tab-pane fade" id="tcmls">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>参考性谓词：</strong>
                        <?php
                        echo '&nbsp;(' . implode(',&nbsp;', array_slice($predicates, 0, 20));
                        if (count($predicates) > 20)
                            echo '...)';
                        ?>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                              enctype="multipart/form-data">

                            <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                            <div class="form-group">
                                <label class="col-sm-1 control-label" for="subject">主体:</label>
                                <div class="col-sm-11">
                                    <input class="form-control" type="text" id="subject" name="subject" value = "<?php echo $subject; ?>" >
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-1 control-label" for="property">属性:</label>
                                <div class="col-sm-11">

                                    <?php
                                    $query = "SELECT property FROM properties";
                                    $result = mysqli_query($dbc, $query) or die('Error querying database.');

                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<label><input type="radio" id="property" name="property" value="' . $row[0] . '" >'
                                        . $row[0] . '</label>&nbsp;&nbsp;';
                                    }
                                    ?>


                                    <input class="form-control" id="extraproperty" name="extraproperty" type="text"  value = "<?php if (isset($property)) echo $property; ?>" placeholder="其他属性...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label" for="object">客体:</label>
                                <div class="col-sm-11">
                                    <input class="form-control" type="text" id="object" name="object" value = "<?php echo $object; ?>" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-1 control-label" for="description">注释:</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" id="description" name="description"  placeholder="请输入注释" rows="2"><?php if (isset($description)) echo $description; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-11">
                                    <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>

            <div class="tab-pane fade" id="graph">
                <p>语言系统中的相关陈述：</p>
                <table class="table">                 

                    <?php
                    $subject_ids = get_ids($dbc, $subject);
                    $object_ids = get_ids($dbc, $object);

                    foreach ($subject_ids as $subject_id) {
                        foreach ($object_ids as $object_id) {                            
                            render_triples($dbc, $db_name, $db_name . ':o' . $subject_id, $db_name . ':o' . $object_id);
                        }
                    }
                    ?>
                </table>

            </div>

            <div class="tab-pane fade" id="baidu">
                <iframe src="<?php echo 'http://www.baidu.com/s?tn=baiduhome_pg&ie=utf-8&bs=iframe%E7%94%A8%E6%B3%95&f=8&rsv_bp=1&rsv_spt=1&wd=' . $subject . '+' . $object; ?>" width="100%" height="1000"> 
                百度搜索结果 
                </iframe>
            </div>
            <div class="tab-pane fade" id="params">
                <div class = "panel panel-default">
                    <div class = "panel-heading">
                        <strong>语义关系参数</strong>
                    </div>
                    <div class = "panel-body">
                        <?php
                        echo '<p><strong>价值:</strong>' . $value . '</p>';

                        echo '<p><strong>距离:</strong>' . $distance . '</p>';

                        echo '<p><strong>频数:</strong>' . $frequency . '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>












</div>



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
