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

/**
 * Get human file size
 */
function human_filesize($size,$unit="") {
   if( $size < 0 )
      return ">= 2GB";
   
   if( (!$unit && $size >= 1<<30) || $unit == "GB")
      return number_format($size/(1<<30),2)."GB";
   
   if( (!$unit && $size >= 1<<20) || $unit == "MB")
      return number_format($size/(1<<20),2)."MB";
   
   if( (!$unit && $size >= 1<<10) || $unit == "KB")
      return number_format($size/(1<<10),2)."KB";
   
   return number_format($size)." bytes";
}
/**
 * Generate HTML table given path
 */
function generateHTMLTableFromFileSystem($relative_path, $www_root,$file_extension='mp4')
{
   $relative_path = rtrim($relative_path, '\\/');

   echo "<table>\n";

   echo "<tr><th valign=\"top\"><img src=\"/icons/blank.gif\" alt=\"[ICO]\"></th><th> Name </th><th> Size <th> <tr>\n";
   
   //Show link to parent directory
   echo "<tr>\n";
   echo "<td valign=\"top\"><img src=\"/icons/back.gif\" alt=\"[PARENTDIR]\"></td>";
   echo "<td> <a href='index.html?relative_path=".dirname($relative_path)."'>Parent Directory</A> </td>\n";
   echo "<td align=\"right\">  - </td>\n";
   echo "</tr>\n";

   echo "<tr><th colspan=\"5\"><hr></th></tr>\n";

   if (is_dir("$www_root/$relative_path"))
   {
      foreach (scandir("$www_root/$relative_path") as $f) 
      {
         if ($f !== '.' and $f !== '..' and $f !== '.AppleDouble') 
         {
            if (is_dir("$www_root/$relative_path/$f")) 
            {
               //Show link to another directory
               echo "<tr>\n";
               echo "<td valign=\"top\"><img src=\"/icons/folder.gif\" alt=\"[DIR]\"></td>\n";
               echo "<td> <a href='index.html?relative_path="."$relative_path/$f"."'>$f</A> </td>\n";
               echo "<td align=\"right\">  - </td>\n";
               echo "</tr>\n";
            }
            else 
            {
               if (strcasecmp($file_extension, substr($f,-3)) == 0){

                  //show player
                  echo "<tr>\n";
                  echo "<td valign=\"top\"><img src=\"/icons/movie.gif\" alt=\"[movie]\"></td>\n";
                  echo "<td> <a href='player.html?file="."$relative_path/$f"."'>$f</A> </td>\n";
                  echo "<td align=\"right\">".human_filesize(filesize("$www_root/$relative_path/$f"))."</td>\n";
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
