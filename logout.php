<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
  
  require_once 'functions.php';

  if (isset($_SESSION['USERNAME']))
  {
      destroySession();
  }
header("Location: index.php");  
exit();

?>
