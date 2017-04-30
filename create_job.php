<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
  require_once 'functions.php';
    
if($_SESSION['TYPE']!=="WORKER")
   { 
    header("Location: index.php");
    exit();
   }
    else if($_SESSION['TYPE']==="WORKER")
    {
        $loggedin=true;
    }
  else if (isset($_SESSION['USERNAME']))
  {
    header("Location: user.php");
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
                    <li  >
                        <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-desktop"></i> Profile</a>
                    </li>
                    
                <li class="active">
                        <a href='create_job.php'><i class='fa fa-fw fa-pencil-square-o'></i> Create Jobs</a>
                    </li>
                    <li >
                        <a href='volunteers_jobs.php'><i class='fa fa-fw fa-briefcase'></i> Volunteer Overview</a>
                    </li> <li >
                        <a href='application_overview.php'><i class='fa fa-fw fa-file'></i> Application Overview</a>
                    </li>   
                
                    <li>
                        <a href="calender.php"><i class="fa fa-fw fa-table"></i> Calender</a>
                    </li>
                    
                    
                    
                   
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper5">
<div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="sign">Job Creator</h1>
                        </div>
                    </div>
                </div>
                <div class='main log'>
                    
 <?php   

if($_SESSION['STATE']==="NO")
{
    $error = "Organization bio must be filled out before creating jobs<br><br>";
}
if (isset($_POST['jobname']))
{
    if(isset($_POST['jobdesc'])&&isset($_POST['num']))
    {
        $a=trim($_POST['jobname']);
        $b=trim($_POST['jobdesc']);
        $c=trim($_POST['num']);
        if($a==""||$b==""||$c=="")
        {
            $error = "Not all fields were entered<br><br>";
            $unfield="";
            goto enda;
        }
        random:
        $randid=rand(10000,getrandmax());
        $result = queryMysql("SELECT * FROM FULLVIEW WHERE POSID='$randid'");
        if($result->num_rows)
        {
            goto random;
        }
        $jobn=$_POST['jobname'];
        $jobdesc=$_POST['jobdesc'];
        $numa=$_POST['num'];
        $time=$_SERVER['REQUEST_TIME'];
        $namef=$_SESSION['ORG'];  
        $govidf=$_SESSION['GOVID'];
        $cityf=$_SESSION['CITY'];
        $statef=$_SESSION['STATE'];
        queryMysql("INSERT INTO FULLVIEW VALUES('$namef','$randid','$jobn','$govidf','$jobdesc','$numa','$numa','$time','$cityf','$statef')");
        queryMysql("INSERT INTO RECENTLYADDED VALUES('$namef','$randid','$time')");
        queryMysql("INSERT INTO SEARCHVIEW VALUES('$namef','$randid','$jobn','$jobdesc','$time','$cityf','$statef')");
        
        $error = "Job has been created<br><br>";
            $unfield="";
    }
    else
    {
        $error = "Not all fields were entered<br><br>";
            $unfield="";
        
    }
}
enda:
echo $error;
  
            if($_SESSION['STATE']!=="NO")
            {
                echo "<form method='POST' action='create_job.php' class='form-signin'> 
                        <span>Job Name</span>
                       <input type='text' id='us'  onBlur='checkUser(this.value)' maxlength='30' name='jobname'   placeholder=" . $unfield. " required autofocus/><span id='info'></span>
                        <br>
                        <span>Job description</span>
                       <textarea rows='4' cols='23' type='text' id='us'  name='jobdesc'   placeholder=" . $unfield. " required autofocus/></textarea><span id='info'></span>
                        <br>
                        <span>Number of Volunteers needed</span>
                       <input type='text' id='us'  onBlur='checkUser(this.value)' maxlength='30' name='num'   placeholder=" . $unfield. " required autofocus/><span id='info'></span>
                        <br>
                        <input type='submit' value='Create'>
                    </form>";
            }
                ?>
                <br>
            </div>
           
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

     