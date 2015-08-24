<script type="text/javascript">
	{literal}
		$(function() {
			$.fn.paginate({/literal}{$pages.totalpage}{literal}, {/literal}{$pages.current}{literal})
		});
	{/literal}
</script>
<div id="ajax-clientlist">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" id="datatable" width="100%">
		<thead>
			<tr>
				<th>{$lang.name} / {$lang.userid}</th>
				<th data-hide="phone">{$lang.email}</th>
				<th >{$lang.realname}</th>
				<th>{$lang.proof}</th>
				<th data-hide="phone">{$lang.notes}</th>
				<th>{$lang.status}</th>
				<th data-hide="phone">{$lang.dateadd}</th>
			</tr>
		</thead>
		<tbody>
			{section name=row loop=$clients}
				<tr data-uid="{$clients[row].uid}">
					<td> 
						{if !$linkprofil}
							{$clients[row].userid|e}
						{else}
							<a href="http://{$linkprofil}/{$clients[row].userid|e}" target="_blank">{$clients[row].userid|e}</a>
						{/if}
					</td>
					<td>{$clients[row].email|e}</td>
					<td>{$clients[row].realname}</td>
					<td style="text-align:center">
						<a class="proofdialog label label-info" href="index.php?mode=getproof&uid={$clients[row].uid|e}">{$lang.view}</a>
					</td>
					<td style="text-align:center">
						<a class="notesdialog label label-info" href="index.php?mode=getnotes&uid={$clients[row].uid|e}">{$lang.view}</a>
					</td>
					<td style="text-align:center">
					{if $clients[row].status == "0"}
						<span class="label label-success">{$lang.trust}</span>
					{elseif $clients[row].status == "1"}
						<span class="label label-danger">{$lang.untrustworthy}</span>
					{/if}
					</td>
					<td style="text-align:center">{$clients[row].time|date_format:"%A | %d.%m.%Y  - %R"}</td>
				</tr>
			{/section}
		</tbody>
	</table>
</div>