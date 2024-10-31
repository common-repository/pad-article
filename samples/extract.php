<?php

// Includes
include_once("./include/padfile.php");

// Create PAD file object for the local file "pad_file.xml"
// This could also be an absolute local path or an URL!
$PAD = new PADFile("./samples/pad_file.xml");

// Load file
if ( !$PAD->Load() )
  echo "Error: Cannot load PAD file.<br>\n";

// Sample Output
echo "<b>Program Name:</b> " . $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name") . "<br>\n";
echo "<b>Program Version:</b> " . $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version") . "<br>\n";

?>