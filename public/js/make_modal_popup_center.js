//General code needed make the modal popup vertically center
function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height()-$dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

$(document).ready(function(){
    $('.modal').on('show.bs.modal', centerModal);
});


$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});