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
    include_once ("./relation_header.php");
    ?>



    <table class="table table-bordered">   

        <?php
        if ((count($subject_ids) != 0) && (count($object_ids) != 0)) {
            
            $subject_id = $subject_ids[0];
            //$subject_type = get_type($dbc, $db_name . ':o' . $subject_id);                
            $object_id = $object_ids[0];
            //$object_type = get_type($dbc, $db_name . ':o' . $object_id);  
            //$class_links = get_class_links($dbc, $subject_type, $object_type) ;

            $class_links = get_candidate_properties($dbc, $db_name . ':o' . $subject_id, $db_name . ':o' . $object_id);

            echo '<tr><td><strong>主体:</strong></td>
                <td>' . render_word($dbc, $db_name, $subject, true) . '</td></tr>';

            if (count($class_links) != 0) {
                echo '<tr><td><strong>谓词：</strong></td><td>' . implode(',', $class_links) . '</td></tr>';
            } else {
                echo '<tr><td><strong>谓词：</strong></td><td>' . implode(',', $predicates) . '</td></tr>';
            }

            echo '<tr><td><strong>客体：</strong></td><td colspan=4>' . render_word($dbc, $db_name, $row['OBJECT'], true) . '</td></tr>';
            echo '<tr><td><strong>参考参数：</strong></td><td>赋值：' . $value . '；距离：' . $distance . '；频数：' . $frequency . '</td>';
            //echo '<td>距离</td><td>' . $distance . '</td>';
            //echo '<td>频数</td><td>' . $frequency . '</td></tr>';


            //return render_value($dbc, $db_name, $db_name . ':o' . $id, $with_def);
        }
        ?>

    </table>



</div>



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
