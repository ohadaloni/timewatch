<div class="container">	 
	<table>
		<tr class="timeWatchHeaderRow">
			<td>month</td>
			<td>project</td>
			<td>time</td>
			<td></td>
			<td></td>
		<tr>
		{foreach from=$rows item=row}
			<tr class="timeWatchRow">
				<td>{$row.month}</td>
				<td>{$row.project}</td>
				<td>{$row.time}</td>



				<td><a href="/timeWatch/show?month={$row.month}&project={$row.project}"><img
					border="0"
					src="/images/list.png"
					alt="details"
					title="details"
				/></a></td>
				<td>
					<a href="/timewatch/export?month={$row.month}&project={$row.project}"><img
						border="0"
						title="export"
						src="/images/excel.png"
					/></a>
				</td>
			</tr>
		{/foreach}
		<tr class="timeWatchHeaderRow">
			<td>Total:</td>
			<td>{$totalTime}</td>
			<td></td>
		<tr>
	</table>
</div>
