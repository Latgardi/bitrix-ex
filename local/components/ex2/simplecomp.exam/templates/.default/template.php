<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<? if (count($arResult["FIRMS"]) > 0) : ?>
    <ul>
        <? foreach ($arResult["FIRMS"] as $arFirm): ?>
            <li>
                <b><?=$arFirm["NAME"]?></b>
            </li>
            <? if (count($arFirm["PRODUCTS"]) > 0): ?>
                <ul>
                    <? foreach ($arFirm["PRODUCTS"] as $arProduct): ?>
                        <li>
							<?=$arProduct["NAME"]?> –
							<?=$arProduct["PROPERTIES"]["PRICE"]["VALUE"]?> –
							<?=$arProduct["PROPERTIES"]["MATERIAL"]["VALUE"]?> –
                            <a href="<?=$arProduct["DETAIL_PAGE_URL"]?>"><?=$arResult["DETAIL_LINK_TEMPLATE"]?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            <? endif;
		endforeach;?>

    </ul>

<? endif; ?>

<? $APPLICATION->IncludeComponent("bitrix:main.pagenavigation", "modern", array(
	"NAV_OBJECT" => $this->nav,
	"SEF_MODE" => "Y",
	"COMPONENT_TEMPLATE" => "modern"
),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>


