<form method="get" action="/timeWatch/updatePasswd">
	<table border="0">
		<tr class="timeWatchHeaderRow">
			<td colspan="2">Changeing Password for {$loginName}</td>
		</tr>
		<tr class="timeWatchRow">
			<td>Old Password</td>
			<td><input type="text" name="oldPasswd" size="30" /></td>
		</tr>
		<tr class="timeWatchRow">
			<td>New Password</td>
			<td><input type="text" name="newPasswd" size="30" /></td>
		</tr>
		<tr class="timeWatchRow">
			<td>New Password (again)</td>
			<td><input type="text" name="newPasswd2" size="30" /></td>
		</tr>
		<tr class="timeWatchRow">
			<td></td>
			<td><input type="submit" value="Update Password" /></td>
		</tr>
	</table>
</form>
