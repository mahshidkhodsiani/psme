<?php


include 'PersianCalendar.php';

echo mds_date("Y/m/d", "now", 1);


if(mds_date("Y/m/d", "now", 1) > '1403/2/8'){
    echo "true";
}else{
    echo "false";
}