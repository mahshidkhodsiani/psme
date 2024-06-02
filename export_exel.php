<?php
session_start();

include 'config.php';
include 'functions.php';

error_reporting(E_ERROR | E_PARSE);

// Start building HTML table
$html_table = '<table border="1">';
$html_table .= '<thead>
                    <tr>
                        <th scope="col" class="text-center">ردیف</th>
                        <th scope="col" class="text-center">نام شخص</th>
                        <th scope="col" class="text-center">کد دستگاه</th>
                        <th scope="col" class="text-center">قطعه</th>
                        <th scope="col" class="text-center">سایز قطعه</th>
                        <th scope="col" class="text-center">شیفت</th>
                        <th scope="col" class="text-center">تاریخ</th>
                        <th scope="col" class="text-center">زمان تولید</th>
                        <th scope="col" class="text-center">زمان مجاز</th>
                        <th scope="col" class="text-center">میزان تاخیر</th>
                        <th scope="col" class="text-center">تعداد</th>
                        <th scope="col" class="text-center">قیمت واحد</th>
                        <th scope="col" class="text-center">قیمت (تومان)</th>
                    </tr>
                </thead>';
$html_table .= '<tbody>';

$a = 1;
$result = $conn->query($_SESSION['query']);
$totals = []; // Initialize an empty array to store total prices

while ($row = $result->fetch_assoc()) {
    $html_table .= '<tr>';
    $html_table .= '<td class="text-center">' . $a . '</td>';
    $html_table .= '<td class="text-center">' . givePerson($row['user']) . '</td>';
    $html_table .= '<td class="text-center">' . giveDeviceCode($row['device_number']) . '</td>';
    $html_table .= '<td class="text-center">' . $row['piece_name'] . '</td>';

    // Display size of the piece
    $nameData = giveName($row['size']);
    if (!empty($nameData) && is_array($nameData)) {
        $html_table .= '<td class="text-center">' . $nameData['size'] . '</td>';
    } else {
        $html_table .= '<td class="text-center">کاربر خالی وارد کرده</td>';
    }

    // Display shift based on value
    $html_table .= '<td class="text-center">';
    switch($row['shift']) {
        case 1:
            $html_table .= 'روز';
            break;
        case 2:
            $html_table .= 'عصر';
            break;
        case 3:
            $html_table .= 'شب';
            break;
        default:
            $html_table .= 'نامشخص';
            break;
    }
    $html_table .= '</td>';

    $html_table .= '<td class="text-center">' . $row['date'] . '</td>';

    // Calculate and display production time
    $start_time = strtotime($row['start']);
    $finish_time = strtotime($row['stop']);
    $time_difference = $finish_time - $start_time;
    $net_seconds = $time_difference;
    $html_table .= '<td class="text-center">' . $net_seconds . ' ثانیه </td>';

    // Display allowed time (size time piece)
    $size_time_piece = (int)giveTimePiece($row['size']);
    $html_table .= '<td class="text-center">' . $size_time_piece . ' ثانیه </td>';

    // Calculate remaining time or delay
    $remaining_time = $size_time_piece - $net_seconds;
    if ($remaining_time >= 0) {
        $delay_message = "تاخیر نداشته";
    } else {
        $delay_message = abs($remaining_time) . " ثانیه";
    }
    $html_table .= '<td class="text-center">' . $delay_message . '</td>';

    // Display number of items
    $html_table .= '<td class="text-center">' . $row['numbers'] . '</td>';

    // Calculate unit price and display
    $price = isset($nameData['price']) ? $nameData['price'] : 0;
    $html_table .= '<td class="text-center">' . number_format($price) . '</td>';

    // Calculate total price and display
    $totalPrice = $price * intval($row['numbers']);
    $html_table .= '<td class="text-center">' . number_format($totalPrice) . '</td>';

    // Add totalPrice to the totals array
    $totals[] = $totalPrice;

    $html_table .= '</tr>';
    $a++;
}

$html_table .= '</tbody>';

// Calculate total sum
$totalSum = array_sum($totals);

// Add total sum row to the table footer
$html_table .= '<tfoot>';
$html_table .= '<tr>';
$html_table .= '<th colspan="11" class="text-right">جمع کل این صفحه:</th>';
$html_table .= '<th colspan="2" class="text-center">' . number_format($totalSum) . '</th>';
$html_table .= '</tr>';
$html_table .= '</tfoot>';

$html_table .= '</table>';

// Set headers for Excel export
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=table_data.xls");

// Output HTML table as Excel file
echo $html_table;
?>
