<?php
$db_name = "clan";
include_once ("./header.php");
include_once ("./functions.php");

function render_triples($dbc, $property, $verb) {
    $query = "SELECT * FROM verbs WHERE property like '%$property%' and verb = '$verb' ";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    
    echo '<table class="table table-bordered" >';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row[subject] . '</td>';
        echo '<td>' . $row[verb] . '</td>';
        echo '<td>' . $row[object] . '</td>';
        echo '<td>' . $row[text] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

function get_verbs($dbc, $property) {
    $query = "SELECT verb, count(*) FROM verbs WHERE property like '%$property%' group by verb order by count(*) desc";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $verbs = array();
    while ($row = mysqli_fetch_array($result)) {
        $verbs[] = $row[verb];
    }
    return $verbs;
}

function render_properties($dbc, $active_property) {
    $query = "SELECT * FROM verbs";
    $result = mysqli_query($dbc, $query) or die('Error querying database:' . $query);
    $property_array = array();
    while ($row = mysqli_fetch_array($result)) {
        foreach (explode("$", $row[property]) as $cur_property) {
            if (array_key_exists($cur_property, $property_array)) {
                $property_array[$cur_property] = $property_array[$cur_property] + 1;
            } else {
                $property_array[$cur_property] = 1;
            }
        }
    }
    arsort($property_array);
    foreach ($property_array as $property => $count) {
        echo '<li ';
        if ($property == $active_property) {
            echo 'class = "active"';
        }
        echo '><a href = "properties.php?';
        echo 'active_property=' . $property . '">' . $property . '</a></li>';
    }
}

if (isset($_GET['active_property']) && ($_GET['active_property'] != '')) {
    $active_property = $_GET['active_property'];
} else {
    $active_property = '位于';
}
?>
<div class="container">
    <?php
    ?>

    <p></p>

    <div class="row">
        <div class="col-md-3">
            <ul class="well nav nav-pills">
                <?php
                render_properties($dbc, $active_property);
                ?>
            </ul>

        </div>
        <div class="col-md-9" role="main">     
            <div >  
                <?php
                if (isset($active_property)) {
                    echo '<h1>“' . $active_property . '”对应的谓词</h1>';
                    echo '<hr>';
                    $verbs = get_verbs($dbc, $active_property);
                    foreach ($verbs as $verb) {
                        echo '<p class="lead">' . $verb . '</p>';
                        render_triples($dbc, $active_property, $verb);
                    }
                } else {
                    render_warning('<<请在右侧选择关系以查看相关陈述');
                }
                ?>
            </div>
        </div>    
    </div>
</div>
<?php
include_once ("./foot.php");
?>