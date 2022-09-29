<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"NEWS_AUTHOR_PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_AUTHOR_PROP_CODE"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"USER_AUTHOR_TYPE_PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_AUTHOR_TYPE_PROP_CODE"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array("DEFAULT" => 36000000),
	),
);