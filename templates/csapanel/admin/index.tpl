<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-signal"></i> {$lang.statistics}</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-4">
						<ul class="site-stats">
							<li>
								<div class="cc">
									<i class="fa fa-user fa-2x"></i> <strong>{$usertrust}</strong><small>{$lang.usertrust}</small>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-4">
						<ul class="site-stats">
							<li>
								<div class="cc">
									<i class="fa fa-legal fa-2x"></i><strong>{$untrustworthy}</strong><small>{$lang.useruntrustworthy}</small>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-4">
						<ul class="site-stats">
							<li>
								<div class="cc">
									<i class="fa fa-pie-chart fa-2x"></i><strong>{$userpending}</strong><small>{$lang.userpending}</small>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row hidden-xs">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> {$lang.events} <a href="utility.php?module=logs"><span style="font-size: 11px; font-weight:normal;">{$lang.viewall}</span></a></h3>
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="datatable" width="100%">
					<thead>
						<tr>
							<th>{$lang.time}</th>
							<th>{$lang.username}</th>
							<th>{$lang.description}</th>
							<th>{$lang.runby}</th>
						</tr>
					</thead>
					<tbody>
						{section name=id loop=$events}
							<tr>
								<td>{$events[id].time|date_format:"%A | %B %e, %Y  - %I:%M %p"}</td>
								<td>{$events[id].user|e}</td>
								<td>{$events[id].message}</td>
								<td>{$events[id].runby|e}</td>
							</tr>
						{/section}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>