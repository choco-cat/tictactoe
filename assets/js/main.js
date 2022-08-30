$(document).ready(function () {
    $('.game-table td').click(
        function () {
            sendData({row: $(this).parent().index(), col: $(this).index()}, './helpers/game.php');
            return false;
        }
    );
});

function sendData(data, url) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: data,
        success: function (response) {
            result = $.parseJSON(response);
        },
        error: function (response) {
            console.log('Ошибка сервера!');
        }
    });
}
