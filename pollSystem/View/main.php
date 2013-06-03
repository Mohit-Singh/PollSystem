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
});

function openCreateNewPoll()
{
$("#divCreateNewPoll").toggle();

}
var optionCount=2;
function addMoreOptions()
{
	optionCount++;
	$("#addMoreOptions").append("<label>Option"+optionCount+"</label><br>");
	$("#addMoreOptions").append("<input type='text' name='option"+optionCount+"'><br><br>");

	
	
}
</script>

</head>
<body>
<div id="wrapper">
  
  <hr class="noscreen" />
  <div class="content">
    <div class="column-left">
      <h3>MENU</h3>
      
    
    
    <p><a id="register" href="#registerDiv">REGISTER</a></p>
    <p><a id="login" href="#loginDiv">LOGIN</a></p>

<div class="hidden">
    <div id="loginDiv">
    <h2>LOGIN</h2>
    <label>USERNAME:</label>
        <input type="text"/></br>
        <label>PASSWORD:</label>
        <input type="text"/></br>
        <input type="button" name="signIn" value="LOGIN"/>
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
        <input type="text" name="firstName"/></br>
       </td>
        </tr>
        <tr>
        <td>
        <label>LASTNAME:</label>
        </td>
        <td>
        <input type="text"name="lastName"/></br>
        </td>
        </tr>
        <tr>
        <td>
        <label>PASSWORD:</label>
        </td>
        <td>
        <input type="text" name="password"/></br>
        </td>
        </tr>
        <tr>
        <td>
        <label>EMAIL:</label></td><td>
        <input type="text" name="email"/></br></td>
        </tr>
        <tr>
        <td>
        <input type="button" name="register" value="REGISTER" onclick="register()"/></td></tr>
        </table>
    </div>
</div>  
      
      
      
    </div>
    <div id="skip-menu"></div>
    <div class="column-right">
      <div class="box">
        <div class="box-top"></div>
        <div class="box-in">
          <h2>Welcome to Polling System</h2>
         <div id="divMainPageContainer">

<div id="divMainPageCenter">
<input type="button" name="createNewPoll" value="createNewPoll" onclick="openCreateNewPoll();">
<div id="divCreateNewPoll">

<label>CREATE POLL</label></br>
<textarea rows="1" cols="50"></textarea>
<div id="options">
<label>Option 1</label></br>
<input type="text"></br>
<label>Option 2</label></br>
<input type="text"></br>
<div id="addMoreOptions">

</div>
<input type="button" name="addMoreOptions" value="addMoreOptions" onclick="addMoreOptions();">

</div>

</div>
</div>
</div>
        </div>
      </div>
      <div class="box-bottom">
        <hr class="noscreen" />
        <div class="footer-info-left"><a href=""></a></div>
        <div class="footer-info-right"><a href=""></a></div>
      </div>
    </div>
    <div class="cleaner">&nbsp;</div>
  </div>
</div>
<div align=center>OSSCUBE<a href='http://www.osscube.com>OSSCUBE.COM'></a></div></body>
<head>
<script type="text/javascript">
function register() {
	$.post('index.php',
			{
		'controller':'MainController',
		'method':'registerUser'
			},function(data,status){
					if(status == "success") {
						if
						
					}
				});
}
</script>
</head>
</html>