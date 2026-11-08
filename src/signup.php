<?php
    $first_name= $_POST['fname'];
    $last_name= $_POST['lname'];
    $identification_number= $_POST['idnumber'];
    $mobile_phone= $_POST['mphone'];
    $email= $_POST['email'];
    $password= MD5($_POST['passw']);

    
    
    echo "<br>" . $first_name; 
    echo "<br>" . $last_name;
    echo "<br>" . $identification_number; 
    echo "<br>" . $mobile_phone; 
    echo "<br>" . $email; 
    echo "<br>" . $password;