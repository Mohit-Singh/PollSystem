<div class="box-in">
	<h2>Welcome to Polling System</h2>
	<div id="divMainPageContainer">

		<div id="divMainPageCenter">

			<input type="button" name="createNewPoll" value="createNewPoll"
				onclick="openCreateNewPoll();" />
			<div id="divCreateNewPoll">
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
				<div id="addMoreOptions"></div>
				<input type="button" name="addMoreOptions" value="Add More Options"
					onclick="addMoreOptions();" />
			</div>

		</div>
	</div>
</div>