<script type="text/javascript">
	{literal}
		$(function() {
			$.fn.paginate({/literal}{$pages.totalpage}{literal}, {/literal}{$pages.current}{literal})
		});
	{/literal}
</script>
<div id="ajax-clientlist">
	<table class="table table-striped table-bordered table-condensed" id="datatable" width="100%">
		<thead>
			<tr>
				<th>{$lang.name} / {$lang.userid}</th>
				<th>{$lang.email}</th>
				<th data-hide="phone">{$lang.realname}</th>
				<th data-hide="phone">{$lang.proof}</th>
				<th data-hide="phone">{$lang.notes}</th>
				<th data-hide="phone">{$lang.status}</th>
				<th data-hide="phone">{$lang.manage}</th>
			</tr>
		</thead>
		<tbody>
			{section name=row loop=$clients}
				<tr data-uid="{$clients[row].uid}">
					<td>{$clients[row].userid|e}</td>
					<td>{$clients[row].email|e}</td>
					<td>{$clients[row].realname}</td>
					<td style="text-align:center">
						<a class="proofdialog label label-info" href="clients.php?mode=getproof&uid={$clients[row].uid|e}">{$lang.view}</a>
					</td>
					<td style="text-align:center">
						<a class="notesdialog label label-info" href="clients.php?mode=getnotes&uid={$clients[row].uid|e}">{$lang.view}</a>
					</td>
					<td style="text-align:center">
					{if $clients[row].status == "0"}
					<span class="label label-success">{$lang.trust}</span>
					{elseif $clients[row].status == "1"}
						<span class="label label-danger">{$lang.untrustworthy}</span>
					{/if}
					</td>
					<td width="80"><a class="btn btn-success btn-xs" href="clients.php?mode=summary&uid={$clients[row].uid}"><i class="fa fa-edit"></i> {$lang.manage}</a></td>
				</tr>
			{/section}
		</tbody>
	</table>
</div>
