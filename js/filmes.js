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
        var info = this.id.split("_");
        $('.filmeInfo').hide();
        $('#filmeInfo' + info[1]).fadeIn();
        $('#posterImg').hide();
        $('#posterImg').attr('src', 'images/posters/' + info[0] + '.jpg');
        $('#posterImg').fadeIn();
    });
    $('.codBarras').on('click', function() {
        $('#codBarrasImg').attr('src', 'images/barcodes/' + this.id + '.gif');
        $('#codBarrasImg').fadeIn();
    });
    $('#codBarrasImg').on('click', function() {
        $('#codBarrasImg').fadeOut();
    });
    $('.btnTrocar').on('click', function() {
        var infos = this.id.split("_");
        $('#filmeInfo' + infos[0]).hide();
        $('#codBarrasImg').fadeOut();
        $('#filmeInfo' + infos[1]).show();
    });
    $('#posterImg').on('click', function() {
        $('.filmeInfo').fadeOut();
        $('#posterImg').fadeOut();
        $('#codBarrasImg').fadeOut();
    });
    $('#novo').on('click', function() {
        $('#addFilme').fadeToggle();
    });
    $('#submit').on('click', function() {
        window.open('https://barcode.tec-it.com/en/EAN13?data=' + $('#codBarrasForm').val());
    });
});