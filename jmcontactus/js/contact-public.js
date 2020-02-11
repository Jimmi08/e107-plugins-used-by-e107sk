$(document).ready(function() {
	if (typeof $.fn.datepicker === "function") {
		$(".js-datepicker").datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			orientation: "top left"
		});
	}
});
