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
$get_aocname = strip_tags($_GET['id']);
$get_multi = strip_tags($_GET['multi']);
$get_year = strip_tags($_GET['year']);
$get_year2 = strip_tags($_GET['year2']);
$search = $_GET['search'];
$divisions["Humanities"] = 0;
$divisions["Natural Sciences"] = 1;
$divisions["Social Sciences"] = 2;

if ($search == 1)
{
	$query = mysql_query("SELECT thesis FROM aocs WHERE aoc LIKE '%" . $get_aocname . "%' ");
}
else
{
	$query = mysql_query("SELECT thesis FROM aocs WHERE aoc = '" . trim($get_aocname) . "' ");
}

while ($data = mysql_fetch_assoc($query))
{
	$veri = mysql_fetch_assoc(mysql_query("SELECT * FROM theses WHERE id = '" . $data['thesis'] . "'"));

	if ($veri['graduatedate'] > $get_year and $veri['graduatedate'] < $get_year2)
	{
		$title = str_replace('”', '', $veri['title']);
		$title = str_replace('“', '', $title);
		$title = str_replace('\\', '', $title);
		$title = str_replace("'", '', $title);
		$title = str_replace('"', '', $title);
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
?>
	 <tr>
	      <td onClick="getDetail(<?php echo $veri['id']; ?>);" style="cursor: pointer"><?php
			echo mysql_real_escape_string($veri['title']); ?></td>
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