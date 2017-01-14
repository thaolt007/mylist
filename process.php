<?php
//Ham ghi ra file
function writelist($record) {
    $filename = "link.txt";
    $file = fopen($filename, "a");

    if ($file == false) {
        echo "Loi mo file khi write";
        return FALSE;
    }
    fwrite($file, $record);
    fclose($file);
    return TRUE;
}

//Ham doc tu file
function readlist() {
    $filename = "link.txt";
    $data = array();
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        if ($file == false) {
            echo "Loi mo file khi read";
            return 0;
        }

        while (!feof($file)) {
            $record = fgets($file); // get 1 row
            $data[] = $record;
        }
    }
    return $data;
}

//#############################################################################
//define(FAIL, 0);
//define(SUCCESS, 1);

$link = $_POST['link'];
$day = date("d-m-Y");

//Xu ly ghi ra file
$response = array();
$response['code'] = 0;
if ($link != "") {
    $record = $link . " " . $day . "\n";
    $status = writelist($record);
    if ($status) {
        $response['code'] = 1;
        $response['link'] = $link;
        $response['day'] = $day;
        echo json_encode($response);
    }
}


//Xu ly doc tu file
$data = readlist();


?>
