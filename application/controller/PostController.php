<?php

class PostController extends Core_Controller
{

	public function addAction()
	{
		$userId = $this->_currentUser->getId();
		$content = $this->getRequest()->getPost('content');

		$post = new Model_Post();
		$post->setParentPostId(null);
		$post->setUserId($userId);
		$post->setContent($content);
		$post->setCreated(time());
		$post->setModified(time());
		$post->setVisibility('public');

		$postId = Service_Post::store($post);

		$feed_array = Service_Feed::getUserFeedPost($userId, $postId)->toArray();

		$feed_array['content'] = Core_Helper_FeedFormatter::format($feed_array['content']);
		$feed_array['created'] = Core_Helper_DateSince::format($feed_array['created']);

		if ($feed_array['groupId']) {
			$feed_array['group'] = Service_Group::getById($feed_array['groupId'])->toArray();
		}

		$this->json($feed_array);
	}

	public function getAction()
	{
		$postId = $this->getRequest()->getGet('post');
		$post = Service_Post::getById($postId);

		$this->json($post->toArray());
	}

	public function deleteAction()
	{
		$postId = $this->getRequest()->getPost('post');
		$post = Service_Post::getById($postId);

		if ($post->getUserId() != $this->_currentUser->getId())
		{
			return $this->json(array('status' => 'error', 'message' => 'permission denied'));
		}

		Service_Post::delete($postId);

		return $this->json(array('status' => 'success'));
	}

	public function toggleLikeAction()
	{
		$userId = $this->_currentUser->getId();
		$postId = $this->getRequest()->getPost('post');
		$post = Service_Feed::getUserFeedPost($userId, $postId);

		$like = new Model_Like();
		$like->setUserId($userId);
		$like->setPostId($postId);
		$like->setCreated(time());

		if (!$post->getLiked()) {
			Service_Like::store($like);
		} else {
			Service_Like::delete($like);
		}

		$post = Service_Post::getById($postId);
		$post->setModified(time());
		Service_Post::store($post);

		$post = Service_Feed::getUserFeedPost($userId, $postId)->toArray();

		$post['content'] = Core_Helper_FeedFormatter::format($post['content']);
		$post['created'] = Core_Helper_DateSince::format($post['created']);

		if ($post['groupId']) {
			$post['group'] = Service_Group::getById($post['groupId'])->toArray();
		}

		$this->json($post);
	}

}