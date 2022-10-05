<?php
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EventHandlers", "deactivateBlockElement"));

class EventHandlers
{
	public function deactivateBlockElement(array &$arFields)
	{
		$productsIBlockID = 2;

		if ($arFields["IBLOCK_ID"] == $productsIBlockID && $arFields["ACTIVE"] == "N") {
			$iblock = \Bitrix\Iblock\Iblock::wakeUp($productsIBlockID)->getEntityDataClass();
			$element = $iblock::getById($arFields["ID"])->fetchObject();
			$counter = $element->get("SHOW_COUNTER");
			if ($counter > 2) {
				global $APPLICATION;
				$APPLICATION->throwException("Товар невозможно деактивировать, у него $counter просмотров");
				return false;
			}
		}
	}
}