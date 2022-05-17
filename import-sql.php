<?php

// --- Warning: Make sure your database name correct, same name will be overwrited
// --- Warning: This custom import sql code currently cannot import trigger bound database
//// --- Warning: Make sure you not included trigger in imported file --FIXED

//ENTER THE RELEVANT INFO BELOW
$hostname     = "localhost";
$username     = "root";
$password     = "";
$dbname       = @$_GET['dbname'];
$backup_name  = @$_GET['backup'] ? $_GET['backup'] : "$dbname.sql";

// Create connection
$conn = new mysqli($hostname, $username, $password);

// Create new database if not exist
echo "Creating database: $dbname";
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
$conn->query("USE `$dbname`");
echo "<br/>";

// Reset database tables
$query = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname'";
$tables = $conn->query($query);
while ($data = $tables->fetch_assoc()) {
  echo "Restructuring... " . $data['table_name'];
  $conn->query("DROP TABLE $data[table_name]");
  echo "<br/>";
}

// Import database

echo "Importing... $backup_name";
echo "<br/>";


$templine = "";
$lines = file("$backup_name");
$delimiter = false;
foreach ($lines as $line) {
  if (substr($line, 0, 2) == '--' || $line == '') continue;
  // Fix: Handle trigger delimiter keyword error
  if (trim($line) == "DELIMITER $$") {
    $delimiter = true;
    continue;
  }

  if (trim($line) == "$$") continue;
  if (trim($line) == "DELIMITER ;") {
    $delimiter = false;
    continue;
  }


  // if (trim($line) == "END") $line = trim($line) . ";";
  $templine .= $line;
  if ($delimiter) {
    if (trim($line) == "END") {
      $conn->query($templine);
      // echo $templine;
      $templine = "";
    }
  } else if (substr(trim($line), -1, 1) == ';') {
    $conn->query($templine);
    // echo $templine;
    $templine = "";
  }
}

echo "Successfully... All tables is imported";
echo "<br/>";

echo "Successfuly... database is imported!";

if (@$_GET['backlink']) header('location: ' . $_GET['backlink']);
