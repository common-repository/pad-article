<?php
                     
// Includes
include_once("./include/padfile.php");


// Read input
$URL = @$_POST["URL"];
if ( $URL == "" ) $URL = "http://";

// Create PAD file object
$PAD = new PADFile($URL);

?>
<form method='POST' action='<?php echo $_SERVER["PHP_SELF"]; ?>#prefill'>
  <table>
    <tr>
      <td>PAD URL:</td>
      <td>
        <input type='text' name='URL' size='60' value='<?php echo $PAD->URL; ?>'>
        <input type='submit' value='Prefill Form!'><br>
        &nbsp;<br>
<?php

  // If the form above has been posted, load the PAD file from the entered URL
  if ( $URL != "http://" )
  {
    echo "Loading <i>" . $PAD->URL . "</i> ... ";
    $PAD->Load();
    switch ( $PAD->LastError )
    {
      case ERR_NO_ERROR:
        echo "<font color='green'>OK</font>\n";
        break;
      case ERR_NO_URL_SPECIFIED:
        echo "<br><font color='red'>No URL specified.</font>";
        break;
      case ERR_READ_FROM_URL_FAILED:
        echo "<br><font color='red'>Cannot open URL.";
        if ($PADFile->LastErrorMsg != "")
          echo " (" . $PADFile->LastErrorMsg . ")";
        echo "</font>";
        break;
      case ERR_PARSE_ERROR:
        echo "<br><font color='red'>Parse Error: " . $PAD->ParseError . "</font>";
        break;
    }
  }

  // Now, we prefill every form field with the data from the PAD file - if available
  // For program descriptions, we will use the GetBestDescription() method that will
  // extract the description text from the PAD file that fits best to the given
  // length and language.

?>
      </td>
    </tr>
    <tr>
      <td>Program Name:</td>
      <td><input name='ProgramName' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name"); ?>'></td>
    </tr>
    <tr>
      <td>Program Version:</td>
      <td><input name='ProgramVersion' type='text' size='60'
                 value='<?php echo $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version"); ?>'></td>
    </tr>
    <tr>
      <td>Description:</td>
      <td><textarea name='ProgramDescription' cols='42'><?php echo $PAD->GetBestDescription(250, "English"); ?></textarea></td>
    </tr>
  </table>
</form>