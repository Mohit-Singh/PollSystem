<script type="text/javascript">
$("#dopoll").click(function() {

	$.ajax({
        url: './index.php?controller=mainController&method=pollLoad',
        type: 'POST',
        data: $('#QuestionForm').serialize(),
        success: function (select) {
            alert(select);
            $("#contentrender").html(select);
           // $("#grdSearch").fadeIn(6000);
        }   
    });
});
</script>
<div class="box-in">
	
	<div id="divMainPageContainer">

		<div id="divMainPageCenter">
		
		<a href = "#divCreateNewPoll" id = "CreateNewPollClick">
		
			<input type="button" class="btn" name="createNewPoll" value="createNewPoll"/><hr />
			<div id="divCreateNewPoll" style = "display:none">
				<form id="submitForm">
					<table id="addMoreOptionsTable">
						<tr>
							<td><label>CREATE POLL</label></td>
							<td><textarea name="question" rows="1" cols="50"></textarea></td>
						</tr>
						<tr>
							<td><label>Option</label></td>
							<td><input name="opt1" type="text" /></td>
						</tr>
						<tr>
							<td><label>Option</label></td>
							<td><input name="opt2" type="text" /></td>
						</tr>
					</table>
					
					<input type="button" value="Submit" onclick="AddQuestion();"></input>
                    
				</form>
					<input type="button" name="addMoreOptions" value="Add More Options"
					onclick="addMoreOptions();" />
							<div id="addMoreOptionsDiv"></div>

	
			</div>
		</div>
	</div>
</div>