$(document).ready(function() {
    // $(".fancybox").fancybox();
});


$(document).on('click', '.tag', function () {
    var $clickedElement = $(this),
        $mainContent = $('.js-main-content'),
        page = $mainContent.data('page'),
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
            tagIds: activeTags,
            page: page
        },
        success: function (response) {
            if (response.status === 'success') {
                $('.js-main-content').html(response.view);
            }
        },
        error: function () {
        }
    });
});

