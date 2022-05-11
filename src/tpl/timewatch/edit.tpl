<div class="container">	 
	<form method="post" action="/timewatch/update">
		<h4>Change {$row.date} Timewatch</h4>
		project: <input type="text" width="12" name="project" value="{$row.project}">
		<br />
		timeIn: <input type="text" width="12" placeholder="timeIn" name="timeIn" value="{$row.timeIn}">
		timeOut: <input type="text" width="12" placeholder="timeOut" name="timeOut" value="{$row.timeOut}">
		<br />
		timeIn2: <input type="text" width="12" placeholder="timeIn2" name="timeIn2" value="{$row.timeIn2}">
		timeOut2: <input type="text" width="12" placeholder="timeOut2" name="timeOut2" value="{$row.timeOut2}">
		<br />
		timeIn3: <input type="text" width="12" placeholder="timeIn3" name="timeIn3" value="{$row.timeIn3}">
		timeOut3: <input type="text" width="12" placeholder="timeOut3" name="timeOut3" value="{$row.timeOut3}">
		<br />
		<input type="hidden" name="id" value="{$row.id}">
		<input type="hidden" name="date" value="{$row.date}">
		<button class="btn btn-large btn-primary" type="submit">Update</button>
	</form>
</div>
