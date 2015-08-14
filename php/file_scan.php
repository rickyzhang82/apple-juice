<?php
// File processing 
/*
 * Given root path and filter, return multi-dimension array that store files and sub-directories
 */
function getFilteredFiles($root_dir, $file_extension='mp4') 
{
   $root_dir = rtrim($root_dir, '\\/');
   $result = array();
    
   foreach (scandir($root_dir) as $f) 
   {
      if ($f !== '.' and $f !== '..') 
      {
         if (is_dir("$root_dir/$f")) 
         {
               $result = array_merge($result, array("$root_dir/$f" => getFilteredFiles("$root_dir/$f", $file_extension)));
         }
         else 
         {
            if (strcasecmp($file_extension, substr($f,-3)) == 0)
               $result[] = "$root_dir/$f";
         }
      }
   }

   return $result;
}

function generateHTMLTableFromFileSystem($root_dir, $file_extension='mp4')
{
   $root_dir = rtrim($root_dir, '\\/');

   echo "<table>\n";

   echo "<tr> <th> Name </th> <tr>\n";
   
   //Show link to parent directory
   echo "<tr>\n";
   echo "<td> <a href='index.html?root_dir=".dirname($root_dir)."'>Parent Directory</A> </td>\n";
   echo "</tr>\n";
 
   if (is_dir($root_dir))
   {
      foreach (scandir($root_dir) as $f) 
      {
         if ($f !== '.' and $f !== '..') 
         {
            if (is_dir("$root_dir/$f")) 
            {
               //Show link to another directory
               echo "<tr>\n";
               echo "<td> <a href='index.html?root_dir="."$root_dir/$f"."'>$f</A> </td>\n";
               echo "</tr>\n";
            }
            else 
            {
               if (strcasecmp($file_extension, substr($f,-3)) == 0){

                  //show player
                  echo "<tr>\n";
                  echo "<td> <a href='player.html?file="."$root_dir/$f"."'>$f</A> </td>\n";
                  echo "</tr>\n";
               }
            }
         }
      }
   }
   
   echo "</table>\n";

}
?>
