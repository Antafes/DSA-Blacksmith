<!DOCTYPE html>
<html lang="{$languageCode}">
	<head>
		<title>{$translator->getTranslation('title')}</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript">
			window.translations = {$translations};
		</script>
		{include_css}
		{include_js}
	</head>
	<body>
		<div id="head">
			{include file='menu.tpl'}
			<div class="clear"></div>
		</div>