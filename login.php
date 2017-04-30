<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
<?php 
  require_once 'functions.php';
    
if($_SESSION['TYPE']==="ADMIN")
   { 
    header("Location: admin.php");
    exit();
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

    <div id="wrapper">

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
                    <a href="login.php"><i class="fa fa-user"></i>                   Sign In</a>
                    
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            
            <!-- /.navbar-collapse -->
        </nav>

        

            
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="sign">Log In</h1>
                        </div>
                    </div>
                </div>
                <div class='main log'>
                    <h3>Please enter your details to log in</h3>
<?php 
  
  $error = $userid = $password = "";

  if (isset($_POST['userid']))
  {
    $userid = sanitizeStrings($_POST['userid']);
    $pw = sanitizeStrings($_POST['password']);
    $userid = trim($userid);
    $pw = trim($pw);
    
    
    if ($userid == "" || $pw== "")
        $error = "\tNot all fields were entered\n\t<br>\n\t<br>";
    else
    {
        $userid=strtoupper ($userid);
        $salt1="qm&h*";
        $salt2="pg!@";
        $password= hash('ripemd128',"$salt1$pw$salt2");
        $result = queryMySQL("SELECT USERNAME,PASSWORD,TYPE FROM USERS
        WHERE USERNAME='$userid' AND PASSWORD='$password'");

      if ($result->num_rows == 0)
      {
        $error = "\t<span class='error'>Username/Password invalid</span>
        <br>
        <br>";
          $userid = $password = "";
      }
      else
      {
        $row = $result->fetch_assoc();
        $_SESSION['USERNAME'] = $userid;
        $_SESSION['PASSWORD'] = $password;
        $_SESSION['TYPE']=$row['TYPE'];
        header("Location: index.php"); 
        exit();
        
      }
    }
  }
echo "$error";
?>
                    <form method='post' action='login.php' class="form-signin">
                        <span class='fieldname'>Username</span>
                        <input type='text' maxlength='32' name='userid' value='<?php echo "$userid"; ?>' required autofocus /><br>
                        <span class='fieldname'>Password</span>
                        <input type='password' maxlength='32' name='password' value='<?php echo "$password"; ?>' required  />
                        <br>
                        <span class='fieldname'>&nbsp;</span>
                        <input type='submit' value='Login'>
                    </form>
                    Dont have an account? Sign up <a href="signup.php">here</a>.
                    <div> Workers login <a href="o_login.php">here</a>.  </div>    </div>
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
