<?php
if (isset($arParams["CANONICAL"])) {
	$iblock = \Bitrix\Iblock\Iblock::wakeUp(5)->getEntityDataClass();

	$elements = $iblock::getList(array(
			"select" => array("NAME", "NEWS"),
			"filter" => array(
				"IBLOCK_ID" => $arParams["CANONICAL"],
				"IBLOCK_ELEMENTS_ELEMENT_CANONICAL_NEWS_VALUE" => $arParams["ELEMENT_ID"]),
		)
	);

	$arCanonical = $elements->fetch();
	$cp = $this->__component;

	if (!empty($arCanonical) && is_object($cp)) {
		$cp->arResult["CANONICAL"] = $arCanonical["NAME"];
		$cp->SetResultCacheKeys(array("CANONICAL"));
	}
}





