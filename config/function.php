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


function AltTextAnalyzer($ImageList,$AltTextList) {
    $search_map = array('["','"]');
    $replace_map = array('','');
    $cleaned_Images_List = str_replace($search_map,$replace_map,$ImageList);
    $cleaned_Images_Array = explode('", "',$cleaned_Images_List);
    //var_dump($cleaned_Images_Array);
    $cleaned_AltText_List = str_replace($search_map,$replace_map,$AltTextList);
    $cleaned_AltText_Array = explode('", "',$cleaned_AltText_List);
    //var_dump($cleaned_AltText_Array);
  
  
    $counter = 0;
    $resultset = "";
    foreach($cleaned_AltText_Array as $key=>$item){
  
      if($item == "Alt missing") {
  
        $resultset .= "<p>".$cleaned_Images_Array[$key]."</p>";
        $counter++;
  
      }
  
    }
    return [
            "items"=>$resultset,
            "counter"=>$counter
          ];
  }
