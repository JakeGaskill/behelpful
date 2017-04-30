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

        
                       <!-- signup title-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="sign">Sign Up</h1>
                        </div>
                    </div>
                </div>
                <div class='main log'>
                    <h3>Please enter your details to sign up</h3>
 <?php   

  $error = $userid =$repass =$password = "";
    $unfield="Max 30 character";
    $passreqs = "8 - 30 characters";
  if (isset($_SESSION['USERNAME'])) destroySession();

  if (isset($_POST['userid']))
  {
    $userid = sanitizeStrings($_POST['userid']);
    $password = sanitizeStrings($_POST['password']);
    $repass = sanitizeStrings($_POST['repass']);
    $organization = sanitizeStrings($_POST['orgname']);
    $counter=0;
    
    for($i=0; $i<strlen($organization); $i++) 
    {
        if($organization[$i]===' '&&$counter===0)
        {
            $organization[$i]='_';
            $counter=1;
        }
        else if($organization[$i]!==' ')
        {
            $counter=0;
        }
    
    }
    $governmentid =sanitizeStrings($_POST['govid']);
    $workerid=sanitizeStrings($_POST['workid']);
    $userid = trim($userid);
    $password = trim($password);
    $repass = trim($repass);
    $organization=trim($organization);
    $workerid=trim($workerid);
    $governmentid=trim($governmentid);
      
      
    $return=$userid;
    if ($userid == "" || $password == "" || $repass=="")
    {
      $error = "Not all fields were entered<br><br>";
        $userid = $repass =$password = "";
    }
    else
    {
        $userid=strtoupper ($userid);
        $uipwcheck=strtoupper ($password);
        $result = queryMysql("SELECT * FROM ORGANIZATION_WORKER WHERE USERNAME='$userid' OR WORKER_ID='$workerid'");

        if ($result->num_rows) 
        {
            $error = "That username or worker id already exists<br><br>";
            $userid = $repass =$password = "";
        }
        else if($repass == $password)
        {
            
            if(strlen($password)< 8)
            {
                $error = "The length of the password you input does not satisfy minimum requirements<br><br>";
                $userid = $repass =$password = "";
            }
            else if(strlen($password)> 30)
            {
                $error = "The length of the password you entered surpass the password range <br><br>";
                $userid = $repass =$password = "";
            }
            else if( $userid == $uipwcheck)
            {
                $error = "DO NOT USE USERNAME AS YOUR PASSWORD, please enter a different password<br><br>";
                $userid = $repass =$password = "";
            }
            else
            {
                
               $r1= queryMysql("SELECT * FROM ORGANIZATION WHERE GOVERNMENTID='$governmentid'");
                if($r1->num_rows)
                {
                    $salt1="qm&h*";
                $salt2="pg!@";
                
                $password= hash('ripemd128',"$salt1$repass$salt2");
                $per="USER";
                queryMysql("INSERT INTO ORGANIZATION_WORKER  VALUES('$userid', '$workerid', '$password','$governmentid','WORKER')");
                    echo "<h4>Account created</h4>\nPlease Log in.\n<br>\n<br>";
                $error = $userid =$repass =$password = "";
                    
                }
                else
                {
                $salt1="qm&h*";
                $salt2="pg!@";
                
                $password= hash('ripemd128',"$salt1$repass$salt2");
                $per="USER";
                queryMysql("INSERT INTO ORGANIZATION_WORKER  VALUES('$userid', '$workerid', '$password','$governmentid','WORKER')");
                
                $no="NO";
                queryMysql("INSERT INTO ORGANIZATION  VALUES('$organization', '$no','$no','$no','$no','$no','$no','$governmentid','$no','$no','$no')");
                echo "<h4>Account created</h4>\nPlease Log in.\n<br>\n<br>";
                $error = $userid =$repass =$password = "";
                }
                
            }
        }
        else
        {
            $userid = $repass =$password = "";
           $error = "Passwords does not match\n<br>\n<br>";
        }
            
    }
  }
echo "$error" ;
?>
                    <form method='POST' action='o_signup.php' class="form-signin"> 
                        <span>Username:</span>
                       <input type='text' id="us"  onBlur='checkUser(this.value)' maxlength='30' name='userid'   placeholder='<?php echo "$unfield"; ?>' required autofocus/><span id='info'></span>
                        <br>
                        <span>ORGANIZATION NAME:</span>
                       <input type='text' id="us"  onBlur='checkUser(this.value)' maxlength='30' name='orgname'   placeholder='<?php echo "$unfield"; ?>' required autofocus/><span id='info'></span>
                        <br>
                        <span>Goverment ID:</span>
                       <input type='text' id="us"  onBlur='checkUser(this.value)' maxlength='30' name='govid'   placeholder='<?php echo "$unfield"; ?>' required autofocus/><span id='info'></span>
                        <br>
                        <span>Worker ID:</span>
                       <input type='text' id="us"  onBlur='checkUser(this.value)' maxlength='30' name='workid'   placeholder='<?php echo "$unfield"; ?>' required autofocus/><span id='info'></span>
                        <br>
                        <span class='fieldname'>Password:</span>
                        <input type='password' id="pa" maxlength='30' name='password' value='<?php echo "$password"; ?>' placeholder='<?php echo "$passreqs"; ?>' required />
                        <br>
                        <span class='fieldname'>Re-type Password:</span>
                        <input type='password' id="rpa" maxlength='32'  name='repass' value='<?php echo "$repass"; ?>' placeholder='<?php echo "$passreqs"; ?>' required /><br>
                        <span class='fieldname'>&nbsp;</span>
                        <input type='submit' value='Sign up'>
                    </form>
                
                <br>
            </div>
<script src="js/jquery.js"></script>
<script src="js/functions.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
  </body>
</html>
