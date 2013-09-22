<?php

function delete_triple($dbc, $id) {
    $query = "DELETE FROM graph WHERE id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

function render_graph($dbc, $name, $edit) {
    $query = "select * from graph where subject ='$name'";
    //if (!$edit) $query .= " limit 10";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];
        $value = $row[value];
        //if (!$edit)  $value = tcmks_substr($value);
        $id = $row[id];

        //echo '<form class="form-horizontal" role = "form">';
        echo '<form action="' . $_SERVER['PHP_SELF'] . '" role = "form" method="post" class="form-horizontal"
                  enctype="multipart/form-data">';
        echo '<input  type="hidden" id="name" name="name" value = "' . $name . '" >';
        echo '<input  type="hidden" id="property" name="property" value = "' . $property . '" >';
        echo '<input  type="hidden" id="id" name="id" value = "' . $id . '" >';

        echo '<div class = "form-group">';
        echo '<label class = "col-sm-2 control-label" for = "value">' . $property . '</label>';

        echo '<div class = "col-sm-9">';

        echo '<div class="input-group">';
        echo '<input type = "text" class = "form-control" id = "value" name="value" value = "' . $value . '">';
        echo '<span class="input-group-btn">';
        echo '<input type = "submit" name="update" value="确定" class = "btn btn-success">';
        
        echo '</span>';
       
        echo '</div>';
        echo '</div>';
        echo '<div class = "col-sm-1">';
        
        echo '<a class="btn btn-danger active" href="' . $_SERVER['PHP_SELF'] . '?id=' . $name . '&delete_triple_id=' . $id . '">删除</a>';

        echo '</div>';
        echo '</div>';









        echo '</form>';


        //echo "<p><strong>$property</strong>:&nbsp;$value";

        echo "</p>";
    }
}

function render_entity($dbc, $name, $edit = false) {
    /*
      $query = "select * from def where name ='$name'";
      $result = mysqli_query($dbc, $query) or die('Error querying database2.');
      if ($row = mysqli_fetch_array($result)) {
      $def = $row[def];
      } else {
      $def = $name;
      }

      $width = $edit ? 200 : 100;

      $image_file = 'img/' . get_image_file_by_name($dbc, $name);

      echo '<div class="media">';
      echo '<a class="pull-right" href="search.php?keywords=' . $name . '">';
      echo '<img width="' . $width . '" class="media-object" src="' . $image_file . '" data-src="holder.js/64x64">';
      echo '</a>';
      echo '<div class="media-body"  align ="left">';
      echo '<h2>' . $name . '</h2>';
      echo '<h4>' . $def . '</h4>';
      echo '</div></div>';
     */
    echo '<div  align ="left">';
    if (isset($name)) {
        render_graph($dbc, $name, $edit);
    }
    echo '</div>';
}

?>
