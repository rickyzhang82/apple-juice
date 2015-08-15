<?php
// File processing 
/*
 * Given root path and filter, return multi-dimension array that store files and sub-directories
 */
function getFilteredFiles($relative_path, $file_extension='mp4') 
{
   $relative_path = rtrim($relative_path, '\\/');
   $result = array();
    
   foreach (scandir($relative_path) as $f) 
   {
      if ($f !== '.' and $f !== '..') 
      {
         if (is_dir("$relative_path/$f")) 
         {
               $result = array_merge($result, array("$relative_path/$f" => getFilteredFiles("$relative_path/$f", $file_extension)));
         }
         else 
         {
            if (strcasecmp($file_extension, substr($f,-3)) == 0)
               $result[] = "$relative_path/$f";
         }
      }
   }

   return $result;
}

function generateHTMLTableFromFileSystem($relative_path, $www_root,$file_extension='mp4')
{
   $relative_path = rtrim($relative_path, '\\/');

   echo "<table>\n";

   echo "<tr><th valign=\"top\"><img src=\"/icons/blank.gif\" alt=\"[ICO]\"></th><th> Name </th> <tr>\n";
   
   //Show link to parent directory
   echo "<tr>\n";
   echo "<td valign=\"top\"><img src=\"/icons/back.gif\" alt=\"[PARENTDIR]\"></td>\n";
   echo "<td> <a href='index.html?relative_path=".dirname($relative_path)."'>Parent Directory</A> </td>\n";
   echo "</tr>\n";

   echo "<tr><th colspan=\"5\"><hr></th></tr>\n";

   if (is_dir("$www_root/$relative_path"))
   {
      foreach (scandir("$www_root/$relative_path") as $f) 
      {
         if ($f !== '.' and $f !== '..') 
         {
            if (is_dir("$www_root/$relative_path/$f")) 
            {
               //Show link to another directory
               echo "<tr>\n";
               echo "<td valign=\"top\"><img src=\"/icons/folder.gif\" alt=\"[DIR]\"></td>\n";
               echo "<td> <a href='index.html?relative_path="."$relative_path/$f"."'>$f</A> </td>\n";
               echo "</tr>\n";
            }
            else 
            {
               if (strcasecmp($file_extension, substr($f,-3)) == 0){

                  //show player
                  echo "<tr>\n";
                  echo "<td valign=\"top\"><img src=\"/movie/folder.gif\" alt=\"[DIR]\"></td>\n";
                  echo "<td> <a href='player.html?file="."$relative_path/$f"."'>$f</A> </td>\n";
                  echo "</tr>\n";
               }
            }
         }
      }
   }
   
   echo "<tr><th colspan=\"5\"><hr></th></tr>\n";
   
   echo "</table>\n";

}
?>
