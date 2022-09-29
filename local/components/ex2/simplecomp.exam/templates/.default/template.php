<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
    <p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<? if (count($arResult["AUTHORS"]) > 0) : ?>
    <ul>
		<? foreach ($arResult["AUTHORS"] as $authorID => $arAuthor): ?>
            <li>
                [<?=$authorID?>] – <?=$arAuthor["LOGIN"]?>
            </li>
			<? if (count($arAuthor["NEWS"]) > 0): ?>
                <ul>
					<? foreach ($arAuthor["NEWS"] as $newsItem): ?>
                        <li>
							<?=$newsItem["NAME"]?>
                        </li>
					<? endforeach; ?>
                </ul>
			<? endif;
		endforeach;?>
    </ul>
<? endif; ?>


