<div class="container">
	<form method="post" action="/">
		<table>
			<tr style="background-color:#def;">
				<td>
					Email: <input type="text" size="40" placeholder="email" name="loginName"><br />
				</td>
				<td>
					Password: <input type="password" size="20" placeholder="Password" name="passwd"><br />
				</td>
				<td>
					<div
						class="g-recaptcha"
						data-sitekey="{$RE_CAPTACH_SITE_KEY}"
					></div>
				</td>
				<td>
					<button type="submit">Sign in</button>
				</td>
			</tr>
		</table>
	</form>
	<hr />
	<form method="post" action="/timewatch/register">
		<table>
			<tr style="background-color:#fa7;">
				<td>
					Email: <input type="text" size="40" placeholder="email" name="email">
				</td>
				<td>
					<div
						class="g-recaptcha"
						data-sitekey="{$RE_CAPTACH_SITE_KEY}"
					></div>
				</td>
				<td>
					<button type="submit">Create Account</button>
				</td>
			</tr>
		</table>
	</form>
	<hr />
	<form method="post" action="/timewatch/forgotPass">
		<table>
			<tr style="background-color:#faa;">
				<td>
					Email: <input type="text" size="40" placeholder="email" name="email">
				</td>
				<td>
					<div
						class="g-recaptcha"
						data-sitekey="{$RE_CAPTACH_SITE_KEY}"
					></div>
				</td>
				<td>
					<button type="submit">Forgot Password</button>
				</td>
			</tr>
		</table>
	</form>

	<br />
	Your email will never be used for anything other than the above.
	<br />
	<script src='https://www.google.com/recaptcha/api.js'></script>
</div>
