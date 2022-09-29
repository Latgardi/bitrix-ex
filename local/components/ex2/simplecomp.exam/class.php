<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

class SimpleComp extends  CBitrixComponent
{
	private int $curUserID;
	private int $curUserAuthorType;
	private int $newsCnt = 0;
	private array $arAuthors;


	public function onPrepareComponentParams($arParams): array
	{
		if (!isset($arParams["CACHE_TIME"])) {
			$arParams["CACHE_TIME"] = 36000000;
		}
		if (!isset($arParams["NEWS_IBLOCK_ID"])) {
			$arParams["PRODUCTS_IBLOCK_ID"] = 1;
		}
		if (!isset($arParams["NEWS_AUTHOR_PROP_CODE"])) {
			$arParams["FIRMS_IBLOCK_ID"] = "AUTHOR";
		}
		if (!isset($arParams["USER_AUTHOR_TYPE_PROP_CODE"])) {
			$arParams["DETAIL_LINK_TEMPLATE"] = "UF_AUTHOR_TYPE";
		}

		return $arParams;
	}

	public function executeComponent()
	{
		global $APPLICATION;

		$this->getResult();
		$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE") . $this->arResult["NEWS_CNT"]);
		$this->includeComponentTemplate();
	}

	private function getCurUser(): void
	{
		global $USER;

		if ($USER->IsAuthorized()) {
			$this->curUserID = $USER->GetID();
			$obUser = CUser::GetList(
				"id",
				"asc",
				array("ID" => $this->curUserID),
				array("SELECT" => array(
					$this->arParams["USER_AUTHOR_TYPE_PROP_CODE"]
				))
			);
			$this->curUserAuthorType = $obUser->Fetch()[$this->arParams["USER_AUTHOR_TYPE_PROP_CODE"]];
		}
	}

	private function getAuthors(): void
	{
		$obAuthors = CUser::GetList(
			"id",
			"asc",
			array(
				$this->arParams["USER_AUTHOR_TYPE_PROP_CODE"] => $this->curUserAuthorType,
			),
			array("FIELDS" => array(
				"LOGIN",
				"ID",
			))
		);
		while ($row = $obAuthors->GetNext()) {
			if ($row["ID"] == $this->curUserID) {
				continue;
			}
			$this->arAuthors[$row["ID"]] = array("LOGIN" => $row["LOGIN"]);
		}
	}

	private function linkNews(): void
	{
		$obNews = CIBlockElement::GetList(
			array(),
			array(
				"IBLOCK_ID" => $this->arParams["NEWS_IBLOCK_ID"],
				"PROPERTY_" . $this->arParams["NEWS_AUTHOR_PROP_CODE"] => array_keys($this->arUsers),
			),
			false,
			false,
			array(
				"NAME",
				"IBLOCK_ID",
				"ID",
				"ACTIVE_FROM",
			)
		);
		while ($element = $obNews->GetNextElement()) {
			$arNewsAuthors = $element->GetProperties()[$this->arParams["NEWS_AUTHOR_PROP_CODE"]]["VALUE"];
			if (in_array($this->curUserID, $arNewsAuthors)) {
				continue;
			}
			$this->newsCnt++;
			$arFields = $element->GetFields();
			foreach ($arNewsAuthors as $authorID) {
				if (array_key_exists($authorID, $this->arAuthors)) {
					$this->arAuthors[$authorID]["NEWS"][] = $arFields;
				}
			}
		}
	}


	private function getCount(): void
	{
		$this->arResult["NEWS_CNT"] = $this->newsCnt;
	}


	private function getResult(): void
	{
		if ($this->startResultCache($this->arParams["CACHE_TIME"])) {
			$this->getCurUser();
			$this->getAuthors();
			$this->linkNews();
			$this->getCount();
			$this->arResult["AUTHORS"] = $this->arAuthors;
		}
	}
}
