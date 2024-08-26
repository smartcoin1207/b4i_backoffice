(function($) {
  "use strict"; // Start of use strict

  function addOption(selectElement, newValue) {
		let selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
		if (!selectedOptions.includes(newValue)) {
			selectedOptions.push(newValue);
		}
		selectElement.value = '';
		selectedOptions.forEach(value => {
			Array.from(selectElement.options).forEach(option => {
				if (option.value === value) {
					option.selected = true;
				}
			});
		});
	}

	function formatDateString(dateString) {
		// Create a Date object from the input value
		var date = new Date(dateString);
		
		// Define options for the formatted date
		var options = { day: '2-digit', month: 'short', year: 'numeric' };
		
		var dateStringPre = date.toLocaleDateString('en-US', options);
		var dateString = dateStringPre.replace(/,/g, '');
		return dateString;
	}

  // Toggle the side navigation
  $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
    if ($(".sidebar").hasClass("toggled")) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
    
    // Toggle the side navigation when window is resized below 480px
    if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
      $("body").addClass("sidebar-toggled");
      $(".sidebar").addClass("toggled");
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

	// Call the dataTables jQuery plugin
	$('#dataTable').DataTable({
		"oLanguage": {
			"sSearch": "Filter"
		}
	});
	
	$('#dataTable-startups').DataTable({
		"oLanguage": {
			"sSearch": "Filter"
		}
	});

	// setTimeout(() => {
		// $('#dataTable').attr('data-order', '[[ 1, "desc" ]]');
	// }, 1000);

	
/*
  var dd_html = '';
	dd_html += '<div class="d-inline-block mr-3" style="border-right: 1px #ddd solid;">';
	dd_html += '	<div class="custom-control custom-checkbox d-inline-block mr-2">';
	dd_html += '		<input type="checkbox" name="acc_track" id="acceleration_track_1" class="custom-control-input" value="Digital tech">';
	dd_html += '		<label class="custom-control-label m-0" for="acceleration_track_1">Digital tech</label>';
	dd_html += '	</div>';
	dd_html += '	<div class="custom-control custom-checkbox d-inline-block mr-2">';
	dd_html += '		<input type="checkbox" name="acc_track" id="acceleration_track_2" class="custom-control-input" value="Made in Italy">';
	dd_html += '		<label class="custom-control-label m-0" for="acceleration_track_2">Made in Italy</label>';
	dd_html += '	</div>';
	dd_html += '	<div class="custom-control custom-checkbox d-inline-block mr-3">';
	dd_html += '		<input type="checkbox" name="acc_track" id="acceleration_track_3" class="custom-control-input" value="Sustainability">';
	dd_html += '		<label class="custom-control-label m-0" for="acceleration_track_3">Sustainability</label>';
	dd_html += '	</div>';
	dd_html += '</div>';	

	var table = $('#dataTable-startups').DataTable({
		fnInitComplete: function(){
			var $row = $('#dataTable-startups_filter').parent().parent();
			$row.find('.col-md-6:first').removeClass('col-md-6').addClass('col-md-4');
			$row.find('.col-md-6').removeClass('col-md-6').addClass('col-md-8');
			$('#dataTable-startups_filter').prepend(dd_html);
		}
	});
	
	$('#acceleration_track_1').on('change', function() {
	  if ($(this).is(':checked')) {
	    $.fn.dataTable.ext.search.push(
	      function(settings, data, dataIndex) {  
	         if( data[5].indexOf('Digital tech')!==-1 ) return true;
	      }
	    )
	  } else {
	    $.fn.dataTable.ext.search.pop();
	  }
	  table.draw();
	});
	
	$('#acceleration_track_2').on('change', function() {
	  if ($(this).is(':checked')) {
	    $.fn.dataTable.ext.search.push(
	      function(settings, data, dataIndex) {  
	         if( data[5].indexOf('Made in Italy')!==-1 ) return true;
	      }
	    )
	  } else {
	    $.fn.dataTable.ext.search.pop();
	  }
	  table.draw();
	});
	
	$('#acceleration_track_3').on('change', function() {
	  if ($(this).is(':checked')) {
	    $.fn.dataTable.ext.search.push(
	      function(settings, data, dataIndex) {  
	         if( data[5].indexOf('Sustainability')!==-1 ) return true;
	      }
	    )
	  } else {
	    $.fn.dataTable.ext.search.pop();
	  }
	  table.draw();
	});
*/
	// Inline editing
	$('.edit').on('click', function() {
		if( !$('#status').prop('checked') ) return false;
		var multi = false;
		var $wrapper = $(this).parent().parent();
		var text = $wrapper.find('.data-value').text();

		if( $wrapper.find('.data-value').hasClass('multi')) {
			multi = text.split(", ");
		} 
		$wrapper.find('.show-data').hide();
		if( !multi ) {
			$wrapper.find('.edit-data input').val(text);
			$wrapper.find('.edit-data textarea').val(text);

			var field = $wrapper.find('.edit-data select').attr('name');
			if(field == 'staged') {
				if(text == 'Series A') {
					text = "SeriesA";
				} else if(text == 'Series B') {
					text = "SeriesB";
				} else if(text == "Series C") {
					text = "SeriesC";
				}
			}
			$wrapper.find('.edit-data select').val(text);

			$wrapper.find('.edit-data select').val(text).select2();
			$('.select2-container').css('width', 'calc(100% - 100px)');
			$('.select2-selection').css('height', 'calc(1.5em + .75rem + 2px)');
			$('.select2-search__field').addClass('form-control');
			$('.select2-results ul').css('max-height', '400px'); 

			setTimeout(function(){
				$wrapper.find('.edit-data input').focus();
				$wrapper.find('.edit-data select').focus();
			}, 20);
		} else {
			if($wrapper.find('.edit-data select').attr('name') == 'investor_ids[]'){
				const multiSelect = document.getElementById('investor_ids');
				multi.forEach(function(item) {
					addOption(multiSelect, item);
				});
				multiSelect.loadOptions();
			} else {
				multi.forEach(function(item){
					$wrapper.find('.edit-data input[value="'+item+'"]').prop('checked', 1);
				});
			}			
		}
		$wrapper.find('.edit-data').fadeIn();
	});
	
	$('.cancel').on('click', function() {
		if( !$('#status').prop('checked') ) return false;
		var $wrapper = $(this).parent().parent();
		cancelEditing($wrapper)
	});
	
	$('.save').on('click', function() {
		if( !$('#status').prop('checked') ) return false;
		var $wrapper = $(this).parent().parent();
		saveData($wrapper);
	});
	
	$(".table-form input[type='text'], .table-form input[type='date'], .table-form select").on('keyup', function (e) {
		if( !$('#status').prop('checked') ) return false;
		if( e.key==='Enter' || e.keyCode===13 || e.key==='Escape' || e.keyCode===27 ) {
			var $wrapper = $(this).parent().parent();
			if( e.key==='Enter' || e.keyCode===13 ) saveData($wrapper);
			if( e.key==='Escape' || e.keyCode===27 ) cancelEditing($wrapper);
		}
	});
	
	function cancelEditing($wrapper) {
		$wrapper.find('.edit-data').hide();
		$wrapper.find('.show-data').fadeIn();
	}
	
	function saveData($wrapper) {
		var setFlag = 0;
		var replace = 0;
		if($wrapper.find(".edit-data select").attr("name") == "investor_ids[]") {
			var text = $wrapper.find('.edit-data select').val();
			var field = "investor_ids";
		} else if( $wrapper.find('.edit-data input[type="checkbox"]').length > 0  ) {
			var text = '';
			var replace = 1;
			$wrapper.find('.edit-data input[type="checkbox"]:checked').each(function() {
				text += $(this).val() + ', ';
			});
			text = text.slice(0, -2);
			var field = $wrapper.find('.edit-data input[type="checkbox"]').attr('name');
			field = field.replace('[]', '');
		} else {
			var text = $wrapper.find('.edit-data input').val();
			var field = $wrapper.find('.edit-data input').attr('name');
		}
		if( text==undefined) {
			text = $wrapper.find('.edit-data select').val();
			
			if( $wrapper.find('.edit-data select').attr('name')=='startup_country' || $wrapper.find('.edit-data select').attr('name')=='company_country' || $wrapper.find('.edit-data select').attr('name')=='nationality') setFlag = 1;
			var field = $wrapper.find('.edit-data select').attr('name');
		} 

		if( text==undefined) {
			text = $wrapper.find('.edit-data textarea').val();
			
			var field = $wrapper.find('.edit-data textarea').attr('name');
		} 

		if( field==='sustainability' && text==null ) {
			alert('Please select a value');
			return false;
		}

		if(field == "startup_id") {
			var label = $wrapper.find('.edit-data select option:selected').text();
			$wrapper.find(".text-value").text(label);
		}

		$wrapper.find('.data-value').text(text);
		$wrapper.find('.text-value').text(text);

		if(field == 'staged') {
			if(text == 'SeriesA') {
				$wrapper.find(".data-value").text("Series A");
			} else if(text =='SeriesB') {
				$wrapper.find(".data-value").text("Series B");
			} else if(text == 'SeriesC') {
				$wrapper.find(".data-value").text("Series C");
			}
		} 

		if(field == "startup_id") {
			var label = $wrapper.find('.edit-data select option:selected').text();
			var oldURL = $wrapper.find("a.text-value").attr("href");
			var newURL = oldURL.replace(/\/\d+\//, '/' + text + '/');
			var dataBatch = $wrapper.find('.edit-data select option:selected').data("batch");
			var batchNumber = dataBatch.replace(/\D/g, "");

			$wrapper.find(".text-value").text(label);
			$wrapper.find("a.text-value").attr("href", newURL);
			$("span.call_name.data-value").text(batchNumber);
		}

		if(field == 'investor_ids') {
			const selectElement = document.getElementById('investor_ids');
            const selectedOptions = Array.from(selectElement.selectedOptions);
            const selectedTexts = selectedOptions.map(option => option.text).join(', ');
			$wrapper.find('.text-value').text(selectedTexts);
		}

		if(field == "announced_date") {
			var announcedDate = new Date(text);
			$("span.announced_date_year.data-value").text(announcedDate.getFullYear());
			$wrapper.find('.text-value').text(formatDateString(text));
		}

		$wrapper.find('.edit-data').hide();
		if( setFlag ) {
			var $img = $wrapper.find('img');
			console.log($img.attr('src') );
			var newPath = $wrapper.find('img').attr('data-src') + text + '.svg';
			$img.attr('src', newPath).attr('title', text);
		}
		if(field == "investor_ids") {
			const textString = text.map(item => `{${item}}`).join('');
			text = textString;
		} else if( replace ) {
			text = text.replaceAll(', ', ' | ');
		}

		// post data to save
		$.ajax({
			url:  _BASEURL+'save/',
			type: 'POST',
			data: {
				id: _ID,
				type: _TYPE,
				field: field,
				data: text
			},
			datatype: 'json'
		})
		.done(function(data, status) {
			if( data!='OK' ) alert('Ops! An error occurred\n['+data+']');
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			if( errorThrown=='Unauthorized') {
				alert('Ops, session expired!');
				window.location.href = _BASEURL;
			} else {
				alert('Ops! An error occurred...['+errorThrown+']');
			}
		});
		// end
		$wrapper.find('.show-data').fadeIn();
	}

	// GRANT
	$('#grant-now').on('click', function(e) {
		e.preventDefault();
		if( !$('#status').prop('checked') ) return false;
		$(this).hide();
		var $wrapper = $(this).parent();
		$wrapper.find('.edit-data').show();
	});
	
	$('#cancel-grant').on('click', function(e) {
		e.preventDefault();
		if( !$('#status').prop('checked') ) return false;
		var $wrapper = $(this).parent().parent();
		$wrapper.find('.edit-data').hide();
		$wrapper.find('#grant-now').show();
	});
	
	$('#save-grant').on('click', function(e) {
		e.preventDefault();
		if( !$('#status').prop('checked') ) return false;
		if( $('#grant_application').val()=='' || $('#grant_application').val()==null ) {
			alert('Please select a grant');
			return false;
		}
		var $wrapper = $(this).parent().parent();
		$wrapper.find('.edit-data').hide();
		$wrapper.find('.spinner-border').show();
		// post data to save
		$.ajax({
			url:  _BASEURL+'save-grant/',
			type: 'POST',
			data: {
				id: _ID,
				type: _TYPE,
				grant: $('#grant_application').val()
			},
			datatype: 'json'
		})
		.done(function(data, status) {
			$wrapper.find('.spinner-border').hide();
			if( data!='OK' ) {
				alert('Ops! An error occurred\n['+data+']');
			} else {
				$wrapper.html('<b class="text-primary mr-2">🎉 '+$('#grant_application').val().toUpperCase() +' 🎉</b>');
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			$wrapper.find('.spinner-border').hide();
			if( errorThrown=='Unauthorized') {
				alert('Ops, session expired!');
				window.location.href = _BASEURL;
			} else {
				alert('Ops! An error occurred...['+errorThrown+']');
			}
		});
	});
	
	// STATUS
	var status;
	
	$('#status').on('click', function() {
		status = $('#status').prop('checked');
		if( status==1 ) status='1';
		else status='0';
		$('#change-status-modal').modal({backdrop: 'static'},'show');
	});
	
	$('#btn-dismiss-modal').on('click', function() {
		var checked=1;
		if( status=='1' ) checked=0;
		$('#status').prop('checked', checked);
	});
	
	$('#btn-confirm-modal').on('click', function() {
		// post data to save
		$.ajax({
			url:  _BASEURL+'save-status/',
			type: 'POST',
			data: {
				id: _ID,
				type: _TYPE,
				status: status
			},
			datatype: 'json'
		})
		.done(function(data) {
			if( data!='OK' ) {
				alert('Ops! An error occurred\n['+data+']');
			} else {
				var opacity=.5;
				if( status=='1' ) opacity=1;
				$('#card-body').css('opacity', opacity);
			}
			$('#change-status-modal').modal('hide');
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
	
	// EXPORT
	$("#export").on('click', function(e) {
		e.preventDefault();
		var URL = $(this).attr('href');
		if( URL.indexOf('?')==-1 ) URL+='?';
		var q = $('input[type="search"]').val();
		if( q ) URL += '&q='+q;
		URL+='&action=export';
		/*
		if( $('#acceleration_track_1').prop('checked') ) URL += '&acceleration_track_1='+$('#acceleration_track_1').val();
		if( $('#acceleration_track_2').prop('checked') ) URL += '&acceleration_track_2='+$('#acceleration_track_2').val();
		if( $('#acceleration_track_3').prop('checked') ) URL += '&acceleration_track_3='+$('#acceleration_track_3').val();
		*/
		window.location.href = URL;
	});
	
	// SEARCH TOGGLE
	$("#search").on("click", function(e) {
		e.preventDefault();
		$('#search_form').slideToggle(50);
	});
	
	// CHECKBOX STATUS LISTENER
	$(document).on('change', '#startups-list input[name="status[]"]', function() {
		let list = $('#startups-list').serializeArray();
		list.shift();
		if( list[0].name=="set_all" ) list.shift();
		console.log('list', list);
		if( list.length==0 ) $('#change-status').hide();
		else $('#change-status').show();
		if( list.length==0 ) $('#set-all').prop('checked', 0);
	});
	
	$(document).on('change', '#founders-list input[name="status[]"]', function() {
		let list = $('#founders-list').serializeArray();
		list.shift();
		if( list[0].name=="set_all" ) list.shift();
		console.log('list', list);
		if( list.length==0 ) $('#change-status').hide();
		else $('#change-status').show();
		if( list.length==0 ) $('#set-all').prop('checked', 0);
	});
	
	// SET ALL
	$(document).on('change', '#set-all', function() {
		if( $(this).prop('checked') ) {
			$('#startups-list input[name="status[]"]').prop('checked', 1);
			$('#change-status').show();
		} else {
			$('#startups-list input[name="status[]"]').prop('checked', 0);
			$('#change-status').hide();
		}
	});
	
	$(document).on('change', '#set-all', function() {
		if( $(this).prop('checked') ) {
			$('#founders-list input[name="status[]"]').prop('checked', 1);
			$('#change-status').show();
		} else {
			$('#founders-list input[name="status[]"]').prop('checked', 0);
			$('#change-status').hide();
		}
	});
	
	// APPEND STATUS CONTROL
	$('#dataTable-startups_length label').after('<a href="#status" class="ml-5" id="change-status" style="display:none;"><i class="fas fa-toggle-off mr-2"></i>Change status</a>');
	$('#dataTable_length label').after('<a href="#status" class="ml-5" id="change-status" style="display:none;"><i class="fas fa-toggle-off mr-2"></i>Change status</a>');

	var checkbox_html = '<div class="accleration-type-checkbox-group row">';
	
	checkbox_html += '<div class="col-md-6 custom-flex"><input type="checkbox" id="acceleration_type_pre_acceleration" name="acceleration_type_check[]" value="Pre-acceleration" checked> <label for="acceleration_type_pre_acceleration" >Pre-Acceleration</label></div>';

	checkbox_html += '<div class="col-md-6 custom-flex"><input type="checkbox" id="acceleration_type_acceleration" name="acceleration_type_check[]" value="Acceleration" checked> <label for="acceleration_type_acceleration" >Acceleration</label></div>';

	checkbox_html += '</div>';
	
	$('#dataTable_filter').parent().before(checkbox_html);
	$('#dataTable_filter').parent().parent().find('.col-sm-12.col-md-6').removeClass('col-md-6').addClass('col-md-4');
	$('#dataTable_filter').parent().parent().find('.accleration-type-checkbox-group').removeClass('col-md-6').addClass('col-sm-12').addClass('col-md-4');


	$(document).ready(function() {
		// Function to filter table rows based on checkbox values
		function filterTable() {
			// Get all checked checkboxes
			var selectedValues = $('input[name="acceleration_type_check[]"]:checked').map(function() {
				return this.value;
			}).get();
			
			// Filter rows
			$('#dataTable').DataTable().rows().every(function() {
				var data = this.data();
				var accelerationType = data[Object.keys(data).length - 1];
				var showRow = false; // Show all rows if no checkboxes are selected
				showRow = selectedValues.length == 2 ? true : false;
				if(!showRow) {
					showRow = selectedValues.some(function(value) {
						return accelerationType === value;
					});
				}
				
				$(this.node()).toggle(showRow);
			});
			
			// Redraw table to apply the filter
			$('#dataTable').DataTable().draw();
		}
		
		// Attach the filter function to the checkbox change event
		$('input[name="acceleration_type_check[]"]').on('change', function() {
			filterTable();
		});
	});
	

	// CHANGE STATUS
	$(document).on('click', '#change-status', function(e) {
		e.preventDefault();
		var list = [];
		if( $('#startups-list').length ) {
			list = $('#startups-list').serializeArray();
		} else {
			list = $('#founders-list').serializeArray();
		}
		list.shift();
		if( list[0].name=="set_all" ) list.shift();
		let action = "inactive";
		if( $('#startups-list input[name="status[]"]:checked').first().attr('data-status')=='0' ) action = 'active';
		if( $('#founders-list input[name="status[]"]:checked').first().attr('data-status')=='0' ) action = 'active';
		$('#status-label').text(action);
		if( $('#startups-list').length ) {
			$('#list-items').text(list.length + ' startup' + (list.length>1 ? 's': ''));
		} else {
			$('#list-items').text(list.length + ' founder' + (list.length>1 ? 's': ''));
		}
		$('#multi-change-status-modal').modal({backdrop: 'static'},'show');
	});
	
	$('#btn-confirm-change').on('click', function() {
		var list = [];
		if( $('#startups-list').length ) {
			list = $('#startups-list').serializeArray();
			list.shift();
			status = '0';
			if( $('#startups-list input[name="status[]"]:checked').first().attr('data-status')=='0' ) status = '1';
		} else {
			list = $('#founders-list').serializeArray();
			list.shift();
			status = '0';
			if( $('#founders-list input[name="status[]"]:checked').first().attr('data-status')=='0' ) status = '1';
		}
		// post data to save
		$.ajax({
			url:  _BASEURL+'save-status-multi/',
			type: 'POST',
			data: {
				ids: list,
				type: _TYPE,
				status: status
			},
			datatype: 'json'
		})
		.done(function(data) {
			if( data!='OK' ) {
				alert('Ops! An error occurred\n['+data+']');
			} else {
				var opacity=.5;
				if( status=='1' ) opacity=1;
				if( $('#startups-list').length ) {
					$('#startups-list input[name="status[]"]:checked').prop('checked',false).attr('data-status',status).closest('tr').css('opacity', opacity);
				} else {
					$('#founders-list input[name="status[]"]:checked').prop('checked',false).attr('data-status',status).closest('tr').css('opacity', opacity);
				}
				$('#change-status').hide();
				$('#set-all').prop('checked', 0);
			}
			$('#multi-change-status-modal').modal('hide');
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
	
})(jQuery); // End of use strict
