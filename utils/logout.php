<?php
session_start();
session_destroy(); 
header('Location: /'); // Redirect to the home page
exit; 
