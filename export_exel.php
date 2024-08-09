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
    $size_display = (!empty($nameData) && is_array($nameData)) ? $nameData['size'] : 'کاربر خالی وارد کرده';
    $html_table .= '<td class="text-center">' . $size_display . '</td>';

    // Display shift based on value
    $shift_display = match ($row['shift']) {
        1 => 'روز',
        2 => 'عصر',
        3 => 'شب',
        default => 'نامشخص'
    };
    $html_table .= '<td class="text-center">' . $shift_display . '</td>';

    $html_table .= '<td class="text-center">' . $row['date'] . '</td>';

    // Calculate and display production time
    $start_time = strtotime($row['start']);
    $finish_time = strtotime($row['stop']);
    $time_difference = $finish_time - $start_time;
    $html_table .= '<td class="text-center">' . $time_difference . ' ثانیه </td>';

    // Fetch additional data
    $size_piece = $row['size'];
    $piece_name = $row['piece_name'];
    $level = $row['level'];
    $sqll = "SELECT * FROM pieces WHERE size = '$size_piece' AND name = '$piece_name' AND level = '$level'";
    $resultt = $conn->query($sqll);

    if ($resultt->num_rows > 0) {
        $roww = $resultt->fetch_assoc();
        $time_one = $roww['time_one'];
        $price = $roww['price'];
        $all_time = $time_one * $row['numbers'];
        $all_price = $price * $row['numbers'];
        $totals[] = $all_price;

        $delay = $all_time - $time_difference;
        $delay_message = $delay >= 0 ? "تاخیر نداشته" : $delay . ' ثانیه';

    } else {
        $all_time = "زمانی ثبت نشده";
        $delay_message = "زمانی ثبت نشده";
        $all_price = "قیمتی ثبت نشده";
        $price = "قیمتی ثبت نشده";
        $totals[] = 0;
    }

    $html_table .= '<td class="text-center">' . $all_time . ' ثانیه </td>';
    $html_table .= '<td class="text-center">' . $delay_message . '</td>';
    $html_table .= '<td class="text-center">' . $row['numbers'] . '</td>';
    $html_table .= '<td class="text-center">' . $price . '</td>';
    $html_table .= '<td class="text-center">' . $all_price . '</td>';
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
