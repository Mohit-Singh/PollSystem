    <script src="./assets/js/RGraph.common.core.js" ></script>
    <script src="./assets/js/RGraph.common.effects.js" ></script>
    <script src="./assets/js/RGraph.pie.js" ></script>
      <script src="./assets/js/RGraph.hbar.js" ></script>
    <link rel="stylesheet" href="./assets/css/demos.css" type="text/css" media="screen" />

<a href="#" onclick="home()">Home</a>
<table>
<tr>
	<td>Question: <?php  echo $data[0]['question'];?></td>
</tr>
<?php $count=1; foreach ($data as $key =>$val){?>
	<tr><td><input name="options" type="radio" id="optid<?php echo $val['optId']?>"onclick="vote(<?php echo $val['optId']?>)" <?php 
	
	if(!isset($_SESSION['userId']))
	{
		echo "disabled=true";
	}
		
	
	?>>Option<?php echo $count; ?>: <?php echo $val['options']?></td></tr>
	<?php }?>
</table>
 <canvas id="cvs" width="350" height="300">[No canvas support]</canvas>
  <canvas id="cvs2" width="350" height="300">[No canvas support]</canvas>
<script>
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
						$("#column-right").html(data);
						});
		});	
	
}

$.post('index.php',{"controller":"mainController",
	"method":"getOption",
	"QuestionId":<?php echo $data[0]['qId']?>,
			"LoginUsername":<?php if(isset($_SESSION['userId'])){echo $_SESSION['userId'];}else{echo "0";}?>},function(data){
				if(data.trim() !=0)
				{
					$("#optid"+data).attr("checked",true);
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