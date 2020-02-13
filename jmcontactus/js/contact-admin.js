$(document).ready(function() {

	// Ajax ////////////////////////////////

	function ADMINajax(data, callback){		
		$.post("ajax.php", data, function(response) {
			$.bootstrapGrowl(response, {type: 'success'});
		});
	}

	// Feild Multipler /////////////////////

	$(document).on('click', '#add_fields', function(){
		$('.emailto_email:last').clone().appendTo('.additionalfields');
		$('.emailto_email:not(:first) button').removeAttr('disabled');	
	});

	// Feild Deletor ///////////////////////
	
	$(document).on('click', '.delete_field', function(){
		if($('.emailto_email').length != 1) {
			$(this).parent().remove();
		}
	});
	
	// Drag to Order ///////////////////////
	
	if (typeof $.fn.sortable === "function") {
		$('#order_container').sortable({
			handle : '.move_item',
			update : function () {
				var order = $('#order_container').sortable('serialize');
				ADMINajax({func: 'ORDERitems', itemorder: order});
			}
		});
	}
	
	// Delete Field ////////////////////////
	
	$(document).on('click', '.item_delete', function() {
		var field = $(this);
		var id = $(this).attr('id');
		
		$('#modal-form-delete').modal('show');
		
		$('#modal-form-delete').on('click', '.btn-danger', function() {
			$(field).closest('tr').fadeOut('slow');
			ADMINajax({func : 'DELETEitem', sID: id});
			$('#modal-form-delete').modal('hide');
		});
	});
	
	// Delete Message //////////////////////
	
	$(document).on('click', '.message_delete', function() {
		var message = $(this);
		var id = $(this).attr('id');
		
		$('#modal-message-delete').modal('show');
		
		$('#modal-message-delete').on('click.messageDelete', '.btn-danger', function() {
			$(message).closest('tr').fadeOut('slow');
			ADMINajax({func : 'DELETEmessage', sID: id});
			$('#modal-message-delete').modal('hide');
		});
	});
	
	$('#modal-message-delete').on('hidden.bs.modal', function (e) {
		$('#modal-message-delete').off('click.messageDelete');
	})
	
	// Address Auto-Complete ///////////////
	
	if (typeof google === 'object' && typeof google.maps === 'object') {
	
		var autocomplete;
	
		function initialize() {
			// Create the autocomplete object, restricting the search
			// to geographical location types.
			autocomplete = new google.maps.places.Autocomplete(
				/** @type {HTMLInputElement} */
				(document.getElementById('jmcontactus-googlemap')), {
					types: ['geocode']
				});
		}
		
		// Bias the autocomplete object to the user's geographical location,
		// as supplied by the browser's 'navigator.geolocation' object.
		function geolocate() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {
					var geolocation = new google.maps.LatLng(
						position.coords.latitude, position.coords.longitude);
					autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
						geolocation));
				});
			}
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
	}
				
});
