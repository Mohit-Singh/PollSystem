    <script src="./assets/js/RGraph.common.core.js" ></script>
    <script src="./assets/js/RGraph.common.effects.js" ></script>
        <script src="./assets/js/RGraph.common.dynamic.js" ></script>
    <script src="./assets/js/RGraph.common.tooltips.js" ></script>
    <script src="./assets/js/RGraph.pie.js" ></script>
      <script src="./assets/js/RGraph.hbar.js" ></script>
      <script src="./assets/js/RGraph.bar.js" ></script>
      <script src="./assets/js/RGraph.line.js" ></script>
      <script src="./assets/js/RGraph.common.key.js" ></script>
       <script src="./assets/js/RGraph.radar.js" ></script>
    <link rel="stylesheet" href="./assets/css/demos.css" type="text/css" media="screen" />
<div id="questionDiv">

<h2>Pollings</h2>
<div id="linkGraph">
<label style="color:#254117;"><b>VIEW MORE GRAPHS :</b></label>
<a href="#graph1" id = "graph1Click">Graph 1</a>
<a href="#graph2" id = "graph2Click">Graph 2</a>
<a href="#questionComments" id = "questionCommentsClick">Comments</a>
</div>
<table id = "tableDiv" style = "margin : 20px; padding-bottom : 10px;float:left;word-wrap:break-word;">
<tr>
	<td style="font-size: 1.3em; color:#254117;">Question: <?php  echo $data[0]['question'];?></td>
</tr><hr>
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
	<?php $count++; }?>
</table>

<div id = "graph3" style="float:left; clear:both;">
 <canvas id="cvs3" width="350" height="300">[No canvas support]</canvas>
</div>
<div id = "graph4" style="float:left">
  <canvas id="cvs4" width="350" height="300">[No canvas support]</canvas>
</div>

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
					
						options[i]="opt "+(i+1);
						i++;

					});
				i=0;
				$.each(result['votes'],function(key,val){
					
					votes[i]=val;
					i++;

				});

				$.ajax({
					url : './index.php?controller=mainController&method=showOpinions',
					type : 'post',
					async : false,
					data : "questionid=" + <?php echo $data[0]['qId']?>,
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
				
				loadGraph(options,votes);			
	});
	
	function loadGraph(opt,vot)
	{

        var hbar = new RGraph.HBar('cvs', vot)
        .Set('grouping', 'grouped')
        .Set('vmargin', 20)
        .Set('labels', opt)
        .Set('key', opt)
        .Set('key.position', 'gutter')
        .Set('key.position.gutter.boxed', true)
        .Set('key.colors', ['#3366CC','#DC3912','#FF9900','#109618'])
        .Set('colors', ['Gradient(white:#3366CC:#3366CC)',
                        'Gradient(white:#DC3912:#DC3912)',
                        'Gradient(white:#FF9900:#FF9900)',
                        'Gradient(white:#109618:#109618)'
                        ])
        .Set('tooltips', opt).Draw();
        
        var bar = new RGraph.Bar('cvs2', [vot])
        .Set('labels', [opt])
        .Set('tooltips', ['Luis','Luis','Kevin','Kevin','John','John','Gregory','Gregory'])
        .Set('tooltips.event', 'onmousemove')
        .Set('ymax', 30)
        .Set('strokestyle', 'white')
        .Set('linewidth', 2)
        .Set('shadow', true)
        .Set('shadow.offsetx', 0)
        .Set('shadow.offsety', 0)
        .Set('shadow.blur', 10)
        .Set('hmargin.grouped', 2)
        .Set('units.pre', '')
        .Set('title', 'An example Bar chart')
        .Set('gutter.bottom', 20)
        .Set('gutter.left', 40)
        .Set('gutter.right', 15)
        .Set('colors', ['Gradient(white:rgba(255, 176, 176, 0.5))','Gradient(white:rgba(153, 208, 249,0.5))'])
        .Set('background.grid.autofit.numhlines', 5)
        .Set('background.grid.autofit.numvlines', 4)
    
    // This draws the chart
    	RGraph.Effects.Fade.In(bar, {'duration': 250});        

        var hbar = new RGraph.HBar('cvs3', vot)
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


        var pie = new RGraph.Pie('cvs4', vot)
        .Set('strokestyle', '#e8e8e8')
        .Set('linewidth', 5)
        .Set('shadow', true)
        .Set('shadow.offsety', 15)
        .Set('shadow.offsetx', 0)
        .Set('shadow.color', '#aaa')
        .Set('exploded', 10)
        .Set('radius', 50)
        .Set('tooltips', opt)
        .Set('tooltips.coords.page', true)
        .Set('labels', opt)
        .Set('labels.sticks', true)
        .Set('labels.sticks.length', 15)
    
    // This is the factor that the canvas is scaled by
    var factor = 1.5;

    // Set the transformation of the canvas - a scale up by the factor (which is 1.5 and a simultaneous translate
    // so that the Pie appears in the center of the canvas
    pie.context.setTransform(factor,0,0,1,((pie.canvas.width * factor) - pie.canvas.width) * -0.5,0);

    //pie.Draw();
    RGraph.Effects.Pie.RoundRobin(pie, {frames:30});
	}

</script>