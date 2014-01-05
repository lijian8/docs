<br>
<div class="row">
    <div class="col-md-8">
        <?php
        $filter = array_merge($type_labels, $names);

        $values = get_literals($dbc, $db_name, PREFIX . $id, $filter, $ratio = '10%') + get_literals($dbc, $db_name, $name, $filter, $ratio = '10%');
        //ksort($values);

        $values_in_graph = array();
        foreach ($values as $property => $value) {
            if (mb_strlen($value, 'UTF-8') < 100) {
                $values_in_graph[$property] = $value;
                unset($values[$property]);
            }
        }

        foreach ($values as $property => $value) {
            echo "<p class='lead'><strong>$property</strong></p>";
            echo $value;
            echo "<hr>";
        }

        echo "<p class='lead'><strong>相关文献</strong></p>";
        //$query = "SELECT * FROM resource where title like '%$keywords%' or description like '%$keywords%' ORDER BY title ASC LIMIT 0,10";

        $query = build_query($name) . " LIMIT 0, 10";


        $result = mysqli_query($dbc, $query) or die('Error querying database.');
        while ($row = mysqli_fetch_array($result)) {
            $title = $row[title];
            $doc_id = $row[id];
            $def = $row[description];
            echo "<p><a href=\"resource_viewer.php?db_name=$db_name&id=$doc_id\">$title</a></p>";

            echo "<p>" . tcmks_substr($def) . "</p>";

            echo "<br>";
        }
        echo "<a href='search.php?db_name=$db_name&keywords=$name'>检索更多 》</a>";
        ?>


    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $name; ?>的知识图谱</h3>
            </div>
            <div class="panel-body" align="center">
                <?php
                $image_file = 'img/' . $name . '.jpg';
                if (is_file(iconv('utf-8', 'gb2312', $image_file))) {
                    echo '<a class="thumbnail" href="search.php?keywords=' . $name . '">';
                    echo '<img width="' . $width . '" class="img-thumbnail" src="' . $image_file . '" alt="' . $name . '" >';
                    echo $name;
                    echo '</a>';
                }
                ?>   
            </div>

            <table class="table">
                <tbody>

                    <?php
                    // echo "<tr><td width='10%'>代码:</td><td>" . $id . "</td></tr>";
                    //  echo "<tr><td width='10%'>类型:</td><td>" . implode(',', get_types($dbc, $name, $id)) . "</td></tr>";



                    $s = '';
                    foreach ($names as $name_property) {
                        $s .= render_info_by_property($dbc, $db_name, PREFIX . $id, $name_property, false);
                    }
                    if ($s != '')
                        echo "<tr><td width='30%'>相关术语:</td><td>$s</td></tr>";

                    render_links($dbc, $db_name, PREFIX . $id, '30%');
                    
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




