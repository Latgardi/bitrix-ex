<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class SimpleComp extends  CBitrixComponent
{
	private array $arNews;
	private array $arNewsID;
	private array $arSections;
	private array $arSectionsID;

	public function onPrepareComponentParams($arParams): array
	{
		if(!isset($arParams["CACHE_TIME"])) {
			$arParams["CACHE_TIME"] = 36000000;
		}
		if(!isset($arParams["NEWS_IBLOCK_ID"])) {
			$arParams["NEWS_IBLOCK_ID"] = 1;
		}
		if(!isset($arParams["PRODUCTS_IBLOCK_ID"])) {
			$arParams["PRODUCTS_IBLOCK_ID"] = 2;
		}

		return $arParams;
	}

	public function executeComponent()
	{
		global $APPLICATION;

		$this->getResult();
		$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE") . $this->arResult["PRODUCT_CNT"]);
		$this->includeComponentTemplate();
	}

	private function getNews(): void
	{
		$obNews = CIBlockElement::GetList(
			array(),
			array(
				"IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y",
			),
			false,
			false,
			array(
				"NAME",
				"ID",
				"ACTIVE_FROM",
			)
		);
		while ($row = $obNews->GetNext()) {
			$this->arNewsID[] = $row["ID"];
			$this->arNews[$row["ID"]] = $row;
		}
	}

	private function getSections(): void
	{
		$obSections = CIBlocksection::GetList(
			array(),
			array(
				"IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y",
				$this->arParams["PRODUCTS_IBLOCK_PROPERTY"] => $this->arNewsID,
			),
			true,
			array(
				"NAME",
				"IBLOCK_ID",
				"ID",
				$this->arParams["PRODUCTS_IBLOCK_PROPERTY"],
			)
		);
		while ($row = $obSections->GetNext()) {
			$this->arSectionsID[] = $row["ID"];
			$this->arSections[$row["ID"]] = $row;
		}
	}

	private function linkProducts(): void
	{
		$obProducts = CIBlockElement::GetList(
			array(),
			array(
				"IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y",
				//"SECTION_ID" => $arSectionsID
			),
			false,
			false,
			array(
				"NAME",
				"IBLOCK_SECTION_ID",
				"ID",
				"IBLOCK_ID",
				"PROPERTY_ARTNUMBER",
				"PROPERTY_MATERIAL",
				"PROPERTY_PRICE"
			)
		);

		while ($row = $obProducts->GetNext()) {
			$arButtons = CIBlock::GetPanelButtons(
				$row["IBLOCK_ID"],
				$row["ID"],
				$row["IBLOCK_SECTION_ID"],
				array("SECTION_BUTTONS"=>false, "SESSID"=>false)
			);
			$this->AddEditAction(
				$row["ID"],
				$arButtons["edit"]["add_element"]["ACTION_URL"],
				CIBlock::GetArrayByID($row["IBLOCK_ID"], "ELEMENT_ADD")
			);
			$this->AddEditAction(
				$row["ID"],
				$arButtons["edit"]["edit_element"]["ACTION_URL"],
				CIBlock::GetArrayByID($row["IBLOCK_ID"], "ELEMENT_EDIT")
			);
			$this->AddDeleteAction(
				$row["ID"],
				$arButtons["edit"]["delete_element"]["ACTION_URL"],
				CIBlock::GetArrayByID($row["IBLOCK_ID"], "ELEMENT_DELETE"),
				array("CONFIRM" => GetMessage("CT_BCS_ELEMENT_DELETE_CONFIRM"))
			);

			foreach ($this->arSections[$row["IBLOCK_SECTION_ID"]][$this->arParams["PRODUCTS_IBLOCK_PROPERTY"]] as $newsID) {
				$this->arNews[$newsID]["PRODUCTS"][] = $row;
			}
		}
	}

	private function getCount(): void
	{
		$count = 0;
		foreach ($this->arSections as $section) {
			$count += $section["ELEMENT_CNT"];
		}
		$this->arResult["PRODUCT_CNT"] = $count;
	}

	private function getSectionNames(): void
	{
		foreach ($this->arSections as $section) {
			foreach ($section[$this->arParams["PRODUCTS_IBLOCK_PROPERTY"]] as $newsID) {
				$this->arNews[$newsID]["SECTIONS"][] = $section["NAME"];
			}
		}
	}

	private function getResult(): void
	{
		if ($this->startResultCache($this->arParams["CACHE_TIME"])) {
			$this->getNews();
			$this->getSections();
			$this->linkProducts();
			$this->getCount();
			$this->getSectionNames();
			$this->arResult["NEWS"] = $this->arNews;
		}
	}
}
