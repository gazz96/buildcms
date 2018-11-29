<?php 

function tanggal($type=""){
	$now = explode('-', date('Y-m-D-d'));

	$bulan_arr = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	);

	$hari_arr = array(
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Thu' => 'Rabu',
		'Wed' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu',
		'Sun' => 'Minggu'
	);
	$hari = $hari_arr[$now[2]];
	$bulan = $bulan_arr[$now[1]];
	$tanggal = "";
	if ($type == "") {
		$tanggal = $hari . ", " . $now[3] . " " . $bulan . " " . $now[0];
	}
	else{
		$tanggal = $now[3] . "-" . $now[1] . "-" . $now[0];
	}
	return $tanggal;
}