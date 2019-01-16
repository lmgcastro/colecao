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
    $("#ordem_colecao").hide();
    $("#col_ord").on('click', function() {
        $("#colecao_inp").toggle();
        $("#ordem_colecao").toggle();
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
    var c;
    $('.titulo').on('click', function() {
        c = this.id.substring(22,25);
        $('#filmeInfo' + c).show();
        $('#posterImg').attr('src', 'images/posters/' + this.id.substring(0,9) + '.jpg');
        $('#posterImg').show();
        $('#codBarrasImg').attr('src', 'images/barcodes/' + this.id.substring(9,22) + '.gif');
        $('#codBarrasImg').show();
    });

    $('#posterImg').on('click', function() {
        $('#filmeInfo' + c).hide();
        $('#posterImg').hide();
        $('#posterImg').attr('src', '');
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