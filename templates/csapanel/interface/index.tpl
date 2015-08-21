<script type="text/javascript" language="javascript">
	{literal}
	$(function() {
		$(document).on("click", ".proofdialog", function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				success: function(data) {
					BootstrapDialog.show({
						title: '{/literal}{$lang.proof}{literal}',
						message: data,
						height: '600px',
						buttons: [{
								label: '{/literal}{$lang.ok}{literal}',
								action: function(dialogRef) {
									dialogRef.close();
								}
							}]
					});
				}
			});
		});		
		$(document).on("click", ".notesdialog", function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).attr('href'),
				type: 'GET',
				success: function(data) {
					BootstrapDialog.show({
						title: '{/literal}{$lang.notes}{literal}',
						message: data,
						height: '600px',
						buttons: [{
								label: '{/literal}{$lang.ok}{literal}',
								action: function(dialogRef) {
									dialogRef.close();
								}
							}]
					});
				}
			});
		});
	});
	{/literal}
</script>
<div class="row">
	<article class="data-block">
		<div class="data-container">
			<header>
				<h2><i class="fa fa-users"></i> {$lang.top10}</h2>
				<p>{$lang.top10info}</p>
			</header>
			<section>
				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" id="datatable" width="100%">
					<thead>
						<tr>
							<th>{$lang.name} / {$lang.userid}</th>
							<th>{$lang.email}</th>
							<th data-hide="phone">{$lang.realname}</th>
							<th data-hide="phone">{$lang.proof}</th>
							<th data-hide="phone">{$lang.notes}</th>
							<th data-hide="phone">{$lang.status}</th>
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
			</section>
		</div>
	</article>
</div>
