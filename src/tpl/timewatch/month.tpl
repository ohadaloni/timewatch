<div class="container">	 
	<table>
		<tr class="timeWatchHeaderRow">
			<td>
				<a href="/timewatch/export?month={$month}"><img
					border="0"
					title="export"
					src="/images/excel.png"
				/></a>
			</td>
			<td>date</td>
			<td>in</td>
			<td>out</td>
			<td>in</td>
			<td>out</td>
			<td>in</td>
			<td>out</td>
			<td>total</td>
		<tr>
		{foreach from=$rows item=row}
			<tr class="timeWatchRow">
				<td>{$row.weekday}</td>
				<td>{$row.date|substr:8:2}</td>
				<td>{$row.timeInFmt}</td>
				<td>{$row.timeOutFmt}</td>
				<td>{$row.timeIn2Fmt}</td>
				<td>{$row.timeOut2Fmt}</td>
				<td>{$row.timeIn3Fmt}</td>
				<td>{$row.timeOut3Fmt}</td>
				<td>
					{if $row.date == $today || $row.date == $yesterday}
						<a href="/timewatch/edit?id={$row.id}">{$row.totalTimeFmt}</a>
					{else}
						{$row.totalTimeFmt}
					{/if}
				</td>
			</tr>
		{/foreach}
		<tr class="timeWatchHeaderRow">
			<td></td>
			<td>date</td>
			<td>in</td>
			<td>out</td>
			<td>in</td>
			<td>out</td>
			<td>in</td>
			<td>out</td>
			<td>{$totalTimeFmt}</td>
		<tr>
	</table>
</div>
