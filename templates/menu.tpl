<div id="menu">
	{if $smarty.session.userId}
		<a class="button{if !$smarty.get.page || $smarty.get.page == 'Index'} active{/if}" href="index.php?page=Index">{$translator->getTranslation('index')}</a>
		<a class="button{if $smarty.get.page == 'Blueprints'} active{/if}" href="index.php?page=Blueprints">{$translator->getTranslation('blueprints')}</a>
		<a class="button{if $smarty.get.page == 'Craftings'} active{/if}" href="index.php?page=Craftings">{$translator->getTranslation('craftings')}</a>
		<a class="button{if $smarty.get.page == 'Materials'} active{/if}" href="index.php?page=Materials">{$translator->getTranslation('materials')}</a>
		<a class="button{if $smarty.get.page == 'Techniques'} active{/if}" href="index.php?page=Techniques">{$translator->getTranslation('techniques')}</a>
		<a class="button{if $smarty.get.page == 'Items'} active{/if}" href="index.php?page=Items">{$translator->getTranslation('items')}</a>
		<a class="button{if $smarty.get.page == 'ItemTypes'} active{/if}" href="index.php?page=ItemTypes">{$translator->getTranslation('itemTypes')}</a>
		<a class="button{if $smarty.get.page == 'Characters'} active{/if}" href="index.php?page=Characters">{$translator->getTranslation('characters')}</a>
		<a class="button{if $smarty.get.page == 'Options'} active{/if}" href="index.php?page=Options">{$translator->getTranslation('options')}</a>
		{if $isAdmin}
			<a class="button{if $smarty.get.page == 'Admin'} active{/if}" href="index.php?page=Admin">{$translator->getTranslation('admin')}</a>
		{/if}
		<a class="button{if $smarty.get.page == 'Logout'} active{/if}" href="index.php?page=Logout">{$translator->getTranslation('logout')}</a>
	{else}
		<a class="button{if $smarty.get.page == 'Login'} active{/if}" href="index.php?page=Login">{$translator->getTranslation('login')}</a>
		<a class="button{if $smarty.get.page == 'Register'} active{/if}" href="index.php?page=Register">{$translator->getTranslation('register')}</a>
	{/if}
	<div class="clear"></div>
</div>