<div class="row">
	<div class="col-md-8">
<?php 
function fungsiCurl($url){
  $data = curl_init();
  curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($data, CURLOPT_URL, $url);
  curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
  $hasil = curl_exec($data);
  curl_close($data);
  //var_dump($hasil);
  return $hasil;
}
$url = fungsiCurl('http://www.bmkg.go.id/cuaca/prakiraan-cuaca-indonesia.bmkg?Prov=34&NamaProv=Sumatera%20Utara');
$pecah = explode('<div class="prakicu-kabkota tab-v1">',$url);
$pecah_1 = explode('</table>', $pecah[1]);
//var_dump($pecah_1);
$p = str_replace('<a href="', '<a href="http://www.bmkg.go.id/', $pecah_1[0]);
$p1 = str_replace('<a href="', '<a href="http://www.bmkg.go.id/', $pecah_1[1]);

echo '<div class="prakicu-kabkota tab-v1">';
	echo $p;
	echo '</table>';
	echo $p1;
	echo '</table>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
echo '</div>';
echo '<div class="clearfix"></div>';


