<?php
require_once 'functions.php';

  if (isset($_POST['user']))
  {
      
    $posid= $_POST['user'];
    $user=$_POST['userid'];
    $month=$_POST['month'];
    $day=$_POST['day'];
    $year=$_POST['year'];
    $hour=$_POST['hour'];
    $min=$_POST['minu'];
    $paa=$_POST['paa'];
    $time=$_SERVER['REQUEST_TIME'];
      if($posid=="Select one"||$user=="Select one"||$month=="Select one"||$day=="Select one"||$year=="Select one"||$hour=="Select one"||$min=="Select one"||$paa=="Select one")
      {
          echo "3";
      }
      else
      {
          $r2 = queryMysql("SELECT * FROM INTERVIEW WHERE USER='$user' AND POSID='$posid'");
          if($r2->num_rows)
          {
              $result=queryMysql("SELECT * FROM FULLVIEW WHERE  POSID='$posid' ");
              $row=$result->fetch_assoc();
              $GOV=$row['GOVERNMENTID'];
              $ORG=$row['ORGANIZATION'];
            $r1 = queryMysql("SELECT * FROM CALENDER WHERE  USER='$user' AND YEAR='$year' AND MONTH='$month' AND DAY='$day'");
              if($r1->num_rows)
              {
                  $rowa=$r1->fetch_assoc();
                  $r2 = queryMysql("SELECT * FROM CALENDER WHERE  USER='$user' AND POSID='$posid' AND YEAR='$year' AND MONTH='$month' AND DAY='$day'");
                  
                  if($r2->num_rows)
                  {
                      $r3= queryMysql("SELECT * FROM CALENDER WHERE  USER='$user' AND POSID='$posid' AND YEAR='$year' AND MONTH='$month' AND DAY='$day' AND HOUR='$hour' AND MIN='$min' AND AM_PM='$paa'");
                      if($r3->num_rows)
                      {
                          echo "7";
                      }
                      else
                      {
                          $rowb=$r2->fetch_assoc();
                          $shour=$hour;
                          if($hour=="12"&&$paa="A.M.")
                          {
                              $hour=0;
                          }
                          else if($paa=="P.M.")
                          {
                              $hour=$hour+12;
                          }
                          $ts=mktime($hour,$min,0,$month,$day,$year);
                          if($rowb['TIMESTAMP']<$ts)
                          {
                          queryMysql("UPDATE CALENDER SET HOUR='$shour', MIN='$min', AM_PM='$paa', TIMESTAMP='$ts' WHERE  USER='$user' AND POSID='$posid' AND YEAR='$year' AND MONTH='$month' AND DAY='$day'");
                              queryMysql("UPDATE INTERVIEW SET TIMESTAMP='$ts' WHERE  USER='$user' AND POSID='$posid'");
                              
                              echo "6";
                          }
                          else
                          {
                              echo "5";
                          }
                      }
                      
                  }
                  else
                  {
                    echo "1"; 
                  }
              }
              else
              {

                  $r1 = queryMysql("SELECT * FROM CALENDER WHERE   YEAR='$year' AND MONTH='$month' AND DAY='$day' AND HOUR='$hour' AND MIN='$min' AND AM_PM='$paa' AND GOVERNMENTID='$GOV'");
                  if($r1->num_rows)
                  {
                      echo "2";
                  }
                  else
                  {
                      $r3= queryMysql("SELECT * FROM CALENDER WHERE  USER='$user' AND POSID='$posid'");
                      $rowab=$r3->fetch_assoc();
                      $shour=$hour;
                      if($hour=="12"&&$paa=="A.M.")
                      {
                          $hour=0;
                      }
                      else if($paa=="P.M.")
                      {
                          $hour=$hour+12;
                      }
                      $ts=mktime($hour,$min,0,$month,$day,$year);
                      if($rowab['TIMESTAMP']<$ts)
                      {
                      /*queryMysql("UPDATE CALENDER SET HOUR='$hour', MIN='$min', AM_PM='$paa', TIMESTAMP='$ts' WHERE  USER='$user' AND POSID='$posid' AND YEAR='$year' AND MONTH='$month' AND DAY='$day'");
                        queryMysql("INSERT INTO INTERVIEW VALUES('$ORG','$posid','$ts','$user')");  
                          queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");*/
                          queryMysql("UPDATE CALENDER SET HOUR='$shour', MIN='$min', AM_PM='$paa', TIMESTAMP='$ts', YEAR='$year', MONTH='$month', DAY='$day' WHERE  USER='$user' AND POSID='$posid'");
                              queryMysql("UPDATE INTERVIEW SET TIMESTAMP='$ts' WHERE  USER='$user' AND POSID='$posid'");
                          queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");
                      echo "6";
                      }
                      else
                      {
                          echo "5";
                      }
                  }

              }
          }
          else
          {
            $result=queryMysql("SELECT * FROM FULLVIEW WHERE  POSID='$posid' ");
              $row=$result->fetch_assoc();
              $GOV=$row['GOVERNMENTID'];
              $ORG=$row['ORGANIZATION'];
            $r1 = queryMysql("SELECT * FROM CALENDER WHERE  USER='$user' AND YEAR='$year' AND MONTH='$month' AND DAY='$day'");
              if($r1->num_rows)
              {

                 echo "1"; 
              }
              else
              {

                  $r1 = queryMysql("SELECT * FROM CALENDER WHERE   YEAR='$year' AND MONTH='$month' AND DAY='$day' AND HOUR='$hour' AND MIN='$min' AND AM_PM='$paa' AND GOVERNMENTID='$GOV'");
                  if($r1->num_rows)
                  {
                      echo "2";
                  }
                  else
                  {
                      $shour=$hour;
                      if($hour=="12"&&$paa="A.M.")
                      {
                          $hour=0;
                      }
                      else if($paa=="P.M.")
                      {
                          $hour=$hour+12;
                      }
                      $ts=mktime($hour,$min,0,$month,$day,$year);
                      if($time+172800<$ts)
                      {
                      queryMysql("INSERT INTO CALENDER VALUES('$user','$posid','$ts','$year','$month','$day','$shour','$min','$paa','$GOV')");
                        queryMysql("INSERT INTO INTERVIEW VALUES('$ORG','$posid','$ts','$user')");  
                          queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid' AND USER='$user'");
                      echo "0";
                      }
                      else
                      {
                          echo "4";
                      }
                  }

              }
            }
      }
  }

//echo $month; //date('l jS \of F Y h:i:s A',mktime(15,$min,0,$month,$day,$year));
   
?>