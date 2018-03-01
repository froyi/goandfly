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

                $('.js-reise-remove').remove();
                if (typeof response.regionRemove !== 'undefined') {
                    $('.js-teaser').prepend(response.regionRemove);
                }
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

    if ($('.hole-reise .js-hole-reisedaten-select').val() !== 0) {
        $('.hole-reise').submit();
        $('html, body').animate({
            scrollTop: $('.js-bearbeite-reise').offset().top
        }, 2000);
    }
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
        error: function() {
            $frageStatus.html('Die Frage konnte nicht gespeichert werden');
        }
    });
});

$(document).on('submit', '.js-bearbeite-frage', function (event) {
    event.preventDefault();

    var frageId = $('.js-frage-liste').val(),
        $bearbeiteFrageContainer = $('.js-bearbeite-frage-container');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-bearbeite-frage',
        dataType: 'json',
        data: {
            frageId: frageId
        },
        success: function (response) {
                $bearbeiteFrageContainer.html(response.view);
        },
        error: function() {
            $bearbeiteFrageContainer.html('Die Frage konnte nicht gefunden werden.');
        }
    });
});


$(document).on('submit', '.js-erstelle-leistungen', function (event) {
    event.preventDefault();

    var $this = $(this),
        reiseDataId = $this.find('.js-reiseId').val(),
        leistungenData = $this.find('#editorCKE3').val(),
        leistungIdData = $this.find('.js-leistungId').val(),
        $statusContainer = $('.js-erstelle-leistung-status');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-erstelle-leistungen',
        dataType: 'json',
        data: {
            reiseId: reiseDataId,
            text: leistungenData,
            leistungId: leistungIdData
        },
        success: function () {
            $statusContainer.html('Die Leistung wurde erfolgreich gespeichert.');
        },
        error: function() {
            $statusContainer.html('Die Leistung konnte nicht gespeichert werden werden.');
        }
    });
});

$(document).on('submit', '.js-erstelle-reiseverlauf', function (event) {
    event.preventDefault();

    var $this = $(this),
        reiseDataId = $this.find('.js-reiseId').val(),
        verlaufReisetag = $this.find('.js-reisetag'),
        verlaufTitel = $this.find('.js-titel'),
        verlaufBeschreibung = $this.find('.js-beschreibung'),
        $statusContainer = $('.js-erstelle-reiseverlauf-status');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-erstelle-reiseverlauf',
        dataType: 'json',
        data: {
            reiseId: reiseDataId,
            reisetag: verlaufReisetag.val(),
            titel: verlaufTitel.val(),
            beschreibung: verlaufBeschreibung.val()
        },
        success: function () {
            $statusContainer.html('Der Verlauf wurde erfolgreich gespeichert.');
            verlaufReisetag.val('');
            verlaufTitel.val('');
            verlaufBeschreibung.val('');
        },
        error: function() {
            $statusContainer.html('Der Verlauf konnte nicht gespeichert werden werden.');
        }
    });
});

$(document).on('submit', '.js-bearbeite-reiseverlauf', function (event) {
    event.preventDefault();

    var reiseverlaufIdData = $('.js-verlaufliste').val(),
        $bearbeiteReiseverlaufContainer = $('.js-bearbeite-reiseverlauf-container');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-bearbeite-reiseverlauf',
        dataType: 'json',
        data: {
            reiseverlaufId: reiseverlaufIdData
        },
        success: function (response) {
            $bearbeiteReiseverlaufContainer.html(response.view);
        },
        error: function() {
            $bearbeiteReiseverlaufContainer.html('Der Reiseverlauf konnte nicht gefunden werden.');
        }
    });
});

$(document).on('submit', '.js-erstelle-reisetermin', function (event) {
    event.preventDefault();

    var $this = $(this),
        reiseDataId = $this.find('.js-reiseId').val(),
        reiseTerminStart = $this.find('.js-start'),
        reiseTerminEnde = $this.find('.js-ende'),
        reiseTerminPreis = $this.find('.js-preis'),
        $statusContainer = $('.js-erstelle-reisetermin-status');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-erstelle-reisetermin',
        dataType: 'json',
        data: {
            reiseId: reiseDataId,
            start: reiseTerminStart.val(),
            ende: reiseTerminEnde.val(),
            preis: reiseTerminPreis.val()
        },
        success: function () {
            $statusContainer.html('Der Reisetermin wurde erfolgreich gespeichert.');
            reiseTerminStart.val('');
            reiseTerminEnde.val('');
            reiseTerminPreis.val('');
        },
        error: function() {
            $statusContainer.html('Der Reisetermin konnte nicht gespeichert werden werden.');
        }
    });
});

$(document).on('submit', '.js-bearbeite-reisetermin', function (event) {
    event.preventDefault();

    var reiseterminIdData = $('.js-termine-liste').val(),
        $bearbeiteTerminContainer = $('.js-bearbeite-reisetermin-container');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-bearbeite-termin',
        dataType: 'json',
        data: {
            terminId: reiseterminIdData
        },
        success: function (response) {
            $bearbeiteTerminContainer.html(response.view);
        },
        error: function() {
            $bearbeiteTerminContainer.html('Der Termin konnte nicht gefunden werden.');
        }
    });
});

$(document).on('submit', '.js-erstelle-reisetags', function (event) {
    event.preventDefault();

    var $this = $(this),
        reiseDataId = $this.find('.js-reiseId').val(),
        tagData = $this.find('.js-tag-auswahl').val(),
        $statusContainer = $('.js-erstelle-tag-status');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=ajax-erstelle-tag',
        dataType: 'json',
        data: {
            reiseId: reiseDataId,
            tagIds: tagData
        },
        success: function () {
            $statusContainer.html('Die Tags wurden erfolgreich gespeichert.');
        },
        error: function() {
            $statusContainer.html('Die Tags konnte nicht gespeichert werden werden.');
        }
    });
});
