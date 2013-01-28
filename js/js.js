$(window).ready(function () {
	newBoard();
});

function newBoard() {
	$.ajax({
		url: "init.php",
		dataType: "text",
		type: "POST",
		success: function (data) {
			$("#minesweeper").html(data);
		}
	});
}

function clickTd(td) {
	var coord = td.id.split(";");
	var row = coord[0];
	var col = coord[1];

	$.ajax({
		url: "play.php",
		data: {
			"col": col,
			"row": row
		},
		dataType: "text",
		type: "POST",
		success: function (data) {
			$("#minesweeper").html(data);
		}
	});
}