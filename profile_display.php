 <?php 

//print_r($row); 

//exit();
?>



<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
           

       
       <br>

      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Profile Info</h3>
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
                  <table class="table table-user-information">
                    <tbody>
                      
    <table>
        <tr>
            <td>First Name</td>
        <td><?php echo($row['FIRST_NAME']); ?></td></tr>
        <tr>
           <tr>
               <td>Last Name</td>
        <td><?php echo($row['LAST_NAME']); ?></td></tr>
        <tr>
            <td>Address</td>
            <td><?php echo($row['ADRESS']); ?></td>
        </tr>
    <tr>
            <td>City</td>
            <td><?php echo($row['CITY']); ?></td>
        </tr>
	<tr>
            <td>State</td>
            <td><?php echo($row['STATE']); ?></td>
        </tr>
	<tr>
            <td>Zipcode</td>
            <td><?php echo($row['ZIP_CODE']); ?></td>
        </tr>
        <tr>
            <td>Home Phone Number</td>
             <td><?php echo($row['PHONEH']); ?></td>
        </tr>
        <tr>
            <td>Mobile #1</td>
             <td><?php echo($row['PHONEM1']); ?></td>
        </tr>
        <tr>
            <td>Mobile #2</td>
             <td><? echo($row['PHONEM2']); ?></td>
        </tr>

        <tr>
        <td>Email</td>
        <td><?php echo($row['EMAIL']); ?></td>
        </tr>
        
        <tr>
            <td>Bio</td>
             <td><?php echo($row['BIO']); ?>
            <input type="hidden" name="send" value="1"></td>
        </tr>
        
    </table>
   
                      </tr>
                     
                    </tbody>
                  </table>
                  
                  
                  <a href="http://behelpful.byethost7.com/profile.php?action=edit" class="btn btn-primary">Edit</a>
                <a href="<?php echo($row['DOCPATH']); ?>" target="_blank" class="btn btn-primary">My Resume</a>
                  
                </div>
              </div>
            </div>
                 
            
          </div>
        </div>
      </div>
    </div>

   