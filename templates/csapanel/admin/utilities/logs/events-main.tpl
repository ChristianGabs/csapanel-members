<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$.fn.CreateDatatable('#eventtable');
			$.fn.eventPaginate({/literal}{$pages.totalpage}{literal}, {/literal}{$pages.current}{literal})
	
			$('#userid').change(function() {
				$.fn.refreshEventList(0);
			});
		});
	{/literal}
</script>

<form action="utility.php?module=logs&logtype=events" method="get" id="eventform">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-bell"></i> {$lang.eventlog}</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<select name="userid" id="userid" class="form-control">
						<option value="">{$lang.user}</option>
						{section name=row loop=$users}
							<option value="{$users[row].uid}" {if $smarty.request.userid == $users[row].uid}selected=selected{/if}>{$users[row].email|e}</option>
						{/section}
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<a href="utility.php?module=logs&clear=true" class="clearbutton btn btn-danger">{$lang.cleareventlog}</a>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="eventlist">
						{include file='admin/utilities/logs/events-list.tpl'}
					</div>
					<div id="pagination"></div>
				</div>
			</div>
		</div>
	</div>
</form>