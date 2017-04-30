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
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
                    
                <li >
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

        <div id="page-wrapper2">
<div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="sign">Address Change/Set</h1>
                        </div>
                    </div>
                </div>
                <div class='main log'>
                    
 
                <br>
            </div>
            <?php   
        if(isset($_POST['address']))
        {
            $a1=$_POST['address'];
            $c1=$_POST['city'];
            $s1=$_POST['state'];
            $z1=$_POST['zipcode'];
            $ph1=$_POST['phoneh'];
            $pf1=$_POST['phonef'];
            $w1=$_POST['website'];
            $b1=$_POST['bio'];
            $gov=$_SESSION['GOVID'];
            queryMysql("UPDATE ORGANIZATION SET ADRESS='$a1', PHONEH='$ph1', PHONEF='$pf1', DESCRIPTION='$b1', WEBSITE='$w1', CITY='$c1', STATE='$s1', ZIP_CODE='$z1' WHERE GOVERNMENTID='$gov'");
            echo "<h2>Address has been changed</h2>";
            
        }
        


            $gov=$_SESSION['GOVID'];
            $result = queryMySQL("SELECT * FROM ORGANIZATION WHERE GOVERNMENTID='$gov'");
            $row=$result->fetch_assoc();
            if($row['ADRESS']==="NO"||$row['PHONEH']==="NO"||$row['PHONEF']==="NO"||$row['DESCRIPTION']==="NO"||$row['WEBSITE']==="NO"||$row['CITY']==="NO"||$row['STATE']==="NO"||$row['ZIP_CODE']==="NO")
            {
                $addres=$city=$state=$zip=$phoneh=$phonef=$web=$bio="";
                
                
            }
            else
            {
                $addres=$row['ADRESS'];
                $city=$row['CITY'];
                $state=$row['STATE'];
                $zip=$row['ZIP_CODE'];
                $phoneh=$row['PHONEH'];
                $phonef=$row['PHONEF'];
                $web=$row['WEBSITE'];
                $bio=$row['DESCRIPTION'];
            }
        

        
?>
            <form method='POST' action='o_adress.php' class="form-signin"> 
                        <span>Address</span>
                       <input type='text' maxlength='30' id='addres' name='address'   value='<?php echo "$addres"; ?>' required autofocus/><span id='info'></span>
                        <br>
                        <span class='fieldname'>City</span>
                        <input type='text' maxlength='30' id='city' name='city' value='<?php echo "$city"; ?>' required />
                        <br>
                        <span class='fieldname'>State</span>
                        <input type='text' id="rpa" maxlength='32' id='state' name='state' value='<?php echo "$state"; ?>'  required /><br>
                        <span class='fieldname'>Zip-Code</span>
                        <input type='text' id="rpa" maxlength='32' id='zipcode' name='zipcode' value='<?php echo "$zip"; ?>'  required /><br>
                <span>Phone</span>
                       <input type='text' maxlength='30' id='phoneh' name='phoneh'   value='<?php echo "$phoneh"; ?>' required autofocus/><span id='info'></span>
                        <br>
                <span>Fax</span>
                       <input type='text' maxlength='30' id='phonef' name='phonef'   value='<?php echo "$phonef"; ?>' required autofocus/><span id='info'></span>
                        <br>
                <span>Website</span>
                       <input type='text' maxlength='30' id='web' name='website'   value='<?php echo "$web"; ?>' required autofocus/><span id='info'></span>
                        <br>
                <span>Organzation Bio</span>
                       <textarea rows='4' cols='23'type='text' maxlength='30' id='bio' name='bio'   value='' required autofocus/><?php echo "$bio"; ?></textarea><span id='info'></span>
                        <br>
                        <span class='fieldname'>&nbsp;</span>
                        <input type='submit' value='Submit'>
                    </form>
           
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

     