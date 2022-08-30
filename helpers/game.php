<?php
$data = $_POST;
if (!$data['board']) {
    return;
}
$step = array();
$board = $data['board'];
foreach ($board as $indexRow => $row) {
    if (!empty($step )) {
        break;
    }
    foreach ($row as $indexColumn => $cell) {
        if($cell === '') {
            $step = array(
                'row' => $indexRow,
                'col' => $indexColumn
            );
            break;
        }
    }
}

echo json_encode($step);
