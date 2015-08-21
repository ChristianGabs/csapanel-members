<form method="post" action="index.php" role="form" class="form-horizontal">
	<input type="hidden" name="action" value="login" />
	<div class="panel panel-primary">
		<div class="panel-body">
			<legend>{$lang.controlpanellogin}</legend>
			<div class="form-group">
				<label for="email" class="col-sm-3 control-label">{$lang.email}</label>
				<div class="col-sm-7">
					<input type="text" name="email" id="email" value="" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-3 control-label">{$lang.password}</label>
				<div class="col-sm-7">
					<input type="password" name="password" id="password" value="" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label for="language" class="col-sm-3 control-label">{$lang.language}</label>
				<div class="col-sm-7">
					<select name="language" id="language" class="form-control">
						{foreach from=$languages item=item}
							<option value="{$item}" {if $settings.language == $item}selected=selected{/if}>{$item}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<hr/>
			<div class="centered">
				<button class="btn btn-primary" type="submit" name="login"><i class="fa fa-key"></i> {$lang.login}</button>
			</div>
		</div>
		<div class="panel-footer">
			<div class="centered">
				<a href="#" class="forgotpassword">{$lang.recoverpassword}</a>
			</div>
		</div>
	</div>
</form>