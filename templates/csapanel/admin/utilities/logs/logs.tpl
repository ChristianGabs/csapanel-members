<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$('#logtabs a[href="#events"]').click();
			$.fn.refreshEventList = function(page) {
				$.fn.ajaxWindow();
				$.ajax({
					url: 'utility.php?module=logs&logtype=events&mode=pagination&userid=' + $('select[name=userid]').val() + '&type=' + $('select[name=type').val() + '&page=' + page,
					success: function(html) {
						$('#eventlist').empty();
						$("#eventlist").html(html);
						$.fn.ajaxWindow(false);
						$.fn.CreateDatatable('#eventtable');
					},
					error: function(objAJAXRequest, strError) {
						$.fn.ajaxWindow(false);
						$.fn.Alert("{/literal}{$lang.error}{literal}", "{/literal}{$lang.errorclients}{literal}");
					}
				});
			};
			
			$.fn.eventPaginate = function(totalpages, currentpage) {
				if (totalpages > 0) {
					$('#pagination').bootstrapPaginator({
						currentPage: currentpage,
						totalPages: totalpages,
						onPageClicked: function(event, originalEvent, type, page) {
							$.fn.refreshEventList(page);
						}
					});
				} else {
					$('#pagination').empty();
				}
			};
	
		});
	{/literal}
</script>
<div class="well well-lg">
	<ul class="nav nav-tabs" id="logtabs">
		<li class="active"><a href="#events" data-url="utility.php?module=logs&logtype=events" data-toggle="tab">{$lang.events}</a></li>
	</ul>
	<div class="tab-content" id="logtabs">
		<div class="tab-pane active" id="events"></div>
	</div>
</div>