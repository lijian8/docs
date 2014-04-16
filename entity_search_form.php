
<form class="form-search" action="entity_search.php" method="get" class="form-horizontal"
      enctype="multipart/form-data">
    <input type="hidden" id ="db_name" name ="db_name" value ="<?php if (isset($db_name)) echo $db_name; ?>">
    <div class="container" >
        <div class="row">
            <div class="col-md-3">
                <img width="100%" class="media-object" src="img/logo.jpg" >                    
            </div>   
            <div class="col-md-9">

                <ul class="nav nav-pills" align="center">
                    <?php
                   
                    foreach ($db_labels as $db => $db_label) {
                      
                        
                        echo '<li ' . (($db == $db_name) ? 'class="disabled"' : '') . '><a href="entity_search.php?keywords=' . $keywords . '&db_name=' . $db . '">' . $db_label . '</a></li>';
                    }
                    ?>  
                    <li><a href="#">更多>></a></li>
                </ul>
                <div class="input-group">
                    <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......"  value ="<?php if (isset($keywords)) echo $keywords; ?>">
                    <span class="input-group-btn">
                        <button name ="submit" type="submit" class="btn btn-primary  btn-lg"><span class="glyphicon glyphicon-search"></span></button>
                    </span> 
                </div> 

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

    </div>

</form> 