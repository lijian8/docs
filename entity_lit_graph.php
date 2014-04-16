<?php

function render_related_docs($dbc, $file_id) {
    echo "<p class='lead'><strong>相关文献</strong></p>";
    //$query = "SELECT * FROM resource where title like '%$keywords%' or description like '%$keywords%' ORDER BY title ASC LIMIT 0,10";


    $recommended = array();

    $metadata_query = "SELECT * FROM metadata where value = '" . $file_id . "'";

    $metadata_result = mysqli_query($dbc, $metadata_query) or die('Error querying database:' . $metadata_query);
    while ($row = mysqli_fetch_array($metadata_result)) {

        $id = $row[subject];
        $property = $row[property];
        $value = $row[value];
        if (array_key_exists($id, $recommended)) {
            $recommended[$id][] = array($property, $value);
        } else {
            $recommended[$id] = array(array($property, $value));
        }
    }



    foreach ($recommended as $id => $pv) {
        $query = "SELECT * FROM resource where id = $id";
        $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
        if ($inner_row = mysqli_fetch_array($result)) {
            $title = $inner_row[title];
            $def = $inner_row[description];
            echo "<a  href=\"resource_viewer.php?db_name=$db_name&id=$id\">$title</a><br>";

            echo tcmks_substr($def) . '<br>';
            echo '<font color="green">';
            foreach ($pv as $pair) {
                echo '<strong>' . $pair[0] . ": " . $pair[1] . '</strong>&nbsp;&nbsp;';
            }
            echo '</font>';

            echo "<br><br>";
        }
    }



    $query = build_query($file_id, array_keys($recommended)) . " LIMIT 0, 10";


    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    while ($row = mysqli_fetch_array($result)) {
        $title = $row[title];
        $doc_id = $row[id];
        $def = $row[description];
        echo "<a href=\"resource_viewer.php?db_name=$db_name&id=$doc_id\">$title</a><br>";

        echo tcmks_substr($def) . "<br>";

        echo "<br>";
    }
}
?>

<br>
<div class="row">
    <div class="col-md-8">

        <?php
        $filter = array_merge($type_labels, $names);

        $values = get_literals($dbc, $db_name, PREFIX . $id, $filter, $ratio = '10%') + get_literals($dbc, $db_name, $file_id, $filter, $ratio = '10%');
//ksort($values);

        $values_in_graph = array();
        foreach ($values as $property => $value) {
            if (mb_strlen($value, 'UTF-8') < 100) {

                $values_in_graph[$property] = $value;
                unset($values[$property]);
            }
        }

        foreach ($values as $property => $value) {
            echo "<a class='pull-right' href='#'><span class='glyphicon glyphicon-pencil'></span> 编辑</a>";
            echo "<p class='lead'><strong>$property</strong></p>";
            echo $value;
            echo "<hr>";
        }

        render_related_docs($dbc, $file_id);
        echo "<a class='btn btn-default' href='search.php?db_name=$db_name&keywords=$file_id'>更多文献 》</a>";
        ?>


    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $file_id; ?>的知识图谱</h3>
            </div>
            <div class="panel-body" align="center">
                <?php
                $image_file = 'img/' . $file_id . '.jpg';
                if (is_file(iconv('utf-8', 'gb2312', $image_file))) {
                    echo '<a class="thumbnail" href="search.php?keywords=' . $file_id . '">';
                    echo '<img width="' . $width . '" class="img-thumbnail" src="' . $image_file . '" alt="' . $file_id . '" >';
                    echo $file_id;
                    echo '</a>';
                }
                ?>   
            </div>

            <table class="table">
                <tbody>

                    <?php
// echo "<tr><td width='10%'>代码:</td><td>" . $id . "</td></tr>";
//  echo "<tr><td width='10%'>类型:</td><td>" . implode(',', get_types($dbc, $name, $id)) . "</td></tr>";



                    $s = array();
                    foreach ($names as $name_property) {
                        $query = "select * from graph where (subject ='". PREFIX . $id ."' or  subject ='". $file_id ."' ) and property = '$name_property'";

                        $result = mysqli_query($dbc, $query) or die('Error querying database2.');

                        while ($row = mysqli_fetch_array($result)) {
                            $value = $row[value];
                            $s[] = render_value($dbc, $db_name, $value, false);
                        }
                    }
                    if (count($s) != 0) {
                        echo "<tr><td width='30%'>相关术语:</td><td>";
                        echo implode(', ', $s);
                        echo "</td></tr>";
                    }
                    render_links($dbc, $db_name, PREFIX . $id, '30%');
                    render_rlinks($dbc, $db_name, PREFIX . $id, '30%');

                    foreach ($values_in_graph as $property => $value) {
                        //echo "<p><strong>$property</strong>$value</p>";
                        echo "<tr><td width='10%'>" . $property . ":</td><td>";
                        echo $value;
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<hr>



