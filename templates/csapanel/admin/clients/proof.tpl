<ul>
	{section name=row loop=$client}
		{if !$client[row]}
			<p>{$lang.noproof}</p>
		{else}
			<li><a target="_blank" href="{$client[row]}">{$client[row]}</a></li>
		{/if}
	{/section}
</ul>