$('#apps1').hide();
$('#inter1').hide();
$('.settimerinter').hide();
function appshow()
{
   
    if($('#apps').hasClass("dropup"))
       {
        $('#apps').removeClass("dropup").addClass("dropdown");
           $('#apps1').hide();
       }
    else if($('#apps').hasClass("dropdown"))
    {
        $('#apps').removeClass("dropdown").addClass("dropup");
        $('#apps1').show(); 
    }
}

function sub_inter(id,user)
{
    var u=id.value;
    var w=user;
    var ids="sec_"+u+user;
    var mo="month_"+u+"_"+user;
    var da="day_"+u+"_"+user;
    var ye="year_"+u+"_"+user;
    var hou="hour_"+u+"_"+user;
    var mine="min_"+u+"_"+user;
    var paa="pa_"+u+"_"+user;
    
    var month= document.getElementById(mo).value;
    var day = document.getElementById(da).value;
    var year = document.getElementById(ye).value;
    var hour = document.getElementById(hou).value;
    var minute= document.getElementById(mine).value;
    var pm_am= document.getElementById(paa).value;
    
    var mas="feedback_"+user;
    params  = "user=" + u +"&userid=" + w + "&month=" + month + "&day=" + day + "&year=" + year + "&hour=" + hour + "&minu=" + minute + "&paa=" + pm_am;
    
  request = new ajaxRequest();
    
  request.open("POST", "set_interview.php", true);
   
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
  request.setRequestHeader("Content-length", params.length);
    
  request.setRequestHeader("Connection", "close");
    
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
        {
            if(this.responseText==="0")
            {
              document.getElementById(mas).innerHTML="REQUEST SUCCESSFUL - PLEASE REFRESH PAGE";
                document.getElementById(ids).innerHTML="<h5>"+user+"'s interview set</h5>";
            }
            else if (this.responseText==="1")
            {
                document.getElementById(mas).innerHTML="<h5>must set interview for another day</h5>";
                
                
            }
            else if (this.responseText==="2")
            {
                document.getElementById(mas).innerHTML="<h5>must set interview for another time</h5>";
                
                
            }
            else if (this.responseText==="3")
            {
                document.getElementById(mas).innerHTML="<h5>INVALID ENTRY</h5>";
               
                
            }
            else if (this.responseText==="4")
            {
                document.getElementById(mas).innerHTML="<h5>interview date must be set 48 hour from today </h5>";
                
                
            }
            else if (this.responseText==="5")
            {
                document.getElementById(mas).innerHTML="<h5>interview date must be set a time or day after the intial interview submission</h5>";
                
                
            }
            else if (this.responseText==="6")
            {
                document.getElementById(mas).innerHTML="<h5>inter view updated - PLEASE REFRESH PAGE</h5>";
                document.getElementById(ids).innerHTML="<h5>"+user+"'s - interview rescheduled</h5>";
                
                
            }
            else if (this.responseText==="7")
            {
                document.getElementById(mas).innerHTML="<h5>You have set the interview for the same time and day</h5>";
                
                
            }
            
        }
  }
  request.send(params)
  
  
    
    
}

function daysset(id,user)
{
    var u = id;
    var w = user;
   var ids = "day_"+u+"_"+user;
    var m = "#month_"+u+"_"+user;
    var mp = "month_"+u+"_"+user;
    var ye = "year_"+u+"_"+user;
    var month = document.getElementById(mp).value;
    var year =document.getElementById(ye).value;
   // document.getElementById("feedback").innerHTML=month;
    if(month==1||month==3||month==5||month==7||month==8||month==10||month==12)
    {
       document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option>"; 
    }
    else if(month==4||month==6||month==9||month==11)
    {
        document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option>";
    }
    else if(month==2)
    {
        
        if(year%4==0)
        {
            if(year%100==0)
            {
                if(year%400==0)
                {
                   document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option><option>29</option>"; 
                }
                else
                {
                   document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option>"; 
                }
            }
            else
            {
                document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option><option>29</option>";
            }
        }
        else
        {
            document.getElementById(ids).innerHTML="<option selected disabled>Select one</option><option>1 </option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13 </option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option><option>25 </option><option>26</option><option>27</option><option>28</option>";
        }
    }
        
}

function intershow()
{
   
    if($('#inter').hasClass("dropup"))
       {
        $('#inter').removeClass("dropup").addClass("dropdown");
           $('#inter1').hide();
       }
    else if($('#inter').hasClass("dropdown"))
    {
        $('#inter').removeClass("dropdown").addClass("dropup");
        $('#inter1').show(); 
    }
}

function showtime(id,user)
{
    var u=id.value;
    var w=user;
   var ids="#set_"+u+"_"+user;
    $(ids).show(); 
    
}

function accept(id,user)
{
    var u=id.value;
    var w=user;
   var ids="sec_"+u+user;
    params  = "user=" + u +"&userid=" + w ;
    var mas="feedback_"+user;
  request = new ajaxRequest();
    
  request.open("POST", "set_approve.php", true);
   
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
  request.setRequestHeader("Content-length", params.length);
    
  request.setRequestHeader("Connection", "close");
    
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
         document.getElementById(mas).innerHTML=this.responseText+"- PLEASE REFRESH PAGE";
  }
  request.send(params)
  
  document.getElementById(ids).innerHTML="<h5>request successful-accepted</h5>";
}

 function decline(id,user)
{
    var u=id.value;
    var w=user;
   var ids="sec_"+u+user;
    params  = "user=" + u +"&userid=" + w ;
    var mas="feedback_"+user;
  request = new ajaxRequest();
    
  request.open("POST", "set_decline.php", true);
   
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
  request.setRequestHeader("Content-length", params.length);
    
  request.setRequestHeader("Connection", "close");
    
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
         document.getElementById(mas).innerHTML=this.responseText+"- PLEASE REFRESH PAGE";
  }
  request.send(params)
  
  document.getElementById(ids).innerHTML="<h5>request successful-declined</h5>";
}
 
function setinter(id,user)
{
    var u=id.value;
    var w=user;
   
    params  = "user=" + u +"&userid=" + w ;
    
  request = new ajaxRequest();
    
  request.open("POST", "inter_set.php", true);
   
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
  request.setRequestHeader("Content-length", params.length);
    
  request.setRequestHeader("Connection", "close");
    
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
        {
            var re="0";//this.responseText;
            if(re==="1"){
         document.getElementById("feedback").innerHTML="Interview has been set";
            }
            else
            {
                document.getElementById("feedback").innerHTML="Set another time or date";
            }
        }
  }
  request.send(params)
}
function Save(id,user)
{
    var u=id.value;
    var w=user;
   
    params  = "user=" + u +"&userid=" + w ;
    
  request = new ajaxRequest();
    
  request.open("POST", "saved_b.php", true);
   
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
  request.setRequestHeader("Content-length", params.length);
    
  request.setRequestHeader("Connection", "close");
    
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
         document.getElementById("feedback").innerHTML=this.responseText;
  }
  
  request.send(params)
    if($("#save_button").hasClass("save"))
  {
    $("#save_button").removeClass("save").addClass("saved");
      document.getElementById("save_button").innerHTML="Saved";
  }
else if ($("#save_button").hasClass("saved"))
 {
    $("#save_button").removeClass("saved").addClass("save");
    document.getElementById("save_button").innerHTML="Save";

 }
}

function Apply(id,user)
{
    var u=id.value;
    var w=user;
   
    params  = "user=" + u +"&userid=" + w ;
  request = new ajaxRequest();
  request.open("POST", "applying.php", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader("Content-length", params.length);
  request.setRequestHeader("Connection", "close");
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
         document.getElementById("feedback").innerHTML=this.responseText;
  }
  request.send(params)
  
    
}

function deletev(id,user)
{
    var u=id.value;
    var w=user;
    
   document.getElementById("feedback").innerHTML="hi";
    params  = "user=" + u +"&userid=" + w ;
  request = new ajaxRequest();
  request.open("POST", "deletev.php", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader("Content-length", params.length);
  request.setRequestHeader("Connection", "close");
  request.onreadystatechange = function()
  {
    if (this.readyState == 4)
      if (this.status == 200)
        if (this.responseText != null)
         document.getElementById("feedback").innerHTML=this.responseText;
  }
  request.send(params)
  document.getElementById(w).innerHTML="deleted";
    
}

function ajaxRequest()
{
  try { var request = new XMLHttpRequest() }
  catch(e1) {
    try { request = new ActiveXObject("Msxml2.XMLHTTP") }
    catch(e2) {
      try { request = new ActiveXObject("Microsoft.XMLHTTP") }
      catch(e3) {
        request = false
  } } }
  return request
}

