<div class="row">
<div class="col-md-8">
<?php 
$jlh_data = count($data);
$kalender = '';
for ($i=0; $i < $jlh_data; $i++) { 
	$kalender .= "{
		'title' : '" . $data[$i]['tema'] . "' ,
		'start' : '" . $data[$i]['tgl_mulai'] . "',
		'end'	: '" .  $data[$i]['tgl_selesai'] . "'
		},";
}
?>
 <script>
    $(document).ready(function(){
    	
        $('#agenda').fullCalendar({
            defaultDate: '<?php echo date('Y-m-d'); ?>',
            editable: true,
            eventLimit: true,
            events:[<?php echo $kalender; ?>]
        });
    });
</script>
<div id="agenda"></div>

