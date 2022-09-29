<?php
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("EventHandlers", "deactivateBlockElement"));
AddEventHandler("main", "OnEpilog", Array("EventHandlers", "writeLog404Handler"));
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

	public function writeLog404Handler()
	{
		if (defined("ERROR_404")) {
			global $APPLICATION;
			$pageURL = $APPLICATION->GetCurPage();
			CEventLog::Add(array(
				"SEVERITY" => "SECURITY",
				"AUDIT_TYPE_ID" => "ERROR_404",
				"MODULE_ID" => "MAIN",
				"DESCRIPTION" => $pageURL
			));
		}
	}
}