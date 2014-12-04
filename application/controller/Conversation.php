<?php

namespace Application\Controller;

use Core\Controller;
use Service\Conversation as ConversationService;
use Service\User;

class Conversation extends Controller
{

	public function indexAction()
	{
		$conversations = ConversationService::getByUserId($this->_currentUser->getId());

		$this->_view->conversations = $conversations;
	}

	public function getMessagesAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');
		$offset = $this->getRequest()->getPost('offset', 0);

		$posts = ConversationService\Post::getLastByConversationId($conversationId, $offset);

		$response = array();

		foreach ($posts as $post) {

			$postArray = $post->toArray();
			$postUser = User::getById($post->getUserId());

			$postArray['user'] = array(
				'id' => $postUser->getId(),
				'first_name' => $postUser->getFirstName(),
				'last_name' => $postUser->getLastName(),
				'portrait_file_id' => $postUser->getPortraitFileId()
			);

			$response[] = $postArray;
		}

		$this->json($response);
	}

}