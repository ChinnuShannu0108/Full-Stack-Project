<?php
$conn = new mysqli("localhost", "root", "JesuS0108.", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Upload Profile Image</title>
    <style>
        body{
            font-family: Arial;
            text-align:center;
            background:#b2f7ef;
            padding-top:100px;
        }

        .box{
            background:white;
            padding:30px;
            width:350px;
            margin:auto;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.2);
        }

        input{
            margin:10px 0;
        }

        button{
            padding:8px 20px;
            background:#0d6262;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#094949;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Upload Student Profile</h2>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Enter Student Name" required><br>
        <input type="file" name="image" required><br>
        <button type="submit" name="upload">Upload</button>
    </form>

<?php
if(isset($_POST['upload'])){

    $name = $_POST['name'];

    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $folder = "images/" . time() . "_" . $image_name;

    if(move_uploaded_file($tmp_name, $folder)){

        $sql = "UPDATE details SET profile_img='$folder' WHERE name='$name'";

        if($conn->query($sql)){
            echo "<p style='color:green;'>Image Uploaded Successfully!</p>";
        } else {
            echo "<p style='color:red;'>Database Update Failed!</p>";
        }

    } else {
        echo "<p style='color:red;'>File Upload Failed!</p>";
    }
}
?>

</div>

</body>
</html>
