<?php

include("config.php");
$i = 0;
$old = array();
$names="";
$sources="";
$query = mysql_query("SELECT DISTINCT aoc, thesis, COUNT(*) c FROM aocs GROUP BY aoc");
while($data = mysql_fetch_assoc($query)) {
	if($data['c'] > 4 & $old['aoc'] != $data['aoc']) {
	$inquery = mysql_query("SELECT * FROM aocs WHERE aoc = '".$data['aoc']."'");
	$old["Natural Sciences"] = 0;
	$old["Social Sciences"] = 0;
	$old["Humanities"] = 0;
	while($indata = mysql_fetch_assoc($inquery)) {
		$veri = mysql_fetch_assoc(mysql_query("SELECT division FROM theses WHERE id = ".$indata['thesis']." "));
		$old[$veri['division']] += 1;
	}

	if($old["Natural Sciences"] != 0) {
		$sources .= '{"source": "'.trim($data['aoc']).'", "target": "Natural Sciences", "value":'.$old['Natural Sciences'].'},<br />';
	}
	if($old["Social Sciences"] != 0) {
		$sources .= '{"source": "'.trim($data['aoc']).'", "target": "Social Sciences", "value":'.$old['Social Sciences'].'},<br />';
	}
	if($old["Humanities"] != 0) {
		$sources .= '{"source": "'.trim($data['aoc']).'", "target": "Humanities", "value":'.$old['Humanities'].'},<br />';
	}
	
	if($old["Natural Sciences"] >= $old["Social Sciences"]) {
		if($old["Natural Sciences"] >= $old["Humanities"]) {
			$group = 1;
		} else {
			$group = 0;
		}

	} else {
		if($old["Social Sciences"] >= $old["Humanities"]) {
			$group = 2;
		} else {
			$group = 0;
		}
	}
	if(trim($data['aoc']) == "Social Sciences" or trim($data['aoc']) == "Natural Sciences" or trim($data['aoc']) == "Humanities") {
	$names.= '{"name": "'.trim($data['aoc']).'", "type": "0", "group": "'.$group.'", "radius": '.floor(sqrt($data['c']))+35.'},<br />';
	} else {
	$names.= '{"name": "'.trim($data['aoc']).'", "type": "1", "group": "'.$group.'", "radius": '.floor(sqrt($data['c'])).'},<br />';
	}



	$old = array();
	$old['aoc'] = $data['aoc'];
	}
}

echo $names;
echo $sources; 


?>