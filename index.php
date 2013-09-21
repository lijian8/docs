<?php
include_once ("./header.php");
?>

<form class="form-search" action="search.php" method="post" class="form-horizontal"
      enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" align="center" >
            <img width="60%" class="media-object" src="img/logo_large_wide.jpg" >
            <p></p> 
            <div class="input-group">
                <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......">
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-lg" name ="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span> 
            </div> 
            <br>
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
            <br><br>
            
        </div>
    </div>
</form>
<br>
<br>
<br>
<?php
include_once ("./foot.php");
?>
