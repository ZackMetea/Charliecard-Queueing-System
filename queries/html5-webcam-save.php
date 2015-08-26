<?php
$connecionInfoFile = parse_ini_file("connectionInfo.ini");
$rawData = $_POST['imgBase64'];
$filteredData = explode(',', $rawData);
$unencoded = base64_decode($filteredData[1]);

$datime = date("Y-m-d") ; # - 3600*7

$firstname  = $_POST['firstname'] ;
$lastname  = $_POST['lastname'] ;
$phone  = $_POST['phone'] ;
$bday  = $_POST['bday'] ;
$filename = '\\\\172.17.0.14\\APL-SERV\\Data32\\PICTURE\\PIDQ\\'.$datime.'\\'.$firstname.'-'.$lastname."-".$bday.'.jpg';
$dirname = dirname($filename);
if(!is_dir($dirname))
{
	mkdir($dirname, 0755, true);
}
// name & save the image file 

$fp = fopen($filename, 'w');
fwrite($fp, $unencoded);
fclose($fp);

$filenameserver = 'C:/xampp/htdocs/'.$connecionInfoFile['imagepath'].'/images/customers/'.$datime.'/'.$firstname.'-'.$lastname."-".$bday.'.jpg';
$dirnameserver = dirname($filenameserver);
if(!is_dir($dirnameserver))
{
	mkdir($dirnameserver, 0755, true);
}
$fp = fopen($filenameserver, 'w');
fwrite($fp, $unencoded);

fclose($fp);
  // update or insert a users record  
?>