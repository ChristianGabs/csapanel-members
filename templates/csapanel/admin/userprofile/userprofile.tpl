<form action="userprofile.php" method="post" role="form" class="form-horizontal">
	<input type="hidden" name="uid" value="{$info.uid}" />
	<input type="hidden" name="mode" value="save" />
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
							<label for="password">{$lang.password}</label>
							<input class="form-control" id="password" name="password" {if !$info}required="true"{/if} size="30" type="password" />
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
							<label for="firstname">{$lang.firstname}</label>
							<input class="form-control" id="firstname" name="firstname" size="30" required="true" type="text" value="{$info.firstname|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="lastname">{$lang.lastname}</label>
							<input class="form-control" id="lastname" name="lastname" size="30" required="true" type="text" value="{$info.lastname|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="phone">{$lang.phone}</label>
							<input class="form-control" id="phone" name="phone" size="30" type="text" value="{$info.phone|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="address">{$lang.address}</label>
							<input class="form-control" id="address" name="address" size="30" type="text" value="{$info.address|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="city">{$lang.city}</label>
							<input class="form-control" id="city" name="city" size="30" type="text" value="{$info.city|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="state">{$lang.state}</label>
							<input class="form-control" id="state" name="state" size="30" type="text" value="{$info.state|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="zipcode">{$lang.zipcode}</label>
							<input class="form-control" id="zipcode" name="zipcode" size="30" type="text" value="{$info.zipcode|e}" />
						</div>
					</div>
					<div class='col-xs-12 col-sm-4 col-md-5 col-lg-4'>    
						<div class='form-group'>
							<label for="country">{$lang.country}</label>
							<input class="form-control" id="country" name="country" size="30" type="text" value="{$info.country|e}" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>    
						<div class='form-group'>
							<label for="notes">{$lang.notes}</label>
							<textarea class="form-control" name="notes" id="notes" cols="50" rows="3" type="text">{$info.notes|e}</textarea>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<div class="centered">
		<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> {$lang.save}</button>
	</div>
</form>