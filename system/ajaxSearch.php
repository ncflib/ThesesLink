<?php
include ("config.php");
$i = 0;
$old = array();
$aocarray = array();
$names = "";
$sources = "";
$get_aocname = strip_tags($_GET['id']);
$get_multi = strip_tags($_GET['multi']);
$get_year = strip_tags($_GET['year']);
$get_year2 = strip_tags($_GET['year2']);
$divisions["Humanities"] = 0;
$divisions["Natural Sciences"] = 1;
$search = $_GET['search'];
$divisions["Social Sciences"] = 2;
$cachedosyasi = "cache/".md5($_GET['id'].$get_aocname.$get_multi.$get_year.$get_year2.$search.$_GET['multi']."ajaxAOCS");
if (file_exists($cachedosyasi)) {
include($cachedosyasi);
exit;
}
ob_start();
$query = $db->prepare("SELECT thesis FROM aocs WHERE aoc LIKE ?");  
$query->execute(array('%'.$get_aocname.'%'));  
$query= $query->fetchAll();
foreach($query as $data)
{
	$veri = $db -> query("SELECT * FROM theses WHERE id = '" . $data['thesis'] . "'")->fetch(PDO::FETCH_ASSOC);

	// TAKE ALL THE AOCS ASSOCIATED WITH THIS THESIS, CREATE LINKS AND THESIS NODE

	if ($veri['graduatedate'] > $get_year and $veri['graduatedate'] < $get_year2)
	{
		$title = str_replace('”', '', $veri['title']);
		$title = str_replace('“', '', $title);
		$title = str_replace('\\', '', $title);
		$title = str_replace("'", '', $title);
		$title = str_replace('"', '', $title);
		if (strlen($title) > 70)
		{
			$title = substr($title, 0, 70);
			$title = $title . "...";
		}

		$querynew = $db->query("SELECT aoc FROM aocs WHERE thesis = '" . $data['thesis'] . "'", PDO::FETCH_ASSOC);
		$querynewsize = $querynew->rowCount();
		if ($get_multi == 1)
		{
			$limiter = 1;
		}
		else
		{
			$limiter = 0;
		}

		if ($querynewsize > $limiter)
		{
			foreach($querynew as $verinew)
			{
				if ($aocarray[$verinew['aoc']] != "")
				{
					$aocarray[$verinew['aoc']]+= 1;
				}
				else
				{
					$aocarray[$verinew['aoc']] = 1;
				}

				$sources.= '{"target": "' . $title . '", "source": "' . $verinew['aoc'] . '", "value":1},';
			}

			$names.= '{"name": "' . $title . '", "title": "", "type": "2", "group": "' . $divisions[$veri['division']] . '", "radius": 7, "id" : ' . $veri['id'] . '},';
		}
	}

	// Nat sci : 1
	// Humanities 0
	// Social 2

	$i++;
}

$size = sizeof($aocarray);
$keys = array_keys($aocarray);
$values = array_values($aocarray);

if ($size > 0)
{
	for ($a = 0; $a < $size; $a++)
	{
		$query = $db->prepare("SELECT division FROM aocs WHERE aoc =?");  
		$query->execute(array($keys[$a]));  
		$veri  = $query->fetch(PDO::FETCH_ASSOC);
		if ($get_aocname == $keys[$a])
		{
			$names.= '{"name": "' . $keys[$a] . '", "title": "", "type": "1", "group": "' . $veri['division'] . '", "radius": 50, "id" : ' . $i . '},';
		}
		else
		{
			$names.= '{"name": "' . $keys[$a] . '", "title": "", "type": "1", "group": "' . $veri['division'] . '", "radius": ' . min($values[$a] * 10, 60) . ', "id" : ' . $i . '},';
		}

		$i++;
	}
}

echo "[ [";
echo substr($names, 0, -1);
echo "],[";
echo substr($sources, 0, -1);
echo "] ]";
$ch = fopen($cachedosyasi, 'w');
fwrite($ch, ob_get_contents());
fclose($ch);
ob_end_flush();
?>