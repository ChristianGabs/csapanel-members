<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$.fn.CreateDatatable('#datatable');
			$(document).on("click", ".delete", function() {
				var url = $(this).attr('href');
				BootstrapDialog.confirm("{/literal}{$lang.deleteadmin}{literal}", function(r) {
					if (r) {
						$.fn.ajaxWindow();
						window.location.href = url;
					}
				});
				return false;
			});
		});
	{/literal}
</script>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<center>
			<a href="administrators.php?mode=add" class="btn btn-primary"><i class="fa fa-plus"></i> {$lang.addadministrator}</a>
		</center>
	</div>
</div>
<br/>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-users"></i> {$lang.administrators}</h3>
	</div>
	<div class="panel-body">
		<table id="datatable" class="table table-striped table-bordered table-condensed dataTable" width="100%">
			<thead>
				<tr>
					<th>{$lang.email}</th>
					<th width="60">{$lang.edit}</th>
					<th width="60">{$lang.delete}</th>
				</tr>
			</thead>
			<tbody>
				{section name=row loop=$admins}
					<tr>
						<td>{$admins[row].email|e}</td>
						<td align="center"><a href="administrators.php?mode=edit&uid={$admins[row].uid}" data-toggle="tooltip" title="{$lang.edit}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></td>
						<td align="center"><a href="administrators.php?mode=delete&uid={$admins[row].uid}" class="btn btn-danger btn-sm delete" data-toggle="tooltip" title="{$lang.delete}"><i class="fa fa-trash-o"></i></a></td>
					</tr>
				{/section}
			</tbody>
		</table>
	</div>
</div>
