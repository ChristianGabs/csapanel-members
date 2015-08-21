<div class="button-add">
	<div class="centered">
		<a class="btn btn-primary" href="utility.php?module=databaseoptimize&mode=optimize"><i class="fa fa-refresh"></i> {$lang.optimize}</a>
</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-sitemap"></i> {$lang.optimize}</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="centered">
				<span class="label label-info">{$lang.optimizetips}</span>
			</div>
			<div class="centered notification">
				<span class="label label-info">{$lang.optimizetips2}</span>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" id="datatable" width="100%">
					<thead>
						<tr>
							<th>{$lang.table}</th>
							<th>{$lang.operation}</th>
							<th>{$lang.status}</th>
							<th width='30%'>{$lang.messages}</th>
						</tr>
					</thead>
					<tbody>
						{section name=row loop=$analysis}
							<tr>
								<td>{$analysis[row].Table|e}</td>
								<td>{$analysis[row].Op|e}</td>
								<td>{$analysis[row].Msg_type|e}</td>
								<td>{$analysis[row].Msg_text|e}</td>
							</tr>
						{/section}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>