<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "storagedb";

$con = new mysqli($servername, $username, $password, $dbname);
global $con;

if(!$con){
    die("Database connection failed");
}
  function filteration($data){
    foreach($data as $key => $value){
      $value = trim($value);
      $value = stripslashes($value);
      $value = strip_tags($value);
      $value = htmlspecialchars($value);
      $data[$key] = $value;
    }
    return $data;
  }

  function selectAll($table)
  {
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
  }

  function select($query, $values, $datatypes)
{
    global $con; // ✅ IMPORTANT

    $stmt = mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $res;
    }else{
        die("Query cannot be prepared - Select");
    }
}
function insert($query, $values, $datatypes)
{
    global $con;
    $stmt = mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res; 
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert");
        }
    } else {
        die("Query cannot be prepared - Insert");
    }
}

?>