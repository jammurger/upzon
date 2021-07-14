<?php
// Cleaned json with this way :D I didn't afford for finding normal way looking good imo
function tagcleaner($data)
{
    $data = str_replace("[[", "", $data);
    $data = str_replace("[", "", $data);
    $data = str_replace("]]", "", $data);
    $data = str_replace('""', "", $data);
    $data = str_replace('"', "", $data);
    return $data;
}
?>