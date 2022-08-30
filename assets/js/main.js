$(document).ready(function () {
    getBoard();
    $('.game-table td').click(
        function () {
            $(this).html('X');
            sendData({row: $(this).parent().index(), col: $(this).index()}, './helpers/game.php');
            return false;
        }
    );
});

function getBoard() {
    const board = [[], [], []];
    $('.game-table td').each(function () {
        board[$(this).parent().index()][$(this).index()] = $(this).text();
    });
    console.log(board);
};

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
