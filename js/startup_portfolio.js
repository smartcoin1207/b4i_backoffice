(function($) {
    "use strict"; // Start of use strict 

    function convertToNumber(formattedNumber) {
        // Remove commas from the string
        const cleanedNumberString = formattedNumber.replace(/./g, '');
        
        // Convert the cleaned string to a number
        const number = Number(cleanedNumberString);
        
        return number;
    }

    $('.startup_select').select2();
    $('.select2-container').css('width', 'calc(100%)');
    $('.select2-selection').css('height', 'calc(1.5em + .75rem + 2px)');
    $('.select2-search__field').addClass('form-control');
    $('.select2-results ul').css('max-height', '400px');

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
            raisedValue = convertToNumber(raisedValue);
            if (isNaN(raisedValue) || raisedValue === "") {
                $("input[name='raised']").after("<div class='validation-message text-danger'>Please enter a valid number for the Raised field.</div>");
                return;
            }
    
            var selectedStartups = $('#investor_ids').val();
            console.log(selectedStartups);
    
            // If all validations pass, submit the form
            $("#startup_portfolio_form").submit();
        });

        $('#delete_startup_btn').on('click', function() {
            var startupPortofolioId = $(this).data('id');

            // Confirm the action with the user
            if (confirm('Are you sure you want to delete this entry?')) {
                // User confirmed, proceed with AJAX request
                $.ajax({
                    url:  _BASEURL+'startup_portfolio/', // Change this to your server-side script
                    type: 'POST',
                    data: { 
                        cmd: 'delete_startup',
                        id: startupPortofolioId 
                    },
                    success: function(response) {
                        window.location.href = _BASEURL +  'startup_portfolios';
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting the entry.');
                    }
                });
            } else {
                // User canceled, do nothing
                alert('Deletion canceled.');
            }
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
                    newOption.selected = true;
                    
                    investorSelect.add(newOption);
                    investorSelect.loadOptions();
                    $('input[name="new_investor"]').val('');
                    $("#btn-save-investor").css("display", "none");
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

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('raisedInput');

        // Format number with periods
        function formatNumber(value) {
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Use regex to insert periods
        }

        // Remove periods for plain number
        function unformatNumber(value) {
            return value.replace(/\./g, ''); // Remove periods
        }

        // Event handler for formatting input
        input.addEventListener('input', function(e) {
            // Remove non-numeric characters
            let value = e.target.value.replace(/[^0-9]/g, '');

            // Format value and set it back to the input
            e.target.value = formatNumber(value);
        });
    });
  })(jQuery);