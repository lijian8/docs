<?php

function render_triple($dbc, $db_name, $id) {
    $query = "select * from graph where id = '$id'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    if ($row = mysqli_fetch_array($result)) {
        echo '<span class="glyphicon glyphicon-chevron-left"></span>';
        echo render_value($dbc, $db_name, $row['subject'], false);
        echo '&nbsp;';
        echo $row['property'];
        echo '&nbsp;';
        echo render_value($dbc, $db_name, $row['value'], false);
        echo '<span class="glyphicon glyphicon-chevron-right"></span>';
    }
}

function get_classes_from_sn($dbc) {
    $query = "SELECT distinct subject FROM semantic_network";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row[0]);
    }

    return $arr;
}

function get_properties_from_sn($dbc) {
    $query = "select distinct property from semantic_network";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $arr = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($arr, $row[0]);
    }

    return $arr;
}

function get_classes($dbc) {
    $query = "select distinct value from graph where property='类型'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $classes = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($classes, $row[value]);
    }
    return $classes;
}

function get_properties($dbc) {
    $query = "select distinct property from graph";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $classes = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($classes, $row[0]);
    }

    return $classes;
}

function get_num_of_literals($dbc) {

    $query = "select count(id) as c from graph where not(value like '" . PREFIX . "%')";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[c];
    } else {
        return 0;
    }
}

function get_num_of_relations($dbc) {

    $query = "select count(id) as c from graph where value like '" . PREFIX . "%'";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[c];
    } else {
        return 0;
    }
}

function get_num_of_facts($dbc) {
    $query = "select count(id) as c from graph";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[c];
    } else {
        return 0;
    }
}

function get_num_of_entities($dbc) {
    $query = "select count(id) as c from def";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    if ($row = mysqli_fetch_array($result)) {
        return $row[c];
    } else {
        return 0;
    }
}

function get_entity_of_type($dbc, $name, $type) {
    $query = "select id, def from def where name ='$name'";

    $result = mysqli_query($dbc, $query) or die('Error querying database1.');

    while ($row = mysqli_fetch_array($result)) {
        $id = $row[id];

        if (instance_of($dbc, $id, $type))
            return $id;
    }
    return '';
}

function instance_of($dbc, $id, $type) {
    $subject = PREFIX . $id;
    $query = "select * from graph where subject='$subject' and property = '" . ENTITY_TYPE . "' and value = '$type'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $types = array();
    if ($row = mysqli_fetch_array($result)) {
        return true;
    } else {
        return false;
    }
}

function render_graph_by_property($dbc, $name, $property) {
    $query = "select * from graph where subject ='$name' and property='$property'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    if (mysqli_num_rows($result) != 0) {
        echo '<div class="panel panel-info">';
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title">' . $property . '</h3>';
        echo '</div>';
        echo '<div class="panel-body">';
        while ($row = mysqli_fetch_array($result)) {
            //$property = $row[property];
            $value = $row[value];
            $id = $row[id];
            //echo "<p><strong>$property</strong>:&nbsp;$value";

            echo $value;

            echo '<a href="' . $_SERVER['PHP_SELF'] . '?name=' . $name . '&delete_triple_id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>';

            echo "</p>";
        }
        echo '</div></div>';
    }
}
/*
function render_graph($dbc, $id, $ontology) {

    $types = get_types($dbc, $id);
    foreach ($types as $type) {
        $properties = $ontology[$type];
        foreach ($properties as $property) {
            render_graph_by_property($dbc, PREFIX . $id, $property);
        }
    }
}*/

function render_info_by_property($dbc, $db_name, $name, $property, $with_def = true) {
    $query = "select * from graph where subject ='$name' and property = '$property'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $s = '';
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[value];
        $id = $row[id];

        $s .= "<p>";
        $s .= render_value($dbc, $db_name, $value, $with_def);
        //$s .= '<a href="entity.php?name=' . $name . '&delete_triple_id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>';
        $s .= "</p>";
    }
    return $s;
}

function get_summary($dbc, $db_name, $name) {
    $s = '';
    $query = "select * from graph where subject ='$name' limit 10";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    if (mysqli_num_rows($result) != 0) {
        $r = get_property_values_from_row($dbc, $db_name, $result, array(), false);
        foreach ($r as $property => $value) {
            $s .= "$property:&nbsp;";
            $s .= implode(',', $value);
            $s .= "&nbsp;";
        }
    }

    /*
      $query = "select * from graph where subject ='$name'  limit 10";
      $result = mysqli_query($dbc, $query) or die('Error querying database2.');
      $s = '';
      if (mysqli_num_rows($result) != 0) {
      while ($row = mysqli_fetch_array($result)) {
      $property = $row[property];
      $value = $row[value];
      $s .= "<strong>$property</strong>:&nbsp;";
      $s .= render_value($dbc, $value, false);
      $s .= "&nbsp;";
      }
      }
     */

    return $s;
}

function get_reverse_property_values_from_row($dbc, $db_name, $result, $values, $with_def = true) {
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property] . '之逆属性';
        $value = $row[subject];
        if (array_key_exists($property, $values)) {
            array_push($values[$property], render_value($dbc, $db_name, $value, $with_def));
        } else {
            $values[$property] = array(render_value($dbc, $db_name, $value, $with_def));
        }
    }
    return $values;
}

function get_property_values_from_row($dbc, $db_name, $result, $values, $with_def = true) {
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];
        $value = $row[value];

        if (array_key_exists($property, $values)) {
            array_push($values[$property], render_value($dbc, $db_name, $value, $with_def));
        } else {
            $values[$property] = array(render_value($dbc, $db_name, $value, $with_def));
        }
    }

    return $values;
}

function get_property_values($dbc, $db_name, $name, $values = array()) {

    $query = "select * from graph where subject ='$name'";


    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $n = mysqli_num_rows($result);
    if ($n != 0) {
        if ($n < 20) {
            $values = get_property_values_from_row($dbc, $db_name, $result, $values);
        } else {
            $values = get_property_values_from_row($dbc, $db_name, $result, $values, false);
        }
    }

    return $values;
}

function get_reverse_property_values($dbc, $db_name, $name, $values = array()) {

    $query = "select * from graph where value ='$name'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    $n = mysqli_num_rows($result);
    if ($n != 0) {
        if ($n < 20) {
            $values = get_reverse_property_values_from_row($dbc, $db_name, $result, $values);
        } else {
            $values = get_reverse_property_values_from_row($dbc, $db_name, $result, $values, false);
        }
    }

    return $values;
}

function get_literals($dbc, $db_name, $name, $filter, $ratio = '10%') {
    $query = "select * from graph where subject ='$name' and not(value like '" . PREFIX . "%')  limit 100";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    $values = array();

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $property = $row[property];
            $value = $row[value];


            if (!in_array($property, $filter)) {

                if (array_key_exists($property, $values)) {
                    $values[$property] = $values[$property] . ',&nbsp;' . render_value($dbc, $db_name, $value, false);
                } else {
                    $values[$property] = render_value($dbc, $db_name, $value, false);
                }
            }

            //echo "<p><strong>$property</strong>:&nbsp;$value";
        }
    }
    return $values;
}

function get_links($dbc, $db_name, $name) {
    $query = "select * from graph where subject ='$name' and value like '" . PREFIX . "%'  limit 100";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    $values = array();

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $property = $row[property];
            $value = $row[value];
            if (array_key_exists($property, $values)) {
                $values[$property] = $values[$property] . ',&nbsp;' . render_value($dbc, $db_name, $value, false);
            } else {
                $values[$property] = render_value($dbc, $db_name, $value, false);
            }

            //echo "<p><strong>$property</strong>:&nbsp;$value";
        }
    }
    return $values;
}

function render_links($dbc, $db_name, $name, $ratio = '10%') {
    $query = "select * from graph where subject ='$name' and value like '" . PREFIX . "%'  limit 100";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    $values = array();

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $property = $row[property];
            $value = $row[value];
            if (array_key_exists($property, $values)) {
                $values[$property] = $values[$property] . ',&nbsp;' . render_value($dbc, $db_name, $value, false);
            } else {
                $values[$property] = render_value($dbc, $db_name, $value, false);
            }

            //echo "<p><strong>$property</strong>:&nbsp;$value";
        }
    }

    foreach ($values as $property => $value) {
        echo "<tr><td width='$ratio'>" . $property . ":</td><td>";
        echo $value;
        echo "</td></tr>";
    }
}


function render_rlinks($dbc, $db_name, $name, $ratio = '10%') {
    $query = "select * from graph where value ='$name' and subject like '" . PREFIX . "%'  limit 100";
    
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');

    $values = array();

    if (mysqli_num_rows($result) != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $property = $row[property];
            $value = $row[subject];
            if (array_key_exists($property, $values)) {
                $values[$property] = $values[$property] . ',&nbsp;' . render_value($dbc, $db_name, $value, false);
            } else {
                $values[$property] = render_value($dbc, $db_name, $value, false);
            }

            //echo "<p><strong>$property</strong>:&nbsp;$value";
        }
    }

    foreach ($values as $property => $value) {
        echo "<tr><td width='$ratio'>" . $property . " (逆属性):</td><td>";
        echo $value;
        echo "</td></tr>";
    }
}

function get_types($dbc, $id) {
    return get_values($dbc, PREFIX . $id, '类型');
}

function render_list($dbc, $db_name, $property, $values) {

    //echo '<ul class="list-group">';
    echo '<ol >';
    foreach ($values as $value) {

        //echo '<li class="list-group-item">';   
        echo '<li>';
        echo render_value($dbc, $db_name, $value, true);
        echo '</li>';
    }
    echo '</ol>';
}

function render_panel($dbc, $db_name, $property, $values) {
    echo '<div class="panel panel-info">';
    echo '<div class="panel-heading">';
    echo '<h3 class="panel-title">' . $property . '</h3>';
    echo '</div>';
    echo '<ul class="list-group">';
    foreach ($values as $value) {

        echo '<li class="list-group-item">';
        echo render_value($dbc, $db_name, $value, true);
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
}

function get_ids($dbc, $name) {
    $query = "select id, def from def where name like '%$name%'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $ids = array();
    while ($row = mysqli_fetch_array($result)) {
        $ids[] = $row[id];
    }
    return $ids;
}

function get_id($dbc, $name) {
    
    $query = "select id, def from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $ids = array();
    while ($row = mysqli_fetch_array($result)) {
        $ids[] = $row[id];
    }

    if (count($ids) == 0) {
        $ids = get_ids($dbc, $name);
        if (count($ids) == 0) {
            return '';
        }
    }
    return $ids[0];
}

function get_subjects($dbc, $object, $property) {
    $query = "select * from graph where value = '$object' and property = '$property'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $types = array();
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[subject];
        array_push($types, $value);
    }

    return $types;
}

function get_values($dbc, $subject, $property) {
    $query = "select * from graph where subject='$subject' and property = '$property'";

    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    $types = array();
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[value];
        array_push($types, $value);
    }

    return $types;
}

function get_entity_link($id, $name, $db_name) {
    return "<a href=\"entity.php?id=$id&db_name=$db_name\">$name</a>";
}

function get_entity_name($dbc, $name) {
    if (strpos($name, PREFIX) === 0) {
        $id = str_replace(PREFIX, "", $name);
        $query = "select * from def where id ='$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database1.');
        if ($row = mysqli_fetch_array($result)) {
            return $row[name];
        } else {
            return $name;
        }
    }

    return $name;
}

function render_value($dbc, $db_name, $name, $with_def = true) {

    if (strpos($name, $db_name . ':o') === 0) {
        $id = str_replace($db_name . ':o', "", $name);
        $query = "select * from def where id ='$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database1.');
        if ($row = mysqli_fetch_array($result)) {
            $name = $row[name];
            $def = $row[def];
            $result = get_entity_link($id, $name, $db_name);
            if ($with_def) {
                if ($def == '')
                    $def = get_summary($dbc, $db_name, $db_name . ':o' . $id);
                if ($def != '') {
                    $result .= '&nbsp;<em><small>(' . $def . ')' . '</small></em>';
                }
            }
        } else {
            //$result = "<a>\"" . $name . "\"</a>";
            $result = $name;
        }
    } else {
        $result = $name;
    }

    return $result;
}

?>
