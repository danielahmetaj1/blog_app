<?php 
require 'config/constants.php';
// fshij session e perdoruesit
session_destroy();
header('location: ' . ROOT_URL);
die();
