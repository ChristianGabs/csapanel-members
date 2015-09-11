<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$("#mainadmin").change(function() {
				var selected = $("#mainadmin option:selected");
				if (selected.val() == 1) {
					$(".permissions").hide("fast");
				} else {
					$(".permissions").show("fast");
				}
			});
		});
	{/literal}
</script>
<form action="administrators.php" method="post" role="form">
	{if $info.uid}
		<input type="hidden" name="uid" value="{$info.uid}" />
		<input type="hidden" name="mode" value="edit" />
	{else}
		<input type="hidden" name="mode" value="add" />
	{/if}
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-users"></i> {$lang.administrators}</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-6">
				<div class='col-sm-6'>    
					<div class='form-group'>
						<label for="email">{$lang.email}</label>
						<input class="form-control" id="email" name="email" value="{$info.email|e}" required="true" size="30" type="email" />
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='form-group'>
						<label for="password">{$lang.password}</label>
						<input class="form-control" id="password" name="password" {if !$info}required="true"{/if} size="30" type="password" />
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='form-group'>
						<label for="status">{$lang.status}</label>
						<select name="status" class="form-control" id="status">
							<option value="1" {if !$info.status == "1"}selected=selected{/if}>{$lang.active}</option>
							<option value="0" {if $info.status == "0"}selected=selected{/if}>{$lang.suspended}</option>
						</select>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='form-group'>
						<label for="mainadmin">{$lang.mainadmin}</label>
						<select name="mainadmin" class="form-control" id="mainadmin">
							<option value="1" {if $info.mainadmin == "1"}selected=selected{/if}>{$lang.yesstr}</option>
							<option value="0" {if !$info || $info.mainadmin == "0"}selected=selected{/if}>{$lang.nostr}</option>
						</select>
					</div>
				</div>
				<div class='col-sm-11'>
					<div class='form-group'>
						<label for="allowedips">{$lang.allowedips}</label>
						<textarea name="allowedips" id="allowedips" cols="17" rows="8" class="form-control">{$info.allowedips|e}</textarea>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="permissions" {if $info.mainadmin == "1"}style="display:none;"{/if}>
					<table align="left">
						<tr>
							<td align="left"><b>{$lang.clients}</b></b></td>
						</tr>
						<tr>
							<td align="left">
								<input type="checkbox" name="perms[]" value="addclient" {if in_array("addclient", $info.permissions)}checked=checked{/if}> {$lang.add}
							</td>
							<td align="left">
								<input type="checkbox" name="perms[]" value="editclient" {if in_array("editclient", $info.permissions)}checked=checked{/if}> {$lang.edit}
							</td>
						</tr>
						<tr>
							<td align="left">
								<input type="checkbox" name="perms[]" value="deleteclient" {if in_array("deleteclient", $info.permissions)}checked=checked{/if}> {$lang.delete}
							</td>
							<td align="left">
								<input type="checkbox" name="perms[]" value="manageclient" {if in_array("manageclient", $info.permissions)}checked=checked{/if}> {$lang.manage}
							</td>
						</tr>
						<tr>
							<td align="left">
							<input type="checkbox" name="perms[]" value="approveclient" {if in_array("approveclient", $info.permissions)}checked=checked{/if}> {$lang.approve}
							</td>
						</tr>
						<tr>
							<td align="left"><b>{$lang.configuration}</b></td>
						</tr>
						<tr>
							<td align="left">
								<input type="checkbox" name="perms[]" value="generalsettings" {if in_array("generalsettings", $info.permissions)}checked=checked{/if}> {$lang.generalsettings}
							</td>
							<td align="left">
								<input type="checkbox" name="perms[]" value="optimizedatabase" {if in_array("optimizedatabase", $info.permissions)}checked=checked{/if}> {$lang.optimize}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 centered">
				<br />
				<button type="submit" class="btn btn-primary" name="submit" value="{$lang.save}"><i class="fa fa-save"></i> {$lang.save}</button>
			</div>
		</div>
	</div>
</form>