<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>{$settings.title|e} - {$pagename}</title>
		<link rel="shortcut icon" href="//{$settings.webpath}/templates/{$settings.template}/images/favicon.ico"/>
		<link href="//{$settings.webpath}/templates/{$settings.template}/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="//{$settings.webpath}/templates/{$settings.template}/css/font-awesome.min.css">
		
		<link href="//{$settings.webpath}/templates/{$settings.template}/css/csa-admin.css" rel="stylesheet">
		
		<!-- JavaScript -->
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery-1.11.1.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery-ui.custom.js"></script>
		<!--<script src="//code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/bootstrap.js"></script>
		<!--[if lt IE 9]>
			<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
		<![endif]-->
		
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery.form.js"></script>
		<script type="text/javascript">
			{literal}
				$(function(){$(document).on("click","button[name=login]",function(t){t.preventDefault(),$("input[name=action]").val("login"),$("form").submit()}),$(document).on("click","a[class=forgotpassword]",function(t){t.preventDefault(),$("input[name=action]").val("forgotpassword"),$("form").submit()}),$("form").submit(function(){return $(this).ajaxSubmit({beforeSubmit:function(){$("button[name=login]").text("{/literal}{$lang.pleasewait}{literal}")},clearForm:!1,resetForm:!1,type:"post",timeout:3e4,success:function(t){var e=$("<div />").html(t);$(e).find("#good").text().length?($("#ajax_good_text").html("{/literal}{$lang.loginverified}{literal}").parent().show(),location.href=$(e).find("#good").text()):$("#ajax_good").hide(),$(e).find("#error").text().length?($("#ajax_error_text").html($(e).find("#error").text()).parent().show(),$("button[name=login]").text("{/literal}{$lang.login}{literal}")):$("#ajax_error").hide()},error:function(){$("#ajax_error_text").html("{/literal}{$lang.unablelogin}{literal}").parent().show()}}),!1})});
			{/literal}
		</script>
	</head>
	<body>
		<noscript>{$lang.no_javascript}</noscript>
		<div id="loadingbar" style="display:none;"><img src="templates/{$settings.template}/images/ajax-loader.gif" /></div>
		<div class="loginbox">
			<div class="centered">
				<img src="../templates/{$settings.template}/images/logo.png" alt="CSA-Panel" />
			</div>
			<div class="login_container">
				{include file="common/message-header.tpl"}