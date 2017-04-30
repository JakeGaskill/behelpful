<?php
require_once 'functions.php';

  if (isset($_POST['user']))
  {
      
    $posid= $_POST['user'];
    $user=$_POST['userid'];
    $time=$_SERVER['REQUEST_TIME'];
      
    $r1 = queryMysql("SELECT * FROM DECLINE WHERE USER='$user' AND POSID='$posid'");
      if($r1->num_rows)
      {
          
          echo "Volunteer has already been declined";
          queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");
          queryMysql("DELETE FROM INTERVIEW WHERE POSID='$posid' AND USER='$user'");
      }
      else
      {
          $r2 = queryMysql("SELECT * FROM INTERVIEW WHERE USER='$user' AND POSID='$posid'");
          if($r2->num_rows)
          {
          $r1 = queryMysql("SELECT * FROM FULLVIEW WHERE  POSID='$posid'");
          $row = $r1->fetch_assoc();
          $gov=$row['GOVERNMENTID'];
          $org=$row['ORGANIZATION'];
          queryMysql("INSERT INTO DECLINE VALUES('$org','$posid','$time','$user')");
          queryMysql("DELETE FROM INTERVIEW WHERE POSID='$posid' AND USER='$user'");
    
        echo "Volunteer has been declined";
          }
          else
          {
              
           $r1 = queryMysql("SELECT * FROM FULLVIEW WHERE  POSID='$posid'");
          $row = $r1->fetch_assoc();
          $gov=$row['GOVERNMENTID'];
          $org=$row['ORGANIZATION'];
          queryMysql("INSERT INTO DECLINE VALUES('$org','$posid','$time','$user')");
          queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");
    
        echo "Volunteer has been declined";
              
          }
      }
  }
   
?>