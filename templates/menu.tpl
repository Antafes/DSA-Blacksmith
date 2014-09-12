<div id="menu">
	{if $smarty.session.userId}
		<a class="button" href="index.php?page=Index">{$translator->getTranslation('index')}</a>
		<a class="button" href="index.php?page=Materials">{$translator->getTranslation('materials')}</a>
		<a class="button" href="index.php?page=Techniques">{$translator->getTranslation('techniques')}</a>
		<a class="button" href="index.php?page=ItemTypes">{$translator->getTranslation('itemTypes')}</a>
		{if $isAdmin}
			<a class="button" href="index.php?page=Admin">{$translator->getTranslation('admin')}</a>
		{/if}
		<a class="button" href="index.php?page=Logout">{$translator->getTranslation('logout')}</a>
	{else}
		<a class="button" href="index.php?page=Login">{$translator->getTranslation('login')}</a>
		<a class="button" href="index.php?page=Register">{$translator->getTranslation('register')}</a>
	{/if}
	<div class="clear"></div>
</div>