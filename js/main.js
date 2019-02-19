
$(document).ready(function(){

	$(".myBtn").click(function(){
		var id = $(this).attr('rel');
		var cost = $(this).attr('mel');
		var type = $(this).attr('bel');

		$('#book_type').val(type);
		$('#book_cost').val(cost);
		$('#book_id').val(id);
		
	  $("#myModal").modal();
	});

	var datePicker = function() {
		// jQuery('#time').timepicker();
		$('.date').datepicker({
		  'format': 'm/d/yyyy',
		  'autoclose': true
		});

		$( ".fromDate" ).datepicker({ 
			format: "yyyy-mm-dd",
			startDate: '0d',
			endDate: '+2m +10d' ,
			autoclose: true
		}).on('changeDate', function (selected) {
			var minDate = new Date(selected.date.valueOf());
			$('.toDate').datepicker('startDate', minDate);
	});

		$( ".toDate" ).datepicker({ 
			format: "yyyy-mm-dd",
			startDate: '0d',
			endDate: '+2m +10d' ,
			autoclose: true
		}).on('changeDate', function (selected) {
			var maxDate = new Date(selected.date.valueOf());
			$('.fromDate').datepicker('endDate', maxDate);
	});

	};

	datePicker();

	

  });

