 <?php 

//print_r($row); 

//exit();
?>
<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
          
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Enter Info</h3>
            </div>
            <div class="panel-body">
              <div class="row">
               
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                
                <form id="form1" method="post" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
            <td>First Name</td>
        <td><input type="text" id="Fname" name="FIRST_NAME" value="<?php if(isset($_GET['action'])){ echo($row['FIRST_NAME']); } ?>"></td></tr>
        <tr>
           <tr>
               <td>Last Name</td>
        <td><input type="text" id="Lname" name="LAST_NAME" value="<?php if(isset($_GET['action'])){ echo($row['LAST_NAME']); } ?>"></td></tr>
        <tr>
            <td>Address</td>
            <td><input type="text" id="addressid" name="ADRESS" value="<?php if(isset($_GET['action'])){ echo($row['ADRESS']); } ?>"></td>
        </tr>
    <tr>
            <td>City</td>
            <td><input type="text" id="city" name="CITY" value="<?php if(isset($_GET['action'])){ echo($row['CITY']); } ?>"></td>
        </tr>
	<tr>
            <td>State</td>
            <td><input type="text" id="state" name="STATE" value="<?php if(isset($_GET['action'])){ echo($row['STATE']); } ?>"></td>
        </tr>
	<tr>
            <td>Zipcode</td>
            <td><input type="text" id="zipcode" name="ZIP_CODE" value="<?php if(isset($_GET['action'])){ echo($row['ZIP_CODE']); } ?>"></td>
        </tr>
        <tr>
            <td>Home Phone Number</td>
             <td><input type="text" id="homephone" name="PHONEH" value="<?php if(isset($_GET['action'])){ echo($row['PHONEH']); } ?>"></td>
        </tr>
        <tr>
            <td>Mobile #1</td>
             <td><input type="text" id="mobilep1" name="PHONEM1" value="<?php if(isset($_GET['action'])){ echo($row['PHONEM1']); } ?>"></td>
        </tr>
        <tr>
            <td>Mobile #2</td>
             <td><input type="text" id="mobilep2" name="PHONEM2" value="<?php if(isset($_GET['action'])){ echo($row['PHONEM2']); } ?>"></td>
        </tr>

        <tr>
        <td>Email</td>
        <td><input type="text" id="Email" name="EMAIL" value="<?php if(isset($_GET['action'])){ echo($row['EMAIL']); } ?>"></td>
        </tr>
        
        <tr>
            <td>Bio</td>
             <td><input type="text" id="biography" name="BIO" value="<?php if(isset($_GET['action'])){ echo($row['BIO']); } ?>">
            <input type="hidden" name="send" value="1"></td>
        </tr>
                     
                    </tbody>
                  </table>
                  
                   <button href="#" class="btn btn-primary" type="submit" value="Submit" name="Submit"><?php if($_GET['action']=="edit"){?>Save Changes<?php }else{?>Submit<?php }?></button>
</form>
                  
                 
                </div>
              </div>
            </div>
                 
            
          </div>
        </div>
      </div>
    </div>