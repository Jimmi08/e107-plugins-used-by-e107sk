(function ($) {
    $(document).ready(function () {
        $('.truncated').hide()
            .after('<i class="fas fa-plus-circle" aria-hidden="true"></i>')
            .next().on('click', function () {
                $(this).toggleClass('fas fas fa-minus-circle').prev().toggle();
            });
    });
})(jQuery);
