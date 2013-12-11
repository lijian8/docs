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
    $relation_tab_id = 'add';
    include_once ("./relation_header.php");
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>参考性谓词：</strong>
            <?php
            echo '&nbsp;' . implode(',&nbsp;', array_slice($predicates, 0, 20));
            if (count($predicates) > 20)
                echo '...';
            
            ?>
            
        </div>
        <div class="panel-body">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal"
                  enctype="multipart/form-data">

                <input  type="hidden" id="name" name="name" value = "<?php echo $name; ?>" >

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="subject">主体:</label>
                    <div class="col-sm-11">
                        <input class="form-control" type="text" id="subject" name="subject" value = "<?php echo $subject; ?>" >
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-1 control-label" for="property">属性:</label>
                    <div class="col-sm-11">

                        <?php
                        if ((count($subject_ids) != 0) && (count($object_ids) != 0)) {
                            $subject_id = $subject_ids[0];
                            $object_id = $object_ids[0];
                            $candidate_properties = get_candidate_properties($dbc, $db_name . ':o' . $subject_id, $db_name . ':o' . $object_id);
                            foreach ($candidate_properties as $candidate_property) {
                                echo '<label><input type="radio" id="property" name="property" value="' . $candidate_property . '" >'
                                . $candidate_property . '</label>&nbsp;&nbsp;';
                            }
                        } else {
                            $query = "SELECT property FROM properties";
                            $result = mysqli_query($dbc, $query) or die('Error querying database.');
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<label><input type="radio" id="property" name="property" value="' . $row[0] . '" >'
                                . $row[0] . '</label>&nbsp;&nbsp;';
                            }
                        }
                        ?>
                        <input class="form-control" id="extraproperty" name="extraproperty" type="text"  value = "<?php if (isset($property)) echo $property; ?>" placeholder="其他属性...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="object">客体:</label>
                    <div class="col-sm-11">
                        <input class="form-control" type="text" id="object" name="object" value = "<?php echo $object; ?>" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label" for="description">注释:</label>
                    <div class="col-sm-11">
                        <textarea class="form-control" id="description" name="description"  placeholder="请输入注释" rows="2"><?php if (isset($description)) echo $description; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-1 col-sm-11">
                        <input class="btn btn-large btn-primary" type="submit" name="submit" value="提交" />    
                    </div>
                </div>

            </form>
        </div>
    </div>



</div>












</div>



<!-- Example row of columns -->


<!-- /container -->
<?php
include_once ("./foot.php");
?>
