<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
  require_once 'functions.php';
    
if ($_SESSION['TYPE']==="ADMIN")
{ 
header("Location: admin.php");
exit();
}
else if (!isset($_SESSION['USERNAME']))
{
header("Location: index.php");
exit();
}
  ?>
      
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Be Helpful</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper2">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="page-wrapper2" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Be Helpful</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['USERNAME'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        
                        <li>
                            <a href="setting.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li >
                        <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-desktop"></i> Profile</a>
                    </li>
    <?php
            if($_SESSION['TYPE']!=="WORKER"){
            echo "
                    <li>
                        <a href='resume.php'><i class='fa fa-fw fa-file'></i> Resume</a>
                    </li>
                    <li >
                        <a href='saved.php'><i class='fa fa-fw fa-bookmark'></i> Saved</a>
                    </li>
                    <li >
                        <a href='current_enrolled.php'><i class='fa fa-fw fa-briefcase'></i> Currently Enrolled</a>
                    </li>
                    <li>
                        <a href='javascript:;' data-toggle='collapse' data-target='#demo'><i class='fa fa-fw fa-pencil-square-o'></i> Applied <i class='fa fa-fw fa-caret-down'></i></a>
                        <ul id='demo' class='collapse'>
                            <li>
                                <a href='inprogress.php'><i class='fa fa-fw fa-bar-chart-o'></i>In Progress</a>
                            </li>
                            <li>
                                <a href='interview.php'><i class='fa fa-fw fa-tasks'></i>Interview</a>
                            </li>
                            <li>
                                <a href='approved.php'><i class='fa fa-fw fa-check'></i>Approved</a>
                            </li>
                            <li>
                                <a href='declined.php'><i class='fa fa-fw fa-times-circle'></i>Decline</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href='history.php'><i class='fa fa-fw fa-history'></i> History</a>
                    </li>";
            }
            else{
                echo "<li>
                        <a href='create_job.php'><i class='fa fa-fw fa-pencil-square-o'></i> Create Jobs</a>
                    </li>
                    <li >
                        <a href='volunteers_jobs.php'><i class='fa fa-fw fa-briefcase'></i> Volunteer Overview</a>
                    </li><li >
                        <a href='application_overview.php'><i class='fa fa-fw fa-file'></i> Application Overview</a>
                    </li>";
}
                        ?>
                    <li class= "active">
                        <a href="calender.php"><i class="fa fa-fw fa-table"></i> Calender</a>
                    </li>
                    
                    
                    <?php
if($_SESSION['TYPE']!=="WORKER"){
            echo "
                    <li>
                        <a href='recent_added.php'><i class='fa fa-fw fa-bolt'></i> Recently Added</a>
                    </li>
                    ";}
?>
                   
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<h1 id="title">Calendar</h1>
        <div  class="calender">

           <?php
            /* date settings */
$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

/* "previous month" control */
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt; 	Previous Month</a>';


/* bringing the controls together */
$controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.' </form>';
$iden=$_SESSION['USERNAME'];
/* get all events for the given month */
$events = array();
if($_SESSION['TYPE']==="WORKER")
{
    $go=$_SESSION['GOVID'];
    $query4 = queryMysql("SELECT POSID, YEAR, MONTH, DAY, HOUR, MIN, AM_PM FROM CALENDER  WHERE YEAR='$year' AND MONTH='$month' AND GOVERNMENTID='$go' ORDER BY TIMESTAMP");
}
else
{
    
$query4 = queryMysql("SELECT POSID, YEAR, MONTH, DAY, HOUR, MIN, AM_PM FROM CALENDER  WHERE YEAR='$year' AND MONTH='$month' AND USER='$iden' ORDER BY TIMESTAMP");
}

while($row  = $query4->fetch_assoc()) {
    $datefull=$row['YEAR']."-".$row['MONTH']."-".$row['DAY'];
	$events[$datefull] = $row;
    
}


echo '<h2 style="float:center; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
echo '<div style="float:center;padding-bottom:10px;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$events);
echo '<br /><br />';
            
            ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
