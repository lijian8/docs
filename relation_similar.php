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
<div class="container">
    <?php
    $relation_tab_id = 'similar';
    include_once ("./relation_header.php");
    ?>


    <p>相关陈述：</p>
    <table class="table">   

        <tr><td width="40%">主体</td><td width="20%">谓词</td><td width="40%">客体</td></tr>

        <?php
        $subject_ids = get_ids($dbc, $subject);
        $object_ids = get_ids($dbc, $object);

        foreach ($subject_ids as $subject_id) {
            foreach ($object_ids as $object_id) {
                render_triples($dbc, $db_name, $db_name . ':o' . $subject_id, $db_name . ':o' . $object_id);
            }
        }
        ?>
    </table>

</div>



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
