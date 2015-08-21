$(document).ready(function() {
	$('.dropdown').on('show.bs.dropdown', function(e) {
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
	});
	$('.dropdown').on('hide.bs.dropdown', function(e) {
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp();
	});
	$('[data-toggle="tooltip"]').tooltip();
	var hash = document.location.hash;
	var prefix = "tab_";
	if (hash) {
		$('.nav-tabs a[href="' + hash.replace(prefix, "") + '"]').tab('show');
	}
	$('.nav-tabs a').on('shown.bs.tab', function(e) {
	});
	$('.nav-tabs a').click(function(e) {
		var url = $(this).attr("data-url");
		if (url)
		{
			$.fn.ajaxWindow();
			e.preventDefault();
	
			var url = $(this).attr("data-url");
			var href = this.hash;
			var pane = $(this);
	
			$.ajax(url, {
			timeout: 30000,
			success: function (data) {
				$(href).html(data);
				$.fn.ajaxWindow(false);
					pane.tab('show');
			} 
			});
		}
	});
	window.onbeforeunload = function() {
		$.fn.ajaxWindow();
	};
	$.extend($.fn.dataTable.defaults, {
		"sPaginationType": "bootstrap",
		"bFilter": false,
		"bSort": false,
		"bPaginate": false,
		"bDestroy": true,
		"iDisplayLength": 30,
		"sDom": "<'row'<'span6'T><'span6'f>r>t<'row'<'span6'p>>",
		bAutoWidth: false
	});
	$.fn.CreateDatatable = function(table, options) {
		var defaults = {
			"fnDrawCallback": function() {
				$('table' + table + ' td').bind('mouseenter', function() {
					$(this).parent().children().each(function() {
						$(this).addClass('datatable_highlight');
					});
				});
				$('table' + table + ' td').bind('mouseleave', function() {
					$(this).parent().children().each(function() {
						$(this).removeClass('datatable_highlight');
					});
				});
				responsiveHelper.respond();
			},
			fnPreDrawCallback: function() {
				if (!responsiveHelper) {
					responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, {tablet: 1024, phone: 480});
				}
			},
			fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				responsiveHelper.createExpandIcon(nRow);
			}
		};
	
		$.extend(defaults, options);
		var tableContainer = $(table);
		var responsiveHelper;
		tableContainer.dataTable(defaults);
	};
	$.fn.Alert = function(title, message) {
		BootstrapDialog.show({
			title: "<i class=\"fa fa-exclamation-triangle\"> " + title,
			message: message
		});
	};
	var ajaxopened = false;
	$.fn.ajaxWindow = function(enabled) {
		if (typeof (enabled) === 'undefined') {
			enabled = true;
		}
		if (enabled === false) {
			ajaxopened = false;
			$('#ajaxprocessing').modal('hide');
		} else {
			if (ajaxopened !== true) {
				$('#ajaxprocessing').modal({backdrop: 'static'}, 'show');
				ajaxopened = true;
			}
		}
	};
	$.fn.ParseAjax = function(data) {
		var response = $('<div />').html(data);
		if ($(response).find('#good').text().length) {
			$('#ajax_good_text').html($(response).find('#good').text()).parent().show();
		} else {
			$("#ajax_good").hide();
		}
		if ($(response).find('#error').text().length) {
			$('#ajax_error_text').html($(response).find('#error').text()).parent().show();
		} else {
			$("#ajax_error").hide();
		}
	};
	$('[data-toggle="tooltip"]').livequery(function() {
		$(this).tooltip();
	});
	
});

// Iframe resize
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 30 + 'px';
    obj.style.width = obj.contentWindow.document.body.scrollWidth + 30 + 'px';
}