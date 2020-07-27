<select class="form-control" name="{$name}">
		<option value=""></option>
		{foreach from=$from item=item}
				<option value="{$item}"
						{if $selected == $item}selected="selected"{/if}
				>{$item}</option>
		{/foreach}
</select>
