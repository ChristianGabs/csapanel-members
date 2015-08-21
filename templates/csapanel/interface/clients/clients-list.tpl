<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			var timer = null;
			$('input[name=search]').keyup(function() {
				clearTimeout(timer);
				timer = setTimeout(function() {
					var dataString = 'mode=pagination&search=' + $('input[name=search]').val();
					$.ajax({
						url: "index.php",
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
								url: 'index.php?mode=pagination&search=' + $('input[name=search]').val() + '&page=' + page,
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
			// --------- Get Proof Dialog ---------------------
			$(document).on("click", ".proofdialog", function(e) {
				e.preventDefault();
				$.ajax({
					url: $(this).attr('href'),
					type: 'GET',
					success: function(data) {
						BootstrapDialog.show({
							title: '{/literal}{$lang.proof}{literal}',
							message: data,
							height: '330px',
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
			// --------- Get Notes Dialog ---------------------
			$(document).on("click", ".notesdialog", function(e) {
				e.preventDefault();
				$.ajax({
					url: $(this).attr('href'),
					type: 'GET',
					success: function(data) {
						BootstrapDialog.show({
							title: '{/literal}{$lang.notes}{literal}',
							message: data,
							height: '330px',
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
				<h2><i class="fa fa-users"></i> {$lang.clientlist}</h2>
				<p>{$lang.clientlistinfo}</p>
			</header>
			<section>
				<div class='form-group'>
					<label><i class="fa fa-search "></i> {$lang.smartsearch}</label>
					<input class="form-control" id="search" name="search" size="30" type="search" value="{$smarty.request.search}" />
				</div>
				<div id="searchresults">
					{include file='interface/clients/ajax-clientlist.tpl'}
				</div>
				<div id="pagination"></div>
			</section>
		</div>
	</article>
</div>
