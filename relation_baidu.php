<?php
include_once ("./header.php");
include_once ("./resource_helper.php");
include_once ("./messages.php");
include_once ("./functions.php");
require_once('appvars.php');
include_once ("./db_helper.php");
include_once ("./graph_helper.php");
include_once ("./function.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    render_warning('无相关实体信息');
}
?>
<p></p>
<div class="container">
    
    <?php
    $relation_tab_id = 'baidu';
    include_once ("./relation_header.php");
    ?>

    <div class="container">
        <iframe src="<?php echo 'http://www.baidu.com/s?tn=baiduhome_pg&ie=utf-8&bs=iframe%E7%94%A8%E6%B3%95&f=8&rsv_bp=1&rsv_spt=1&wd=' . $subject . '+' . $object; ?>" width="100%" height="1000"> 
        百度搜索结果 
        </iframe>
    </div>

</div>



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
