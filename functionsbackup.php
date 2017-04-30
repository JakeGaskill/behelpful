<?php
    $teamURL = dirname($_SERVER['PHP_SELF']) . DIRECTORY_SEPARATOR;
    $server_root = dirname($_SERVER['PHP_SELF']);

  $dbhost  = 'sql313.byethost7.com';    // Unlikely to require changing
  $dbname  = 'b7_18458171_USERS';   // Modify these...
  $dbuser  = 'b7_18458171';   // ...variables according
  $dbpass  = 'qwerty123qwerty123';   // ...to your installation
  $appname = 'Be Helpful'; // ...and preference

 $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);


  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
  function destroySession()
  {
    $_SESSION=array();

   if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');
      
    session_destroy();
  }



    function ago($time)
    {
       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths = array("60","60","24","7","4.35","12","10");

       $now = time();

           $difference     = $now - $time;
           $tense         = "ago";

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       if($difference != 1) {
           $periods[$j].= "s";
       }

       return "$difference $periods[$j] ago ";
    }


  function sanitizeStrings($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }

   function sanitizeString($_connection, $str)
   {
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_connection, $str);
   }


    function SavePostToDB($_connection, $_user, $_title, $_text, $_time, $_file_name, $_filter)
{
	
	if (!($stmt = $_connection->prepare("INSERT INTO WALL(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, IMAGE_FILTER) VALUES (?, ?, ?, ?, ?, '$_filter')")))
	{
		echo "Prepare failed: (" . $_connection->errno . ") " . $_connection->error;
	}

	
	if (!$stmt->bind_param('sssss', $_user, $_title, $_text, $_time, $_file_name))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}

   function getPostcards($_connection)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, IMAGE_FILTER FROM WALL ORDER BY TIME_STAMP DESC";
    if(!$result = $_connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    while($row = $result->fetch_assoc())
    {
        
        $lcount=0;
        $result3 = queryMysql("SELECT IMAGE FROM LIKES");
         while($rowl = $result3->fetch_assoc())
        {
             if($rowl['IMAGE']===$row['TIME_STAMP'])
             {
                 $lcount=$lcount+1;
             }
         }
        $postedago = ago($row['TIME_STAMP']);
       
         $u=$_SESSION['userid'];
        $i=$row['TIME_STAMP'];
        $output = $output . '<div class = "well"><div class = "row"><div class="col-lg-12 title">' . $row['STATUS_TITLE'] . '</div></div><div class = "row content"><div class="col-lg-12 yellow"><div class = "row"><div class="col-lg-6 pic"><img class="img-responsive feed" src="' . $server_root . 'users/' . $row['IMAGE_NAME'] . '" alt="" style="filter:' . $row['IMAGE_FILTER'] . '; -webkit-filter:' . $row['IMAGE_FILTER'] . ';"></div><div class="col-lg-6 b"><br><div class="texts">'. $row['STATUS_TEXT'] . '</div></div></div><div class = "row landn"><div class="col-lg-6 lpost"><button type="submit" id="b'.$row['TIME_STAMP'] .'"  class="';
        
        
        $result4 = queryMysql("SELECT * FROM LIKES WHERE USER='$u' AND IMAGE='$i' ");

    if ($result4->num_rows)
    {
      $output = $output.'liked';
    }
    else
    {
      $output = $output.'like';
    }
        
        
    $output=$output.'" onclick="likes(\''.$_SESSION['userid'].'\',\''.$row['TIME_STAMP']. '\')" >';
     $result5 = queryMysql("SELECT * FROM LIKES WHERE USER='$u' AND IMAGE='$i' ");

    if ($result5->num_rows)
    {
      $output = $output.'liked';
    }
    else
    {
      $output = $output.'like';
    }       
    $output=$output.'</button> &nbsp; <span id="l'.$row['TIME_STAMP'] .'">'.$lcount.'</span> likes</div> <div class="col-lg-6 npost"><div class="names">posted by <span class="ulname">' . $row['USER_USERNAME'] . '</span> ~' . $postedago . '</div></div>  </div></div></div></div>';

    }  
    return $output;
}
  
function getUsers($_connection)
{
     $query = "SELECT userid,Permission FROM USERS ORDER BY userid";
    if(!$result = $_connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    while($row = $result->fetch_assoc())
    {
        $per=$row['Permission'];
        if($per!=="ADMIN")
        {
            $str=trim($row['userid']," ");
            $out=$out.'<div class="row qw" id="'.$str.'"><div class="col-xs-12 col-md-8 line">'.$str.
                '</div><div class="col-xs-12 col-md-4"><button type="submit" value="'.$str.'" onclick="deleteuser(this)">delete</button></div></div>';
        }
    }
    echo $out;
}

function draw_calendar($month,$year,$events = array()){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;height:100px;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			
			$event_day = $year.'-'.$month.'-'.$list_day;
            
			if(isset($events[$event_day])) {
				foreach(array_chunk($events[$event_day], 4, true) as $event) {
					$calendar.= '<div class="event">' . $event['POSID'] . '</div>';
				}
			}
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8 && $days_in_this_week > 1):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
        
	   $calendar.= '</tr>';
	endif;

	
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

function recent($connection)
{
    
    
    $query = "SELECT ORGANIZATION, POSID, TIMESTAMP FROM RECENTLYADDED ORDER BY TIMESTAMP DESC";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a href="view.php?viewid=' . $row['POSID'] . '">' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'].'-'.$rowl['STATE'] . '<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM RECENTLYADDED WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}

function volunteer($connection)
{
  $out="";
    $govidd=$_SESSION['GOVID'];
    $query = "SELECT POSID, JOB_NAME, TIME_STAMP, NEED, AVAILABLE FROM FULLVIEW WHERE GOVERNMENTID='$govidd' ORDER BY TIME_STAMP ASC";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    while($row = $result->fetch_assoc())
    {
        $taken=$row['NEED'] - $row['AVAILABLE'];
        $posid=$row['POSID'];
        $out = $out . '<div class="topper"><h4>' . $row['JOB_NAME'] . '<span class="rightr">' . $taken . '/' .$row['NEED'] . '</span></h4></div>'; 
        
        $r2 = queryMysql("SELECT USER FROM VOLUNTEER WHERE POSID='$posid'");
        while($row2=$r2->fetch_assoc())
        {
            $out = $out . "<div class='topper'>". $row2['USER']."</div>";
        }
    }
        
    return $out;
}
function search_click()
{
    
}
function fullview($connection,$viewid)
{
    $out="";
    $query = "SELECT ORGANIZATION, POSID, JOB_NAME, GOVERNMENTID, FULL_DESCRIPTION, TIME_STAMP, CITY, STATE, AVAILABLE FROM FULLVIEW WHERE POSID='$viewid'";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    
    
    $us=$_SESSION['USERNAME'];
    $time = $_SERVER['REQUEST_TIME'];
    $re=queryMysql("SELECT * FROM HISTORY WHERE USER='$us' AND POSID='$viewid'");
    if($re->num_rows)
    {
        queryMysql("UPDATE HISTORY SET TIME_STAMP='$time' WHERE USER='$us' AND POSID='$viewid'");
    }
    else
    {
        queryMysql("INSERT INTO HISTORY VALUES('$us','$viewid','$time')");
    }
    $row = $result->fetch_assoc();
    $govid=$row['GOVERNMENTID'];
    $r2 = queryMysql("SELECT ADRESS, PHONEH, PHONEF, LOGO, DESCRIPTION, WEBSITE, CITY, STATE, ZIP_CODE FROM ORGANIZATION WHERE GOVERNMENTID='$govid'");
    
    $row2=$r2->fetch_assoc();
    $out=$out. "<div class='row'><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 col-sm-offset-0  toppad' ><div class='panel panel-info'><div class='panel-heading'><h3 class='panel-title'>Volunteering</h3>
            </div>
            <div class='panel-body'>
              <div class='row'>
                <div class='col-md-3 col-lg-3 ' align='center'> <img alt='User Pic' src='".$server_root . "img/" ;
    if($row2['LOGO']==="NO")
    {
        $out=$out. "logo_default.png";
    }
    else
    {
    }
    $t=(int)$row['TIME_STAMP'];
    $date=date("m-d-Y",$t);
    
    $out=$out."'class='img-circle img-responsive'> </div><div class=' col-md-9 col-lg-9 '><table class='table table-user-information'><tbody><tr><td>Job Position:</td><td>" . $row['JOB_NAME'] . "</td></tr><tr><td>Job Description</td><td>" . $row['FULL_DESCRIPTION'] . "</td></tr><tr><td>Position opened:</td><td>" . $date ."</td></tr><tr><td>Address</td><td>" . $row2['ADRESS']  . "</td></tr><tr><td>City</td><td>" . $row2['CITY'] . "</td></tr><tr><td>State</td><td>" . $row2['STATE'] . "</td></tr><tr><td>Zip code</td><td>" . $row2['ZIP_CODE'] . "</td></tr><tr><td>Positions Available</td><td>" . $row['AVAILABLE'] . "</td></tr><tr><td>Website</td><td>" . $row2['WEBSITE'] . "</td></tr><tr><td>Organization</td><td>" . $row['ORGANIZATION'] . "</td></tr><tr><td>Organization Bio</td><td>" . $row2['DESCRIPTION'] . "</td></tr><tr><td>Phone</td><td>" . $row2['PHONEH'] . "</td></tr><tr><tr><td>Fax</td><td>" . $row2['PHONEF'] . "</td></tr></tbody></table><button type='submit' id='save_button' value='" . $row['POSID'] . "' onclick=\"Save(this,'" . $us . "')\" class='btn btn-primary";
    
    $r1 = queryMysql("SELECT * FROM SAVED WHERE USER='$us' AND POSID='$viewid'");
    if($r1->num_rows)
    {
        $out=$out." saved'>Saved</button>";
    }
    else
    {
        $out=$out." save'>Save</button>";
    }
    $out=$out."<button type='submit' value='" . $row['POSID'] . "' onclick=\"Apply(this,'" . $us . "')\"  class='btn btn-primary'>Apply</button>"; 
    return $out;
}

function saved($connection)
{
    
    $us=$_SESSION['USERNAME'];
    $query = "SELECT USER, POSID, TIMESTAMP  FROM SAVED WHERE USER='$us' ORDER BY TIMESTAMP DESC";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a href="view.php?viewid=' . $row['POSID'] . '">' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'].'-'.$rowl['STATE'] . '<div>' . $rowl['JOB_DESCRIPTION'] . '</div> Added to list ' . ago($row['TIMESTAMP']) . '</div>';
       
        
        
    }
    return $output;
}


//JAKE'S PART
function interview($connection)
{
    
    
    $query = "SELECT ORGANIZATION, POSID, TIMESTAMP FROM INTERVIEW ORDER BY TIMESTAMP DESC";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a>' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'] .'-'. $rowl['STATE'] .'<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM INTERVIEW WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}

function inprogress($connection)
{
    
    
    $query = "SELECT ORGANIZATION, POSID, GOVERNMENTID, TIMESTAMP FROM INPROGRESS";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a>' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'] .'-'. $rowl['STATE'] .'<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM INPROGRESS WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}

function approved($connection)
{
    
    
    $query = "SELECT ORGANIZATION, POSID, TIMESTAMP FROM APPROVED";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a>' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'] .'-'. $rowl['STATE'] .'<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM APPROVED WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}

function decline($connection)
{
    
    
    $query = "SELECT ORGANIZATION, POSID, TIMESTAMP FROM DECLINE";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a>' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'] .'-'. $rowl['STATE'] .'<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM DECLINE WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}

function currentlyenrolled($connection)
{
    
    
    $query = "SELECT USER, POSID, GOVERNMENTID FROM VOLUNTEER";
    if(!$result = $connection->query($query))
    {die('There was an error running the query [' . $_connection->error . ']');}
    $output = '';
    $time = $_SERVER['REQUEST_TIME'];
    while($row = $result->fetch_assoc())
    {
        $posid=$row['POSID'];
        if($time-$row['TIMESTAMP']<(60*60*24*7))
        {
            

            $result4 = queryMysql("SELECT ORGANIZATION, POSID, JOB_NAME, JOB_DESCRIPTION, TIME_STAMP, CITY, STATE FROM SEARCHVIEW WHERE POSID='$posid'");
            $rowl = $result4->fetch_assoc();
            $output = $output . '<div class="topper"><a>' . $rowl['JOB_NAME'] . ' </a>- ' . $rowl['CITY'] .'-'. $rowl['STATE'] .'<div>' . $rowl['JOB_DESCRIPTION'] . '</div>' . ago($row['TIMESTAMP']) . '</div>';
        }
        else
        {
            
            $result2 = queryMysql("DELETE FROM VOLUNTEER WHERE POSID='$posid'");
        }
        
        
    }
    return $output;
}
/* THIS IS ANTHONY STUFF DO NOT ALTER*/



function create_profile(){

 $USER=$_SESSION['USERNAME'];
 $FIRST_NAME=$_POST['FIRST_NAME'];
 $LAST_NAME=$_POST['LAST_NAME'];
 $ADRESS=$_POST['ADRESS'];
 $PHONEH=$_POST['PHONEH'];
 $PHONEM1=$_POST['PHONEM1'];
 $PHONEM2=$_POST['PHONEM2'];
 $BIO=$_POST['BIO'];
 $EMAIL=$_POST['EMAIL'];
 $CITY=$_POST['CITY'];
 $STATE=$_POST['STATE'];
 $ZIP_CODE=$_POST['ZIP_CODE'];

    
if($_SESSION['TYPE']==="WORKER")
{
    $sql = "INSERT INTO WORKER_PROFILE(USER, FIRST_NAME, LAST_NAME, ADRESS, PHONEH, PHONEM1, PHONEM2, BIO,EMAIL, CITY, STATE, ZIP_CODE) VALUES('$USER','$FIRST_NAME','$LAST_NAME','$ADRESS','$PHONEH','$PHONEM1','$PHONEM2','$BIO','$EMAIL', '$CITY', '$STATE',' $ZIP_CODE')";

//$sql = "INSERT INTO PROFILE (USER) VALUES('"$USER"')";

queryMysql($sql);
}
else
{
$sql = "INSERT INTO PROFILE(USER, FIRST_NAME, LAST_NAME, ADRESS, PHONEH, PHONEM1, PHONEM2, BIO,EMAIL, CITY, STATE, ZIP_CODE) VALUES('$USER','$FIRST_NAME','$LAST_NAME','$ADRESS','$PHONEH','$PHONEM1','$PHONEM2','$BIO','$EMAIL', '$CITY', '$STATE',' $ZIP_CODE')";

//$sql = "INSERT INTO PROFILE (USER) VALUES('"$USER"')";

queryMysql($sql);
    }
  
}

function edit_profile(){
     $USER=$_SESSION['USERNAME'];
    if (!isset($_POST['send']))
    {
        if($_SESSION['TYPE']==="WORKER")
        {
            $sql="SELECT * FROM  WORKER_PROFILE WHERE USER =  '$USER'";
            // $row = queryMysql($sql);
            $result = queryMysql($sql);
            $row  = $result->fetch_assoc();
            // Array ( [USER] => LUIS123 [FIRST_NAME] => Anthony [LAST_NAME] => Reyes [ADRESS] => 1750 N 17th court apt.204 [PHONEH] => 9548297525 [PHONEM1] => 9548297525 [PHONEM2] => 9548297525 [BIO] => dick [EMAIL] => st.luis1@yahoo.com )
            // print_r($row);
            //exit();
            include('profile_info.php');
        }
        else{
        $sql="SELECT * FROM  PROFILE WHERE USER =  '$USER'";
        // $row = queryMysql($sql);
        $result = queryMysql($sql);
        $row  = $result->fetch_assoc();
        // Array ( [USER] => LUIS123 [FIRST_NAME] => Anthony [LAST_NAME] => Reyes [ADRESS] => 1750 N 17th court apt.204 [PHONEH] => 9548297525 [PHONEM1] => 9548297525 [PHONEM2] => 9548297525 [BIO] => dick [EMAIL] => st.luis1@yahoo.com )
        // print_r($row);
        //exit();
        include('profile_info.php');
        }

    }
    elseif(isset($_POST['send']))
    {
 //$USER=$_SESSION['USERNAME'];
 $FIRST_NAME=$_POST['FIRST_NAME'];
 $LAST_NAME=$_POST['LAST_NAME'];
 $ADRESS=$_POST['ADRESS'];
 $PHONEH=$_POST['PHONEH'];
 $PHONEM1=$_POST['PHONEM1'];
 $PHONEM2=$_POST['PHONEM2'];
 $BIO=$_POST['BIO'];
 $EMAIL=$_POST['EMAIL'];
 $CITY=$_POST['CITY'];
 $STATE=$_POST['STATE'];
 $ZIP_CODE=$_POST['ZIP_CODE'];
        
        if($_SESSION['TYPE']==="WORKER")
        {
        
        $sql="UPDATE WORKER_PROFILE SET  USER='$USER',FIRST_NAME='$FIRST_NAME',LAST_NAME= '$LAST_NAME',ADRESS='$ADRESS',PHONEH='$PHONEH', PHONEM1='$PHONEM1',PHONEM2=' $PHONEM2',BIO='$BIO', EMAIL='$EMAIL', CITY='$CITY', STATE='$STATE',ZIP_CODE='$ZIP_CODE' WHERE USER='$USER'";
        
        queryMysql($sql);
        echo "Thank you it has been updated";
            //UPDATE table_name SET column1=value1,column2=value2,...WHERE some_column=some_value;
        }
        else
        {
            $sql="UPDATE PROFILE SET  USER='$USER',FIRST_NAME='$FIRST_NAME',LAST_NAME= '$LAST_NAME',ADRESS='$ADRESS',PHONEH='$PHONEH', PHONEM1='$PHONEM1',PHONEM2=' $PHONEM2',BIO='$BIO', EMAIL='$EMAIL', CITY='$CITY', STATE='$STATE',ZIP_CODE='$ZIP_CODE' WHERE USER='$USER'";
        
        queryMysql($sql);
        echo "Thank you it has been updated";
            //UPDATE table_name SET column1=value1,column2=value2,...WHERE some_column=some_value;
        }
    }
    
    
}

function upload_pdf(){
 
 /*
 TARGET DIRECTORY
 */
  $target_dir = "resume/";

  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

/*
    FILE TYPE
*/
  $fileType = $_FILES["fileToUpload"]["type"];

  $uploadOk = 1;

  /*
   Check if file already exists
   */
  if (file_exists($target_file)){
   echo("Sorry, file already exists.");
   $uploadOk = 0;
  }

  /* 
  Check file size

  */

  if ($_FILES["fileToUpload"]["size"] > 500000){
   echo "Sorry, your file is too large.";
   $uploadOk = 0;
  }
  
  /* 
  Check if $uploadOk is set to 0 by an error
  */
  if ($uploadOk == 0){
     echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
 }else {

    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
    
         insertResumeInfo($target_file,$fileType);

         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
    }else {
        echo "Sorry, there was an error uploading your file.";
    }

 }

}


function insertResumeInfo($DOCPATH,$FILETYPE)
{
//echo("this is file path ".$DOCPATH . " this is filetype ".$FILETYPE);
//    return;
    $userid=$_SESSION['USERNAME'];
 $sql = "INSERT INTO RESUME (USER, TIMESTAMP, DOCPATH, FILETYPE) VALUES ('$userid',NOW(),'$DOCPATH','$FILETYPE')";
    
    queryMysql($sql);
    //global $connection;
    
 /* $userid=$_SESSION['USERNAME'];
  $sql = 'INSERT INTO RESUME (USER, TIMESTAMP, DOCPATH, FILETYPE) VALUES (?,NOW(),?,?)';
    

 $stmt= $connection->prepare($sql);

 $stmt->bind_parma('sss',$userid,$DOCPATH,$FILETYPE);

 //$fileinfo=$stmt->execute();
    $stmt->execute();
echo($stmt->error);
    
  echo('file');
    return;
    //echo($fileinfo);
    //return;
    
    if ($fileinfo==true)
    {
        return true;
    
        
    }
    else{ 
        return false;
    }
*/
}

function UserResults()
{
    $USER=$_SESSION['USERNAME'];
    if($_SESSION['TYPE']==="WORKER")
    {
        $sql="SELECT * FROM  WORKER_PROFILE WHERE USER ='$USER'";
        $results=queryMysql($sql);
       // print_r($results);
        //return;
        if($results->num_rows==1)
        {
         return true;   


        }
        return false;
    }
    else
    {
    
        $sql="SELECT * FROM  PROFILE WHERE USER ='$USER'";
        $results=queryMysql($sql);
       // print_r($results);
        //return;
        if($results->num_rows==1)
        {
         return true;   


        }
        return false;
    }
    
}
function showProfile()
{
    $USER=$_SESSION['USERNAME'];
    if($_SESSION['TYPE']==="WORKER")
    {
        $sql="SELECT * FROM  WORKER_PROFILE WHERE USER =  '$USER'";
        // $row = queryMysql($sql);
        $result = queryMysql($sql);
        $row  = $result->fetch_assoc();
        // Array ( [USER] => LUIS123 [FIRST_NAME] => Anthony [LAST_NAME] => Reyes [ADRESS] => 1750 N 17th court apt.204 [PHONEH] => 9548297525 [PHONEM1] => 9548297525 [PHONEM2] => 9548297525 [BIO] => dick [EMAIL] => st.luis1@yahoo.com )
        // print_r($row);
        //exit();
        include('profile_display.php');
    }
     else {
    $sql="SELECT PROFILE . * , RESUME.DOCPATH FROM PROFILE, RESUME WHERE PROFILE.USER = '$USER' AND RESUME.USER = '$USER'";
        // $row = queryMysql($sql);
        $result = queryMysql($sql);
        $row  = $result->fetch_assoc();
        // Array ( [USER] => LUIS123 [FIRST_NAME] => Anthony [LAST_NAME] => Reyes [ADRESS] => 1750 N 17th court apt.204 [PHONEH] => 9548297525 [PHONEM1] => 9548297525 [PHONEM2] => 9548297525 [BIO] => dick [EMAIL] => st.luis1@yahoo.com )
        // print_r($row);
        //exit();
        include('profile_display.php');
    }
    
    
}

function searchResults()
{
    $job=$_POST['job'];
    $location=$_POST['location'];
    if(!isset($job) || ($location))
       {
           include('searchform.php');
            
       }
    else
        {
        $html="";
        $sql="SELECT * FROM  `FULLVIEW` WHERE CITY LIKE '%$location%' OR JOB_NAME LIKE '%$job%'";
        $result=queryMysql($sql);
        while($row=$result->fetch_assoc())
        {
        
            $html.=$row['JOB_NAME'] ." ".$row['FULL_DESCRIPTION']." ".$row['CITY']."</br>";
            
        }
        return $html;
        }
        
}
    


?>
