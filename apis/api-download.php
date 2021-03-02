<?php
session_start();
if( !$_SESSION['jUser'] ){
  header('Location: ../login.php');
  exit;
}
//realpath escapes dangerous chars like ../ by returning /img/example.jpg
$img_path = "/Applications/MAMP/htdocs/security/Web Security Project/keabook/img/";
$img = realpath("../img/".$_GET["file"]);

//realpath returns false on failure, e.g. if the file does not exist
//404 not found
if($img===false){
	http_response_code(404);
	exit;
}

//strpos finds the position of the first occurrence of img_path inside img
//401 unauthorised
if(strpos($img, $img_path)!==0){
	http_response_code(401);
	exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$type=finfo_file($finfo, $img);
header("Content-type: ".$type);
finfo_close($finfo);

$handle=fopen($img,"r");
while (!feof($handle)) {
	@$contents.= fread($handle, 8192);
}
echo $contents;

?>