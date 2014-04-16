<?php

class metadataModel {
            public$dbc;
            public$db_name;

    function delete_triple($id) {
        $query = "DELETE FROM metadata WHERE id = '$id'";
        mysqli_query($this->dbc, $query) or die('Error querying database.');
    }

    function get_all_properties() {
        $query = "select distinct property from metadata_elements";
        $result = mysqli_query($this->dbc, $query) or die('Error querying database:' . $query);
        $properties = array();
        while ($row = mysqli_fetch_array($result)) {
            $properties[] = $row[property];
        }
        return $properties;
    }

    function get_properties_of_entity($name) {
        $query = "select distinct property from metadata where subject ='$name'";
        $result = mysqli_query($this->dbc, $query) or die('Error querying database:' . $query);
        $properties = array();
        while ($row = mysqli_fetch_array($result)) {
            $properties[] = $row[property];
        }
        return $properties;
    }

    function render_entity($name, $edit = false) {
        
        echo '<div  align ="left">';
        $properties = $this->get_properties_of_entity($name);


        echo '<div class="panel panel-default">';

        echo '<div class="panel-body">';
        echo '<ul class = "nav nav-pills">';
        $active = true;
        foreach ($properties as $property) {

            if ($active) {
                echo '<li class="active"><a href = "#tab' . $property . '" data-toggle = "tab">' . $property . '</a></li>';
                $active = false;
            } else {
                echo '<li><a href = "#tab' . $property . '" data-toggle = "tab">' . $property . '</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo '<div class="tab-content">';
        $active = true;
        foreach ($properties as $property) {
            if ($active) {
                echo '<div class="tab-pane active" id="tab' . $property . '">';
                $active = false;
            } else {
                echo '<div class="tab-pane" id="tab' . $property . '">';
            }
            $query = "select * from metadata where subject ='$name' and property='$property'";
            $result = mysqli_query($this->dbc, $query) or die('Error querying database2.');

            while ($row = mysqli_fetch_array($result)) {
                $property = $row[property];
                $value = $row[value];
                $id = $row[id];
                $description = $row[description];



                //echo '<form class="form-horizontal" role = "form">';
                echo '<form action="' . $_SERVER['PHP_SELF'] . '" role = "form" method="post" class="form-horizontal"
                  enctype="multipart/form-data">';
                echo '<input  type="hidden" id="name" name="name" value = "' . $name . '" >';
                echo '<input  type="hidden" id="property" name="property" value = "' . $property . '" >';
                echo '<input  type="hidden" id="id" name="id" value = "' . $id . '" >';
                echo '<input  type="hidden" id="db_name" name="db_name" value = "' . $this->db_name . '" >';


                echo '<div class="panel panel-default">';

                echo '<div class="panel-body">';
                echo '<br/>';
                echo '<div class = "form-group">';
                echo '<label class = "col-sm-2 control-label" for = "value">' . $property . '</label>';
                echo '<div class = "col-sm-9">';
                echo '<textarea type = "text" class = "form-control" id = "value" name="value">' . $value . '</textarea>';
                echo '</div>';
                echo '</div>';

                echo '<div class = "form-group">';
                echo '<label class = "col-sm-2 control-label" for = "description">注释</label>';
                echo '<div class = "col-sm-9">';
                echo '<textarea type = "text" class = "form-control" id = "description" name="description">' . $description . '</textarea>';
                echo '</div>';
                echo '</div>';

                echo '<div class = "form-group">';
                echo '<div class = "col-sm-offset-2 col-sm-10">';
                echo '<input  type = "submit" name="update" value="更新" class = "btn  btn-primary">';
                echo ' ';
                echo '<a class="btn btn-warning" href="' . $_SERVER['PHP_SELF'] . '?id=' . $name . '&delete_triple_id=' . $id . '">删除</a>';
                echo '</div>';
                echo '</div>';





                echo '</div>';
                echo '</div>';

                echo '</form>';



                //echo "<p><strong>$property</strong>:&nbsp;$value";
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }

}

$model = new metadataModel();
$model->dbc = $dbc;
$model->db_name = $db_name;
?>
