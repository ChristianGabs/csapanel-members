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
		<link rel="stylesheet" href="//{$settings.webpath}/templates/{$settings.template}/css/datatables.bootstrap.css" />
		<link rel="stylesheet" href="//{$settings.webpath}/templates/{$settings.template}/css/datatables.responsive.css" />
		<link href="//{$settings.webpath}/templates/{$settings.template}/css/csa-admin.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery-1.11.1.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery-ui.custom.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/bootstrap.js"></script>
		<!--[if lt IE 9]>
			<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
			<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
		<![endif]-->
		<script src="//{$settings.webpath}/javascript/lodash.min.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery.datatables.min.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/datatables.bootstrap.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/datatables.responsive.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/bootstrap-dialog.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/bootstrap.paginator.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery.form.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/jquery.livequery.js"></script>
		<script type="text/javascript" language="javascript" src="//{$settings.webpath}/javascript/csa-panel.js"></script>
		<script type="text/javascript" language="javascript">
			var timedout = "{$lang.timedout}";
			var error = "{$lang.error}";
			var send = "{$lang.send}";
			var edit = "{$lang.edit}";
			var save = "{$lang.save}";
			var add = "{$lang.add}";
			var loadingerror = "{$lang.loadingerror}";
			var ugid = "{$ugid}";
		</script>
	</head>
	<body>
		<noscript>{$lang.no_javascript}</noscript>
		<div class="modal fade" id="ajaxprocessing" tabindex="-1" role="dialog" aria-labelledby="ajaxprocessing1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body" style="text-align: center">
						<b>{$lang.requestprocessing}</b><br/>
						{$lang.requestprocessing2}<br/>
						<br/>
						<img alt='{$lang.processing}' title='{$lang.processing}' src='../templates/{$settings.template}/images/ajax-loader.gif'/><br/>
						<span id='ajax_processing_info'>( {$lang.pleasewait} )</span><br/>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper">
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"></a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> {$lang.dashboard}</a></li>
							{if in_array("addclient", $smarty.session.permissions) || in_array("editclient", $smarty.session.permissions) || in_array("deleteclient", $smarty.session.permissions) || in_array("manageclient", $smarty.session.permissions)}
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> {$lang.clients} <i class="arrow fa fa-chevron-right"></i></a>
								<ul class="dropdown-menu">
									{if in_array("addclient", $smarty.session.permissions)}
										<li>
											<a href="clients.php?mode=add"><i class="fa fa-plus"></i> {$lang.addclient}</a>
										</li>
									{/if}
									<li>
										<a href="clients.php"><i class="fa fa-user"></i> {$lang.client_list}</a>
									</li>
									<li>
										<a href="clientspending.php"><i class="fa fa-user"></i> {$lang.userpending}</a>
									</li>
								</ul>
							</li>
						{/if}
						{if $smarty.session.mainadmin == "1"}
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i> {$lang.utilities} <i class="arrow fa fa-chevron-right"></i></a>
								<ul class="dropdown-menu">
									<li><a href="utility.php?module=logs"><i class="fa fa-bell"></i> {$lang.eventlog}</a></li>
								</ul>
							</li>
						{/if}
						{if in_array("generalsettings", $smarty.session.permissions)}
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-keyboard-o"></i> {$lang.configuration} <i class="arrow fa fa-chevron-right"></i></a>
								<ul class="dropdown-menu">
									{if in_array("generalsettings", $smarty.session.permissions)}
										<li>
											<a href="settings.php"><i class="fa fa-cogs"></i>  {$lang.settings}</a>
										</li>
									{/if}
									{if in_array("editadmin", $smarty.session.permissions) || in_array("addadmin", $smarty.session.permissions) || in_array("deleteadmin", $smarty.session.permissions)}
										<li>
											<a href="administrators.php"><i class="fa fa-adn"></i>  {$lang.administrators}</a>
										</li>
									{/if}
								</ul>
							</li>
						{/if}
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question"></i> {$lang.help} <i class="arrow fa fa-chevron-right"></i></a>
							<ul class="dropdown-menu">
								{if in_array("optimizedatabase", $smarty.session.permissions)}
									<li>
										<a href="utility.php?module=databaseoptimize"><i class="fa fa-sitemap"></i> {$lang.optimize}</a>
									</li>
								{/if}
								<li><a href="http://wiki.csa-panel.ro" target="_blank"><i class="fa fa-info-circle"></i> {$lang.documentation}</a></li>
								<li><a href="http://bugs.csa-panel.ro/index.php?project=3&do=index&switch=1" target="_blank"><i class="fa fa-info-circle"></i> {$lang.bugs}</a></li>
							</ul>
						</li>
						{if $updateavailable == true && $smarty.session.mainadmin == "1"}
							<li><a href="utility.php?module=update" >{$lang.update}</a></li>
						{/if}
					</ul>
					<ul class="nav navbar-nav navbar-right navbar-user">
						<li><a href="#" id="clock" data-placement="bottom" data-toggle="tooltip" data-original-title='{$smarty.now|date_format:"%A | %B %e, %Y  - %I:%M %p"}'><i class="fa fa-clock-o"></i></a></li>
						<li><a id="gototop" title="" rel="tooltip" href="#" data-original-title="Back to Top"><i class="fa fa-arrow-circle-up "></i>
						</a></li>
						<li class="dropdown user-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {$smarty.session.email} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="userprofile.php"><i class="fa fa-user"></i> {$lang.myprofile}</a></li>
								<li><a href="{$settings.http_mode}://{$settings.webpath}/admin/index.php?action=logout"><i class="fa fa-power-off"></i> {$lang.logout}</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<div class="page-header">
							<h1>{$pagename}</h1>
						</div> 
						{include file="common/message-header.tpl"}
					</div>
				</div>