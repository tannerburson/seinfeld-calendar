<html>
<head>
	<title>Seinfeld Motivation Calendar</title>
	<?php
		// Parse gadget URL and emit <script src=...</script> statements into the HTML output. 
		// The <script src=...</script> statements will load the libraries passed in via the URL.
		$libraries = split(",", $_GET["libs"]);
		foreach ($libraries as $script) {
			if (preg_match('@^[a-z0-9/._-]+$@i', $script)
			  && !preg_match('@([.][.])|([.]/)|(//)@', $script)) {
			      print "<script src='http://www.google.com/ig/f/$script'></script>";
			}
		} 
	?>

	<script src="jquery-1.2.6.min.js" type="text/javascript"></script>
	<script src="ui.datepicker.js" type="text/javascript"></script>
	<link media="screen" rel="stylesheet" href="ui.datepicker.css" type="text/css">
	<style type="text/css">
		#legend { 
			text-align: left;
			font-weight: bold;
		}
		#consecutive {
			color: #f00;
		}
		.ui-datepicker-one-month {
			width: 250px;
		}
		.ui-datepicker-days-row {
			height: 30px;
		}
		.ui-datepicker-links {
			display: none;
		}
	</style>
	<script type="text/javascript">
		var prefs = new _IG_Prefs();
		var highlightColor = prefs.getString("color");
		var currentMonth = undefined;
		var currentYear = undefined;
		var selectedDates = [];
		var currentCount = 0;
		$(document).ready(function(){
			var opts = {
				onSelect: function(var1) {
					$.post("save.php",
						{ 
							date: var1,
						}
					);
					currentCount = countConsecutiveDates(selectedDates);
				},
				onChange: function(bah,bah2,inst) {
					colorAll();
				},
				onDraw: function(){
					setAllIds();
					colorAll();	
				},
				minDate: '-1w',
				maxDate: '+0d'

			};
			$('#calendar').datepicker(opts);
						
		});
		function setAllIds() {
			currentMonth = parseInt($('.ui-datepicker-new-month').val()) + 1;
			currentYear = $('.ui-datepicker-new-year').val();
			$('.ui-datepicker-days-cell').each(function(){
				$(this).attr('id',"d" + (currentMonth + "_" + $(this).text() + "_" + currentYear));
			});

		}
		function colorAll() {	
			$.getJSON('list.php',
				function(data){
					selectedDates = [];
					$.each(data, function(i, item){
						selectedDates.push(Date.parse(item.selected_date));
						colorize($(dateId(item.selected_date)),highlightColor);
					});
					currentCount = countConsecutiveDates(selectedDates);
					$('#consecutive').html(currentCount);
				}
			);
		}
		function countConsecutiveDates(list){
			list = list.sort().reverse();
			var count=1;
			for(var i=0;i<list.length - 1;i++){
				// If the next element is also in the list count it. also short circuit the if to make sure we don't go out of bounds
				if ( list.length > 2 && list[i] == ((list[i+1]) + (60 * 60 * 24 * 1000)))
					count++;
				else
					break;
			}
			return count;
		}
		function colorize(el,color){
			$(el).attr('style','background-color: ' + color + ' !important');
		}
		function dateId(fdate){
			fdate = "#d" + fdate.replace(/\//g,'_');
			return fdate;
		}
	</script>
</head>
<body>
<div id="yohoho">
	<div id="legend">
		Consecutive Days: <span id="consecutive"></span><br/>
	</div>
	<div id="calendar">
	</div>
</div>
</body>
