<?php
AddEventHandler("main", "OnBeforeEventAdd", Array("EventHandlers", "feedbackFormChangeAuthor"));

class EventHandlers
{
	public function feedbackFormChangeAuthor(string &$event, string &$lid, array &$arFields): void
	{
		if ($event == "FEEDBACK_FORM") {
			global $USER;
			if (!$USER->isAuthorized()) {
				$author = $arFields["AUTHOR"];
				$author = "Пользователь не авторизован, данные из формы: $author";
				$arFields["AUTHOR"] = $author;
			} else {
				$author = $arFields["AUTHOR"];
				$author = "Пользователь авторизован: {$USER->GetID()} ({$USER->GetLogin()}) {$USER->getFullName()}, данные из формы: $author";
				$arFields["AUTHOR"] = $author;
			}
			CEventLog::Add(array(
				"SEVERITY" => "SECURITY",
				"AUDIT_TYPE_ID" => "CHANGE_MAIL_DATA",
				"MODULE_ID" => "MAIN",
				"DESCRIPTION" => "Замена данных в отсылаемом письме – $author"
			));

		}
	}
}