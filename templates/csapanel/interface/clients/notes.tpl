<div class="details">
	{section name=row loop=$client}
		{if !$client[row]}
			<p>{$lang.nodetails}</p>
		{else}
			<p>{$client[row]}</p>
		{/if}
	{/section}
</div>