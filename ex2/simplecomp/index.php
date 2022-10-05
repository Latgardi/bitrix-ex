<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"DETAIL_LINK_TEMPLATE" => "",
		"FIRMS_IBLOCK_ID" => "6",
		"NEWS_AUTHOR_PROP_CODE" => "AUTHOR",
		"NEWS_IBLOCK_ID" => "1",
		"PAGE_SIZE" => "2",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PRODUCTS_IBLOCK_PROPERTY" => "UF_NEWS_LINK",
		"PRODUCT_PROPERTY" => "FIRM",
		"USER_AUTHOR_TYPE_PROP_CODE" => "UF_AUTHOR_TYPE"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>