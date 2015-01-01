<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Model\Conversation as ConversationModel;
use Model\Conversation\User as ConversationUser;
use Model\Conversation\Post as ConversationPostModel;
use Model\Conversation\Post\Seen as ConversationPostSeenModel;
use Service\Conversation as ConversationService;
use Service\Conversation\User as ConversationUserService;
use Service\User;

class Conversation extends Controller
{

	public function indexAction()
	{
		$conversations = ConversationService::getByUserId($this->_currentUser->getId());

		$this->_view->hideLeftColumn = true;
		$this->_view->middleColumnClasses = 'col-md-9 col-lg-9';
		$this->_view->conversations = $conversations;
	}

	public function getMembersAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');

		$users = User::getByConversationId($conversationId);

		$return = array();

		foreach ($users as $user) {

			$return[] = array(
				'id' => $user->getId(),
				'first_name' => $user->getFirstName(),
				'last_name' => $user->getLastName(),
				'portrait_file_id' => $user->getPortraitFileId()
			);

		}

		$this->json($return);
	}

	public function getPostsAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');
		$offset = $this->getRequest()->getPost('offset', 0);

		$posts = ConversationService\Post::getLastByConversationId($conversationId, $this->_currentUser->getId(), $offset);

		$response = array();

		foreach ($posts as $post) {

			if (!$post->getSeen()) {

				$postSeen = new ConversationPostSeenModel();
				$postSeen->setUserId($this->_currentUser->getId());
				$postSeen->setPostId($post->getId());
				$postSeen->setCreated(time());

				ConversationService\Post::storeSeen($postSeen);

			}

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

	public function addPostAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');
		$conversation = ConversationService::getById($conversationId);

		$message = $this->getRequest()->getPost('message');

		if (!$message) {
			$this->json(array(
				'success' => false
			));
			return;
		}

		if (!$conversation->hasRelation($this->_currentUser)) {
			$this->json(array(
				'success' => false
			));
			return;
		}

		$post = new ConversationPostModel();
		$post->setConversationId($conversation->getId());
		$post->setUserId($this->_currentUser->getId());
		$post->setMessage($message);
		$post->setCreated(time());

		$postId = ConversationService\Post::store($post);

		$postSeen = new ConversationPostSeenModel();
		$postSeen->setUserId($this->_currentUser->getId());
		$postSeen->setPostId($postId);
		$postSeen->setCreated(time());

		ConversationService\Post::storeSeen($postSeen);

		$this->json(array(
			'success' => true
		));
	}

	public function createAction()
	{
		$conversation = new ConversationModel();
		$conversation->setCreated(time());
		$conversation->setCreatedBy($this->_currentUser->getId());
		$conversation->setLastUpdate(time());

		$conversationId = ConversationService::store($conversation);

		$conversationUser = new ConversationUser();
		$conversationUser->setConversationId($conversationId);
		$conversationUser->setUserId($this->_currentUser->getId());
		$conversationUser->setCreated(time());
		$conversationUser->setCreatedBy($this->_currentUser->getId());

		ConversationUserService::store($conversationUser);

		$this->json(array(
			'conversation_id' => $conversationId
		));
	}

	public function suggestMembersAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');
		$search = $this->getRequest()->getPost('search');
		$users = array();

		if (!$search) {
			$this->json($users);
			return;
		}

		if ($this->_config['network_type']['value'] === 'public') {

			try {
				$resultUsers = User::searchContactsNotInConversation(
					$search,
					$this->_currentUser->getId(),
					$conversationId
				);

				foreach($resultUsers as $user) {

					$users[] = array(
						'id' => $user->getId(),
						'first_name' => $user->getFirstName(),
						'last_name' => $user->getLastName(),
						'department' => $user->getDepartment(),
						'portrait_file_id' => $user->getPortraitFileId()
					);

				}

			} catch (NoResultException $e) {}

		} else {

			try {
				$resultUsers = User::searchNotInConversation($search, $conversationId);

				foreach($resultUsers as $user) {

					$users[] = array(
						'id' => $user->getId(),
						'first_name' => $user->getFirstName(),
						'last_name' => $user->getLastName(),
						'department' => $user->getDepartment(),
						'portrait_file_id' => $user->getPortraitFileId()
					);

				}

			} catch (NoResultException $e) {}

		}

		$this->json($users);
	}

	public function addMembersAction()
	{
		$conversationId = $this->getRequest()->getPost('conversation_id');
		$newMembers = $this->getRequest()->getPost('new_members');

		foreach ($newMembers as $userId) {

			$conversationUser = new ConversationUser();
			$conversationUser->setConversationId($conversationId);
			$conversationUser->setUserId($userId);
			$conversationUser->setCreated(time());
			$conversationUser->setCreatedBy($this->_currentUser->getId());

			ConversationUserService::store($conversationUser);

		}

		$this->json(array(
			'success' => true
		));
	}

}