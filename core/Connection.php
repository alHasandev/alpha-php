<?php

// class / blueprint for Database Connection

class Connection
{
  // connection property
  protected
    $host = 'localhost',
    $username = 'root',
    $password = '',
    $dbname = 'db_siswa';

  // connection method
  public function __construct()
  {
    try {
      $this->db = new mysqli($this->host, $this->username, $this->password, $this->dbname);

      // check error
      if ($this->db->connect_error) {
        // throw an error exception
        throw new Exception($this->db->connect_error, $this->db->connect_errno);
      }
    } catch (Exception $err) {
      die('Connection error ' . $err->getMessage());
    }
  }
}
