<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>polling</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="View/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./assets/js/fancybox/jquery.fancybox.css" type="text/css" media="screen"/>
<script src="./assets/js/jquery-1.9.1.min.js"></script>
<script src="./assets/js/jquery.tools.min.js"></script>

<script src="./assets/js/fancybox/jquery.fancybox.js"></script>
<script>
$(document).ready(function(){

<?php
if(isset($_SESSION["username"]))
{
?>
$username = "<?php echo $_SESSION["username"]; ?>";
$login = "yes";
<?php 
echo "$.post('index.php',{'loginStatus':'true'},function(data){ $('#column-left').hide(); $('#column-right').html(data); $('#logOut').show(); });";
}
else
{
?>
$username = "<?php echo ""; ?>";
$login = "no";
<?php 
echo "$('#logOut').hide();";
}

?>


loadAllPoll();
$("#divCreateNewPoll").hide();
$("#login").fancybox({
	afterLoad : function(){
	$("#userName").val('');
	$("#password").val('');
	return;
	}
});

$("#register").fancybox({

	afterLoad : function(){
		$("#firstName").val('');
		$("#lastName").val('');
		$("#email").val('');
		$("#registerPassword").val('');
		return;
		}
});



$("#firstName").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#registerClick").trigger("click");
	   }
	}); 
$("#lastName").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#registerClick").trigger("click");
	   }
	}); 
$("#email").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#registerClick").trigger("click");
	   }
	}); 
$("#registerPassword").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#registerClick").trigger("click");
	   }
	}); 
$("#userName").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#signIn").trigger("click");
	   }
	}); 
$("#password").keyup(function(ev) {
	   // 13 is ENTER
	   if (ev.which === 13 ) {
		   $("#signIn").trigger("click");
	   }
	}); 
$("#clickPollOpinion").fancybox({
	afterClose : function(){
		$("#pollOpinion").html("");
		return;
	}

});
$("#CreateNewPollClick").fancybox({
	 'width' : 500,
	 'height' : 200,	 
	 'autoSize' : false,
});	

$("#signIn").click(function(){

$.ajax({
url : './index.php?controller=mainController&method=login',
type : 'post',
data : "userName="+$("#userName").val()+"&password="+$("#password").val(),
success : function(data){
if(data.trim() != "Account Does not exist" && data.trim() != "Password does not match")
{
$("#divRight").hide();
$('#logOut').show();
$("#column-right").html("");
$("#createPoll").html(data);
$username = $("#userName").val();
$login = "yes";
loadAllPoll();
}
else
{
alert(data.trim());
}
}
});
$.fancybox.close();
});
});

function loadAllPoll()
{	$.ajaxSetup({async: false});
    $.post('index.php',{"controller":"mainController","method":"loadAllPoll"},function(data){    
    
    	var result = jQuery.parseJSON(data);
    	
    	var str = "<div id='tableDiv'><table id='pollTable'>";
    	str += "<tr id='tableHead'><td>Question</td>" + "<td>User Email Id</td>"
    			+ "<td>User Name</td>" + "<td>Comment Count</td>"
    			+ "<td>Votes Count</td><td>Vote Now</td>";
		if($login == "yes"){
			str += "<td>Delete Poll</td>";
		}
    	str += "</tr>";
        var count=0;
        $.each(result, function(key,val){
        	if (count % 2 == 0) {
        		str += "<tr id='odd'>";
        	} else {
        		str += "<tr id='even'>";
        	}
        	str += "<td>" + val['question'] + "</td>" + "<td>" + val['username'] + "</td>"
        			+ "<td>" + val['first_name'] + " " + val['last_name'] + "</td>"
        			+ "<td>" + val['comment'] + "</td>" + "<td>" + val['votes'] + "</td>"
        			+ "<td><input type='button' class='btn' value='View Details' onclick='voteNow(\""
        			+ val['id'] + "\")'>";
        	if($username == val['username'] && $login == "yes"){
        		str += "<td><input type='button' class='btn' value='Delete' onclick='DeletePoll(\""
        			+ val['id'] + "\")'></td>";
        	}
        	else{
            	if($login == "yes"){
            	    str += "<td>No</td>";
            	}
        	}
        	str += "</tr>";
        	count++;
        });
        str+="</table></div>";
        $("#column-right").append(str);
    });    
}

function voteNow(id){

	$.post('index.php',{"controller":"mainController","method":"pollLoad","queId":id},function(data){
		$("#hiddenElemtnt").html(data);

		document.getElementById('questionDiv').scrollIntoView();
		});

	
}

function openCreateNewPoll() {
	$("#divCreateNewPoll").toggle();

}
var rowIndex = 2;
function addMoreOptions() {
	rowIndex++;
	var row = "<tr id='row_" + rowIndex
			+ "'><td><label>Option</label></td><td><input name='opt" + rowIndex
			+ "' type=text /></td><td><button onclick='removeRow(" + rowIndex
			+ ");'>X</button></td></tr>";
	$("#addMoreOptionsTable").append(row);

}
function removeRow(rowIndex) {
	$('#row_' + rowIndex).remove();
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
} 

function checkEmail() {

    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    
    $('#email').val('');
 }
}

function register() {	
	checkEmail();
	if($('#email').val().trim() ==  "" )
		alert('Please provide a valid email address');
	if($('#email').val().trim() !=  ""  && $('#registerPassword').val().trim()  !=  "" 
		&& $('#firstName').val().trim() !=  "" && $('#lastName').val().trim() !=  "" ) {
		$.post('index.php', {
			'controller' : 'mainController',
			'method' : 'registerUser',
			'firstName' : htmlEntities( $('#firstName').val() ),
			'lastName' : htmlEntities( $('#lastName').val() ),
			'email' : htmlEntities( $('#email').val() ),
			'password' : htmlEntities( $('#registerPassword').val() ),
		}, function(data, status) {
			if (status == "success") {
				if (data.trim() == "true") {
					alert("you are successfully registered");
					parent.$.fancybox.close();
				} else {
					alert("same email id alredy registered");
					parent.$.fancybox.close();
				}
			}
		});
		}
	else
		{
		alert("* fields are mendatory");
	}
	
}

function DeletePoll($id){
	$status = confirm("you want to delete");
	if($status == true){
    	$.ajax({
    		url : './index.php?controller=mainController&method=delPoll',
    		type : 'post',
    		data : "QuestionId="+$id,
    		success : function(data) {			
    			$("#hiddenElemtnt").html("");
    			$("#pollTable").remove();
    			loadAllPoll();		
    			//location.reload();
    			// $("#column-right").load("./View/poll.php");
    			// loadAllPoll();
    		}
    	});
	}
}

function AddQuestion() {
	$.ajax({
		url : './index.php?controller=mainController&method=AddQuestion',
		type : 'post',
		data : $("#submitForm").serialize(),
		success : function(data) {
			alert("Succesfully saved");
			location.reload();
			// $("#column-right").load("./View/poll.php");
			// loadAllPoll();
		}
	});
}

function logOutUser() {
	$.ajax({
		url : './index.php?controller=mainController&method=userLogOut',
		type : 'post',
		success : function(data) {
			location.reload();
		}
	});
	$login = "no";
}

function viewPreviousPolls() {
	$.ajax({
		url : './index.php?controller=mainController&method=loadPreviousPoll',
		type : 'post',
		async : false,
		// data :
		// "userName="+$("#userName").val()+"&password="+$("#password").val(),
		success : function(data) {
			$("#box1").html('');
			$("#box1").append(data);
		}
	});

	$.ajax({
		url : './index.php?controller=mainController&method=viewPreviousPolls',
		type : 'post',
		// data :
		// "userName="+$("#userName").val()+"&password="+$("#password").val(),
		success : function(data) {
			$("#previousPollDiv").html('');
			$("#previousPollDiv").append(data);
		}
	});
}



</script>
<style>
#logOut {
	float: right;
	margin-right: 50px;
}
#pollTable
{
/*margin-left: 25px;*/
text-align: center;
color: #0A0A2A;
font-family: 'Tangerine', serif;
font-size: 12px;
	padding:3px;

}

#pollTable td {
	border: 1px solid black;
	height: 30px;
	
	width: auto;
	overflow: hidden;
/*     text-overflow: ellipsis;  */
/*     white-space: nowrap;  */
	font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size: 11px;
	word-wrap:break-word;
}

#pollTable #odd
{
background-color : ;
color:#0A0A2A;
}
#pollTable #even
{
background-color : #97C950;
color:#0A0A2A;
}
#pollTable #tableHead
{
	background-color: #323A3F;
	color:white; 
}

#pollTable #tableHead td
{
  font-size: 15px;
}

#header
{
  border:2px solid black;
} 


</style>

</head>
<body>
<div class="main">	
  <div class="header">
    <div class="header_resize">
      <div class="logo">
        <h1><a href="index.html"><span>Polling</span>System<br />
          <small>Welcome to the world of polling </small></a></h1>
      </div>
      <?php
if(!isset($_SESSION["username"]))
{
?>      
      <div id = "divRight" class="right">
<!--         <h2>Menu</h2> -->
        <ul>
          <li>
          <p><a id="register" href="#registerDiv"><blink>REGISTER</blink></a></p></li>
<li><p><a id="login" href="#loginDiv">| <blink>LOGIN</blink></a></p></li>
          
        </ul>
      </div>
<?php 
}
?>
      <div class="clr"></div>
      <div class="menu">
        <ul>
          <li><a href="index.php" class="active"><span>Home</span></a></li>
          <li><a href="#"><span>Services</span></a></li>
          <li><a href="#"><span>About Us</span></a></li>
          <li><a href="#"><span>Contact Us</span></a></li>
          <li><div id="logOut"><a href="#" onclick="logOutUser();">LogOut</a></div></li>
          
        </ul>
      </div>
      <div class="search">
        <form id="form1" name="form1" method="post" action="#">
          <label><span>
            <input name="q" type="text" class="keywords" id="textfield" maxlength="50" value="Search..." />
            </span>
            <input name="b" type="image" src="./View/css/images/search.gif" class="button" />
          </label>
        </form>
      </div>
      <div class="clr"></div>
    </div>
    <div class="headert_text_resize"> <img src="./View/css/images/img_main.jpg" alt="" width="970" height="338" /> </div>
    <div class="clr"></div>
  </div>
  <div class="body">
    <div class="body_resize">
      <div class="left">
       <h2>Welcome To The Polling System</h2>
       <hr />
       <h3>List Of all Polls</h3><hr />
<div id="wrapper">

<div id = "column-left" class="column-left">



<div class="hidden" style="display: none;">
<div id="loginDiv">
<h2>LOGIN</h2>
<label>USERNAME:</label> <input type="text" id="userName"
name="userName" /></br> <label>PASSWORD:</label> <input type="password"
id="password" name="password" /></br> <input type="button"
id="signIn" name="signIn" value="LOGIN" />
</div>
</div>

<div class="hidden" style="display: none;">
<div id="registerDiv">
<h2>REGISTER</h2>
<table>
<tr>
<td><label>* FIRSTNAME:</label></td>
<td><input type="text" name="firstName" id="firstName" /></br></td>
</tr>
<tr>
<td><label>* LASTNAME:</label></td>
<td><input type="text" name="lastName" id="lastName" /></br></td>
</tr>
<tr>
<td><label>* PASSWORD:</label></td>
<td><input type="password" name="password" id="registerPassword" /></br></td>
</tr>
<tr>
<td><label>* EMAIL:</label></td>
<td><input  type="text" name="email" id="email" /></br></td>
</tr>
<tr>
<td><input type="button" id="registerClick" name="register" value="REGISTER"
onclick="register()" /></td>
</tr>
</table>
</div>
</div>


</div>
<a id = "clickPollOpinion" href="#pollOpinion"></a>
<div id = "pollOpinion"></div>
<div id = "createPoll"></div>
<div id="column-right" class="column-right">
<div id="box1" class="box"></div>
</div>


	</div>	
	<div id="hiddenElemtnt"></div>
      </div>
      
      
      <div class="clr"></div>
    </div>
  </div>
  <div class="FBG">
    <div class="FBG_resize">
      <div class="blok">
       
      </div>
      <div class="blok">
       
      </div>
      <div class="blok">
       
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; Copyright <a href="#">Osscube</a>.</p>
      <p class="rf">Layout <a href="http://www.hotwebsitetemplates.net/">OSSCUBE>COM</a></p>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
  </div>
  
</div>
</html>
