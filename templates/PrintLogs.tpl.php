<script>start_pos=<?=$LogParser->start_pos?>; end_pos=<?=$LogParser->end_pos?>; start_line_num=<?=$LogParser->start_line_num?>; end_line_num=<?=$LogParser->end_line_num?>
</script>
<table id="mytable" cellspacing="0" width="100%">
	<colgroup>
	     <col span="1" style="width: 10%;">
	     <col span="1" style="width: 90%;">
	</colgroup>
	<tr class="header">
		<th>Line Number</th>
		<th>Line Content</th>
	</tr>
	<?foreach($results as $line_number=>$line_content){?>
		<tr>
			<td><?=$line_number?></td>
			<td><?=$line_content?></td>
		</tr>
	<?}?>
</table>