<html>
<head>
<script type="text/javascript">
function showOpinions(id) {
	$.ajax({
		url : './index.php?controller=mainController&method=showOpinions',
		type : 'post',
		async : false,
		data : "questionid=" + id,
		dataType: "json",
		success : function(data) {
			$("#show").html('');
			$.each(data,function(i,value){
				//alert(value[1]);
				$("#show").append(value);
				//$("#show").append(value[1]);

				});
			$("#show").append("</br>");
			//$("#show").append(data);
		}
	});
}
</script>
</head>
<div id="previousPollDiv"></div>
<div id="show"></div>
</html>