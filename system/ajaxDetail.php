<?php
include("config.php");
$id = strip_tags($_GET['id']);
$veri = mysql_fetch_assoc(mysql_query("SELECT * FROM theses WHERE id = '$id'"));
?>
<div height="500" style="height:350px; overflow: scroll;">
<table class="table table-dark">
<thead>
</thead>
<tbody>
	<tr><td><b>Title : </b><?php echo $veri['title']; ?></td></tr>
	<tr><td><b>Thesis Record :</b> <a href="<?php echo $veri['tlink']; ?>/00001/citation" target="_BLANK"><?php echo $veri['tlink']; ?></a></td></tr>
	<?php if($veri['abstract'] != "") { ?><tr><td><b>Abstract : </b><?php echo $veri['abstract']; ?></td></tr><?php } ?>
	<tr><td><b>Graduation Date : </b><?php echo $veri['graduatedate']; ?></td></tr>
	<tr><td><b>Author(s) : </b><?php echo $veri['student']; ?></td></tr>
	<tr><td><b>Division : </b><?php echo $veri['division']; ?></td></tr>
</tbody>
</table>
</div>