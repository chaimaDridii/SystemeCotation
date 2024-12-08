<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 
  $db_username = 'root';
 $db_password = '';
 $db_name = 'pfe';
 $db_host = 'localhost';				
$conn = new mysqli($db_host, $db_username, $db_password,$db_name);
 
if ($conn->connect_error) {
    die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
}
$data=[];
if ($_REQUEST['cmd']=="verif_login")
{
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

$sql="SELECT *,(select titre from service S where S.id = C.id_service) as 'service' FROM `compte` C WHERE C.email = '".addslashes($email)."' AND C.password ='".addslashes($password)."'";
    $res = $conn->query($sql);
   if ($res->num_rows>0)
   {
       $row = $res->fetch_assoc();
       $data=["log"=>true , "data"=>$row];
   }
   else
   {
    $data=["log"=>false , "data"=>[]];
   }
print_r(json_encode($data,JSON_UNESCAPED_UNICODE ));
}
else if ($_REQUEST['cmd']=="register")
{$name = $_REQUEST['name'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    $mobile = $_REQUEST['mobile'];
    $sql2 = "INSERT INTO `employee`( `name`, `pwd`, `email`, `mobile`) VALUES ('$name','$password','$email','$mobile')";
    $res2 = $conn->query($sql2);
    if ($res2)
    {
        $data=true;
    }
    else
    {
     $data=false;
    }
    print_r(json_encode($data,JSON_UNESCAPED_UNICODE ));
} 
?>
