<?php
function http_request($url){
    // persiapkan curl
    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // set user agent    
    // curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    // mengembalikan hasil curl
    return $output;
}
/*run curl runction*/
$str_data = http_request('https://icms.garuda-indonesia.com/Services/Shipment/AWBTrackingService.svc/GetAWBTrackingRecord?BasedOn=0&AWBNo='.$_GET['awbno'].'&CarrierCode='.$_GET['crcode'].'');

// decoding the data
$datako = json_decode($str_data, TRUE);

//print_r($datako);

/*fopen and fwrite to data.json*/
 $fp = fopen('data.json', 'w');
 	fwrite($fp,$datako);
 	/*then close*/
 	fclose($fp);
 	/*then get curl*/
 
$str_dt =  file_get_contents('data.json');
/*decode the data*/
 	$data= json_decode($str_dt,true);
 	?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<!-- 	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500|Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
	<!-- <link rel="stylesheet" href="search_forms.css"> -->
	<link rel="stylesheet" href="resp.css">

</head>
<body>

  
</div>
</div>
</div>
<div class="box box-4">
			<div class="box-content">
        <h2>AWB NO: <?php echo $_GET['crcode'];?>-<?=$_GET['awbno'];?></h2>
			 <table>
	<tbody>
		<tr>

	<?php	
	$no=0;
	for($i = 0; $i < sizeof($data["Table0"]); $i++)
	{
	$n2=$no++;
	
	if($n2!=0){
	echo '<td style="text-align:center;padding:1px;"><img src="images/arrowtrack.png" style="width:50px";" alt="arrow"></td>';
	}
	echo '<td style="text-align:center;padding:1px;">
	<p><b>'.$data["Table2"][$i]["Station"].'</b></p><img src="images/'.$data["Table2"][$i]["Action"].'.png" style="width:50px";" alt="confirm order">
	<p><b>'.$data["Table2"][$i]["Action"].'</b></p><p><b>'.$data["Table2"][$i]["createdon"].'</b></p><p><b>'.$data["Table2"][$i]["Pieces"].' pcs, '.$data["Table2"][$i]["Weight"].'kg</b></p></td>';
}
			?>
	
			</tr>
		</tbody>
	</table>
			</div>
		</div>

</body>

</html>