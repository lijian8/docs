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
    $subject_ids = get_ids($dbc, $row['SUBJECT']);
    $object_ids = get_ids($dbc, $row['OBJECT']);
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
        <a class="navbar-brand" href="relation.php?id=<?php echo $id; ?>">语义关系:&nbsp;
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
        <ul class="nav navbar-nav">
            <li <?php echo $relation_tab_id == 'add' ? 'class="active"' : ''; ?>><a href="relation_add.php?id=<?php echo $id; ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;加入语言系统</a></li>  
            <li <?php echo $relation_tab_id == 'docs' ? 'class="active"' : ''; ?>><a href="relation_in_docs.php?id=<?php echo $id; ?>"><span class="glyphicon glyphicon-book"></span>&nbsp;文献来源</a></li>          
            <li <?php echo $relation_tab_id == 'baidu' ? 'class="active"' : ''; ?>><a href="relation_baidu.php?id=<?php echo $id; ?>" ><span class="glyphicon glyphicon-search"></span>&nbsp;百度搜索</a></li>    
            <li <?php echo $relation_tab_id == 'similar' ? 'class="active"' : ''; ?>><a href="relation_similar.php?id=<?php echo $id; ?>" ><span class="glyphicon glyphicon-list"></span>&nbsp;相关陈述</a></li>    
     
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="relation_manager.php?keywords=<?php echo $subject . '+' . $object; ?>" ><span class="glyphicon glyphicon-home"></span>&nbsp;返回首页</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>

