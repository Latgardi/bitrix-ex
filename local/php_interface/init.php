<?php
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EventHandlers", "deactivateBlockElement"));

class EventHandlers
{
	public function deactivateBlockElement(array &$arFields)
	{
		if ($arFields["IBLOCK_ID"] == 2 && $arFields["ACTIVE"] == "N") {
			$count = $arFields["SHOW_COUNTER"];
			if ($count > 2) {
				global $APPLICATION;
				$APPLICATION->throwException("Товар невозможно деактивировать, у него $count просмотров");
				return false;
			}
		}
	}
}