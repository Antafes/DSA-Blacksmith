<div id="menu">
	{if $smarty.session.userId}
		<a class="button{if !$smarty.get.page || $smarty.get.page == 'Index'} active{/if}" href="index.php?page=Index">{$translator->gt('index')}</a>
		<a class="button{if $smarty.get.page == 'Craftings'} active{/if}" href="index.php?page=Craftings">{$translator->gt('craftings')}</a>
		<a class="button{if $smarty.get.page == 'Blueprints'} active{/if}" href="index.php?page=Blueprints">{$translator->gt('blueprints')}</a>
		<a class="button{if $smarty.get.page == 'Materials'} active{/if}" href="index.php?page=Materials">{$translator->gt('materials')}</a>
		<a class="button{if $smarty.get.page == 'Techniques'} active{/if}" href="index.php?page=Techniques">{$translator->gt('techniques')}</a>
		<a class="button{if $smarty.get.page == 'Items'} active{/if}" href="index.php?page=Items">{$translator->gt('items')}</a>
		<a class="button{if $smarty.get.page == 'ItemTypes'} active{/if}" href="index.php?page=ItemTypes">{$translator->gt('itemTypes')}</a>
		<a class="button{if $smarty.get.page == 'Characters'} active{/if}" href="index.php?page=Characters">{$translator->gt('characters')}</a>
		<a class="button{if $smarty.get.page == 'Options'} active{/if}" href="index.php?page=Options">{$translator->gt('options')}</a>
		{if $isAdmin}
			<a class="button{if $smarty.get.page == 'Admin'} active{/if}" href="index.php?page=Admin">{$translator->gt('admin')}</a>
		{/if}
		<a class="button{if $smarty.get.page == 'Logout'} active{/if}" href="index.php?page=Logout">{$translator->gt('logout')}</a>
	{else}
		<a class="button{if $smarty.get.page == 'Login'} active{/if}" href="index.php?page=Login">{$translator->gt('login')}</a>
		<a class="button{if $smarty.get.page == 'Register'} active{/if}" href="index.php?page=Register">{$translator->gt('register')}</a>
	{/if}
	<div class="clear"></div>
</div>