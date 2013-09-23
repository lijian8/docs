<?php
include_once ("./header.php");
?>

<form class="form-search" action="search.php" method="post" class="form-horizontal"
      enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" align="center" >
            <img width="60%" class="media-object" src="img/logo_wide.jpg" >
            <p></p> 
            <div class="input-group">
                <input type="text" id ="keywords" name ="keywords" class="form-control input-lg" placeholder="搜索......">
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-lg" name ="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span> 
            </div> 
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
