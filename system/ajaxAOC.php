<?php
$get_aocname = strip_tags($_GET['id']);
$get_multi = strip_tags($_GET['multi']);
$get_year = strip_tags($_GET['year']);
$get_year2 = strip_tags($_GET['year2']);
$search = $_GET['search'];
$cachedosyasi = "cache/".md5($_GET['id'].$get_aocname.$get_multi.$get_year.$get_year2.$search.$_GET['multi']."ajaxAOC");
if (file_exists($cachedosyasi)) {
include($cachedosyasi);
exit;
}
ob_start();
?>
<div height="500" style="height:400px; overflow: scroll;">
<table class="table table-dark">
	  <thead>
	    <tr>
	      <th scope="col">Title</th>
	      <th scope="col">Date</th>
	      <th scope="col">Student</th>
	    </tr>
	  </thead>
	  <tbody>
<?php
include ("config.php");

$i = 0;
$old = array();
$aocarray = array();
$names = "";
$sources = "";

$divisions["Humanities"] = 0;
$divisions["Natural Sciences"] = 1;
$divisions["Social Sciences"] = 2;

if ($search == 1)
{
	$query = $db->query("SELECT thesis FROM aocs WHERE aoc LIKE '%" . $get_aocname . "%' ", PDO::FETCH_ASSOC);
}
else
{
	$query = $db->query("SELECT thesis FROM aocs WHERE aoc = '" . trim($get_aocname) . "' ", PDO::FETCH_ASSOC);
}

foreach ( $query as $data )
{
	$veri = $db -> query("SELECT * FROM theses WHERE id = '" . $data['thesis'] . "'")->fetch(PDO::FETCH_ASSOC);

	if ($veri['graduatedate'] > $get_year and $veri['graduatedate'] < $get_year2)
	{
		/*$title = str_replace('”', '', $veri['title']);
		$title = str_replace('“', '', $title);
		$title = str_replace('\\', '', $title);
		$title = str_replace("'", '', $title);
		$title = str_replace('"', '', $title);*/
		$title = iconv("ISO-8859-1","UTF-8",$title);
		$querynew = $db->query("SELECT aoc FROM aocs WHERE thesis = '" . $data['thesis'] . "'", PDO::FETCH_ASSOC);
		$querynewsize = $querynew -> rowCount();
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
?>
	 <tr>
	      <td onClick="getDetail(<?php echo $veri['id']; ?>);" style="cursor: pointer"><?php
			echo $veri['title']; ?></td>
	      <td><?php
			echo $veri['graduatedate']; ?></td>
	      <td><?php
			echo $veri['student']; ?></td>
	  </tr>
	<?php
		}
	}

	// Nat sci : 1
	// Humanities 0
	// Social 2

	$i++;
}

?>
</tbody>
</table>
</div>
<?php
$ch = fopen($cachedosyasi, 'w');
fwrite($ch, ob_get_contents());
fclose($ch);
ob_end_flush();
?>