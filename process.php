<?php

//Hàm ghi ra file link.txt
function writelist($record) {
    $filename = "link.txt";
    $file = fopen($filename, "a");

    if ($file == false) {
        // Không mở được file
        return FALSE;
    }
    $size = filesize($filename);
    if ($size == 0) {
        //Khi link.txt chưa có gì
        fwrite($file, $record);
    } else {
        //Khi link.txt đã có dữ liệu
        fwrite($file, "\n" . $record);
    }
    fclose($file);
    return TRUE;
}

//Hàm đọc từ file link.txt
function readlist() {
    $filename = "link.txt";
    $data = array();
    if (!file_exists($filename)) {
        $file = fopen($filename, "a");
        return $data;
    } else {
        $file = fopen($filename, "r");
        if ($file == false) {
            return $data;
        }
        $size = filesize($filename);
        if ($size) {
            while (!feof($file)) {
                // Lấy từng dòng một
                $record = fgets($file);
                $data[] = $record;
            }
        }
    }
    return $data;
}

//#############################################################################
//Phần xử lý ghi ra file link.txt
/*
 * Ghi dữ liệu ra file và trả về thông báo kèm dữ liệu,loại dữ liệu nếu có và thành công
 */
if (isset($_POST['text'])) {
    //Loại bỏ khoảng trống khi nhập, các kí tự >,< tránh lỗi hiển thị
    $character_mask = " > <";
    $text = trim($_POST['text'], $character_mask);
    $day = date("d-m-Y");

    //Phần xử lý ghi ra file
    $response = array();
    $response['code'] = 0;
    if ($text != "") {
        //type: Xác định loại: là liên kết hay text thường
        //type=false nếu là text thường do không tìm thầy "http"; 
        //type=vị trí tìm thấy "http" nếu là liên kết, có thể ở vị 0
        //Nên phía xử lý phải so sánh hoàn toàn mới được (===, !==)
        $http = (strpos($text, "http://")===FALSE) ? 0 : 1;
        $https= (strpos($text, "https://")===FALSE) ? 0 : 1;
        
        $record = $text . " " . $day;
        $status = writelist($record);
        if ($status) {
            $response['code'] = 1;
            $response['text'] = $text;
            $response['day'] = $day;
            $response['type'] = ($http || $https);
            echo json_encode($response);
            exit();
        } else {
            $response['error'] = "Khong mo duoc file";
        }
    } else {
        $response['error'] = "Chua nhap input";
    }
    echo json_encode($response);
}

//#############################################################################
//Phần xử lý đọc từ file link.txt khi mới load lần đầu
/*
 * Trả về dữ liệu trong file link.txt
 * Trả về mảng data chưa có phần tử nào nếu chưa có gì trong file
 * Trả về mảng data có các phần tử theo thứ tự từ trên xuống dưới như trong file
 */
$data = readlist();

//#############################################################################
//Hàm in dữ liệu trong data thành danh sách liên kết, text cùng ngày tháng tạo
function printdata($data) {
    $i = count($data);
    while ($i) {
        $row = $data[--$i];
        echo "<div class='link-row'>";
        echo "<div class='left'>";

        if (strpos($row, "http") !== FALSE) {
            // Liên kết
            $arr = explode(" ", $row);
            echo '<a href="' . $arr[0] . '" target="_blank">' . $arr[0] . '</a>';
            echo "</div>";
            echo "<div class='right'>";
            echo "<p>" . $arr[1] . "</p>";
            echo "</div>";
        } else {
            // Chuỗi text tìm kiếm với google.com
            $arr = array();
            $t = strrpos($row, " ");
            $arr[] = substr($row, 0, $t);
            $arr[] = substr($row, $t);
            echo '<a href="http://google.com/?q=' . $arr[0] . '" target="_blank">' . $arr[0] . '</a>';
            echo "</div>";
            echo "<div class='right'>";
            echo "<p>" . $arr[1] . "</p>";
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='break-line'></div>";
    }
}

?>
