<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$.fn.eventPaginate({/literal}{$pages.totalpage}{literal}, {/literal}{$pages.current}{literal})
		});
	{/literal}
</script>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" id="eventtable" style="width:100%">
	<thead>
		<tr>
			<th width="230">{$lang.time}</th>
			<th width="240">{$lang.user}</th>
			<th width="400">{$lang.description}</th>
			<th>{$lang.runby}</th>
		</tr>
	</thead>
	<tbody>
		{section name=id loop=$events}
			<tr>
				<td>{$events[id].time|date_format:"%A | %d.%m.%Y  - %R"}</td>
				<td>{$events[id].user|e}</td>
				<td>{$events[id].message}</td>
				<td>{$events[id].runby|e}</td>
			</tr>
		{/section}
	</tbody>
</table>
