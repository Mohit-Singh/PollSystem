<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Polling System</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="View/css/style.css" type="text/css" media="screen, projection, tv" />
<link rel="stylesheet" href="View/css/style-print.css" type="text/css" media="print" />

<style>

</style>
<script src="View/jquery1/jquery.erasing-1.3.4.js"></script>
<script src="View/jquery1/jquery.js"></script>

<script src="View/jquery1/jquery.erasing-1.3.pack.js"></script>
<script src="View/jquery1/jquery.fancybox-1.3.4.pack.js"></script>

<script src="View/jquery1/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" href="View/jquery1/jquery.fancybox-1.3.4.css" type="text/css" media="screen">


<script>
$(document).ready(function(){

	
	$("#divCreateNewPoll").hide();
	
	$("#login").fancybox({
        // 'width'            : screenW/2,
        // 'height'        : screenH-210,
        // 'autoScale'        : false,
        // 'transitionIn'        : 'none',
        // 'transitionOut'        : 'none',
        // 'type'            : 'iframe'
     });

	$("#register").fancybox({
        // 'width'            : screenW/2,
        // 'height'        : screenH-210,
        // 'autoScale'        : false,
        // 'transitionIn'        : 'none',
        // 'transitionOut'        : 'none',
        // 'type'            : 'iframe'
     });
    $("#signIn").click(function(){
        $.ajax({
                url : './index.php?controller=mainController&method=login',
                type : 'post',
                data : "userName="+$("#userName").val()+"&password="+$("#password").val(),                
                success : function(data){
                	$("#column-left").hide(); 
                    $("#column-right").html(data);
                }
        });
        $.fancybox.close();
    });    
});

function openCreateNewPoll()
{
$("#divCreateNewPoll").toggle();

}
var rowIndex=2;
function addMoreOptions()
{
	rowIndex++;
    var row = "<tr id='row_"+rowIndex+"'><td><label>Option</label></td><td><input type=text /></td><td><button onclick='removeRow("+rowIndex+");'>X</button></td></tr>";	
    
	$("#addMoreOptionsTable").append(row);

	
	
}
function removeRow(rowIndex){
	
    $('#row_'+rowIndex).remove();
}
</script>

</head>
<body>
<div id="wrapper">
  
  <hr class="noscreen" />
  <div class="content">
    <div id = "column-left" class="column-left">
      <h3>LOGIN/REGISTER</h3>
          
       <p><a id="register" href="#registerDiv">REGISTER</a></p>
       <p><a id="login" href="#loginDiv">LOGIN</a></p>

<div class="hidden">
    <div id="loginDiv">
    <h2>LOGIN</h2>
    <label>USERNAME:</label>
        <input type="text" id = "userName" name = "userName"/></br>
        <label>PASSWORD:</label>
        <input type="text" id = "password" name = "password"/></br>
        <input type="button" id = "signIn" name="signIn" value="LOGIN"/>
    </div>
</div>
      
<div class="hidden">
    <div id="registerDiv">
    <h2>REGISTER</h2>
    <table>
    <tr>
    <td>
        <label>FIRSTNAME:</label></td>
        <td>
        <input type="text"/></br>
       </td>
        </tr>
        <tr>
        <td>
        <label>LASTNAME:</label>
        </td>
        <td>
        <input type="text"/></br>
        </td>
        </tr>
        <tr>
        <td>
        <label>PASSWORD:</label>
        </td>
        <td>
        <input type="text"/></br>
        </td>
        </tr>
        <tr>
        <td>
        <label>EMAIL:</label></td><td>
        <input type="text"/></br></td>
        </tr>
        <tr>
        <td>
        <input type="button" name="register" value="REGISTER"/></td></tr>
        </table>
    </div>
</div>  
      
      
      
    </div>
    
    <div id = "column-right"  class="column-right">
      <div class="box">
        </div>
      </div>
      
    </div>
    <div class="cleaner">&nbsp;</div>
  </div>
</div>
<div align=center>OSSCUBE<a href='http://www.osscube.com'>  OSSCUBE.COM</a></div></body>
</html>