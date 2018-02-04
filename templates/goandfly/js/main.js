$(document).on('click', '.tag', function () {
    var $clickedElement = $(this),
        $mainContent = $('.js-main-content'),
        page = $mainContent.data('page');

    if ($clickedElement.hasClass('active')) {
        $clickedElement.removeClass('active');
    } else {
        $clickedElement.addClass('active');
    }

    handleAngebote(page);
});

$(document).on('click', '#menueBig', function () {
    $("#navigationBig").fadeToggle(500);
});

function handleAngebote(page, regionId) {
    var activeTags = getActiveTags();

    $.ajax({
        type: 'POST',
        url: 'index.php?route=filter-reisen',
        dataType: 'json',
        data: {
            tagIds: activeTags,
            page: page,
            regionId: regionId
        },
        success: function (response) {
            if (response.status === 'success') {
                $('.js-main-content').html(response.view);
            }
        }
    });
}

$(document).on('click', '.continent', function () {
    var $continent = $(this),
        actualContinentId = $continent.data('continentId'),
        $regionenAusgabe = $('#regionenAusgabe'),
        $mainContent = $('.js-main-content'),
        page = $mainContent.data('page');

    $regionenAusgabe.html('');

    var activeTags = getActiveTags();

    $.ajax({
        type: 'POST',
        url: 'index.php?route=navigation-regions',
        dataType: 'json',
        data: {
            continentId: actualContinentId,
            tagIds: activeTags,
            page: page
        },
        success: function (response) {
            if (response.status === 'success') {
                $regionenAusgabe.html(response.view);

                $('.continent').removeClass('active');
                $continent.addClass('active');
            }
        }
    });
});

$(document).on('mouseover', '.js-region', function () {
    var $thisElement = $(this),
        regionBild = $thisElement.data('regionBild'),
        regionBeschreibung = $thisElement.data('regionBeschreibung');

    $('#navigationBild').attr('src', regionBild);
    $('#kontinentInformation').html(regionBeschreibung);
});

$(document).on('click', '.js-region', function () {
    var $thisElement = $(this),
        $mainContent = $('.js-main-content'),
        regionId = $thisElement.data('regionId');

    if ($mainContent.data('page') !== 'home') {
        $(location).attr('href', 'index.php?route=index&regionId=' + regionId);
    } else {
        handleAngebote($mainContent.data('page'), regionId);

        $('#menueBig').trigger('click');
    }
});

$(document).on('mouseover', '.continent', function () {
    $('#world_map').attr('src', $(this).data('continentBild'));
});

function getActiveTags() {
    var activeTags = [];

    $('.tag.active').each(function () {
        activeTags.push($(this).data('tagId'));
    });

    return activeTags;
}

$(document).on('click', '.js-create-reise', function () {
    $('#erstelleReiseContainer').fadeToggle(500);
});

$(document).on('click', '.js-create-neuigkeiten', function () {
    $('#erstelleNeuigkeitenContainer').fadeToggle(500);
});

$(document).on('submit', '#bearbeiteNeuigkeitForm', function (event) {
    event.preventDefault();

    var neuigkeitenId = $(this).find('.holeNeuigkeiten').val(),
        $bearbeiteNeuigkeitenContainer = $('.js-bearbeite-neuigkeiten');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-bearbeite-neuigkeiten',
        dataType: 'json',
        data: {
            newsId: neuigkeitenId
        },
        success: function (response) {
            if (response.status === 'success') {
                $bearbeiteNeuigkeitenContainer.html(response.view);
            }
        }
    });
});

$(document).on('submit', '.hole-reise', function (event) {
    event.preventDefault();

    var reiseIdData = $(this).find('.js-hole-reisedaten-select').val(),
        $bearbeiteReiseContainer = $('.js-bearbeite-reise');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-bearbeite-reise',
        dataType: 'json',
        data: {
            reiseId: reiseIdData
        },
        success: function (response) {
            if (response.status === 'success') {
                $bearbeiteReiseContainer.html(response.view);
                CKEDITOR.replace('ReiseEditorCKE');
                CKEDITOR.replace('editorCKE3');
            }
        }
    });
});

$(document).ready(function () {
    CKEDITOR.replace('editorCKE');
});


$(document).on('submit', '.js-erstelle-frage', function (event) {
    event.preventDefault();

    var $this = $(this),
        reiseIdData = $this.find('.js-reiseId').val(),
        $frageStatus = $('.js-erstelle-frage-status'),
        $frage = $this.find('.js-frage'),
        $antwort = $this.find('.js-antwort');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-erstelle-frage',
        dataType: 'json',
        data: {
            reiseId: reiseIdData,
            frage: $frage.val(),
            antwort: $antwort.val()
        },
        success: function (response) {
            if (response.status === 'success') {
                $frageStatus.html('Die Frage wurde gespeichert.');
                $frage.val('');
                $antwort.val('');

            } else {
                $frageStatus.html('Die Frage konnte nicht gespeichert werden');
            }
        },
        error: function(response) {
            $frageStatus.html('Die Frage konnte nicht gespeichert werden');
        }
    });
});

$(document).on('submit')


