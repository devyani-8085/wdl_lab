<?php
$data = json_decode(file_get_contents("data.json"), true);
?>

<h2>All Users Data</h2>

<table border="1" cellpadding="10">
<tr>
<th>Name</th>
<th>Skills</th>
<th>Interest</th>
<th>City</th>
</tr>

<?php foreach ($data as $u): ?>
<tr>
<td><?= $u['name'] ?></td>
<td><?= implode(", ", $u['skills']) ?></td>
<td><?= $u['interest'] ?></td>
<td><?= $u['city'] ?></td>
</tr>
<?php endforeach; ?>
</table>