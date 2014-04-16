<br>

<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $db_label; ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li><a href="resource_add.php?db_name=<?php echo $db_name; ?>"><span class="glyphicon glyphicon-list"></span>&nbsp;录入文献</a></li>               
        </ul>

        <form class="navbar-form navbar-left" role="search" action="resource_manager.php" method="get" 
              enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" id ="keywords" name ="keywords" value="<?php echo $keywords; ?>" placeholder="请输入关键词...">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>&nbsp;搜索</button>
            <input type="hidden" id ="db_name" name ="db_name" value=" <?php echo $db_name; ?>">
        </form>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">文献库切换<b class="caret"></b></a>                   

                <ul class="dropdown-menu">
                    <?php
                    foreach ($db_labels as $db_id => $dbl) {
                        if ($db_id != $db_name)
                            echo '<li><a href="resource_manager.php?db_name=' . $db_id . '">' . $dbl . '</a></li>';
                    }
                    ?>

                </ul>
            </li>      
            <li><a href="resource_manager.php?db_name=<?php echo $db_name;?>" >返回首页</a></li>

        </ul>
    </div>
</nav>
