<?php
$uid=$_SESSION['userid'];
?>
<head>
<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all">
<script
src='../assets/js/jquery.tools.min.js'></script>
<script
src='../assets/js/jquery-1.9.1.min.js'></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script type="text/javascript">

$(document).ready(function() {
	$('#comments').hide();
	$.ajax({
		type: "POST",
	    url: '../index.php?controller=MainController&method=getComment',  
	     
	       success: function(data){
		       data=jQuery.parseJSON(data);
			$.each(data,function(i,value){
				$("#comments").append(value['text']); 
				 $("#comments").append(" posted by ");
				$("#comments").append(value['login_username']);
				 $("#comments").append("</br>");
			});
			
			
			$("#comments").show();
	     }
	  });
	
});
function postComment()
{
	
$.ajax({
		type: "POST",
	    url: '../index.php?controller=MainController&method=insertComment',  
	     data: $('#commentform').serialize(),
	       success: function(data){
			obj = jQuery.parseJSON(data);
			 $("#comments").append("<br/>");
	    	 $("#comments").append(obj[1]);
	    	 $("#comments").append("posted by ");
	    	 $("#comments").append(obj[0]);
		    
	     }
	  });
} 
</script>
</head>
<body>
<form id="commentform">
<textarea name="comment"></textarea>
<input type="button" onClick='postComment()'/>
<div  style="border:1px solid black" id="comments"></div>
</form>
</body>