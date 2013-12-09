<?php

function get_ids($dbc, $name) {
    $query = "select id from def where name = '$name'";
    $result = mysqli_query($dbc, $query) or die('Error querying database1.');
    $ids = array();
    while ($row = mysqli_fetch_array($result)) {
        $ids[] = $row[id];
    }
    return $ids;
}

function get_entity_link($id, $name, $db_name) {    
    return "<a target=\"_blank\" href=\"/lod/entity.php?id=$id&db_name=$db_name\">$name</a>";
}

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
}

function render_triples_helper($dbc, $db_name, $subject, $object, $query){
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



        echo '<td>' . render_value($dbc, $db_name, $row['subject'], true) . '</td>';
        echo '<td>' . $row['property'] . '</td>';
        echo '<td>' . render_value($dbc, $db_name, $row['value'], true) . '</td>';

        echo '</tr>';
    }
}

function render_triples($dbc, $db_name, $subject, $object) {
    
    //$query = "SELECT * FROM graph where subject like '%" . $subject . "%' and value like '%" . $object . "%' limit 10";
    //render_triples_helper($dbc, $db_name, $subject, $object, $query);
    
    $query = "SELECT * FROM graph where subject like '%" . $subject . "%' or value like '%" . $object . "%' limit 1";
    render_triples_helper($dbc, $db_name, $subject, $object, $query);
    
}

?>
