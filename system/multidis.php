<?php

include('config.php');

for($graduatedate = 1970; $graduatedate<=2018; $graduatedate++) {
$multi = 0;
$single = 0;

$query = mysql_query("SELECT * FROM theses WHERE graduatedate = $graduatedate and division = 'Social Sciences' ");
while($data = mysql_fetch_assoc($query)) {
	$thesisid = $data['id'];
	//$multidiv = mysql_num_rows(mysql_query("SELECT id FROM aocs WHERE thesis = '$thesisid'"));
	//if($multidiv > 1) {
	//	$multi++;
	//} else {
	//	$single++;
	//}
	$multi++;
}

echo $multi;
echo ",";


}




?>