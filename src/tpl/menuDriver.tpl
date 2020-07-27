<div class="navbar-wrapper">
	<div class="container-fluid">
		<nav class="navbar">
			<div class="container">
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						{foreach from=$menu key=sectionName item=sectionData}
							<li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown"
									role="button" aria-haspopup="true" aria-expanded="false">{$sectionName}<span class="caret"></span></a>
								<ul class="dropdown-menu">
									{foreach from=$sectionData key=itemKey item=menuItem}
										<li>
											{if $menuItem.divider}
												{$menuItem.divider}
											{else}
												<a
													href="{$menuItem.url}"
													{if $menuItem.target}
														target="{$menuItem.target}"
													{/if}
												>{$menuItem.title}</a>
											{/if}
										</li>
									{/foreach}
								</ul>
							</li>
						{/foreach}
					</ul>
				</div>
		</nav>
	</div>
</div>
