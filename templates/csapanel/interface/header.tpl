<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>{$settings.title|e} - {$pagename}</title>
		<link rel="shortcut icon" href="//{$settings.webpath}/templates/{$settings.template}/images/favicon.ico"/>
		<link rel="stylesheet" href="//{$settings.webpath}/templates/{$settings.template}/css/font-awesome.min.css">
		<link href="//{$settings.webpath}/templates/{$settings.template}/css/csa-interface.css" rel="stylesheet">
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
	</head>
	<body>
		<noscript>{$lang.no_javascript}</noscript>
		<div id="wrapper">
			<header id="header" class="container">
				<nav>
					<ul>
						<li><a class="show-tip" title="Dashboard" href="/">{$lang.home}</a></li>
						<li><a class="show-tip" title="add" href="/index.php?mode=reportclient">{$lang.report}</a></li>
						<li><a class="show-tip" title="add" href="/index.php?mode=getclientlist">{$lang.clientlist}</a></li>
						<li><a title="login" href="/admin">{$lang.admincp}</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" title="{$lang.chooselang}" href="#">{$lang.language}</a>
							<ul class="dropdown-menu">
								<li><a href="index.php?mode=langeng">{$lang.english}</a></li>
								<li><a href="index.php?mode=langro">{$lang.romanian}</a></li>
							</ul>
						</li>
					</ul>
				</nav>
				<h1>
					<a href="/"><img style="max-height: 50px" title="CSAPanel" alt="CSAPanel" src="templates/{$settings.template}/images/logointerface.png"></a>
				</h1>
			</header>
			<section class="container" role="main">
			{include file="common/message-header.tpl"}
