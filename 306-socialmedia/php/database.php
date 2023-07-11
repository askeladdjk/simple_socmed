<?php
const HOST = "localhost";
const USER = "root";
const PASSWORD = "";
const DATABASE = "octagram_db";

$connection = new mysqli(HOST, USER, PASSWORD, DATABASE) or die("Database Connection Failed: " . $connection->connect_error);