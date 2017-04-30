$('#inter').hide();
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

