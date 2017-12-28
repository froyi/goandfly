$(document).ready(function () {
    // $(".fancybox").fancybox();
});


$(document).on('click', '.tag', function () {
    var $clickedElement = $(this),
        $mainContent = $('.js-main-content'),
        page = $mainContent.data('page');

    if ($clickedElement.hasClass('active')) {
        $clickedElement.removeClass('active');
    } else {
        $clickedElement.addClass('active');
    }

    var activeTags = getActiveTags();

    $.ajax({
        type: 'POST',
        url: 'index.php?route=filter-reisen',
        dataType: 'json',
        data: {
            tagIds: activeTags,
            page: page
        },
        success: function (response) {
            if (response.status === 'success') {
                $('.js-main-content').html(response.view);
            }
        }
    });
});

function getActiveTags() {
    var activeTags = [];

    $('.tag.active').each(function () {
        activeTags.push($(this).data('tagId'));
    });

    return activeTags;
}

