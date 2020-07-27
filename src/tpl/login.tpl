<div class="container">
	<form method="post" action="/">
		<input type="text" size="40" placeholder="email" name="loginName">
		<input type="password" size="20" placeholder="Password" name="passwd">        
		<button type="submit">Sign in</button>
	</form>
	<br />
	<form method="post" action="/timewatch/register">
		<input type="text" size="40" placeholder="email" name="email">
		<button type="submit">Create Account</button>
	</form>
	<br />
	<form method="post" action="/timewatch/forgotPass">
		<input type="text" size="40" placeholder="email" name="email">
		<button type="submit">Forgot Password</button>
	</form>

	<br />
	Your email will only be used for registration verification and 'Forgot Password'.
	<br />
</div>
