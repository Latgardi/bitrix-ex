<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"FIRMS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_FIRMS_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"DETAIL_LINK_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_DETAIL_LINK_TEMPLATE"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"PRODUCT_PROPERTY" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PRODUCT_PROP"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"PAGE_SIZE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PAGE_SIZE"),
			"PARENT" => "BASE",
			"TYPE" => "INT",
		),
		"CACHE_TIME" => array("DEFAULT" => 36000000),
	),

);