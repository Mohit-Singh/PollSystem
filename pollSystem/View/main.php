<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Polling System</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="View/css/style.css" type="text/css"
media="screen, projection, tv" />
<link rel="stylesheet" href="View/css/style-print.css" type="text/css"
media="print" />

<style>
</style>
<script src="./assets/js/jquery-1.9.1.min.js"></script>


<script src="./assets/js/fancybox/jquery.fancybox.js"></script>
<link rel="stylesheet" href="./assets/js/fancybox/jquery.fancybox.css"
type="text/css" media="screen"/>


<script>
$(document).ready(function(){

<?php
if(isset($_SESSION["username"]))
{

echo "$.post('index.php',{'loginStatus':'true'},function(data){ $('#column-left').hide(); $('#column-right').html(data); $('#logOut').show(); });";
}
else
{
echo "$('#logOut').hide();";
}


?>


loadAllPoll();
$("#divCreateNewPoll").hide();
$("#login").fancybox({
// 'width' : screenW/2,
// 'height' : screenH-210,
// 'autoScale' : false,
// 'transitionIn' : 'none',
// 'transitionOut' : 'none',
// 'type' : 'iframe'
});

$("#register").fancybox({
// 'width' : screenW/2,
// 'height' : screenH-210,
// 'autoScale' : false,
// 'transitionIn' : 'none',
// 'transitionOut' : 'none',
// 'type' : 'iframe'
});


$("#clickPollOpinion").fancybox({
	afterClose : function(){
		$("#pollOpinion").html("");
		return;
	}	
});


$("#signIn").click(function(){
$.ajax({
url : './index.php?controller=mainController&method=login',
type : 'post',
data : "userName="+$("#userName").val()+"&password="+$("#password").val(),
success : function(data){
if(data.trim() != "Account Does not exist" && data.trim() != "Password does not match")
{
$("#column-left").hide();
$('#logOut').show();
$("#column-right").prepend(data);

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
{
    $.post('index.php',{"controller":"mainController","method":"loadAllPoll"},function(data){    
    //alert(data);
    	var result = jQuery.parseJSON(data);
    	var str = "<table id='pollTable'>";
    	str += "<tr id='tableHead'><td>Question</td>" + "<td>User Email Id</td>"
    			+ "<td>User Name</td>" + "<td>Comment Count</td>"
    			+ "<td>Votes Count</td><td>Vote Now</td></tr>";
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
        			+ "<td><input type='button' value='Vote Now' onclick='voteNow(\""
        			+ val['id'] + "\")'>" + "</tr>";
        	count++;
        });
        str+="</table>";
        $("#column-right").append(str);
    });
}

function voteNow($id){

	$.ajax({
		async:false,
		url: "index.php?controller=mainController&method=viewPreviousPolls&question="+$id,
		type: "post",
		dataType: "json",
		success: function(data){
			$("#pollOpinion").html("");
			var str = "<table id='pollDispTable'>";
			str += "<tr id='tableHead'><td>Question</td></tr>";
			str += "<td>" + data[0]['question'] + "</td>";
			str += "</table>";
			$("#pollOpinion").append(str);
			$.ajax({
				async:false,
				url: "index.php?controller=mainController&method=showOpinions&question="+$id,
				type: "post",
				dataType: "json",
				success: function(data){
					$("#pollOpinion").append("<div>");
					var strinner = "<table id='pollDispOptionTable'>";					
					 $.each(data, function(i,value){							
						 strinner += "<tr><td>" + value + "</td></tr>";												 
					 });
					 strinner += "</table>";	
					 $("#pollOpinion > div").append(strinner);
					 $("#pollOpinion").append("</div>");
				}
			});			
		}
		});	
	$("#clickPollOpinion").trigger("click");
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


function register() {
	$.post('index.php', {
		'controller' : 'mainController',
		'method' : 'registerUser',
		'firstName' : $('#firstName').val(),
		'lastName' : $('#lastName').val(),
		'email' : $('#email').val(),
		'password' : $('#registerPassword').val(),
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
#logOut
{
float: right;
margin-right: 50px;
}
#pollTable
{
margin-left: 25px;
text-align: center;
color: #0A0A2A;
font-family: 'Tangerine', serif;
font-size: 12px;
}
#pollTable #odd
{
background-color : #A9F5BC;
color:#0A0A2A;
}
#pollTable #even
{
background-color : #F5F6CE;
color:#0A0A2A;
}
#pollTable #tableHead
{
background-color : #2EFEF7;
color:#0A0A2A;
}
#header
{
	border:2px solid black;
}
</style>

</head>
<body>
<div id="header">
      <h1>WELCOME TO POLLING SYSTEM</a></h1>

</div>
<div id="logOut"><a href="#" onclick="logOutUser();">LogOut</a></div>
<div id="wrapper">

<div id = "column-left" class="column-left">
<h3>LOGIN/REGISTER</h3>
<p><a id="register" href="#registerDiv">REGISTER</a></p>
<p><a id="login" href="#loginDiv">LOGIN</a></p>
<!--  <p><a id="viewPolling" href="#" onclick="viewPreviousPolls();">VIEW POLLINGS</a></p> -->

<div class="hidden">
<div id="loginDiv">
<h2>LOGIN</h2>
<label>USERNAME:</label> <input type="text" id="userName"
name="userName" /></br> <label>PASSWORD:</label> <input type="password"
id="password" name="password" /></br> <input type="button"
id="signIn" name="signIn" value="LOGIN" />
</div>
</div>

<div class="hidden">
<div id="registerDiv">
<h2>REGISTER</h2>
<table>
<tr>
<td><label>FIRSTNAME:</label></td>
<td><input type="text" name="firstName" id="firstName" /></br></td>
</tr>
<tr>
<td><label>LASTNAME:</label></td>
<td><input type="text" name="lastName" id="lastName" /></br></td>
</tr>
<tr>
<td><label>PASSWORD:</label></td>
<td><input type="password" name="password" id="registerPassword" /></br></td>
</tr>
<tr>
<td><label>EMAIL:</label></td>
<td><input type="text" name="email" id="email" /></br></td>
</tr>
<tr>
<td><input type="button" name="register" value="REGISTER"
onclick="register()" /></td>
</tr>
</table>
</div>
</div>


</div>
<a id = "clickPollOpinion" href="#pollOpinion"></a>
<div id = "pollOpinion"></div>
<div id="column-right" class="column-right">
<div id="box1" class="box"></div>
</div>


</div>

<div align=center>
OSSCUBE<a href='http://www.osscube.com'> OSSCUBE.COM</a>
</div>
</body>
</html>