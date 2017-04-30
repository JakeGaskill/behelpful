<?php echo("is it worling");?>
<form method='POST' action='' class="form-signin"> 
      <span class='fieldname'>New Password:</span>
      <input type='password' id="pa" maxlength='30'onkeyup="spaceb()" name='password' value='<?php echo "$password"; ?>' placeholder='<?php echo "$passreqs"; ?>' required />
      <br>
      <span class='fieldname'>Re-type New Password:</span>
        <input type='password' id="rpa" maxlength='32' onkeyup="spacec()" name='repass' value='<?php echo "$repass"; ?>' placeholder='<?php echo "$passreqs"; ?>' required /><br>
        <span class='fieldname'>&nbsp;</span>
        <input type='submit' value='Sign up'>
        </form>
<?php
function PassChange()
{
$error = $userid =$repass =$password = "";
$password= $_POST['password'];
$repass=$_POST['repass'];
    if($repass == $password)
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
            else
            {
                $salt1="qm&h*";
                $salt2="pg!@";
                
                $password= hash('ripemd128',"$salt1$repass$salt2");
                $per="USER";
                queryMysql("UPDATE USERS PASSWORD SET PASSWORD ='$password'");
                echo "<h4>PassWord Changed</h4>\nPlease Log in.\n<br>\n<br>";
                $error = $userid =$repass =$password = "";
                
            }
        }
        else
        {
            $userid = $repass =$password = "";
           $error = "Passwords does not match\n<br>\n<br>";
        }
            
    }
  }
}

>?