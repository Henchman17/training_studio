<?php 
session_start(); 
if (isset($_SESSION['fname'])) { 
    echo "<h1>Welcome, " . $_SESSION['fname'] . "!</h1>"; 
    echo "<p>You are now logged in.</p>"; 
    echo "<a href='logout.php'>Logout</a>"; 
    } else if (isset($_SESSION['adname'])) { 
        echo "<h1>Welcome, " . $_SESSION['adname'] . "!</h1>"; 
        echo "<p>You are now logged in.</p>"; 
        echo "<a href='logout.php'>Logout</a>"; 
        } else { header("Location: login.html"); exit(); } ?>