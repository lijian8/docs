<?php
include_once ("./header.php");
include_once ("./db_array.php");
?>

<form class="form-search" action="search.php" method="get" class="form-horizontal"
      enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" align="center" >
            <img width="60%" class="media-object" src="img/logo_wide.jpg" >
            <p></p>             
            <div class="container" align="center">
                <ul class="nav nav-pills" align="center">                   

                    <?php
                    $active_db = isset($_GET['db']) ? $_GET['db'] : 'tcmls';

                    foreach ($db_labels as $db => $db_label) {
                        echo '<li ' . (($db == $active_db) ? 'class="disabled"' : '') . '><a href="' . $_SERVER['PHP_SELF'] . "?db=" . $db . '">' . $db_label . '</a></li>';
                    }
                    ?>  
                    <li><a href="#">更多>></a></li>

                </ul>
            </div>
            <p></p>

            <div class="input-group">
                <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......">
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-lg" name ="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span> 
            </div> 
             <br><br>
            <div class="container" align="center">

                <p><a href="#">领域本体</a>&nbsp;|&nbsp;<a href="#">语义查询</a>&nbsp;|&nbsp;<a href="#">技术文档</a></p>

            </div>
            <!--
            <br>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox1" value="option1"> 古籍
            </label>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox2" value="option2"> 期刊
            </label>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox3" value="option3"> 学位
            </label>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox3" value="option3"> 会议
            </label>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox3" value="option3"> 图书
            </label>
            <label class="checkbox-inline input-lg">
                <input type="checkbox" id="inlineCheckbox3" value="option3"> 标准 
            </label>
            <br><br>-->
            <br><br>

        </div>
    </div>
    <input type="hidden" id ="db_name" name ="db_name" value=" <?php echo $active_db; ?>">
</form>
<br>


<br>
<?php
include_once ("./foot.php");
?>
