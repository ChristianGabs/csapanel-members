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
						<a class="proofdialog label label-primary" href="clientspending.php?mode=getproof&uid={$clients[row].uid|e}"><i class="fa fa-search-plus"></i> {$lang.view}</a>
					</td>
					<td style="text-align:center">
						<a class="notesdialog label label-primary" href="clientspending.php?mode=getnotes&uid={$clients[row].uid|e}"><i class="fa fa-search-plus"></i> {$lang.view}</a>
					</td>
					<td style="text-align:center">
					{if $clients[row].status == "0"}
					<span class="label label-success">{$lang.trust}</span>
					{elseif $clients[row].status == "1"}
						<span class="label label-danger">{$lang.untrustworthy}</span>
					{/if}
					</td>
					<td style="text-align:center" width="80">
					<a class="btn btn-success btn-xs" href="clientspending.php?mode=approve&uid={$clients[row].uid}" data-toggle="tooltip" data-placement="top" title="{$lang.approve}"><i class="fa fa-check"></i></a>
					<a class="btn btn-primary btn-xs" href="clientspending.php?mode=edit&uid={$clients[row].uid}" data-toggle="tooltip" data-placement="top" title="{$lang.edit}"><i class="fa fa-edit"></i></a>
					<a class="btn btn-danger btn-xs" href="clientspending.php?mode=delete&uid={$clients[row].uid}" data-toggle="tooltip" data-placement="top" title="{$lang.delete}"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
			{/section}
		</tbody>
	</table>
</div>
