<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "JesuS0108.", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>

<style>
body{
    margin:0;
    background-color: rgb(147, 253, 241);
    font-family: Arial, sans-serif;
    overflow-x: hidden;
}

.head{
    position: relative;
    left: 30vw;
    top: -4vh;
    font-size: xx-large;
    font-style:italic;
}

h3 ,h4{
    text-align: center;
    font-style:italic;
}

h5{
    position:relative;
    top: -5vh;
    left: 47vw;
}

.logo {
    border-radius: 23px;
    position: relative;
    left: 25vw;
    top: 48px;
    width: 4vw;
    height: 7vh;  
}
.logo:hover{
    transform:rotate(360deg);
    opacity: 1;
    transition: all 0.8s ease-in-out;
    cursor:pointer;
}

.card {
    cursor: pointer;
    position: relative;
    background: lightgreen;
    left: 35.6vw;
    top: 5vh;
    padding: 30px;
    border-radius: 15px;
    width: 400px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    opacity: 0;
transform: translateY(40px);
animation: fadeSlide 0.8s ease forwards;
}
@keyframes fadeSlide {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.info {
    margin: 10px 0;
}

.label {
    font-weight: bold;
}
</style>

</head>
<body>

<nav>
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU__LKaaXZB5kebb1W54TdFDB1_P0D4HCnBkTk8Rfd5g&s" class="logo">

<h2 class="head">Qis College Of Engineering & Technology</h2>
<h5>[AUTONOMOUS]</h5>
<h3>(Approved by AICTE, Permanently Affiliated to JNTUK, Kakinada, Accredited by NBA & UGC Recognised)</h3>
<h4>Vengamukkapalem, Pondur Road, ONGOLE - 523272, A.P.</h4>
</nav>

<div class="card">

<?php
if(isset($_POST['name'])) {

    $name = $_POST['name'];
    $currentTime = date("H:i:s");

    // Break Timings
    if(
        ($currentTime >= "10:40:00" && $currentTime <= "11:00:00") ||
        ($currentTime >= "12:40:00" && $currentTime <= "13:30:00") ||
        ($currentTime >= "15:10:00" && $currentTime <= "15:32:00")
    ){
        echo "<h2>Break Time</h2>";
    }
    else{

        $sql = "
        SELECT d.name, d.student_id, d.branch, d.section,
               t.subject, t.room_no, t.start, t.end
        FROM details d
        JOIN timetable t 
            ON d.branch = t.branch 
           AND d.section = t.section
        WHERE d.name = '$name'
        AND t.day = DAYNAME(CURDATE())
        AND CURTIME() BETWEEN t.start AND t.end
        LIMIT 1
        ";

        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){

            $row = $result->fetch_assoc();

            $startTime = date("g:i A", strtotime($row['start']));
            $endTime = date("g:i A", strtotime($row['end']));

            echo "<h2>Student Details</h2>";
            echo "<div class='info'><span class='label'>Name:</span> " . $row['name'] . "</div>";
            echo "<div class='info'><span class='label'>Student ID:</span> " . $row['student_id'] . "</div>";
            echo "<div class='info'><span class='label'>Branch:</span> " . $row['branch'] . "</div>";
            echo "<div class='info'><span class='label'>Section:</span> " . $row['section'] . "</div>";
            echo "<div class='info'><span class='label'>Current Subject:</span> " . $row['subject'] . "</div>";
            echo "<div class='info'><span class='label'>Room No:</span> " . $row['room_no'] . "</div>";
            echo "<div class='info'><span class='label'>Timing:</span> " . $startTime . " to " . $endTime . "</div>";

        }
        else{
            echo "<h2>No Class Running Now</h2>";
        }
    }

}
else{
    echo "<h2>No Name Received</h2>";
}

$conn->close();
?>

</div>

</body>
</html>