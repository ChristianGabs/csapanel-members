<form action="clientspending.php" method="post">
	<input type="hidden" name="uid" value="{$info.uid}" />
	<input type="hidden" name="mode" value="edit" />
	<ul class="nav nav-tabs">
		<li class="active"><a href="#panelinfo" data-toggle="tab"><i class="fa fa-cog"></i> {$lang.panelinfo}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="panelinfo">
			{include file='admin/clients/incl-panelinfo.tpl'}
		</div>
	</div>
	<div class="centered">
		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {$lang.save}</button>
	</div>
</form>