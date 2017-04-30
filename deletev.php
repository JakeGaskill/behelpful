<?php
require_once 'functions.php';

  if (isset($_POST['user']))
  {
      
    $posid= $_POST['user'];
    $user=$_POST['userid'];
    $time=$_SERVER['REQUEST_TIME'];
      
    $r1 = queryMysql("SELECT * FROM VOLUNTEER WHERE USER='$user' AND POSID='$posid'");
      if($r1->num_rows)
      {
          $r=queryMysql("DELETE FROM VOLUNTEER WHERE USER='$user' AND POSID='$posid'");
          echo "Volunteer has been deleted";
      }
      else
      {
    

    
      echo "User not found";
      }
  }
   
?>