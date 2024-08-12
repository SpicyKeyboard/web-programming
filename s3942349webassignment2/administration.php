<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="adminstyle.css">
<?php
require_once 'adminhead.html';
?>
<body>
    <div class="grid-container">
        <header>
            <img src="rsm_logo.png" alt="Russel Street Medical Logo">
            <h1>Russel Street Medical</h1>
        </header>
        <nav>
                <li><a href="index.php">Home</a></li>
        </nav>
    <main>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            Username: <input type="text" id="username" name="username" placeholder="Enter username" required>
            Password: <input type="password" id="password" name="password" placeholder="Enter password" required>
            <br>
            <input type="submit" value="Enter" name="submit">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user = $_POST['username'];
                $user = htmlspecialchars($user);
                $pass = $_POST['password'];
                $pass = htmlspecialchars($pass);
            }
            ?>
        </form>
    <div class="welcome">
        <p2>Welcome <?php echo $user ?></p2> <br>
        <br> <button onClick="welcomeHide();">Logout</button>
            <?php
                echo "<table>\n\n
                <tr>
                <th>Date Made</th>
                <th>Patient ID</th>
                <th>Date Booked</th>
                <th>Choosen Time</th>
                <th>Appointment For</th>
                </tr>";
                $f = fopen("appointments.txt", "r");
                while (($line = fgetcsv($f)) !== false) {
                    echo "<tr>";
                    foreach ($line as $cell) {
                        echo "<td>" . htmlspecialchars($cell) . "</td>";
                    }
                    echo "</tr>\n";
                }
                fclose($f);
                echo "\n</table>";
            ?>
        <br>
        <form method="post">
            <input type="text",id="useradd" name="useradd" placeholder="Add a user" required>
            <input type="password",id="passadd" name="passadd" placeholder="Users password" required>
            <input type="submit" value="Append user" name="adduser" id="adduser">
        </form>
        
    </div>
    </main>
    <script>
        element = document.querySelector('.welcome');
            element.style.visibility = 'hidden';
        function welcomeCheck() {
            element = document.querySelector('.welcome');
            element.style.visibility = 'visible';
        }
        function welcomeHide() {
            element = document.querySelector('.welcome');
            element.style.visibility = 'hidden';
        }
    </script>
</body>
<?php
    if(isset($_POST['submit'])) {
    $fe = fopen("users.txt", "r");
    $aca = fopen("accessattempts.txt", "a");
    $count = 0;
    $subcount = 0;
    $usersubmission = 1;
    $admin = array();
    while (($userpass = fgetcsv($fe)) !== false) {
        foreach ($userpass as $up) {
            $newup = str_replace(' ', '', $up);
            $admin[$count]=$newup;
            $count++;
        }
        if ($user==$admin[$subcount] && $pass==$admin[$subcount+1]) {
            $usersubmission = 2;
            echo '<script>
            welcomeCheck();
            </script>';
            fclose($aca);
        }
        $subcount=$subcount+2;
    }
    if ($usersubmission = 1) {
        $userdata = array($user.','.$pass);
        fputcsv($aca, $userdata, ',', ' ');
    }
    fclose($fe);
    }
    if(isset($_POST['adduser'])) {
            $fu = fopen("users.txt", "a+");
            $count = 0;
            $subcount = 0;
            $usersubmission = 0;
            $admins = array();
            while (($userpass = fgetcsv($fu)) !== false) {
                foreach ($userpass as $up) {
                    $admin[$count]=$up;
                    $count++;
                }
                if ($_POST['useradd']==$admin[$subcount]) {
                    echo 'Error, User already exists.';
                }
                elseif ($usersubmission == 0) {
                        $useradd = $_POST['useradd'];
                        $passadd = $_POST['passadd'];
                        $newuserdata = array($useradd.','.$passadd);
                        fputcsv($fu, $newuserdata,',',' ');
                        $usersubmission++;
                    }
                
                }
                $subcount++;
                fclose($fu);
            }
            
?>