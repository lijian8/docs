<?php
include_once ("./header.php");
include_once ("./db_helper.php");
?>

<form class="form-search" action="parser.php" method="post" class="form-horizontal"
      enctype="multipart/form-data">
    <input type="hidden" name="db_name" value="<?php echo $db_name; ?>" />
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" align="center" >
            <img width="60%" class="media-object" src="img/logo_wide.jpg" >
            <p></p> 
            <div class="form-group ">
                <label class="control-label" for="file">上传文献原文:</label>
                <input class="form-control" type="file" name="file" id="file" />  
            </div>
            <p></p>
            <input class="btn btn-primary" type="submit" name="submit" value="提交" />    
            <a class="btn btn-success" href="resource_manager.php?db_name=<?php echo db_name; ?>">返回首页</a>
        </div>
    </div>
</form>
<br>
<br>
<br>
<?php
include_once ("./foot.php");
?>
