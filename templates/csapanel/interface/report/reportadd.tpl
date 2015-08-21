<div class="row">
	<article class="data-block">
		<div class="data-container">
			<header>
				<h2><i class="fa fa-users"></i> {$lang.addreportclient}</h2>
				<p>{$lang.addreportinfo}</p>
			</header>
			<section>
				<form action="clients.php" method="post">
					<input type="hidden" name="mode" value="add" />
						<div class="row">
							<div class='col-sm-4'>    
								<div class='form-group'>
									<label for="email">{$lang.email}</label>
									<input class="form-control" id="email" name="email" value="{$info.email|e}" required="true" size="30" type="email" data-toggle="tooltip" data-placement="top" title="{$lang.addemailtip}"/>
								</div>
							</div>
							<div class='col-sm-4'>
								<div class='form-group'>
									<label for="userid">{$lang.userid}</label>
									<input class="form-control" id="userid" name="userid" value="{$info.userid|e}" required="true" size="30" type="text" data-toggle="tooltip" data-placement="top" title="{$lang.adduseridtip}"/>
								</div>
							</div>
							<div class='col-sm-4'>
								<div class='form-group'>
									<label for="status">{$lang.status}</label>
									<select name="status" class="form-control" id="status" value="{$info.realname|e}" data-toggle="tooltip" data-placement="top" title="{$lang.addstatustip}">
										<option value="0" {if $info.status == "0"}selected=selected{/if}>{$lang.trust}</option>
										<option value="1" {if $info.status == "1"}selected=selected{/if}>{$lang.untrustworthy}</option>
									</select>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='col-sm-4'>    
								<div class='form-group'>
									<label for="realname">{$lang.realname}</label>
									<input class="form-control" id="realname" name="realname" size="30" required="true" type="text" value="{$info.realname|e}" data-toggle="tooltip" data-placement="top" title="{$lang.addrealnametip}"/>
								</div>
							</div>
							<div class='col-sm-4'>    
								<div class='form-group'>
									<label for="phone">{$lang.phone}</label>
									<input class="form-control" id="phone" name="phone" size="30" type="text" value="{$info.phone|e}" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class='col-sm-4'>
								<div class='form-group'>
									<label for="proof">{$lang.proof}</label>
									<textarea class="form-control" name="proof" id="proof" cols="70" rows="5" required="true" type="text" data-toggle="tooltip" data-placement="top" title="{$lang.addprooftip}">{$info.proof|e}</textarea>
								</div>
							</div>
							<div class='col-sm-4'>
								<div class='form-group'>
									<label for="notes">{$lang.notes}</label>
									<textarea class="form-control" name="notes" id="notes" cols="70" rows="5" type="text" required="true" data-toggle="tooltip" data-placement="top" title="{$lang.adddetailstip}">{$info.details|e}</textarea>
								</div>
							</div>
						</div>

					<div class="centered">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {$lang.save}</button>
					</div>
				</form>
			</section>
		</div>
	</article>
</div>