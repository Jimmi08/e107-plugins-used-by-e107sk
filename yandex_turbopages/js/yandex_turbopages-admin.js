$(document).ready(function() {

	// Ajax ////////////////////////////////
  
	function ADMINajax(data, callback){		
 
		$.post("ajax.php", data, function(response) {
     
      localStorage.setItem("swal",
                              $.notify(response, { 
      type: 'success' 
      }) 
                        );
                        location.reload();
                        localStorage.getItem("swal");
		 
      
    	});
	}; 
  
  
 
	// Delete URL //////////////////////// 
	$(document).on('click', '.remove_turbopage', function() {
	  var field = $(this);
    var id = $(this).attr('tableid');
    var table = $(this).attr('table');   
    $('#modal-canurl-delete').modal('show');
    
		$('#modal-canurl-delete').on('click', '.btn-danger', function() { 
			ADMINajax({func : 'REMOVE_turbopage', sID: id, sTable:table });
			$('#modal-canurl-delete').modal('hide');
   /*   window.location.reload() ;    */
		});    
    
	});
 
 
	// Create URL //////////////////////// 
	$(document).on('click', '.add_turbopage', function() {
	  var field = $(this);
    var id = $(this).attr('tableid');
    var table = $(this).attr('table');   
		ADMINajax({func : 'ADD_turbopage', sID: id, sTable:table });       
   /* window.location.reload() ;    */
	});
  
	// Create URL //////////////////////// 
	$(document).on('click', '#addall_ytp', function() {
	  var field = $(this);
    var table = $(this).attr('table');     
    var idName = $(this).attr('idName');
		ADMINajax({func : 'GENERATEall_ytp',  sIdName: idName, sTable:table });       
   /* window.location.reload() ;    */
	});  
  
	// Create URL //////////////////////// 
	$(document).on('click', '#deleteall_ytp', function() {
	  var field = $(this);
    var table = $(this).attr('table');     
    var idName = $(this).attr('idName');
		ADMINajax({func : 'DELETEall_ytp',  sIdName: idName, sTable:table });       
   /* window.location.reload() ;    */
	});  
});
