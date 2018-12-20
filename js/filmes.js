$(function() {
    $('#△').prop('disabled', true);
    $('#▽').prop('disabled', true);
    $('#fieldsCombo').change(function() {
        if (this.value == 'Todos') {
            $('#△').prop('checked', false);
            $('#▽').prop('checked', false);
            $('#△').prop('disabled', true);
            $('#▽').prop('disabled', true);
        } else {
            $('#△').prop('disabled', false);
            $('#▽').prop('disabled', false);
        }
    });
    $("#ordem_titulo").hide();
    $("#tit_ord").on('click', function() {
        $("#titulo_inp").toggle();
        $("#ordem_titulo").toggle();
    });
    $("#ordem_diretor").hide();
    $("#dir_ord").on('click', function() {
        $("#diretor_inp").toggle();
        $("#ordem_diretor").toggle();
    });
	$("#regiaoBD").hide();
	$("#regiaoDVD").hide();
	$(".midia").on('click', function() {
        if (this.value == 'Blu-ray') {
			$("#regiaoDVD").hide();
			$("#regiaoBD").show();
		} else {
			$("#regiaoBD").hide();
			$("#regiaoDVD").show();
		}
    });
    $('.titulo').on('click', function() {
        $('#codBarrasImg').hide();
        $('#posterImg').show();
        $('#posterImg').attr('src', 'images/posters/' + this.id + '.jpg');
    });

    $('#posterImg').on('click', function() {
        $('#posterImg').hide();
        $('#posterImg').attr('src', '');
    });
    
    $('.codBarras').on('click', function() {
        $('#posterImg').hide();
        $('#codBarrasImg').show();
        $('#codBarrasImg').attr('src', 'images/barcodes/' + this.innerHTML + '.gif');
    });

    $('#codBarrasImg').on('click', function() {
        $('#codBarrasImg').hide();
        $('#codBarrasImg').attr('src', '');
    });

    $('#novo').on('click', function() {
        $('#addFilme').toggle();
    });

    $('#submit').on('click', function() {
        window.open('https://barcode.tec-it.com/en/EAN13?data=' + $('#codBarrasForm').val());
    });
});