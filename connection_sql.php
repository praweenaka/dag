<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$servername = 'localhost';
$username = 'coolmans';
$password = 'e1E]0Mfua.0T4L';
$port = 10060;
$dbname = 'coolmans_dag';


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
