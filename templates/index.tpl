{include file="header.tpl"}
<script type="text/javascript">
	var typeList = JSON.parse('{$typeList->getAsArray()|json_encode}'),
		texts = {
			title: '{$translator->getTranslation('createType')}',
			parentType: '{$translator->getTranslation('parentType')}',
			typeKey: '{$translator->getTranslation('typeKey')}',
			typeNameDe: '{$translator->getTranslation('typeNameDe')}',
			typeNameEn: '{$translator->getTranslation('typeNameEn')}',
			createType: '{$translator->getTranslation('createType')}'
		};
</script>
<div id="index">
</div>
{include file="footer.tpl"}