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
        			+ "<td><input type='button' value='View Details' onclick='voteNow(\""
        			+ val['id'] + "\")'>" + "</tr>";
        	count++;
        });
        str+="</table>";
        $("#column-right").append(str);
    });
}

function voteNow(id){

	$.post('index.php',{"controller":"mainController","method":"pollLoad","queId":id},function(data){
// 		alert(data);
		$("#hiddenElemtnt").html(data);
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
	padding:3px;
}

#pollTable td
{
	border: 1px solid black;	
	height:30px;
	width: auto;
	overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
	 font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size: 14px;
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
background-color : #97C950;
color:#0A0A2A;
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
      <div class="clr"></div>
      <div class="menu">
        <ul>
          <li><a href="index.html" class="active"><span>Home</span></a></li>
          <li><a href="services.html"><span>Services</span></a></li>
          <li><a href="about.html"><span>About Us</span></a></li>
          <li><a href="contact.html"><span>Contact Us</span></a></li>
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
<div id="hiddenElemtnt" ></div>
      </div>
      <div class="right">
        <h2>Menu</h2>
        <ul>
          <li>
          <p><a id="register" href="#registerDiv"><blink>REGISTER</blink></a></p></li>
<li><p><a id="login" href="#loginDiv"><blink>LOGIN</blink></a></p></li>
          
        </ul>
        <h2>Sponsors</h2>
        <ul class="sponsors">
          <li class="sponsors"><a href="http://www.dreamtemplate.com">DreamTemplate</a><br />
            Over 6,000+ Premium Web Templates</li>
          <li class="sponsors"><a href="http://www.templatesold.com/">TemplateSOLD</a><br />
            Premium WordPress &amp; Joomla Themes</li>
          <li class="sponsors"><a href="http://www.imhosted.com">ImHosted.com</a><br />
            Affordable Web Hosting Provider</li>
          <li class="sponsors"><a href="http://www.csshub.com/">CSS Hub</a><br />
            Premium CSS Templates</li>
          <li class="sponsors"><a href="http://www.evrsoft.com">Evrsoft</a><br />
            Website Builder Software &amp; Tools</li>
          <li class="sponsors"><a href="http://www.myvectorstore.com">MyVectorStore</a><br />
            Royalty Free Stock Icons</li>
        </ul>
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
