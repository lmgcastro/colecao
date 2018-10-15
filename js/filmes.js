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
        $('#barcodeImg').hide();
        $('#posterImg').show();
        $('#posterImg').attr('src', 'images/posters/' + this.id + '.jpg');
    });

    $('#posterImg').on('click', function() {
        $('#posterImg').hide();
        $('#posterImg').attr('src', '');
    });
    
    $('.barcode').on('click', function() {
        $('#posterImg').hide();
        $('#barcodeImg').show();
        $('#barcodeImg').attr('src', 'images/barcodes/' + this.innerHTML + '.gif');
    });

    $('#barcodeImg').on('click', function() {
        $('#barcodeImg').hide();
        $('#barcodeImg').attr('src', '');
    });

    $('#novo').on('click', function() {
        $('#addFilme').toggle();
    });

    $('#submit').on('click', function() {
        window.open('https://barcode.tec-it.com/en/EAN13?data=' + $('#barcodeForm').val());
    });
});
