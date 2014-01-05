<?php

function build_query($user_search, $count_only = false) {

    if ($count_only) {
        $search_query = "SELECT count(*) as count FROM resource";
    } else {
        $search_query = "SELECT * FROM resource";
    }

    //$search_query = "SELECT * FROM resource";
    // Extract the search keywords into an array
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

    if (count($final_search_words) > 0) {
        $title = generate_where_clause($final_search_words, 'title');
        $creator = generate_where_clause($final_search_words, 'creator');
        $description = generate_where_clause($final_search_words, 'description');
        $subject = generate_where_clause($final_search_words, 'subject');

        $where_clause = $title . ' OR ' . $creator . ' OR ' . $description . ' OR ' . $subject;

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
