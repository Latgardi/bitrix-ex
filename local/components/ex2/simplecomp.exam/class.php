<?php
use \Bitrix\Main\UI\PageNavigation;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class SimpleComp extends  CBitrixComponent
{
	private const DETAIL_LINK_TEMPLATE = "детальный просмотр";
	private array $arFirms;
	private array $arFirmsID;
	public PageNavigation $nav;

	public function onPrepareComponentParams($arParams): array
	{
		if (!isset($arParams["CACHE_TIME"])) {
			$arParams["CACHE_TIME"] = 36000000;
		}
		if (!isset($arParams["PRODUCTS_IBLOCK_ID"])) {
			$arParams["PRODUCTS_IBLOCK_ID"] = 2;
		}
		if (!isset($arParams["FIRMS_IBLOCK_ID"])) {
			$arParams["FIRMS_IBLOCK_ID"] = 6;
		}
		if (!isset($arParams["DETAIL_LINK_TEMPLATE"])) {
			$arParams["DETAIL_LINK_TEMPLATE"] = self::DETAIL_LINK_TEMPLATE;
		}
		if (!isset($arParams["PRODUCT_PROPERTY"])) {
			$arParams["PRODUCT_PROPERTY"] = "FIRM";
		}
		if (!isset($arParams["PAGE_SIZE"])) {
			$arParams["PAGE_SIZE"] = 2;
		}

		return $arParams;
	}

	public function executeComponent()
	{
		\Bitrix\Main\Loader::includeModule('iblock');
		global $APPLICATION;

		$this->getResult();
		$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE") . $this->arResult["FIRMS_CNT"]);
		$this->includeComponentTemplate();
	}

	private function getFirms(): void
	{
		global $APPLICATION;

		$this->nav = new PageNavigation("nav-more-firms");
		$this->nav->allowAllRecords(true)
			->setPageSize(1)
			->initFromUri();
		$result = \Bitrix\Iblock\ElementTable::getList(
			array(
				"select" => ["NAME", "ID"],
				"filter" => array("=IBLOCK_ID"=>$this->arParams["FIRMS_IBLOCK_ID"]),
				"count_total" => true,
				"offset" => $this->nav->getOffset(),
				"limit" => $this->nav->getLimit()
			));

		$this->nav->setRecordCount($result->getCount());
		while ($row = $result->fetch()) {
			$this->arFirmsID[] = $row["ID"];
			$this->arFirms[$row["ID"]] = $row;
		}
	}

	private function linkProducts(): void
	{
		global $APPLICATION;
			$obProducts = CIBlockElement::GetList(
				array(),
				array(
					"IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
					"PROPERTY_" . $this->arParams["PRODUCT_PROPERTY"] => $this->arFirmsID,
				),
				false,
				array(
					"nPageSize" => $this->arParams["PAGE_SIZE"],
				),
				array(
					"NAME",
					"IBLOCK_ID",
					"ID",
					"DETAIL_PAGE_URL",
				)
			);
			while ($element = $obProducts->GetNextElement()) {
				$fields = $element->GetFields();
				$fields["PROPERTIES"] = $element->GetProperties();
				foreach ($fields["PROPERTIES"]["FIRM"]["VALUE"] as $firmID) {
					$this->arFirms[$firmID]["PRODUCTS"][] = $fields;
				}
			}

	}


	private function getCount(): void
	{
		$this->arResult["FIRMS_CNT"] = count($this->arFirms);
	}


	private function getResult(): void
	{
		if ($this->startResultCache($this->arParams["CACHE_TIME"])) {
			$this->getFirms();
			$this->linkProducts();
			$this->getCount();
			$this->arResult["FIRMS"] = $this->arFirms;
			$this->arResult["DETAIL_LINK_TEMPLATE"] = $this->arParams["DETAIL_LINK_TEMPLATE"];
			print_r($this->arResult["DETAIL_LINK_TEMPLATE"]);
		}
	}
}
