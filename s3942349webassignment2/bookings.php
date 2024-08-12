<!DOCTYPE html>
<html lang="en">
<?php
    require_once 'bookingshead.html';
    require_once 'bookingsbody.html';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['id'];
        $name = htmlspecialchars($name);
    }
    date_default_timezone_set("Australia/Melbourne");
    if(isset($_POST['submit'])) {
        $dateTime = date("Y/m/d-h:i:sa");
        $checkboxSelected = null;
        $dateBooked = strval($_POST['date']);
        $newDate = date("l, jS F Y",strtotime($dateBooked));
        if(!empty($_POST['option'])) {
            foreach($_POST['option'] as $value){
                $checkboxSelected = ("Chosen time : ".$value);
            }
        }
        $colonLocation = 0;
        $dropValue = strval($_POST['drop']);
        $idValue = strval($_POST['id']);
        if ($idValue = null) {
            $error = "Error, please try again.";
            echo "<script type='text/javascript'>alert('$error');</script>";
        }
        else {
            $data= array ($dateTime, $_POST['id'], $newDate, $checkboxSelected, $dropValue);
            $fp = fopen('appointments.txt', 'a');
            fputcsv($fp, $data);
            fclose($fp);
            $finish = "Submission successful, we will be in touch soon.";
            echo "<script type='text/javascript'>alert('$finish');</script>";
        }
    }
?>
</html>