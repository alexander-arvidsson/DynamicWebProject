<?php
$topic = trim_input($_POST['topic']);
$comment = trim_input($_POST['comment']);
$date = trim_input($_POST['date']);
$time = trim_input($_POST['time']);

  if(empty($topic)) {
    $json = json_encode(array("status" => "Top_Error"));
    echo $json;
    exit();
  } 
  else if(empty($comment)) {
    $json = json_encode(array("status" => "Com_Error"));
    echo $json;
    exit();
  } else if(empty($time)) {
    $json = json_encode(array("status" => "Time_Error"));
      echo $json;
      exit();
    } else if(empty($date))  {
    $json = json_encode(array("status" => "Date_Error"));
    echo $json;
    exit();
    } 

function trim_input($data) {
    $data = trim($data);
    return $data;
  }

?>