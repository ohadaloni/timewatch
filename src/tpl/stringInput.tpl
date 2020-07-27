<div class="well bs-component">
	<form class="form-horizontal" method="get" action="/{$controller}/{$action}">
		<fieldset>
			<label class="col-lg-4 control-label">{$title}</label>
			<div class="col-lg-3">
				<input type="text" class="form-control" id="{$name}"  name="{$name}" value="{$value}" placeholder="{$placeholder}" />
			</div>
			<div class="col-lg-2 col-lg-offset-2">						
				{foreach from=$hidden key=hname item=hvalue}
					<input type="hidden" name="{$hname}" value="{$hvalue}" />
				{/foreach}
				<button type="submit" class="btn btn-primary">{$submitTitle}</button>
			</div>
	</form>
</div>
