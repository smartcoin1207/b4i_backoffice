(function($) {
    "use strict"; // Start of use strict 

	$('#new_startup_btn').on('click', function() {
        // Clear any previous validation messages
        $(".validation-message").remove();

        // Validate the Startup Name field
        if ($("select[name='startup_id']").val() === "") {
            $("select[name='startup_id']").after("<div class='validation-message text-danger'>Please select a startup.</div>");
            return;
        }

        // Validate the Raised field
        var raisedValue = $("input[name='raised']").val();
        if (isNaN(raisedValue) || raisedValue === "") {
            $("input[name='raised']").after("<div class='validation-message text-danger'>Please enter a valid number for the Raised field.</div>");
            return;
        }

        var selectedStartups = $('#investor_ids').val();
        console.log(selectedStartups);

        // If all validations pass, submit the form
        $("#startup_portfolio_form").submit();
	});

    $('#add_new_investor_btn').on('click', function() {
		$('#new_investors_modal').modal({backdrop: 'static'},'show');
	});

	$('#btn-save-investor').on('click', function() {
		// post data to save
        const name = $('input[name="new_investor"]').val();
        if(!name) return false;
        
		$.ajax({
			url:  _BASEURL+'startup_portfolio/',
			type: 'POST',
			data: {
				cmd: "new_investor",
                name: name
			},
			datatype: 'json'
		})
		.done(function(data) {
            const dataObj = JSON.parse(data);
			if( dataObj.status!='success' ) {
				alert('Ops! An error occurred');
			} else {
                let investorSelect = document.getElementById('investor_ids');
                let newOption = document.createElement('option');
                newOption.value = dataObj.id;
                newOption.text = dataObj.name;
                investorSelect.add(newOption);
                investorSelect.loadOptions();
			}
			$('#new_investors_modal').modal('hide');
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			if( errorThrown=='Unauthorized') {
				alert('Ops, session expired!');
				window.location.href = _BASEURL;
			} else {
				alert('Ops! An error occurred...['+errorThrown+']');
			}
		});
	});

  })(jQuery);