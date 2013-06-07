    <script src="./assets/js/RGraph.common.core.js" ></script>
    <script src="./assets/js/RGraph.common.effects.js" ></script>
    <script src="./assets/js/RGraph.pie.js" ></script>
      <script src="./assets/js/RGraph.hbar.js" ></script>
    <link rel="stylesheet" href="./assets/css/demos.css" type="text/css" media="screen" />
<div id="questionDiv">
<h2>Poll</h2>
<a href="#graph1" id = "graph1Click">Graph 1</a>
<a href="#graph2" id = "graph2Click">Graph 2</a>
<a href="#questionComments" id = "questionCommentsClick">Comments</a>
<table id = "tableDiv" style = "margin : auto; padding-bottom : 10px;">
<tr>
	<td>Question: <?php  echo $data[0]['question'];?></td>
</tr>
<?php $count=1; foreach ($data as $key =>$val){?>
	<tr><td>
	<?php 
	
	if(isset($_SESSION['userId']))
	{
		?>
		
		<input name="options" type="radio" class="allOptions" id="optid<?php echo $val['optId']?>"onclick="vote(<?php echo $val['optId']?>)">
		<?php 
	}
	?>Option<?php echo $count; ?>: <?php echo $val['options']?></td></tr>
	<?php }?>
</table>
<div id = "graph1" style="display:none">
 <canvas id="cvs" width="350" height="300">[No canvas support]</canvas>
</div>
<div id = "graph2" style="display:none">
  <canvas id="cvs2" width="350" height="300">[No canvas support]</canvas>
</div>
<div id="questionComments" style="display:none">
	<?php include './View/comment.php';?>
</div>

<script>
$("#graph2Click").fancybox();
$("#graph1Click").fancybox();
$("#questionCommentsClick").fancybox({
'min-width' : 300,
'autoSize' : false
	
});
function home()
{
	location.reload();
}
function vote(optId)
{
	$.post('index.php',{"controller":"mainController",
		"method":"pollNow",
		"QuestionId":<?php echo $data[0]['qId']?>,
				"OptionId":optId,
				"LoginUsername":<?php if(isset($_SESSION['userId'])){echo $_SESSION['userId'];}else{echo "0";}?>},function(data){
					alert("Thanks for Your Vote");
					$.post('index.php',{"controller":"mainController","method":"pollLoad","queId":<?php echo $data[0]['qId']?>},function(data){
						$("#hiddenElemtnt").html(data);
						});
		});	
	$("#tableDiv").html("");
	loadAllPoll();
	
}

$.post('index.php',{"controller":"mainController",
	"method":"getOption",
	"QuestionId":<?php echo $data[0]['qId']?>,
			"LoginUsername":<?php if(isset($_SESSION['userId'])){echo $_SESSION['userId'];}else{echo "0";}?>},function(data){
				if(data.trim() !=0)
				{
					$("#optid"+data).attr("checked",true);
				    $("[type ~='radio']").remove();
					//$(".allOption").remove();
				}
	});

$.post('index.php',{"controller":"mainController",
	"method":"graphData",
	"QuestionId":<?php echo $data[0]['qId']?>
			},function(data){
				//alert(data);
				newData=data.trim();
				result=jQuery.parseJSON(newData);
				var options=new Array();
				var votes=new Array();
				var i=0;
				$.each(result['options'],function(key,val){
					
						options[i]=val['options'];
						i++;

					});
				i=0;
				$.each(result['votes'],function(key,val){
					
					votes[i]=val;
					i++;

				});

				loadGraph(options,votes);			
	});
	
	function loadGraph(opt,vot)
	{
		var donut = new RGraph.Pie('cvs', vot)
        .Set('variant', 'donut')
        .Set('labels', opt)
        .Set('strokestyle', 'transparent')
        .Set('exploded', 3)
  		  RGraph.Effects.Pie.RoundRobin(donut, {'radius': false,'frames':60});

        var hbar = new RGraph.HBar('cvs2', vot)
        .Set('background.grid.hlines', false)
        .Set('xmax', 3.5)
        .Set('scale.decimals', 1)
        .Set('colors', ['#164366','#164366','#164366','#FDB515','#164366'])
        .Set('colors.sequential', true)
        .Set('labels', opt)
        .Set('gutter.left', 125)
        .Set('labels.above', true)
        .Set('labels.above.decimals', 1)
        .Set('noxaxis', true)
        .Set('xlabels', false)

   		RGraph.Effects.HBar.Grow(hbar);
	}

</script>