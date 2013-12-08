<div class="row">
    <div class="col-md-3">
        <img width="100%" class="media-object" src="img/logo.jpg" >                    
    </div>   

    <div class="col-md-9">
        <ul class="nav nav-pills" align="center">


            <?php
            //$active_db = isset($_GET['db_name']) ? $_GET['db_name'] : 'tcmls';
            //$active_db = trim($active_db);


            foreach ($db_labels as $db => $db_label) {
                //echo $db . $active_db . ($db === $active_db);
                echo '<li ';
               // if ($db == $active_db)
                if ($db == $db_name)
                    echo 'class="disabled"';
                // echo 'class="disabled"';
                echo "><a href=\"search.php?keywords=$keywords&db_name=" . $db . '">' . $db_label . '</a></li>';
                      
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
        &nbsp;&nbsp;
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox1" value="option1"> 古籍
        </label>
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox2" value="option2"> 期刊
        </label>
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox3" value="option3"> 学位
        </label>
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox3" value="option3"> 会议
        </label>
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox3" value="option3"> 图书
        </label>
        <label class="checkbox-inline input-sm">
            <input type="checkbox" id="inlineCheckbox3" value="option3"> 标准 
        </label>
        -->
    </div>
</div>
<input type="hidden" id ="db_name" name ="db_name" value=" <?php echo $db_name; ?>">
<hr>
