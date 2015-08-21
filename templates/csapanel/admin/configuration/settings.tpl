<div class="well well-lg">
	<div class="row">
		<div class="col-xs-12 col-xm-12 col-md-12 col-lg-12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-cogs"></i> {$lang.general}</a></li>
				<li><a href="#eventlogging" data-toggle="tab"><i class="fa fa-folder-open"></i> {$lang.eventlogging}</a></li>
				<li><a href="#links" data-toggle="tab"><i class="fa fa-sitemap"></i> {$lang.link}</a></li>
			</ul>
            <div class="tab-content">
				<div class="tab-pane active" id="general">
					<form action="settings.php" method="post" class="form-horizontal" role="form">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">{$lang.general}</h3>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label for="title" class="col-sm-4 control-label">{$lang.title}</label>
											<div class="col-sm-8">
												<input type="text" name="title" class="form-control" id="title" value="{$settings.title|e}">
											</div>
										</div>
										<div class="form-group">
											<label for="template" class="col-sm-4 control-label">{$lang.template}</label>
											<div class="col-sm-8">
												<select name="template" class="form-control" id="template">
													{foreach from=$templates item=item}
														<option value="{$item}" {if $settings.template == $item}selected=selected{/if}>{$item|e}</option>
													{/foreach}
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="defaultlanguage" class="col-sm-4 control-label">{$lang.defaultlanguage}</label>
											<div class="col-sm-8">
												<select name="defaultlanguage" class="form-control" id="defaultlanguage">
													{foreach from=$languages item=item}
														<option value="{$item|e}" {if $settings.language == $item}selected=selected{/if}>{$item|e}</option>
													{/foreach}
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="timezone" class="col-sm-4 control-label">{$lang.timezone}</label>
											<div class="col-sm-8">
												<select name="timezone" class="form-control" id="timezone">
													{foreach from=$timezones item=item key=k}
														<option value="{$k}" {if $settings.timezone == $k}selected=selected{/if}>{$item|e}</option>
													{/foreach}
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="forcehttps" class="col-sm-4 control-label">{$lang.forcehttps}</label>
											<div class="col-sm-8">
												<select name="forcehttps" id="forcehttps" class="form-control" data-toggle="tooltip" data-placement="top" title="{$lang.forcehttpstooltip}">
													<option value="0" {if $settings.forcehttps == "0"}selected=selected{/if}>{$lang.disabled}</option>
													<option value="1" {if $settings.forcehttps == "1"}selected=selected{/if}>{$lang.enabled}</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="baseurl" class="col-sm-4 control-label">{$lang.baseurl}</label>
											<div class="col-sm-8">
												<input type="text" name="baseurl" class="form-control" id="baseurl" value="{$settings.baseurl|e}" disabled="disabled">
											</div>
										</div>
										<div class="form-group">
											<label for="redirectlogout" class="col-sm-4 control-label">{$lang.redirectlogout}</label>
											<div class="col-sm-8">
												<input type="text" name="redirectlogout" class="form-control" id="redirectlogout" value="{$settings.redirectlogout|e}" data-toggle="tooltip" data-placement="top" title="{$lang.redirecttooltip}">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">{$lang.debugging}</h3>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label for="debugging" class="col-sm-4 control-label">{$lang.phpdebugging}</label>
											<div class="col-sm-8">
												<select name="debugging" id="debugging" class="form-control" data-toggle="tooltip" data-placement="top" title="{$lang.debugtooltip}">
													<option value="1" {if $settings.debugging == "1"}selected=selected{/if}>{$lang.enabled}</option>
													<option value="0" {if $settings.debugging == "0"}selected=selected{/if}>{$lang.disabled}</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="smartydebug" class="col-sm-4 control-label">{$lang.smartydebugging}</label>
											<div class="col-sm-8">
												<select name="smartydebug" id="smartydebug" class="form-control" data-toggle="tooltip" data-placement="top" title="{$lang.debugsmartytooltip}">
													<option value="1" {if $settings.smartydebug == "1"}selected=selected{/if}>{$lang.enabled}</option>
													<option value="0" {if $settings.smartydebug == "0"}selected=selected{/if}>{$lang.disabled}</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="centered">
									<button class="btn btn-primary" type="submit" name="submit" value="{$lang.savesettings}" class="btn btn-default"><i class="fa fa-save"></i> {$lang.savesettings}</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="eventlogging">
					<form action="settings.php" method="post" role="form" class="form-horizontal">
						<input type="hidden" name="mode" value="eventlogging" />
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">{$lang.eventlogging}</h3>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="eventlog_login" class="col-sm-4 control-label">{$lang.login}:</label>
									<div class="col-sm-8">
										<select name="eventlog[login]" id="eventlog_login" class="form-control">
											<option value="0" {if $settings.eventlog_login == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_login == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_addadministrator" class="col-sm-4 control-label">{$lang.addadministrator}:</label>
									<div class="col-sm-8">
										<select name="eventlog[addadministrator]" id="eventlog_addadministrator" class="form-control">
											<option value="0" {if $settings.eventlog_addadministrator == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_addadministrator == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_editadministrator" class="col-sm-4 control-label">{$lang.editadministrator}:</label>
									<div class="col-sm-8">
										<select name="eventlog[editadministrator]" id="eventlog_editadministrator" class="form-control">
											<option value="0" {if $settings.eventlog_editadministrator == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_editadministrator == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_deleteadministrator" class="col-sm-4 control-label">{$lang.deleteadministrator}:</label>
									<div class="col-sm-8">
										<select name="eventlog[deleteadministrator]" id="eventlog_deleteadministrator" class="form-control">
											<option value="0" {if $settings.eventlog_deleteadministrator == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_deleteadministrator == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_adduser" class="col-sm-4 control-label">{$lang.adduser}:</label>
									<div class="col-sm-8">
										<select name="eventlog[adduser]" id="eventlog_adduser" class="form-control">
											<option value="0" {if $settings.eventlog_adduser == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_adduser == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_edituser" class="col-sm-4 control-label">{$lang.edituser}:</label>
									<div class="col-sm-8">
										<select name="eventlog[edituser]" id="eventlog_edituser" class="form-control">
											<option value="0" {if $settings.eventlog_edituser == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_edituser == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="eventlog_deleteuser" class="col-sm-4 control-label">{$lang.deleteuser}:</label>
									<div class="col-sm-8">
										<select name="eventlog[deleteuser]" id="eventlog_deleteuser" class="form-control">
											<option value="0" {if $settings.eventlog_deleteuser == "0"}selected=selected{/if}>{$lang.nostr}</option>
											<option value="1" {if $settings.eventlog_deleteuser == "1"}selected=selected{/if}>{$lang.yesstr}</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="centered">
							<button class="btn btn-primary" type="submit" name="submit" value="{$lang.savesettings}" class="btn btn-default"><i class="fa fa-save"></i> {$lang.savesettings}</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="links">
				<form action="settings.php" method="post" role="form" class="form-horizontal">
						<input type="hidden" name="mode" value="links" />
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">{$lang.link}</h3>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="linkprofile" class="col-sm-4 control-label">{$lang.linkprofile}</label>
									<div class="col-sm-8">
										<input type="text" name="linkprofile" class="form-control" id="linkprofile" value="{$settings.linkprofile|e}" data-toggle="tooltip" data-placement="top" title="{$lang.linksprofileinfo}">
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="centered">
							<button class="btn btn-primary" type="submit" name="submit" value="{$lang.savesettings}" class="btn btn-default"><i class="fa fa-save"></i> {$lang.savesettings}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>