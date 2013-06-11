$paging = "";

function loadAllPoll() {
	$perPagePoll = 2;
	str = "";
	$flag = 0;

	$.ajaxSetup({
		async : false
	});
	$
			.post(
					'index.php',
					{
						"controller" : "mainController",
						"method" : "loadAllPoll"
					},
					function(data) {

						var result = jQuery.parseJSON(data);
						$dataLength = result.length;
						// alert($dataLength % $perPagePoll);

						if (($dataLength % $perPagePoll) == 0) {
							$paging = new Array(Math.floor($dataLength
									/ $perPagePoll));
						} else {
							$paging = new Array(Math.floor($dataLength
									/ $perPagePoll) + 1);
						}
						// alert($paging.length);
						$questionCount = 0;

						for ($i = 0; $i < $paging.length; $i++) {

							$paging[$i] = "<div id='tableDiv'>"
									+ "<table id='pollTable'>"
									+ "<tr id='tableHead'><td>Question</td>"
									+ "<td>User Email Id</td>"
									+ "<td>User Name</td>"
									+ "<td>Comment Count</td>"
									+ "<td>Votes Count</td><td>Vote Now</td>";
							if ($login == "yes") {
								$paging[$i] += "<td>Delete Poll</td>";
							}
							$paging[$i] += "</tr>";
							var count = 0;
							str = "";

							for ($j = 0; $j < $perPagePoll; $j++) {
								val = result[$questionCount];

								// var str = "<div id='tableDiv'>";
								// str += "<table id='pollTable'>";
								// str += "<tr id='tableHead'><td>Question</td>"
								// + "<td>User Email Id</td>"
								// + "<td>User Name</td>" + "<td>Comment
								// Count</td>"
								// + "<td>Votes Count</td><td>Vote Now</td>";

								// if($login == "yes"){
								// str += "<td>Delete Poll</td>";
								// }
								// str += "</tr>";

								if (count % 2 == 0) {
									str += "<tr id='odd'>";
								} else {
									str += "<tr id='even'>";
								}
								str += "<td>"
										+ val['question']
										+ "</td>"
										+ "<td>"
										+ val['username']
										+ "</td>"
										+ "<td>"
										+ val['first_name']
										+ " "
										+ val['last_name']
										+ "</td>"
										+ "<td>"
										+ val['comment']
										+ "</td>"
										+ "<td>"
										+ val['votes']
										+ "</td>"
										+ "<td><input type='button' class='btn' value='View Details' onclick='voteNow(\""
										+ val['id'] + "\")'>";
								if ($username == val['username']
										&& $login == "yes") {
									str += "<td><input type='button' class='btn' value='Delete' onclick='DeletePoll(\""
											+ val['id'] + "\")'></td>";
								} else {
									if ($login == "yes") {
										str += "<td>No</td>";
									}
								}
								str += "</tr>";
								count++;
								if ($questionCount < result.length) {
									$questionCount++;
								}
								if ($questionCount >= result.length) {
									$flag = 1;
									break;
								}
								// alert($dataLength);
								// alert(result[$questionCount]['username']);
							}
							$paging[$i] += str;
							$paging[$i] += "</table></div>";
							if ($flag) {
								break;
							}
						}
						$("#column-right").append($paging[0]);
					});
	$("#pagingLinks").html("");
	for ($i = 0; $i < $paging.length; $i++) {
		$("#pagingLinks").append(
				"<input type = \"button\" value = \"" + ($i + 1)
						+ "\" onClick = \"pagination('" + ($i) + "')\" />");
	}
}

function pagination($page) {
	// alert($paging[$page]);
	$("#column-right").html($paging[$page]);
}

function voteNow(id) {

	$.post('index.php', {
		"controller" : "mainController",
		"method" : "pollLoad",
		"queId" : id
	}, function(data) {
		$("#hiddenElemtnt").html(data);

		document.getElementById('questionDiv').scrollIntoView();
	});

}

function openCreateNewPoll() {
	$("#divCreateNewPoll").toggle();

}
var rowIndex = 2;
function addMoreOptions() {
	rowIndex++;
	var row = "<tr id='row_" + rowIndex
			+ "'><td><label>Option</label></td><td><input name='opt" + rowIndex
			+ "' type=text /></td><td><button onclick='removeRow(" + rowIndex
			+ ");'>X</button></td></tr>";
	$("#addMoreOptionsTable").append(row);

}
function removeRow(rowIndex) {
	$('#row_' + rowIndex).remove();
}

function htmlEntities(str) {
	return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(
			/>/g, '&gt;').replace(/"/g, '&quot;');
}

function checkEmail() {

	var email = document.getElementById('email');
	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if (!filter.test(email.value)) {

		$('#email').val('');
	}
}

function register() {
	checkEmail();
	if ($('#email').val().trim() == "")
		alert('Please provide a valid email address');
	if ($('#email').val().trim() != ""
			&& $('#registerPassword').val().trim() != ""
			&& $('#firstName').val().trim() != ""
			&& $('#lastName').val().trim() != "") {
		$.post('index.php', {
			'controller' : 'mainController',
			'method' : 'registerUser',
			'firstName' : htmlEntities($('#firstName').val()),
			'lastName' : htmlEntities($('#lastName').val()),
			'email' : htmlEntities($('#email').val()),
			'password' : htmlEntities($('#registerPassword').val()),
		}, function(data, status) {
			if (status == "success") {
				if (data.trim() == "true") {
					alert("you are successfully registered");
					parent.$.fancybox.close();
				} else {
					alert("same email id alredy registered");
					parent.$.fancybox.close();
				}
			}
		});
	} else {
		alert("* fields are mendatory");
	}

}

function DeletePoll($id) {
	$status = confirm("you want to delete");
	if ($status == true) {
		$.ajax({
			url : './index.php?controller=mainController&method=delPoll',
			type : 'post',
			data : "QuestionId=" + $id,
			success : function(data) {
				$("#hiddenElemtnt").html("");
				$("#pollTable").remove();
				loadAllPoll();
				// location.reload();
				// $("#column-right").load("./View/poll.php");
				// loadAllPoll();
			}
		});
	}
}

function AddQuestion() {
	$.ajax({
		url : './index.php?controller=mainController&method=AddQuestion',
		type : 'post',
		data : $("#submitForm").serialize(),
		success : function(data) {
			alert("Succesfully saved");
			location.reload();
			// $("#column-right").load("./View/poll.php");
			// loadAllPoll();
		}
	});
}

function logOutUser() {
	$.ajax({
		url : './index.php?controller=mainController&method=userLogOut',
		type : 'post',
		success : function(data) {
			location.reload();
		}
	});
	$login = "no";
}

function viewPreviousPolls() {
	$.ajax({
		url : './index.php?controller=mainController&method=loadPreviousPoll',
		type : 'post',
		async : false,
		// data :
		// "userName="+$("#userName").val()+"&password="+$("#password").val(),
		success : function(data) {
			$("#box1").html('');
			$("#box1").append(data);
		}
	});

	$.ajax({
		url : './index.php?controller=mainController&method=viewPreviousPolls',
		type : 'post',
		// data :
		// "userName="+$("#userName").val()+"&password="+$("#password").val(),
		success : function(data) {
			$("#previousPollDiv").html('');
			$("#previousPollDiv").append(data);
		}
	});
}