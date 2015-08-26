/**
 * File:        datatables.responsive.js
 * Version:     0.1.2
 * Author:      Seen Sai Yang
 * Info:        https://github.com/Comanche/datatables-responsive
 *
 * Copyright 2013 Seen Sai Yang, all rights reserved.
 *
 * This source file is free software, under either the GPL v2 license or a
 * BSD style license.
 *
 * This source file is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 *
 * You should have received a copy of the GNU General Public License and the
 * BSD license along with this program.  These licenses are also available at:
 *     https://raw.github.com/Comanche/datatables-responsive/master/license-gpl2.txt
 *     https://raw.github.com/Comanche/datatables-responsive/master/license-bsd.txt
 */

'use strict';

/**
 * Constructor for responsive datables helper.
 *
 * This helper class makes datatables responsive to the window size.
 *
 * The parameter, breakpoints, is an object for each breakpoint key/value pair
 * with the following format: { breakpoint_name: pixel_width_at_breakpoint }.
 *
 * An example is as follows:
 *
 *     {
 *         tablet: 1024,
 *         phone: 480
 *     }
 *
 * These breakpoint name may be used as possible values for the data-hide
 * attribute.  The data-hide attribute is optional and may be defined for each
 * th element in the table header.
 *
 * @param {Object|string} tableSelector jQuery wrapped set or selector for
 *                                      datatables container element.
 * @param {Object} breakpoints          Object defining the responsive
 *                                      breakpoint for datatables.
 */
function ResponsiveDatatablesHelper(e,t){this.tableElement="string"==typeof e?$(e):e,this.columnIndexes=[],this.columnsShownIndexes=[],this.columnsHiddenIndexes=[],this.expandColumn=void 0,this.breakpoints={},this.expandIconTemplate='<span class="responsiveExpander"></span>',this.rowTemplate='<tr class="row-detail"><td><ul><!--column item--></ul></td></tr>',this.rowLiTemplate='<li><span class="columnTitle"><!--column title--></span>: <span class="columnValue"><!--column value--></span></li>',this.disabled=!0,this.skipNextWindowsWidthChange=!1,this.init(t)}ResponsiveDatatablesHelper.prototype.init=function(e){var t=[];_.each(e,function(e,s){t.push({name:s,upperLimit:e,columnsToHide:[]})}),t=_.sortBy(t,"upperLimit");var s=void 0;_.each(t,function(e){e.lowerLimit=s,s=e.upperLimit}),t.push({name:"default",lowerLimit:s,upperLimit:void 0,columnsToHide:[]});for(var n=0,i=t.length;i>n;n++)this.breakpoints[t[n].name]=t[n];for(var a=this.tableElement.fnSettings().aoColumns,n=0,i=a.length;i>n;n++)a[n].bVisible&&this.columnIndexes.push(n);var o=$("thead th",this.tableElement);_.each(o,function(e,t){"expand"===$(e).attr("data-class")&&(this.expandColumn=t);var s=$(e).attr("data-hide");if(void 0!==s){var n=s.split(/,\s*/);_.each(n,function(e){void 0!==this.breakpoints[e]&&this.breakpoints[e].columnsToHide.push(this.columnIndexes[t])},this)}},this),this.disable(!1)},ResponsiveDatatablesHelper.prototype.setWindowsResizeHandler=function(e){if(void 0===e&&(e=!0),e){var t=this;$(window).bind("resize",function(){t.respond()})}else $(window).unbind("resize")},ResponsiveDatatablesHelper.prototype.respond=function(){if(!this.disabled){var e=this,t=$(window).width(),s=0,n=[];_.each(this.breakpoints,function(e){(!e.lowerLimit||t>e.lowerLimit)&&(!e.upperLimit||t<=e.upperLimit)&&(n=e.columnsToHide)},this);var i=!1;if(!this.skipNextWindowsWidthChange)if(this.columnsHiddenIndexes.length!==n.length)i=!0;else{var a=_.difference(this.columnsHiddenIndexes,n).length,o=_.difference(n,this.columnsHiddenIndexes).length;i=a+o>0}i&&(this.skipNextWindowsWidthChange=!0,this.columnsHiddenIndexes=n,this.columnsShownIndexes=_.difference(this.columnIndexes,this.columnsHiddenIndexes),this.showHideColumns(),s=this.columnsHiddenIndexes.length,this.skipNextWindowsWidthChange=!1),this.columnsHiddenIndexes.length?(this.tableElement.addClass("has-columns-hidden"),$("tr.detail-show",this.tableElement).each(function(t,s){var n=$(s);0===n.next(".row-detail").length&&ResponsiveDatatablesHelper.prototype.showRowDetail(e,n)})):(this.tableElement.removeClass("has-columns-hidden"),$("tr.row-detail").each(function(){ResponsiveDatatablesHelper.prototype.hideRowDetail(e,$(this).prev())}))}},ResponsiveDatatablesHelper.prototype.showHideColumns=function(){for(var e=0,t=this.columnsShownIndexes.length;t>e;e++)this.tableElement.fnSetColumnVis(this.columnsShownIndexes[e],!0,!1);for(var e=0,t=this.columnsHiddenIndexes.length;t>e;e++)this.tableElement.fnSetColumnVis(this.columnsHiddenIndexes[e],!1,!1);var s=this;$("tr.row-detail").each(function(){ResponsiveDatatablesHelper.prototype.hideRowDetail(s,$(this).prev())}),this.tableElement.hasClass("has-columns-hidden")&&$("tr.detail-show",this.tableElement).each(function(e,t){ResponsiveDatatablesHelper.prototype.showRowDetail(s,$(t))})},ResponsiveDatatablesHelper.prototype.createExpandIcon=function(e){if(!this.disabled)for(var t=$("td",e),s=this,n=0,i=t.length;i>n;n++){var a=t[n],o=s.tableElement.fnGetPosition(a)[2];if(a=$(a),o===s.expandColumn){0==$("span.responsiveExpander",a).length&&(a.prepend(s.expandIconTemplate),a.on("click","span.responsiveExpander",{responsiveDatatablesHelperInstance:s},s.showRowDetailEventHandler));break}}},ResponsiveDatatablesHelper.prototype.showRowDetailEventHandler=function(e){if(!this.disabled){var t=$(this).closest("tr");t.hasClass("detail-show")?ResponsiveDatatablesHelper.prototype.hideRowDetail(e.data.responsiveDatatablesHelperInstance,t):ResponsiveDatatablesHelper.prototype.showRowDetail(e.data.responsiveDatatablesHelperInstance,t),t.toggleClass("detail-show"),e.stopPropagation()}},ResponsiveDatatablesHelper.prototype.showRowDetail=function(e,t){var s=e.tableElement,n=s.fnSettings().aoColumns,i=$(e.rowTemplate),a=$("ul",i);_.each(e.columnsHiddenIndexes,function(i){var o=$(e.rowLiTemplate);$(".columnTitle",o).html(n[i].sTitle);var l=s.fnGetPosition(t[0]),d=s.fnGetTds(l)[i],h=$(d).contents().clone();$(".columnValue",o).html(h),o.attr("data-column",i);var r=$(d).attr("class");"undefined"!==r&&r!==!1&&""!==r&&o.addClass(r),a.append(o)});var o=e.columnIndexes.length-e.columnsHiddenIndexes.length;i.find("> td").attr("colspan",o),t.after(i)},ResponsiveDatatablesHelper.prototype.hideRowDetail=function(e,t){t.next(".row-detail").find("li").each(function(){var s=e.tableElement,n=s.fnSettings().aoData,i=s.fnGetPosition(t[0]),a=$(this).attr("data-column"),o=$(this).find("span.columnValue").contents();n[i]._anHidden[a]=$(n[i]._anHidden[a]).empty().append(o)[0]}),t.next(".row-detail").remove()},ResponsiveDatatablesHelper.prototype.disable=function(e){this.disabled=void 0===e||e,this.disabled?(this.setWindowsResizeHandler(!1),$("tbody tr.row-detail",this.tableElement).remove(),$("tbody tr",this.tableElement).removeClass("detail-show"),$("tbody tr span.responsiveExpander",this.tableElement).remove(),this.columnsHiddenIndexes=[],this.columnsShownIndexes=this.columnIndexes,this.showHideColumns(),this.tableElement.removeClass("has-columns-hidden"),this.tableElement.off("click","span.responsiveExpander",this.showRowDetailEventHandler)):this.setWindowsResizeHandler()},$.fn.dataTableExt.oApi.fnGetTds=function(e,t){var s,n,i,a=[],o=[],l=0,d="object"==typeof t?e.oApi._fnNodeToDataIndex(e,t):t,h=e.aoData[d].nTr;for(n=0,i=h.childNodes.length;i>n;n++)s=h.childNodes[n],"TD"==s.nodeName.toUpperCase()&&o.push(s);for(n=0,i=e.aoColumns.length;i>n;n++)e.aoColumns[n].bVisible?a.push(o[n-l]):(a.push(e.aoData[d]._anHidden[n]),l++);return a};