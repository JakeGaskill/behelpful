<?php
require_once 'functions.php';

  if (isset($_POST['user']))
  {
      
    $posid= $_POST['user'];
    $user=$_POST['userid'];
    $time=$_SERVER['REQUEST_TIME'];
      
    $r1 = queryMysql("SELECT * FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");
      if($r1->num_rows)
      {
          
          echo "YOU HAVE ALREADY APPLIED";
      }
      else
      {
          $ra=queryMysql("SELECT * FROM DECLINE WHERE POSID='$posid'AND USER='$user'");
          $rd=queryMysql("SELECT * FROM APPROVED WHERE POSID='$posid'AND USER='$user'");
          $rq=queryMysql("SELECT * FROM INTERVIEW WHERE POSID='$posid'AND USER='$user'");
          $rc=queryMysql("SELECT * FROM VOLUNTEER WHERE POSID='$posid'AND USER='$user'");
          if($ra->num_rows||$rd->num_rows||$rc->num_rows||$rq->num_rows)
          {
              if($ra->num_rows)
              {
                  echo "Application cannot be sent because you have previously been declined";
              }
              else if($rd->num_rows)
              {
                  echo "Application cannot be sent because you have been already approved";
              }
              else if($rc->num_rows)
              {
                  echo "Application cannot be sent because you are already enrolled in the job";
              }
              else if($rq->num_rows)
              {
                  echo "Application cannot be sent because you are have an interview for this job";
              }
          }
          else
          {
            $r3=queryMysql("SELECT ORGANIZATION, GOVERNMENTID FROM FULLVIEW WHERE POSID='$posid'");
            $row3=$r3->fetch_assoc();    
            $org=$row3['ORGANIZATION'];
            $gov=$row3['GOVERNMENTID'];
            $result = queryMysql("INSERT INTO INPROGRESS VALUES('$org','$posid', '$gov' ,'$time','$user')");


          echo "Application has been sent";
          }
      }
  }
   
?>