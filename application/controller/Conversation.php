<?php

namespace Application\Controller;

use Core\Controller;
use Service\Conversation as ConversationService;

class Conversation extends Controller
{

	public function indexAction()
	{
		$conversations = ConversationService::getByUserId($this->_currentUser->getId());

		$this->_view->conversations = $conversations;
	}

}