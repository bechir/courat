jQuery(function ($) {
    const alerts = $(".alert.alert-dismissable");
    alerts.addClass('show');

    setTimeout(function() {
        alerts.removeClass('show');
    }, 9000);

    let imagefile = $('input[type="file"]');
    let $img = $('<img id="img-preview" src="#"> class="img-responsive"');

    $.datepicker.regional['fr'] = { clearText: 'Effacer', clearStatus: '',
        closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
        prevText: '&lt;Préc', prevStatus: 'Voir le mois précédent',
        nextText: 'Suiv&gt;', nextStatus: 'Voir le mois suivant',
        currentText: 'Courant', currentStatus: 'Voir le mois courant',
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
        'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
        'Jul','Aoû','Sep','Oct','Nov','Déc'],
        monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
        weekHeader: 'Sm', weekStatus: '',
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
        dateFormat: 'dd/mm/yy', firstDay: 0, 
        initStatus: 'Choisir la date', isRTL: false
    };
    $.datepicker.setDefaults($.datepicker.regional['fr']);
    $('.datepicker').datepicker({
        showAnim: 'slideDown',
    });

    $(".datetime").datetimepicker({
        format: 'DD/MM/YYYY HH:mm',
        autoclose:true,
        locale: 'fr',
        todayHighlight: true,
    });

    $(".time").datetimepicker({
        format: 'HH:mm',
        dateFormat: '',
        timeOnly: true,
        autoclose:true,
        locale: 'fr',
        pickDate: false,
    });

    $('#planning_classes input').attr('type', 'radio');

    imagefile.change(function(){
        $('.preview-container').html($img);
        readURL(this, '#img-preview');
    });

    function readURL(input, src) {
        if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            $(src).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }
});