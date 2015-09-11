<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cog"></i> {$lang.panelinfo}</h3>
	</div>
	<div class="panel-body">
		<fieldset>
			<div class='row'>
				<div class='col-sm-4'>    
					<div class='form-group'>
						<label for="email">{$lang.email}</label>
						<input class="form-control" id="email" name="email" value="{$info.email|e}" required="true" size="30" type="email" />
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='form-group'>
						<label for="userid">{$lang.userid}</label>
						<input class="form-control" id="userid" name="userid" value="{$info.userid|e}" required="true" size="30" type="text" />
					</div>
				</div>
				<div class='col-sm-4'>
					<div class='form-group'>
						<label for="status">{$lang.status}</label>
						<select name="status" class="form-control" id="status">
							<option value="0" {if $info.status == "0"}selected=selected{/if}>{$lang.trust}</option>
							<option value="1" {if $info.status == "1"}selected=selected{/if}>{$lang.untrustworthy}</option>
						</select>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> {$lang.profile}</h3>
	</div>
	<div class="panel-body">
		<fieldset>
			<div class='row'>
				<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
					<div class='form-group'>
						<label for="realname">{$lang.realname}</label>
						<input class="form-control" id="realname" name="realname" size="30" required="true" type="text" value="{$info.realname|e}" />
					</div>
				</div>
				<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
					<div class='form-group'>
						<label for="phone">{$lang.phone}</label>
						<input class="form-control" id="phone" name="phone" size="30" type="text" value="{$info.phone|e}" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					<div class='form-group'>
						<label for="proof">{$lang.proof}</label>
						<textarea class="form-control" name="proof" id="proof" cols="50" rows="3" required="true" type="text">{$info.proof|e}</textarea>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					<div class='form-group'>
						<label for="notes">{$lang.notes}</label>
						<textarea class="form-control" name="notes" id="notes" cols="50" rows="3" type="text">{$info.details|e}</textarea>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>