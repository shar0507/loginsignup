<!-- <?php
if (isset($_POST['password'])) {
    echo "Password is set, but we're not showing it for security reasons.";
} else {
    echo "Password is not set.";
}
?> -->

<!-- <?php
foreach ($_POST as $key => $value) {
    if ($key === 'password' || $key=='password_confirmation') {
        echo "$key: Secret (not displayed)\n";
    } else {
        echo "$key: $value\n";
    }
}
?> -->

<?php 

if(empty($_POST["name"])){
    die("Name is required");
}
if(! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Enter valid email");
}
if(strlen($_POST["password"])<8){
    die("Password must be atleast 8 characters");
}
if(! preg_match("/[a-z]/i", $_POST["password"])){
    die("Password must contain atleast one letter");
}
if(! preg_match("/[0-9]/", $_POST["password"])){
    die("Password must contain atleast one number");
}
if($_POST["password"]!==$_POST["password_confirmation"]){
    die("Passwords must match");
}

$secure_pwd=password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli= require __DIR__."/database.php";
$sql="INSERT INTO user (name,email,password_hash) VALUES(?, ?, ?)";
$stmt=$mysqli->stmt_init();
if(! $stmt->prepare($sql)){
    die("SQL error:" . $mysqli->error);
}
$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $secure_pwd);

try {
    if ($stmt->execute()) {
        header("Location: signup-success.html");
        exit;
    } else {
        die("Error executing statement: " . $stmt->error . " " . $stmt->errno . ". SQL: " . $sql . " Params: " . $_POST["name"] . ", " . $_POST["email"] . ", " . $secure_pwd);
    }
} catch (mysqli_sql_exception $e) {
    die("Caught exception: " . $e->getMessage());
}



// print_r($_POST);
// var_dump($secure_pwd);
?>