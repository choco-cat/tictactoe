$(document).ready(function () {
    $('.game-table td').click(
        function () {
            if ($(this).html() != '') {
                return;
            }
            $(this).html('X');
            sendData({board: getBoard()}, './helpers/game.php');
            return false;
        }
    );
});

function getBoard() {
    const board = [[], [], []];
    $('.game-table td').each(function () {
        board[$(this).parent().index()][$(this).index()] = $(this).text();
    });
    return(board);
};

function sendData(data, url) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: data,
        success: function (response) {
            const result = $.parseJSON(response);
            if (result.step) {
                const row = $('.game-table tr').eq(result.step.row);
                row.children().eq(result.step.col).html(result.step.symb);
            }
            if (result.message) {
                setTimeout(() => alert(result.message), 100);
                return;
            }
        },
        error: function (response) {
            console.log('Ошибка сервера!');
        }
    });
}
