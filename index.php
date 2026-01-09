<?php
session_start();

// $_SESSION['user'] = [
//     'user_id' => 6,         // the inserted id
//     'role'    => 'organisateur',
//     'role_id' => 3,
//     'email'   => "org2@sportticket.ma",
//     'nom'     => "Fassi",
//     'prenom'  => "Youssef",
// ];
// header("Location: organizer/dashboard.php");

$_SESSION['user'] = [
    'user_id' => 1,         // the inserted id
    'role'    => 'admin',
    'role_id' => 1,
    'email'   => "admin@sportticket.ma",
    'nom'     => "Admin",
    'prenom'  => "Super",
];

header("Location: admin/dashboard.php");
exit();