<?php
$cp = $this->__component;

if (is_object($cp)) {
	$cp->arResult["SPECIAL_DATE"] = $arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"];
	$cp->SetResultCacheKeys(array("SPECIAL_DATE"));
}

