
<head>
<link rel="stylesheet" href="./View/css/reset.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="./View/css/core.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="./View/css/accordion.core.css" type="text/css" charset="utf-8">
        <style type="text/css">
            .loading {
                display: none;
            }
            .accordion {
                border: 1px solid #ccc;
             /*   width:  50%;*/ 
            }
                .accordion li h3 a {
                    background:             #666;
                    background:             #666 -webkit-gradient(linear, left top, left bottom, from(#999), to(#666)) no-repeat;
                    background:             #666 -moz-linear-gradient(top,  #999,  #666) no-repeat;
                    border-bottom:          1px solid #333;
                    border-top:             1px solid #ccc;
                    color:                  #fff;
                    display:                block;
                    font-style:             normal;
                    margin:                 0;
                    padding:                5px 10px;
                    text-shadow:            0 -1px 2px #333, #ccc 0 1px 2px;
                }
                    .accordion li.active h3 a {
                        background:             #369;
                        background:             #369 -webkit-gradient(linear, left top, left bottom, from(#69c), to(#369)) no-repeat;
                        background:             #369 -moz-linear-gradient(top,  #69c,  #369) no-repeat;
                        border-bottom:          1px solid #036;
                        border-top:             1px solid #9cf;
                        text-shadow:            0 -1px 2px #036, #9cf 0 1px 2px;
                    }
                    .accordion li.locked h3 a {
                        background:             #963;
                        background:             #963 -webkit-gradient(linear, left top, left bottom, from(#c96), to(#963)) no-repeat;
                        background:             #963 -moz-linear-gradient(top,  #c96,  #963) no-repeat;
                        border-bottom:          1px solid #630;
                        border-top:             1px solid #fc9;
                        text-shadow:            0 -1px 2px #630, #fc9 0 1px 2px;
                    }
                .accordion li h3 {
                    margin:         0;
                    padding:        0;
                }
                .accordion .panel {
                    padding:        10px;
                }
        </style>
<script type="text/javascript" src="./View/js/jquery.accordion.2.0.js" charset="utf-8"></script>

<script type="text/javascript">

$(document).ready(function() {
// 	$('#comments').hide();
	
    
	$("#comments").ready(function(){
		showComments();
		});
//         $('#example4').accordion({
//             canToggle: true,
//             canOpenMultiple: true
//         });
//         $(".loading").removeClass("loading");
});
function showAccordian(){
	$(".accordion").accordion();
}
function showComments(){
	$("#comments").html("");
	$.ajax({
		type: "POST",
	    url: './index.php?controller=MainController&method=getComment&questionId=<?php echo $data[0]['qId']?>',  
	     
	       success: function(data){
				
		       data=jQuery.parseJSON(data);
			$.each(data,function(i,value){
				if(i==0) {
				  $('#comments').prepend("<ul id='example4' class='accordion'>"); }
				  $('#example4').prepend("<li><h3>posted by  "+value['login_id']+" on "+value['date_time']+"</h3><div class=\"panel\">   "+value['comment']+"</div></li>");
				 //  $("#comments").append(" posted by ");
				   
				// $("#comments").append("on ");
				// $("#comments").append(value['date_time']);
				 //$("#comments").append("</br>");
				//$("#comments").append(value['login_id']);
				//$('#comments').append("<div class='panel loading'>");
				//$("#comments").append(value['comment']); 
				//$("#comments").append("</div></li>"); 
				 
				 //$("#comments").append("--------------------------</br>");
			});
			
			
			$("#comments").show();
			showAccordian();
	     }
	  });
	$("#postCommentText").val("");
}
function postComment()
{
	
$.ajax({
		type: "POST",
	    url: './index.php?controller=MainController&method=insertComment&questionId=<?php echo $data[0]['qId']?>',  
	     data: $('#commentform').serialize(),
	       success: function(data){
			obj = jQuery.parseJSON(data);
			alert("post has bn made");
			 //$("#comments").append("---------------------------------");
// 			 $('#comments').prepend("<ul id='example4' class='accordion'>");
// 			 $('#example4').prepend("<li><h3>posted by  "+obj[0]+"</h3><div class=\"panel\">"+obj[1]+"</div></li>");
// 			 showAccordian();
			 // 	    	 $("#comments").prepend(obj[1]);
// 	    	 $("#comments").prepend(" posted by ");
// 	    	 $("#comments").prepend(obj[0]);
// 	    	 $("#comments").prepend("</br>");
// 			 $("#comments").prepend("---------------------</br>");
	     }
	  });
showComments();
} 
</script>
</head>
<body>
<form id="commentform">
 <?php	if(isset($_SESSION['userId']))
	{?>
<textarea id = "postCommentText" name="comment"></textarea>
		<input type="button" onClick='postComment()' value="post comment"/>
	<?php } ?>
<div  style="border:1px solid black" id="comments"></div>
</form>
</body>