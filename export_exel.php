<?php
session_start();

include 'config.php';
include 'functions.php';

error_reporting(E_ERROR | E_PARSE);

// Start building HTML table
$html_table = '<table border="1">';
$html_table .= '<thead><tr><th scope="col">ردیف</th><th scope="col">نام شخص</th><th scope="col">کد دستگاه</th>
        <th scope="col">نام قطعه</th><th scope="col">سایز قطعه</th><th scope="col">شیفت</th><th scope="col">تاریخ</th>
        <th scope="col">تعداد</th><th scope="col">قیمت</th></tr></thead>';
$html_table .= '<tbody>';

$a = 1;
$result = $conn->query($_SESSION['query']);
$totals = []; // Initialize an empty array to store total prices

while ($row = $result->fetch_assoc()) {
    $html_table .= '<tr>';
    $html_table .= '<th scope="row">' . $a . '</th>';
    $html_table .= '<td>' . givePerson($row['user']) . '</td>';
    $html_table .= '<td>' . giveDeviceCode($row['device_number']) . '</td>';
    $html_table .= '<td>' . $row['piece_name'] . '</td>';
    $html_table .= '<td>' . giveName($row['size'])['size']  . '</td>';
    $html_table .= '<td>';

    // Display shift based on value
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
    }

    $html_table .= '</td>';
    $html_table .= '<td>' . $row['date'] . '</td>';
    $html_table .= '<td>' . $row['numbers'] . '</td>';

    // Calculate and display price
    $nameData = giveName($row['size']);
    if (!empty($nameData) && is_array($nameData)) {
        $price = isset($nameData['price']) ? $nameData['price'] : 0;
        $totalPrice = $price * intval($row['numbers']);
        $html_table .= '<td>' . number_format($totalPrice) . '</td>';
        $totals[] = $totalPrice; // Add totalPrice to the totals array
    } else {
        $html_table .= '<td class="text-center">کاربر خالی وارد کرده</td>';
    }

    $html_table .= '</tr>';
    $a++;
}

$html_table .= '</tbody>';

// Calculate total sum
$totalSum = array_sum($totals);

// Add total sum row to the table footer
$html_table .= '<tfoot>';
$html_table .= '<tr>';
$html_table .= '<th colspan="8" class="text-right">جمع کل این صفحه:</th>';
$html_table .= '<th class="text-center">' . number_format($totalSum) . '</th>';
$html_table .= '</tr>';
$html_table .= '</tfoot>';

$html_table .= '</table>';

// Set headers for Excel export
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=table_data.xls");

// Output HTML table as Excel file
echo $html_table;
?>
