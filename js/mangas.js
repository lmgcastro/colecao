$(function() {
    $('#botaoExistente').on('click', function() {
        $('#addMangaNovo').hide();
        $('#addManga').toggle();
    });
    $('#botaoNovo').on('click', function() {
        $('#addManga').hide();
        $('#addMangaNovo').toggle();
    });
});