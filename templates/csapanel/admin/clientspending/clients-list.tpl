<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			var timer = null;
			$('input[name=search]').keyup(function() {
				clearTimeout(timer);
				timer = setTimeout(function() {
					var dataString = 'mode=pagination&search=' + $('input[name=search]').val();
					$.ajax({
						url: "clientspending.php",
						data: dataString,
						success: function(html) {
							$('#searchresults').empty();
							$("#searchresults").html(html);
							$.fn.CreateDatatable('#datatable');
						},
						error: function(objAJAXRequest, strError) {
							$.fn.Alert("{/literal}{$lang.error}{literal}","{/literal}{$lang.errorclients}{literal}");
						}
					});
				}, 500);
			});
		
			$.fn.CreateDatatable('#datatable');
			
			$.fn.paginate = function(totalpages, currentpage)
			{
				if (totalpages > 0) {
					$('#pagination').bootstrapPaginator({
						currentPage: currentpage,
						totalPages: totalpages,
						onPageClicked: function(event, originalEvent, type, page) {
							$.ajax({
								url: 'clientspending.php?mode=pagination&search=' + $('input[name=search]').val() + '&page=' + page,
								success: function(html) {
									$('#ajax-clientlist').empty();
									$("#ajax-clientlist").html(html);
									$.fn.CreateDatatable('#datatable');
								},
								error: function(objAJAXRequest, strError) {
									$.fn.Alert("{/literal}{$lang.error}{literal}","{/literal}{$lang.errorclients}{literal}");
								}
							});
						}
					});
				}
				else
				{
					$('#pagination').empty();
				}
			};
			$.fn.paginate({/literal}{$pages.totalpage}{literal}, {/literal}{$pages.current}{literal})
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
<div class="panel panel-primary col-search">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-search "></i> {$lang.smartsearch}</h3>
	</div>
	<div class="panel-body">
		<div class='form-group'>
			<input class="form-control" id="search" name="search" size="30" type="search" value="{$smarty.request.search}" />
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> {$lang.clients}</h3>
	</div>
	<div class="panel-body">
		<div id="searchresults">
			{include file='admin/clientspending/ajax-clientlist.tpl'}
		</div>
		<div id="pagination"></div>
	</div>
</div>