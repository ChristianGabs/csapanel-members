<script type="text/javascript" language="javascript">
	{literal}
		$(function() {
			$(document).on('close.bs.alert', '.alert', function() {
				var id = $(this).data('id');
				if (id)
				{
					$.get('index.php?mode=disablenotice&type=' + id);
				}
			});
		});
	{/literal}
</script>

{if $systemmessage}
	{foreach from=$systemmessage item=message}
		<div class="alert alert-info alert-dismissable" data-id="{$message.type}">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{$message.message}
		</div>
		<br />
	{foreachelse}
		<div class="alert alert-info alert-dismissable" >
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{$systemmessage}
		</div>
	{/foreach}
{/if}
{if $errormessage}
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{foreach from=$errormessage item=message}
			{$message}<br />
		{foreachelse}
			{$errormessage}
		{/foreach}
	</div>
	<br />
{/if}
{if $goodmessage}
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{foreach from=$goodmessage item=message}
			{$message}<br />
		{foreachelse}
			{$goodmessage}
		{/foreach}
	</div>
	<br />
{/if}
<div id="ajax_error" class="alert alert-danger alert-dismissable" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <div id="ajax_error_text"></div>
</div>
<div id="ajax_good" class="alert alert-success alert-dismissable" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <div id="ajax_good_text"></div>
</div>