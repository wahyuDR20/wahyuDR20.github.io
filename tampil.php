<?php
require 'curl_lib.php';

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
  <title>Tracking AirwayBill CSC Garuda Juru Mudi</title>
    <link rel="stylesheet" href="search_forms.css">
  </head>
  <body>
    <div class="wrapper">
      <div id="formContent">
        <!-- Tabs Titles -->
        <h2 class="active">AWB NO:<?php echo $_GET['crcode'];?>-<?=$_GET['awbno'];?>
          <!-- <br>(<?=$data["Table0"][0]["FlightNo"];?>) -->
        </h2>
        <!-- Icon -->
        <div class="fadeIn first">
          <table>
            <tbody>
              <tr>
                <?php	
              
$a=count($data["Table0"]);
if($a=='0'){
echo "data tidak ditemukan, coba cek no awb kembali";
}else{
$no=0;
for($i = 0; $i < sizeof($data["Table0"]); $i++)
{
$n2=$no++;
if($n2!=0){
echo '<td style="text-align:center;padding:1px;"><img src="images/arrowtrack.png" style="width:50px";" alt="arrow"></td>';
}
echo '<td style="text-align:center;padding:1px;"><p>'.$data["Table2"][$i]["FlightNo"].'<br>'.$data["Table2"][$i]["Station"].'</p><img src="images/'.$data["Table2"][$i]["Action"].'.png" style="width:50px";" alt="confirm order">
<p>'.$data["Table2"][$i]["Action"].'</p><p>'.$data["Table2"][$i]["createdon"].'</p><p>'.$data["Table2"][$i]["Pieces"].' pcs, '.$data["Table2"][$i]["Weight"].'kg</p></td>';

}
}
?>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Login Form -->
        <!-- Remind Passowrd -->
        <div id="formFooter">
          <a class="underlineHover" href="amt.php">Kembali
          </a>
        </div>
      </div>
    </div>
  </body>
</html>
