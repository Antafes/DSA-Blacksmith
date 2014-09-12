{include file="header.tpl"}
<div id="admin">
	<table class="collapse">
		<thead>
			<tr>
				<th>{$translator->getTranslation('userId')}</th>
				<th>{$translator->getTranslation('username')}</th>
				<th>{$translator->getTranslation('status')}</th>
				<th>{$translator->getTranslation('admin')}</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$userList item='user'}
				<tr class="{cycle values='odd,even'}">
					<td>{$user->getUserId()}</td>
					<td>{$user->getName()}</td>
					<td class="centered">
						{if $user->getStatus()}
							{$translator->getTranslation('active')}
						{else}
							<a href="index.php?page=Admin&amp;activate={$user->getUserId()}">
								{$translator->getTranslation('activate')}
							</a>
						{/if}
					</td>
					<td class="centered">
						{if $user->getAdmin() && $user->getUserId() != $smarty.session.userId}
							<a href="index.php?page=Admin&amp;removeAdmin={$user->getUserId()}">
								{$translator->getTranslation('removeAdmin')}
							</a>
						{elseif !$user->getAdmin() && $user->getStatus()}
							<a href="index.php?page=Admin&amp;setAdmin={$user->getUserId()}">
								{$translator->getTranslation('setAdmin')}
							</a>
						{/if}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
{include file="footer.tpl"}