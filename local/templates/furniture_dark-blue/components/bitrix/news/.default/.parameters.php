<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SPECIAL_DATE" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SPECIAL_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"CANONICAL" => array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("CANONICAL"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
);
