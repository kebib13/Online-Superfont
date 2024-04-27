<?php
include_once 'f.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['f'])) {
    $f = $_GET['f'];
    $id = $_GET['id'];

    switch ($f) {
        case '+':
            $x = add_product($id);
            error_log('add result: ' . $x);
            echo json_encode([$x]);
            break;
        case '-':
            $x = sub_product($id);
            error_log('sub result: ' . $x);
            echo json_encode([$x]);
            break;
        case 'q':
            $x = get_qty($id);
            error_log('get_qty result: ' . $x);
            echo json_encode([$x]);
            break;
        case 'del':
            del_product($id);
            break;
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid operation']);
            break;
    }
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}

// Add this line to set the Content-Type header
header('Content-Type: application/json');
?>
