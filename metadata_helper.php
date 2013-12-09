<?php

function delete_triple($dbc, $id) {
    $query = "DELETE FROM metadata WHERE id = '$id'";
    mysqli_query($dbc, $query) or die('Error querying database.');
}

function render_graph($dbc, $name, $edit) {
    $query = "select * from metadata where subject ='$name'";
    //if (!$edit) $query .= " limit 10";
    $result = mysqli_query($dbc, $query) or die('Error querying database2.');
    while ($row = mysqli_fetch_array($result)) {
        $property = $row[property];
        $value = $row[value];
        //if (!$edit)  $value = tcmks_substr($value);
        $id = $row[id];
        $description = $row[description];


        //echo '<form class="form-horizontal" role = "form">';
        echo '<form action="' . $_SERVER['PHP_SELF'] . '" role = "form" method="post" class="form-horizontal"
                  enctype="multipart/form-data">';
        echo '<input  type="hidden" id="name" name="name" value = "' . $name . '" >';
        echo '<input  type="hidden" id="property" name="property" value = "' . $property . '" >';
        echo '<input  type="hidden" id="id" name="id" value = "' . $id . '" >';

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';
        echo '<strong>' . $property . '</strong>';
        echo '<a class="btn btn-link pull-right" href="' . $_SERVER['PHP_SELF'] . '?id=' . $name . '&delete_triple_id=' . $id . '">删除</a>';

        echo '<input  type = "submit" name="update" value="更新" class = "btn btn-link pull-right">';

        echo '</div>';
        echo '<div class="panel-body">';
        
         
        
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-1 control-label" for = "value">取值</label>';
        echo '<div class = "col-sm-11">';
        echo '<textarea type = "text" class = "form-control" id = "value" name="value">'. $value .'</textarea>';
        echo '</div>';
        echo '</div>';
        
        echo '<div class = "form-group">';
        echo '<label class = "col-sm-1 control-label" for = "description">注释</label>';
        echo '<div class = "col-sm-11">';
        echo '<textarea type = "text" class = "form-control" id = "description" name="description">'. $description .'</textarea>';
        echo '</div>';
        echo '</div>';
        
        
        
        
        
        echo '</div>';
        echo '</div>';
        
        echo '</form>';


        //echo "<p><strong>$property</strong>:&nbsp;$value";
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
