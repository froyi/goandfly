$(document).on('click', '.tag', function () {
    var $clickedElement = $(this),
        activeTags = [];

    if ($clickedElement.hasClass('active')) {
        $clickedElement.removeClass('active');
    } else {
        $clickedElement.addClass('active');
    }

    $('.tag.active').each(function() {
       activeTags.push($(this).data('tagId'));
    });

    $.ajax({
        type: 'POST',
        url: 'index.php?route=filter-reisen',
        dataType: 'json',
        data: {
            tagIds: activeTags
        },
        success: function () {
            debugger;
        },
        error: function () {
            debugger;
        }
    });

});