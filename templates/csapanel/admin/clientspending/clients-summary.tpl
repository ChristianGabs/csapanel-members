<form action="clients.php" method="post" role="form">
	{if $info.uid}
		<input type="hidden" name="uid" value="{$info.uid}" />
		<input type="hidden" name="mode" value="edit" />
	{else}
		<input type="hidden" name="mode" value="add" />
	{/if}
	<div class="row">
		<div class="col-xs-12 col-xm-12 col-md-12 col-lg-12">
			<ul class="nav nav-tabs">
				{if in_array("editclient", $smarty.session.permissions)}
					<li class="active">
						<a href="#panelinfo" data-toggle="tab"><i class="fa fa-edit"></i> {$lang.panelinfo}</a>
					</li>
				{/if}

				<li class="dropdown">
					<a href="#" id="managementtab" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i> {$lang.management} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="managementtab">
						{if in_array("deleteclient", $smarty.session.permissions)}
							<li>
								<a href="clients.php?mode=delete&uid={$info.uid}" class="delete" tabindex="-1">{$lang.deleteclient}</a>
							</li>
						{/if}
					</ul>
				</li>
			</ul>
			{if in_array("editclient", $smarty.session.permissions)}
				{include file='admin/clients/incl-panelinfo.tpl'}
				<div class="centered">
					<button type="submit" name="submit" class="btn btn-primary" /><i class="fa fa-save"></i> {$lang.save}</button>
				</div>
			{/if}
		</div>
	</div>
</form>