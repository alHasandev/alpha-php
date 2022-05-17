<?php

class Database extends Connection
{
  // set constructor
  public function __construct()
  {
    // get constructor from Connection
    parent::__construct();
  }

  // get Data
  public function readData(string $table): object
  {
    return $this->db->query("SELECT * FROM $table");
  }

  // get data where id
  public function readDataAt(string $table, array $id): string
  {
    // get key id
    $keyId = array_keys($id)[0];
    // return $this->db->query("SELECT * FROM $table WHERE $keyId = '" . $id[$keyId] . "'");
    return "SELECT * FROM $table WHERE $keyId = '" . $id[$keyId] . "'";
  }

  // set new data
  public function createData(string $table, array $data): bool
  {
    // get keyname of form data
    $keys = implode(', ', array_keys($data));

    // make temporary variabel for values
    $temp_values = array_values($data);
    for ($i = 0; $i < count($temp_values); $i++) {
      $temp_values[$i] = "'" . $temp_values[$i] . "'";
    }

    // get value of form data
    $values = implode(', ', $temp_values);

    // make query sql
    $sql = "INSERT INTO $table ($keys) VALUES ($values)";

    // return result of query
    return $this->db->query($sql);
  }

  // update existing data 
  public function updateData(string $table, array $data, array $id): bool
  {

    // get id
    $keyId = array_keys($id)[0];

    $strings = [];

    foreach ($data as $key => $value) {
      array_push($strings, $key . '=' . "'" . $value . "'");
    }

    $string = implode(', ', $strings);

    // rankaian untuk query update
    $sql = 'UPDATE ' . $table . ' SET ' . $string . ' WHERE ' . $keyId . '=' . "'" . $id[$keyId] . "'";

    // return result of query
    return $this->db->query($sql);
    // return $sql;
  }

  // delete data
  public function deleteData(string $table, array $id): bool
  {
    $keyId = array_keys($id)[0];
    $sql = "DELETE FROM $table WHERE $keyId = '" . $id[$keyId] . "'";

    return $this->db->query($sql);
    // return $sql;
  }
}
