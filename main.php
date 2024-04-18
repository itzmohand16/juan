<?php

include_once('db.php');

function responde($error, $data){
    if ($error){
        $response = ['status' => 'error', 'message' => $data];
        echo json_encode($response);
        die();
    }else{
        $response = ['status' => 'success', 'message' => $data];
        echo json_encode($response);
        die();
    }
}
function isArrayFirstItem($needle, $haystack) {
    return is_array($needle) && count($haystack) > 0 && $needle === $haystack[0];
}
function loader($string){
    // Explode the string into lines
    
    file_put_contents('./runer.txt', $string);
    $lines = explode("\n", $string);
    
    // Process each line
    foreach ($lines as &$line) {
        // Check if the line contains any of the specified tags
        if (!preg_match('/<image src=([^>]*)>|<title>|<\/title>|<headline>|<\/headline>|<bold>|<\/bold>/', $line)) {
            // Surround the line with the specified <p> tag
            $line = '<p class="text-xl mb-5 break-all text-white px-6 sm:px-8">' . $line . '</p>';
        }
    }
    
    // Join the lines back into a string
    $string = implode("\n", $lines);
    
    // Apply other replacements
    $string = preg_replace('/<image src=([^>]*)>/', '<img class="kg-image mb-5 medium-zoom-image" alt="" loading="lazy" width="2000" height="267" src="./uploads/$1">', $string); 
    $string = preg_replace('/<image small src=([^>]*)>/', '<img class="kg-image px-[10%] medium-zoom-image" alt="" loading="lazy" width="2000" height="267" src="./uploads/$1">', $string); 
    $string = str_replace("<title>", '<p class="font-semibold text-2xl mt-1 text-white
    break-all px-6 sm:px-8">', $string);
    $string = str_replace("</title>", "</p>", $string);
    $string = str_replace("<headline>", '<p class=" break-all  text-white font-bold   mb-2 text-2xl px-6 sm:px-8">', $string);
    $string = str_replace("</headline>", "</p>", $string);
    $string = str_replace("<bold>", "<p class='px-6 text-white sm:px-8 font-bold'>", $string);
    $string = str_replace("</bold>", "</p>", $string);
    $string = str_replace("<hr>", '<hr class="sm:mx-60 mx-10 sm:my-8 my-6">', $string);
    
    return $string;
}
function homeloader($string){
    // Explode the string into lines
    

    
    // Apply other replacements
    $string = preg_replace('/<image src=([^>]*)>/', '', $string); 
    $string = preg_replace('/<image small src=([^>]*)>/', '', $string); 
    $string = str_replace("<title>", '', $string);
    $string = str_replace("</title>", "", $string);
    $string = str_replace("<headline>", '', $string);
    $string = str_replace("</headline>", "", $string);
    $string = str_replace("<bold>", "", $string);
    $string = str_replace("</bold>", "", $string);
    
    return $string;
}
