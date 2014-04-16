<?php
function build_title_query($user_search) {
    $search_query = "SELECT * FROM resource  ";
    $final_search_words = get_final_search_words($user_search);

    $where_list = array();
    if (count($final_search_words) > 0) {
        foreach ($final_search_words as $word) {
            $where_list[] = "title like '%$word%'";
        }
    }
    $where_clause = implode(' OR ', $where_list);

    if (!empty($where_clause)) {
        $search_query .= " WHERE $where_clause";
    }
    
    return $search_query;
}

function build_metadata_query($user_search) {
    $search_query = "SELECT * FROM metadata  ";
    $final_search_words = get_final_search_words($user_search);
    $where_clause = generate_where_clause($final_search_words, "value");
    if (!empty($where_clause)) {
        $search_query .= " WHERE $where_clause";
    }
    return $search_query;
}

function get_final_search_words($user_search) {
    $clean_search = str_replace(',', ' ', $user_search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
        foreach ($search_words as $word) {
            if (!empty($word)) {
                $final_search_words[] = $word;
            }
        }
    }
    return $final_search_words;
}

function build_query($user_search, $filtered, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM resource";
    } else {
        $search_query = "SELECT * FROM resource";
    }

    $final_search_words = get_final_search_words($user_search);

    if (count($final_search_words) > 0) {
        $title = generate_where_clause($final_search_words, 'title');
        $creator = generate_where_clause($final_search_words, 'creator');
        $description = generate_where_clause($final_search_words, 'description');
        $subject = generate_where_clause($final_search_words, 'subject');

        $where_clause = $title . ' OR ' . $creator . ' OR ' . $description . ' OR ' . $subject;

        if (count($filtered) != 0) {

            $where_clause = '(' . $where_clause . ') and (id not in (' . implode(',', $filtered) . '))';
        }


        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }
    }


    $search_query .= " ORDER BY title";

    return $search_query;
}

function generate_where_clause($final_search_words, $column) {
    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
        foreach ($final_search_words as $word) {
            $where_list[] = "$column LIKE '%$word%'";
        }
    }
    return implode(' OR ', $where_list);
}

?>
