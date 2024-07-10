(function($) {
    "use strict"; // Start of use strict 

    

    setTimeout(() => {
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
                    if(dataObj.status == 'error') {
                        alert(dataObj.message);
                    } else {
                        alert('Ops! An error occurred');
                    }
                } else {
                    let investorSelect = document.getElementById('investor_ids');
                    let newOption = document.createElement('option');
                    newOption.value = dataObj.id;
                    newOption.text = dataObj.name;
                    
                    investorSelect.add(newOption);
                    investorSelect.loadOptions();
                    $('input[name="new_investor"]').val('');
                }
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
    
        $('select[name="startup_id"]').on('change', function() {
            // Get the selected option
            var selectedOption = $(this).find('option:selected');
            
            // Get the data-batch attribute value
            var dataBatch = selectedOption.data('batch');
            
            console.log('Batch:', dataBatch);
            const batchNumber = dataBatch.replace(/\D/g, "");
            $("#batch_number").text(batchNumber);
        });
    
        $('#announced_date').on('change', function() {
            // Get the selected date
            var selectedDate = $(this).val();
            
            // Check if a date is selected
            if (selectedDate) {
                // Extract the year from the date
                var year = new Date(selectedDate).getFullYear();
                
                // Update the ID of the target element
                $('.announced_date_year').text(year);
            } else {
                console.error('No date selected.');
            }
        });
    }, 1000);
  })(jQuery);