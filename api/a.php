<?php
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

	 define('HOST','localhost');
  define('USER','root');
  define('PASS','');
  define('DB','your');
  $conn = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
	
	$id_tiket 		= htmlspecialchars($_POST['id_tiket']);
	$waktu 			= htmlspecialchars($_POST['waktu']);
	$userscanner 	= htmlspecialchars($_POST['userscanner']);
	$kegiatan 		= htmlspecialchars($_POST['kegiatan']);
	// $date_created	= date('H:i:s');

	$sql="select * from activity where id_tiket='$id_tiket' and kegiatan='$kegiatan'";
	$result=mysqli_query($conn,$sql);
	$totalrow=mysqli_num_rows($result);
	echo $sql;
	echo "total row:".$totalrow;
	
	// create
	$query1 		= mysqli_query($conn, "INSERT INTO activity (id_tiket, waktu, userscanner, kegiatan) VALUES ( '$id_tiket', '$waktu', '$userscanner','$kegiatan') ");

	if($query1) {
		echo json_encode(array('response'=>'success'));
	} else {
	    echo json_encode(array('response'=>'failed'));
	}
?>
 