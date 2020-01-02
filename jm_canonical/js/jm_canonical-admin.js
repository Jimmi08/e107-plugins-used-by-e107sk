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
	$(document).on('click', '.delete_canurl', function() {
	  var field = $(this);
    var id = $(this).attr('tableid');
    var table = $(this).attr('table');   
    $('#modal-canurl-delete').modal('show');
    
		$('#modal-canurl-delete').on('click', '.btn-danger', function() { 
			ADMINajax({func : 'DELETEcanurl', sID: id, sTable:table });
			$('#modal-canurl-delete').modal('hide');
   /*   window.location.reload() ;    */
		});    
    
	});
 
 
	// Create URL //////////////////////// 
	$(document).on('click', '.create_canurl', function() {
	  var field = $(this);
    var id = $(this).attr('tableid');
    var table = $(this).attr('table');   
		ADMINajax({func : 'CREATEcanurl', sID: id, sTable:table });       
   /* window.location.reload() ;    */
	});
  
	// Create URL //////////////////////// 
	$(document).on('click', '#generate_canurl', function() {
	  var field = $(this);
    var table = $(this).attr('table');     
    var idName = $(this).attr('idName');
		ADMINajax({func : 'GENERATEcanurl',  sIdName: idName, sTable:table });       
   /* window.location.reload() ;    */
	});  
  
	// Create URL //////////////////////// 
	$(document).on('click', '#deleteall_canurl', function() {
	  var field = $(this);
    var table = $(this).attr('table');     
    var idName = $(this).attr('idName');
		ADMINajax({func : 'DELETEALLcanurl',  sIdName: idName, sTable:table });       
   /* window.location.reload() ;    */
	});  
  
  // Move old redirection data to aredirection plugin
	$(document).on('click', '.move_toredirection', function() {
	  var field = $(this);
    var id = $(this).attr('tableid');
    var table = $(this).attr('table');   
		ADMINajax({func : 'MOVEtoredirection', sID: id, sTable:table });       
   /* window.location.reload() ;    */
	}); 
  
	// Delete URL //////////////////////// 
	$(document).on('click', '#moveall_toredirection', function() {
	  var field = $(this);
    var idName = $(this).attr('idname');
    var table = $(this).attr('table');  
 
    ADMINajax({func : 'MOVEALLcanurl',  sIdName: idName, sTable:table });   
	});
  
      
});
