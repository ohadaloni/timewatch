<select class="form-control" name="{$name}" {$more}>
	<option value=""></option>
	{foreach from=$from item=XitemX}
		<option value="{$XitemX.$idname}"
			{if $selected == $XitemX.$idname}selected="selected"{/if}
		>{$XitemX.$fname}</option>
	{/foreach}
</select>
