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
$divisions["Social Sciences"] = 2;
$query = mysql_query("SELECT thesis FROM aocs WHERE aoc LIKE '%" . $get_aocname . "%' ");

while ($data = mysql_fetch_assoc($query))
{
	$veri = mysql_fetch_assoc(mysql_query("SELECT * FROM theses WHERE id = '" . $data['thesis'] . "'"));

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

		$querynew = mysql_query("SELECT aoc FROM aocs WHERE thesis = '" . $data['thesis'] . "'");
		$querynewsize = mysql_num_rows($querynew);
		if (strip_tags($_GET['multi']) == 1)
		{
			$limiter = 1;
		}
		else
		{
			$limiter = 0;
		}

		if ($querynewsize > $limiter)
		{
			while ($verinew = mysql_fetch_assoc($querynew))
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
		$veri = mysql_fetch_assoc(mysql_query("SELECT * FROM aocs WHERE aoc = '" . mysql_real_escape_string($keys[$a]) . "'"));
		if ($get_aocname == $keys[$a])
		{
			$names.= '{"name": "' . $keys[$a] . '", "title": "", "type": "1", "group": "' . $veri['division'] . '", "radius": 50, "id" : ' . $i . '},';
		}
		else
		{
			$names.= '{"name": "' . $keys[$a] . '", "title": "", "type": "1", "group": "' . $veri['division'] . '", "radius": ' . min($values[$a] * 10, 50) . ', "id" : ' . $i . '},';
		}

		$i++;
	}
}

echo "[ [";
echo substr($names, 0, -1);
echo "],[";
echo substr($sources, 0, -1);
echo "] ]";
?>