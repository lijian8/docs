<?php
include_once ("./header.php");
include_once ("./db_helper.php");
?>

<form class="form-search" action="search.php" method="get" class="form-horizontal"
      enctype="multipart/form-data">

    <div class="container"  align="center" >
        <img width="100%" class="media-object" src="img/logo_wide.jpg" >
        <p></p>             

        <ul class="nav nav-pills" align="center">    
            <?php
            $active_db = isset($_GET['db']) ? $_GET['db'] : DEFAULT_DB_NAME;
            foreach ($db_labels as $db => $db_label) {
                echo '<li ' . (($db == $active_db) ? 'class="disabled"' : '') . '><a href="' . $_SERVER['PHP_SELF'] . "?db=" . $db . '">' . $db_label . '</a></li>';
            }
            ?>     
            <!--
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    更多 <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    ...
                </ul>
            </li>-->
        </ul>

        <p></p>

        <div class="input-group">
            <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......">
            <span class="input-group-btn">
                <button class="btn btn-primary btn-lg" name ="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
            </span> 
        </div> 
        <br>
  
        <?php
        if ($active_db == 'tcmls'){
            include_once("tcmls_recommended_docs.php");
        }else{
        ?>
        <p>为您推荐： 
            <?php
            foreach ($db_search_words[$active_db] as $recommended_search_words) {
                echo "<a href='search.php?db_name=$active_db&keywords=$recommended_search_words'>$recommended_search_words</a>&nbsp;&nbsp;";
            }
            ?>
        </p>
        <?php
        }
        ?>
        <br><br>

    </div>

<input type="hidden" id ="db_name" name ="db_name" value=" <?php echo $active_db; ?>">
</form>
<br>
<br>
<link href="jumbotron-narrow.css" rel="stylesheet">
<?php
include_once ("./foot.php");
?>
