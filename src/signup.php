<?php

    //http:127.0.0.1:80/main-store/src/signup.html
    //get database connection 
    include('../settings/database.php');

    $first_name= $_POST['fname'];
    $last_name= $_POST['lname'];
    $ident_number= $_POST['idnumber'];
    $mobile_phone= $_POST['mphone'];
    $email= $_POST['email'];
    //$passwd= MD5($_POST['passw']);
    $passwd = password_hash($_POST['passw'], PASSWORD_DEFAULT);
    $PHOTO_URL ='photos/photo_default.png';

$sql_check_email ="SELECT * FROM users WHERE email = '$email'";
    $res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows ($res);
if ($total<1){
        //prepare query
        $sql = " 
        INSERT INTO 
        users (firstname, lastname, ident_number, email, password, url_photo, mobile_phone) 
        VALUES (
            '$first_name', 
            '$last_name', 
            '$ident_number', 
            '$email', 
            '$passwd',
            '$PHOTO_URL', 
            '$mobile_phone'
            );
    ";    
    // execute querys
    $res = pg_query($local_conn, $sql);

    if($res){
        //echo "User has been created successfully!!!";
        echo "<script>alert('User has been created successfully!!!')</script>";
        header ('refresh:0;url=signin.html');
    }else {
        echo "Error: user hasn't been created succedully!!!";
    }
} else {
    echo "<script>alert('User email alredy exists. Try again!!!')</script>";
        header ('refresh:0;url=signup.html');
}