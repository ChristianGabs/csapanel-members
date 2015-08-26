/* ================================================
 * Make use of Twitter Bootstrap's modal more monkey-friendly
 * 
 * For Bootstrap 3.
 * 
 * javanoob@hotmail.com
 * 
 * Licensed under The MIT License.
 * ================================================ */
var BootstrapDialog=null;!function(t){"use strict";BootstrapDialog=function(t){this.defaultOptions={type:BootstrapDialog.TYPE_PRIMARY,size:BootstrapDialog.SIZE_NORMAL,title:null,message:null,buttons:[],closable:!0,spinicon:BootstrapDialog.ICON_SPINNER,data:{},onshow:null,onhide:null,autodestroy:!0,height:null},this.indexedButtons={},this.realized=!1,this.initOptions(t)},BootstrapDialog.NAMESPACE="bootstrap-dialog",BootstrapDialog.TYPE_DEFAULT="type-default",BootstrapDialog.TYPE_INFO="type-info",BootstrapDialog.TYPE_PRIMARY="type-primary",BootstrapDialog.TYPE_SUCCESS="type-success",BootstrapDialog.TYPE_WARNING="type-warning",BootstrapDialog.TYPE_DANGER="type-danger",BootstrapDialog.DEFAULT_TEXTS={},BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_DEFAULT]="Information",BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_INFO]="Information",BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_PRIMARY]="Information",BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_SUCCESS]="Success",BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_WARNING]="Warning",BootstrapDialog.DEFAULT_TEXTS[BootstrapDialog.TYPE_DANGER]="Danger",BootstrapDialog.SIZE_NORMAL="size-normal",BootstrapDialog.SIZE_LARGE="size-large",BootstrapDialog.BUTTON_SIZES={},BootstrapDialog.BUTTON_SIZES[BootstrapDialog.SIZE_NORMAL]="",BootstrapDialog.BUTTON_SIZES[BootstrapDialog.SIZE_LARGE]="btn-lg",BootstrapDialog.ICON_SPINNER="fa fa-spinner",BootstrapDialog.prototype={constructor:BootstrapDialog,initOptions:function(o){return this.options=t.extend(!0,this.defaultOptions,o),this},initModalStuff:function(){return this.setModal(this.createModal()).setModalDialog(this.createModalDialog()).setModalContent(this.createModalContent()).setModalHeader(this.createModalHeader()).setModalBody(this.createModalBody()).setModalFooter(this.createModalFooter()),this.getModal().append(this.getModalDialog()),this.getModalDialog().append(this.getModalContent()),this.getModalContent().append(this.getModalHeader()).append(this.getModalBody()).append(this.getModalFooter()),this},createModal:function(){return t('<div class="modal fade" tabindex="-1"></div>')},getModal:function(){return this.$modal},setModal:function(t){return this.$modal=t,this},createModalDialog:function(){return t('<div class="modal-dialog"></div>')},getModalDialog:function(){return this.$modalDialog},setModalDialog:function(t){return this.$modalDialog=t,this},createModalContent:function(){return t('<div class="modal-content"></div>')},getModalContent:function(){return this.$modalContent},setModalContent:function(t){return this.$modalContent=t,this},createModalHeader:function(){return t('<div class="modal-header"></div>')},getModalHeader:function(){return this.$modalHeader},setModalHeader:function(t){return this.$modalHeader=t,this},createModalBody:function(){return t(null!==this.options.height?'<div class="modal-body" style="overflow:auto; max-height: '+this.options.height+'"></div>':'<div class="modal-body"></div>')},getModalBody:function(){return this.$modalBody},setModalBody:function(t){return this.$modalBody=t,this},createModalFooter:function(){return t('<div class="modal-footer"></div>')},getModalFooter:function(){return this.$modaFooter},setModalFooter:function(t){return this.$modaFooter=t,this},createDynamicContent:function(t){var o=typeof t;return"function"===o?t.call(t,this):t},setData:function(t,o){return this.options.data[t]=o,this},getData:function(t){return this.options.data[t]},getType:function(){return this.options.type},setType:function(t){return this.options.type=t,this},getSize:function(){return this.options.size},setSize:function(t){return this.options.size=t,this},getTitle:function(){return this.options.title},setTitle:function(t){return this.options.title=t,this},getMessage:function(){return this.options.message},setMessage:function(t){return this.options.message=t,this},isClosable:function(){return this.options.closable},setClosable:function(t){return this.options.closable=t,this.updateClosable(),this},getSpinicon:function(){return this.options.spinicon},setSpinicon:function(t){return this.options.spinicon=t,this},addButton:function(t){return this.options.buttons.push(t),this},addButtons:function(o){var e=this;return t.each(o,function(t,o){e.addButton(o)}),this},getButtons:function(){return this.options.buttons},setButtons:function(t){return this.options.buttons=t,this},getButton:function(t){return"undefined"!=typeof this.indexedButtons[t]?this.indexedButtons[t]:null},getButtonSize:function(){return"undefined"!=typeof BootstrapDialog.BUTTON_SIZES[this.getSize()]?BootstrapDialog.BUTTON_SIZES[this.getSize()]:""},isAutodestroy:function(){return this.options.autodestroy},setAutodestroy:function(t){this.options.autodestroy=t},getDefaultText:function(){return BootstrapDialog.DEFAULT_TEXTS[this.getType()]},getNamespace:function(t){return BootstrapDialog.NAMESPACE+"-"+t},createHeaderContent:function(){var o=t("<div></div>");return o.addClass(this.getNamespace("header")),o.append(this.createTitleContent()),o.append(this.createCloseButton()),o},createTitleContent:function(){var o=t("<div></div>");return o.addClass(this.getNamespace("title")),o.append(null!==this.getTitle()?this.createDynamicContent(this.getTitle()):this.getDefaultText()),o},createCloseButton:function(){var o=t("<div></div>");o.addClass(this.getNamespace("close-button"));var e=t('<button class="close">×</button>');return o.append(e),o.on("click",{dialog:this},function(t){t.data.dialog.close()}),o},createBodyContent:function(){var o=t("<div></div>");return o.addClass(this.getNamespace("body")),o.append(this.createMessageContent()),o},createMessageContent:function(){var o=t("<div></div>");return o.addClass(this.getNamespace("message")),o.append(this.createDynamicContent(this.getMessage())),o},createFooterContent:function(){var o=t("<div></div>");return o.addClass(this.getNamespace("footer")),o.append(this.createFooterButtons()),o},createFooterButtons:function(){var o=this,e=t("<div></div>");return e.addClass(this.getNamespace("footer-buttons")),this.indexedButtons={},t.each(this.options.buttons,function(t,a){var i=o.createButton(a);"undefined"!=typeof a.id&&(o.indexedButtons[a.id]=i),e.append(i)}),e},createButton:function(o){var e=t('<button class="btn"></button>');return e.addClass(this.getButtonSize()),void 0!==typeof o.icon&&""!==t.trim(o.icon)&&e.append(this.createButtonIcon(o.icon)),void 0!==typeof o.label&&e.append(o.label),e.addClass(void 0!==typeof o.cssClass&&""!==t.trim(o.cssClass)?o.cssClass:"btn-default"),e.on("click",{dialog:this,button:o},function(o){var e=o.data.dialog,a=o.data.button;if("function"==typeof a.action&&a.action.call(this,e),a.autospin){var i=t(this);i.find("."+e.getNamespace("button-icon")).remove(),i.prepend(e.createButtonIcon(e.getSpinicon()).addClass("fa-spin"))}}),e},createButtonIcon:function(o){var e=t("<span></span>");return e.addClass(this.getNamespace("button-icon")).addClass(o),e},enableButtons:function(t){var o=this.getModalFooter().find(".btn");return o.prop("disabled",!t).toggleClass("disabled",!t),this},updateClosable:function(){if(this.isRealized()){var t=this.getModal();t.off("click").on("click",{dialog:this},function(t){t.target===this&&t.data.dialog.isClosable()&&t.data.dialog.close()}),this.getModalHeader().find("."+this.getNamespace("close-button")).toggle(this.isClosable()),t.off("keyup").on("keyup",{dialog:this},function(t){27===t.which&&t.data.dialog.isClosable()&&t.data.dialog.close()})}return this},onShow:function(t){return this.options.onshow=t,this},onHide:function(t){return this.options.onhide=t,this},isRealized:function(){return this.realized},setRealized:function(t){return this.realized=t,this},handleModalEvents:function(){return this.getModal().on("show.bs.modal",{dialog:this},function(t){var o=t.data.dialog;"function"==typeof o.options.onshow&&o.options.onshow(o)}),this.getModal().on("hide.bs.modal",{dialog:this},function(t){var o=t.data.dialog;"function"==typeof o.options.onhide&&o.options.onhide(o)}),this.getModal().on("hidden.bs.modal",{dialog:this},function(o){var e=o.data.dialog;e.isAutodestroy()&&t(this).remove()}),this},realize:function(){return this.initModalStuff(),this.getModal().addClass(BootstrapDialog.NAMESPACE).addClass(this.getType()).addClass(this.getSize()),this.getModalHeader().append(this.createHeaderContent()),this.getModalBody().append(this.createBodyContent()),this.getModalFooter().append(this.createFooterContent()),this.getModal().modal({backdrop:"static",keyboard:!1,show:!1}),this.handleModalEvents(),this.setRealized(!0),this},open:function(){return!this.isRealized()&&this.realize(),this.updateClosable(),this.getModal().modal("show"),this},close:function(){return this.getModal().modal("hide"),this}},BootstrapDialog.show=function(t){new BootstrapDialog(t).open()},BootstrapDialog.alert=function(t,o){new BootstrapDialog({message:t,data:{callback:o},closable:!1,buttons:[{label:"OK",action:function(t){"function"==typeof t.getData("callback")&&t.getData("callback")(!0),t.close()}}]}).open()},BootstrapDialog.confirm=function(t,o){new BootstrapDialog({title:"Confirmation",message:t,closable:!1,data:{callback:o},buttons:[{label:"Cancel",action:function(t){"function"==typeof t.getData("callback")&&t.getData("callback")(!1),t.close()}},{label:"OK",cssClass:"btn-primary",action:function(t){"function"==typeof t.getData("callback")&&t.getData("callback")(!0),t.close()}}]}).open()}}(window.jQuery);