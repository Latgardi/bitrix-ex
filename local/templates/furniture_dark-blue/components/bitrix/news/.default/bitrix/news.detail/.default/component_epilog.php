<?php
if (isset($arResult["CANONICAL"])) {
	$template = "<link rel=\"canonical\" href=\"{$arResult["CANONICAL"]}\">";
	$APPLICATION->setPageProperty("canonical", $template);
}

