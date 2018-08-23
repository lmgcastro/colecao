$(function() {
    $('#botaoExistente').on('click', function() {
        $('#mangaNovo').hide();
        $('#mangaExistente').toggle();
    });
    $('#botaoNovo').on('click', function() {
        $('#mangaExistente').hide();
        $('#mangaNovo').toggle();
    });
});