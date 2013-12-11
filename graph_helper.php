<?php

function get_candidate_properties($dbc, $subject_id, $object_id) {
    
    $subject_type = get_type($dbc, $subject_id);    
    $object_type = get_type($dbc, $object_id);
    return get_class_links($dbc, $subject_type, $object_type);
    
    
}

function get_class_links($dbc, $c1, $c2) {
    $query = "select property from sn1 where subject='$c1' and object = '$c2' order by count desc";
    //echo $query;
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $values = array();
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[0];
        array_push($values, $value);
    }
    return $values;
}

function get_type($dbc, $name) {

    $types = get_types($dbc, $name);
   
    if (count($types) == 0) {
        return '事物';
    } else {
        return $types[0];
    }
}

function get_types($dbc, $name) {
    return get_property_values($dbc, $name, '类型');
}

function get_property_values($dbc, $subject, $property) {

    $query = "select * from graph where subject='$subject' and property = '$property'";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $values = array();
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[value];
        array_push($values, $value);
    }
    return $values;
}

function get_ids($dbc, $name) {
    $query = "select id from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $ids = array();
    while ($row = mysqli_fetch_array($result)) {
        $ids[] = $row[id];
    }
    return $ids;
}

function render_word($dbc, $db_name, $name, $with_def = false) {

    $ids = get_ids($dbc, $name);

    if (count($ids) != 0) {
        $id = $ids[0];
        return render_value($dbc, $db_name, $db_name . ':o' . $id, $with_def);
    } else {
        return $name;
    }
}

function render_value($dbc, $db_name, $name, $with_def = false) {

    if (strpos($name, $db_name . ':o') === 0) {
        $id = str_replace($db_name . ':o', "", $name);
        $query = "select * from def where id ='$id'";
        $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
        if ($row = mysqli_fetch_array($result)) {
            $pre_label = $row[name];
            $def = $row[def];
            $result = get_entity_link($id, get_type($dbc, $name) . ':&nbsp;' . $pre_label, $db_name);
            if (($with_def) && ($def != '')) {
                $result .= '&nbsp;<em><small>(' . tcmks_substr($def) . ')' . '</small></em>';
            }
        } else {
            $result = $name;
        }
    } else {
        $result = $name;
    }

    return $result;
}

function get_entity_link($id, $name, $db_name) {
    return "<a target=\"_blank\" href=\"/lod/entity.php?id=$id&db_name=$db_name\">$name</a>";
}

/*
  function render_value($dbc, $db_name, $name) {

  if (strpos($name, $db_name . ':o') === 0) {
  $id = str_replace($db_name . ':o', "", $name);
  $query = "select * from def where id ='$id'";
  $result = mysqli_query($dbc, $query) or die('Error querying database1.');
  if ($row = mysqli_fetch_array($result)) {
  $name = $row[name];
  $def = $row[def];
  $result = get_entity_link($id, $name, $db_name);
  } else {
  $result = $name;
  }
  } else {
  $result = $name;
  }

  return $result;
  } */

function render_triples_helper($dbc, $db_name, $subject, $object, $query) {
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $row_num = 1;
    $color = true;

    while ($row = mysqli_fetch_array($result)) {
        if ($color) {
            echo '<tr>';
        } else {
            echo '<tr class="info">';
        }
        $color = !$color;

        $no = $skip + ($row_num++);

        //echo '<td width = "3%">' . $no . '</td>';



        echo '<td>' . render_value($dbc, $db_name, $row['subject'], false) . '</td>';
        echo '<td>' . $row['property'] . '</td>';
        echo '<td>' . render_value($dbc, $db_name, $row['value'], false) . '</td>';

        echo '</tr>';
    }
}

function render_triples($dbc, $db_name, $subject, $object) {

    $query = "SELECT * FROM graph where subject like '%" . $subject . "%' and value like '%" . $object . "%' limit 5";
    render_triples_helper($dbc, $db_name, $subject, $object, $query);

    $query = "SELECT * FROM graph where subject like '%" . $subject . "%' and value like '" . $db_name . ':o' . "%' limit 5";
    render_triples_helper($dbc, $db_name, $subject, $object, $query);

    $query = "SELECT * FROM graph where subject like '" . $db_name . ':o' . "%' and value like '%" . $object . "%' limit 5";
    render_triples_helper($dbc, $db_name, $subject, $object, $query);
}

?>
