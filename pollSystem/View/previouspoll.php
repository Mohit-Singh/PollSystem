<html>



<head>
<script type="text/javascript">
function showOpinions(id)
{

	$.ajax({
        url : './index.php?controller=mainController&method=showOpinions',
        type : 'post',
        async:false,
    data : "questionid="+id,                
        success : function(data){
     
         
            $("#show").html('');
            $("#show").append(data);
        }
});


	
}

</script>


</head>

<div id="previousPollDiv" >
	
	
	
	
</div>
<div id="show">



</div>
</html>