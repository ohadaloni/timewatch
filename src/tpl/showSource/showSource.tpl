<table border="0">
	<tr>
		<td valign="top">
			<table border="0">
				<tr class="timeWatchHeaderRow">
					<td>Files</td>
				</tr>
				{foreach from=$files item=file}
					<tr class="timeWatchRow">
						<td>
							<a href="/showSource?file={$file}">{$file}</a>
						</td>
					</tr>
				{/foreach}
			</table>
		</td>
		<td valign="top">
			{if $file}
				<h4>{$fileName}</h4>
				{$source}
			{/if}
		</td>
	</tr>
</table>
