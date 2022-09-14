<div class="container">	 
	<h4>Change {$row.date} Timewatch</h4>
	<form method="post" action="/timewatch/update">
		<table>
			<tr>
				<td>
					project:
				</td>
				<td align="right" colspan="4">
					<input type="text" name="project" value="{$row.project}" />
				</td>
			</tr>
			<tr>
				<td>
					timeIn:
				</td>
				<td>
					<input type="time" name="timeIn" value="{$row.timeIn}" />
				</td>
				<td width="40px"></td>
				<td>
					timeOut:
				</td>
				<td>
					<input type="time" name="timeOut" value="{$row.timeOut}" />
				</td>
			</tr>
			<tr>
				<td>
					timeIn2:
				</td>
				<td>
					<input type="time" name="timeIn2" value="{$row.timeIn2}" />
				</td>
				<td width="40px"></td>
				<td>
					timeOut2:
				</td>
				<td>
					<input type="time" name="timeOut2" value="{$row.timeOut2}" />
				</td>
			</tr>
			<tr>
				<td>
					timeIn3:
				</td>
				<td>
					<input type="time" name="timeIn3" value="{$row.timeIn3}" />
				</td>
				<td width="40px"></td>
				<td>
					timeOut3:
				</td>
				<td>
					<input type="time" name="timeOut3" value="{$row.timeOut3}" />
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<input type="hidden" name="id" value="{$row.id}" />
					<input type="hidden" name="date" value="{$row.date}" />
					<button class="btn btn-large btn-primary" type="submit">Update</button>
				</td>
			</tr>
		</table>
	</form>
</div>
