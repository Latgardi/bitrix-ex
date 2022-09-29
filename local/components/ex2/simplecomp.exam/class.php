<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class SimpleComp extends  CBitrixComponent
{
	private const DETAIL_LINK_TEMPLATE = "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#";
	private array $arFirms;
	private array $arFirmsID;

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

		return $arParams;
	}

	public function executeComponent()
	{
		global $APPLICATION;

		$this->getResult();
		$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE") . $this->arResult["FIRMS_CNT"]);
		$this->includeComponentTemplate();
	}

	private function getFirms(): void
	{
		$obFirms = CIBlockElement::GetList(
			array(),
			array(
				"IBLOCK_ID" => $this->arParams["FIRMS_IBLOCK_ID"],
			),
			false,
			false,
			array(
				"NAME",
				"ID",
			)
		);
		while ($row = $obFirms->GetNext()) {
			$this->arFirmsID[] = $row["ID"];
			$this->arFirms[$row["ID"]] = $row;
		}
	}

	private function linkProducts(): void
	{
			$obProducts = CIBlockElement::GetList(
				array(
					"NAME" => "ASC",
					"SORT" => "ASC",
				),
				array(
					"IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
					"PROPERTY_" . $this->arParams["PRODUCT_PROPERTY"] => $this->arFirmsID,
				),
				false,
				false,
				array(
					"NAME",
					"IBLOCK_ID",
					"IBLOCK_SECTION_ID",
					"CODE",
					"ID",
				)
			);
			while ($element = $obProducts->GetNextElement()) {
				$fields = $element->GetFields();
				$detailURL = str_replace(
					array(
						"#SECTION_ID#",
						"#ELEMENT_CODE#",
					),
					array(
						$fields["IBLOCK_SECTION_ID"],
						$fields["CODE"] . ".php",
					),
					$this->arParams["DETAIL_LINK_TEMPLATE"]
				);
				$fields["DETAIL_PAGE_URL"] = "/" . $detailURL;
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
		}
	}
}
