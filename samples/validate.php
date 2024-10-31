<?php

// Includes
include_once("./include/padfile.php");
include_once("./include/padvalidator.php");

// Read input
$URL = @$_POST["ValidateURL"];
if ( $URL == "" ) $URL = "http://";

// Print the form
?>
<form method='POST' action='<?php echo $_SERVER["PHP_SELF"]; ?>#validate'>
  PAD URL:
  <input type='text' name='ValidateURL' size='60' value='<?php echo $URL; ?>'>
  <input type='submit' value='Validate!'>
</form>
<p>
<?php

// Create PAD file object
$PAD = new PADFile($URL);

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

  // Output
  echo "<h4>Validation Report for <i>" . $PAD->URL . "</i></h4>\n";

  // Create validator
  $PADValidator = new PADValidator("./include/pad_spec.xml");
  if ( !$PADValidator->Load() )
    echo "Error loading Validator.";
  else
  {
    // Validate
    $nErrors = $PADValidator->Validate($PAD);
    if ( $nErrors == 0 )
      // No errors
      echo "<b><font color='green'>No Errors</font></b>";
    else
    {
      // Print validation errors
      echo "<b><font color='red'>" . $nErrors . " Errors</font></b>";
      foreach($PADValidator->ValidationErrors as $err)
      {
        echo "<p><b><font color='red'>Error:</font></b><br>";
        $err->Dump();
        echo "<br>&nbsp;</p>";
      }
    }
  }
}

?>