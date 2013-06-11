<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>polling</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="View/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="./assets/js/fancybox/jquery.fancybox.css"
    	type="text/css" media="screen" />
    <script src="./assets/js/jquery-1.9.1.min.js"></script>
    <script src="./assets/js/jquery.tools.min.js"></script>
    <script src="./assets/js/pollingSystem.js"></script>
    <script src="./assets/js/fancybox/jquery.fancybox.js"></script>
    <script>
    $(document).ready(function(){

    <?php
    if (isset ( $_SESSION ["username"] )) {
    ?>
    
    $username = "<?php echo $_SESSION["username"]; ?>";
    $login = "yes";
    
    <?php
        echo "$.post('index.php',{'loginStatus':'true'},function(data){ $('#column-left').hide(); $('#column-right').html(data); $('#logOut').show(); });";
    } else {
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
    	$.ajax({	url : './index.php?controller=mainController&method=login',
    		type : 'post',
    		data : "userName=" + $("#userName").val() + "&password="
    				+ $("#password").val(),
    		success : function(data) {
    			if (data.trim() != "Account Does not exist"
    					&& data.trim() != "Password does not match") {
    				$("#divRight").hide();
    				$('#logOut').show();
    				//$("#column-right").html("");
    				$("#createPoll").html(data);
    				$username = $("#userName").val();
    				$login = "yes";
    				loadAllPoll();
    			} else {
    				alert(data.trim());
    			}
    		}
    	});
        $.fancybox.close();
    });
});
</script>
<style>
#logOut {
	float: right;
	margin-right: 50px;
}

#pollTable { /*margin-left: 25px;*/
	text-align: center;
	color: #0A0A2A;
	font-family: 'Tangerine', serif;
	font-size: 12px;
	padding: 3px;
/* 	width: 300px; */
}

#pollTable td {
	border: 1px solid black;
	height: 30px;
	width: 22%;//auto;
	overflow: hidden;
	/*     text-overflow: ellipsis;  */
	/*     white-space: nowrap;  */
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	word-break: break-all;
	word-wrap: break-word;
}

#pollTable #odd {
	background-color: ;
	color: #0A0A2A;
}

#pollTable #even {
	background-color: #97C950;
	color: #0A0A2A;
}

#pollTable #tableHead {
	background-color: #323A3F;
	color: white;
}

#pollTable #tableHead td {
	font-size: 14px;
	word-break: normal;
}

#header {
	border: 2px solid black;
}
#pagingLinks{
	margin: 0 auto;
	padding: 0;
	width: 52%;
	text-align: center;
}
#tableDiv td{
    word-break: break-all;
    word-wrap: break-word;
}
</style>
</head>
<body>
	<div class="main">
		<div class="header">
			<div class="header_resize">
				<div class="logo">
					<h1>
						<a href="index.html"><span>Polling</span>System<br /> <small>Welcome
								to the world of polling </small></a>
					</h1>
				</div>
<?php
if (! isset ( $_SESSION ["username"] )) {
?>      
      <div id="divRight" class="right">
					<!--         <h2>Menu</h2> -->
					<ul>
						<li>
							<p>
								<a id="register" href="#registerDiv"><blink>REGISTER</blink></a>
							</p>
						</li>
						<li><p>
								<a id="login" href="#loginDiv">| <blink>LOGIN</blink></a>
							</p></li>
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
						<li><div id="logOut">
								<a href="#" onclick="logOutUser();">LogOut</a>
							</div></li>
					</ul>
				</div>
				<div class="search">
					<form id="form1" name="form1" method="post" action="#">
						<label><span> <input name="q" type="text" class="keywords"
								id="textfield" maxlength="50" value="Search..." />
						</span> <input name="b" type="image"
							src="./View/css/images/search.gif" class="button" /> </label>
					</form>
				</div>
				<div class="clr"></div>
			</div>
			<div class="headert_text_resize">
				<img src="./View/css/images/img_main.jpg" alt="" width="970"
					height="338" />
			</div>
			<div class="clr"></div>
		</div>
		<div class="body">
			<div class="body_resize">
				<div class="left">
					<h2>Welcome To The Polling System</h2>
					<hr />
					<h3>List Of all Polls</h3>
					<div id="wrapper">

						<div id="column-left" class="column-left">
							<div class="hidden" style="display: none;">
								<div id="loginDiv">
									<h2>LOGIN</h2>
									<label>USERNAME:</label> <input type="text" id="userName"
										name="userName" /></br> <label>PASSWORD:</label> <input
										type="password" id="password" name="password" /></br> <input
										type="button" id="signIn" name="signIn" value="LOGIN" />
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
											<td><input type="password" name="password"
												id="registerPassword" /></br></td>
										</tr>
										<tr>
											<td><label>* EMAIL:</label></td>
											<td><input type="text" name="email" id="email" /></br></td>
										</tr>
										<tr>
											<td><input type="button" id="registerClick" name="register"
												value="REGISTER" onclick="register()" /></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<a id="clickPollOpinion" href="#pollOpinion"></a>
						<div id="pollOpinion"></div>
						<div id="createPoll"></div>
						<div id="column-right" class="column-right">
							<div id="box1" class="box"></div>
						</div>
						<div id="pagingLinks"></div>
					</div>
					<div id="hiddenElemtnt"></div>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<div class="FBG">
			<div class="FBG_resize">
				<div class="blok"></div>
				<div class="blok"></div>
				<div class="blok"></div>
				<div class="clr"></div>
			</div>
		</div>
		<div class="footer">
			<div class="footer_resize">
				<p class="lf">
					&copy; Copyright <a href="#">Osscube</a>.
				</p>
				<p class="rf">
					Layout <a href="http://www.hotwebsitetemplates.net/">OSSCUBE>COM</a>
				</p>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
</html>