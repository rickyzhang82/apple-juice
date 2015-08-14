<?php
// File processing 
/*
 * Given root path and filter, return multi-dimension array that store files and sub-directories
 */
function ListIn($root_dir, $prefix = '') 
{
    $root_dir = rtrim($root_dir, '\\/');
    $result = array();
    
    foreach (scandir($root_dir) as $f) 
    {
        if ($f !== '.' and $f !== '..') 
        {
            if (is_dir("$root_dir/$f")) 
            {
                $result = array_merge($result, ListIn("$root_dir/$f", "$prefix$f/"));
            } 
            else 
            {
                $result[] = $prefix.$f;
            }
        }
    }
    
    return $result;
}

?>
