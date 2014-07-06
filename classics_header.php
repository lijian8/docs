<!--<p/>
<div class="panel ">
    <div class="panel-body">
        <img width ="100%" src ="img/classics_project.jpg"></img>    
    </div>        
</div>  -->
<br>
<div class="panel panel-default" align="center">
    <img width ="100%" src ="img/classics_project.jpg"></img>    
</div>       

<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="project_classics.php">项目介绍</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li <?php if ($page_name == 'relations') echo 'class="active"'; ?>><a href="relations.php" >中医古籍的语义关系</a></li>
            <li <?php if ($page_name == 'book_annotation') echo 'class="active"'; ?>><a href="book.php?chapter=卷之一·阴阳脏腑部&section=\JJ卷之一·阴阳脏腑部\PP阴阳" >中医古籍阅览</a></li>
            <li <?php if ($page_name == 'annotation') echo 'class="active"'; ?>><a href="annotation.php?text_id=827" >中医古籍标注</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
<!--
<ul class="nav nav-tabs">    
    <li <?php //if ($page_name == 'introduction') echo 'class="active"';    ?>><a href="project_classics.php" >项目介绍</a></li>
    <li <?php //if ($page_name == 'book_annotation') echo 'class="active"';    ?>><a href="book.php" >中医古籍</a></li>
    <li <?php //if ($page_name == 'relations') echo 'class="active"';    ?>><a href="relations.php" >中医古籍的语义关系</a></li>
    <li <?php //if ($page_name == 'annotation') echo 'class="active"';    ?>><a href="annotation.php" >中医古籍标注</a></li>
</ul>    -->

