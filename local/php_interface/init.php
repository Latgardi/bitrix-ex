<?php
AddEventHandler("main", "OnEpilog", Array("EventHandlers", "setMeta"));

class EventHandlers
{
	public function setMeta(): void
	{
		global $APPLICATION;
		$page = $APPLICATION->GetCurPage();
		$iterator = \CIBlockElement::GetList(
			array(),
			array("NAME" => $page, "IBLOCK_ID" => 6),
			false,
			false,
			array("ID", "PROPERTY_10", "PROPERTY_11")
		);

		while ($data = $iterator->GetNext()) {
			$APPLICATION->SetPageProperty("title", $data["PROPERTY_10_VALUE"]);
			$APPLICATION->SetPageProperty("description", $data["PROPERTY_11_VALUE"]);
		}
	}
}