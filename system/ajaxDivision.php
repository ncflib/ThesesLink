<?php
include ("config.php");

$i = 0;
$old = array();
$names = "";
$sources = "";
$query = mysql_query("SELECT DISTINCT aoc, thesis, COUNT(*) c FROM aocs GROUP BY aoc");

while ($data = mysql_fetch_assoc($query))
{
	if ($data['c'] > 10 & $old['aoc'] != $data['aoc'])
	{
		$inquery = mysql_query("SELECT * FROM aocs WHERE aoc = '" . $data['aoc'] . "'");
		$old["Natural Sciences"] = 0;
		$old["Social Sciences"] = 0;
		$old["Humanities"] = 0;
		while ($indata = mysql_fetch_assoc($inquery))
		{
			$veri = mysql_fetch_assoc(mysql_query("SELECT division FROM theses WHERE id = " . $indata['thesis'] . " "));
			$old[$veri['division']]+= 1;
		}

		// Nat sci : 1
		// Humanities 0
		// Social 2

		if ($old["Natural Sciences"] >= $old["Social Sciences"])
		{
			if ($old["Natural Sciences"] >= $old["Humanities"])
			{
				$group = 1;
			}
			else
			{
				$group = 0;
			}
		}
		else
		{
			if ($old["Social Sciences"] >= $old["Humanities"])
			{
				$group = 2;
			}
			else
			{
				$group = 0;
			}
		}



		if ($group == strip_tags($_GET['id']) or strip_tags($_GET['id']) == 3)
		{
			if ($old["Natural Sciences"] != 0 and (1 == strip_tags($_GET['id']) or strip_tags($_GET['id']) == 3))
			{
				$sources.= '{"target": "' . trim($data['aoc']) . '", "source": "Natural Sciences", "value":' . $old['Natural Sciences'] . '},';
			}

			if ($old["Social Sciences"] != 0 and (2 == strip_tags($_GET['id']) or strip_tags($_GET['id']) == 3))
			{
				$sources.= '{"target": "' . trim($data['aoc']) . '", "source": "Social Sciences", "value":' . $old['Social Sciences'] . '},';
			}

			if ($old["Humanities"] != 0 and (0 == strip_tags($_GET['id']) or strip_tags($_GET['id']) == 3))
			{
				$sources.= '{"target": "' . trim($data['aoc']) . '", "source": "Humanities", "value":' . $old['Humanities'] . '},';
			}

			if (!(trim($data['aoc']) == "Social Sciences" or trim($data['aoc']) == "Natural Sciences" or trim($data['aoc']) == "Humanities"))
			{
				if (strip_tags($_GET['id']) == 3)
				{
					$title = "";
					$radius = 0;
				}
				else
				{
					$title = trim($data['aoc']);
					$radius = 40;
				}
			}
			else
			{
				$title = trim($data['aoc']);
			}

			if (trim($data['aoc']) == "Social Sciences" or trim($data['aoc']) == "Natural Sciences" or trim($data['aoc']) == "Humanities")
			{
				$names.= '{"name": "' . trim($data['aoc']) . '", "title": "' . $title . '", "type": "0", "group": "' . $group . '", "radius": ' . (floor(sqrt($data['c'])) + 50 + $radius) . ', "id" : ' . $i . '},';
			}
			else
			{
				$names.= '{"name": "' . trim($data['aoc']) . '", "title": "", "type": "1", "group": "' . $group . '", "radius": ' . (floor(sqrt($data['c'])) + $radius) . ', "id" : ' . $i . '},';

			}
		}

		$old = array();
		$old['aoc'] = $data['aoc'];
		$i++;
	}
}

echo "[ [";
echo substr($names, 0, -1);
echo "],[";
echo substr($sources, 0, -1);
echo "] ]";
?>
