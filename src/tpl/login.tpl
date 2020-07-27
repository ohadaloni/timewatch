<div class="container">
	<form method="post" action="/">
		Email: <input type="text" size="40" placeholder="email" name="loginName"><br />
		Password: <input type="password" size="20" placeholder="Password" name="passwd"><br />
		<div
			class="g-recaptcha"
			data-sitekey="{$RE_CAPTACH_SITE_KEY}">
		</div>
		<button type="submit">Sign in</button>
	</form>
	<hr />
	<form method="post" action="/timewatch/register">
		Email: <input type="text" size="40" placeholder="email" name="email">
		<div
			class="g-recaptcha"
			data-sitekey="{$RE_CAPTACH_SITE_KEY}">
		</div>
		<button type="submit">Create Account</button>
	</form>
	<hr />
	<form method="post" action="/timewatch/forgotPass">
		<input type="text" size="40" placeholder="email" name="email">
		<div
			class="g-recaptcha"
			data-sitekey="{$RE_CAPTACH_SITE_KEY}">
		</div>
		<button type="submit">Forgot Password</button>
	</form>

	<br />
	Your email will never be used for anything other than the above.
	<br />
	<script src='https://www.google.com/recaptcha/api.js'></script>
</div>
