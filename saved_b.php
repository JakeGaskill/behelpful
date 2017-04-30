<?php
require_once 'functions.php';

  if (isset($_POST['user']))
  {
      
    $posid= $_POST['user'];
    $user=$_POST['userid'];
    $time=$_SERVER['REQUEST_TIME'];
      
    $r1 = queryMysql("SELECT * FROM SAVED WHERE USER='$user' AND POSID='$posid'");
      if($r1->num_rows)
      {
          $r=queryMysql("DELETE FROM SAVED WHERE USER='$user' AND POSID='$posid'");
          echo "Position has been unsaved";
      }
      else
      {
    $result = queryMysql("INSERT INTO SAVED VALUES('$user','$posid','$time')");

    
      echo "Position has been saved";
      }
  }
   
?>