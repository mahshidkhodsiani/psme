<?php
session_start();


include 'config.php';
include 'functions.php';





$html_table = '<table border="1">';
$html_table .= '<thead><tr><th scope="col">ردیف</th><th scope="col">نام شخص</th><th scope="col">کد دستگاه</th>
        <th scope="col">نام قطعه</th><th scope="col">سایز قطعه</th><th scope="col">شیفت</th><th scope="col">تاریخ</th>
        <th scope="col">تعداد</th><th scope="col">قیمت</th></tr></thead>';
$html_table .= '<tbody>';
$a = 1;
$result = $conn->query($_SESSION['query']);
while ($row = $result->fetch_assoc()) {
    $html_table .= '<tr>';
    $html_table .= '<th scope="row">' . $a . '</th>';
    $html_table .= '<td>' . givePerson($row['user']) . '</td>';
    $html_table .= '<td>' . giveDeviceCode($row['device_number']) . '</td>';
    $html_table .= '<td>' . $row['piece_name'] . '</td>';
    $html_table .= '<td>' . giveName($row['size'])['size']  . '</td>';
    $html_table .= '<td>';
    if($row['shift']==1){
        $html_table .= 'روز' ;
    } elseif($row['shift']==2){
        $html_table .= 'عصر' ;
    } elseif($row['shift']==3){
        $html_table .= 'شب' ;
    }
    $html_table .= '</td>';
    $html_table .= '<td>' . $row['date'] . '</td>';
    $html_table .= '<td>' . $row['numbers'] . '</td>';
    $html_table .= '<td>' . giveName($row['size'])['price'] * $row['numbers'] . '</td>';
    $html_table .= '</tr>';
    $a++;
}
$html_table .= '</tbody></table>';

// Set headers for Excel export
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=table_data.xls");

// Output HTML table as Excel file
echo $html_table;
?>