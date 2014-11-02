<?php

class FeedController extends Core_Controller
{

	public function indexAction()
	{
		$user = $this->_currentUser;
		$parentPostId = $this->getRequest()->getPost('parent_post', null);

		$feed = Service_Feed::getUserFeed($parentPostId, $user->getId());
		$data = array();

		foreach ($feed as &$post)
		{
			$post_array = $post->toArray();

			$post_array['content'] = Core_Helper_FeedFormatter::format($post_array['content']);
			$post_array['created'] = Core_Helper_DateSince::format($post_array['created']);

			if ($post_array['groupId']) {
				$post_array['group'] = Service_Group::getById($post_array['groupId'])->toArray();
			}

			$data[] = $post_array;
		}

		$this->json(array('last_update' => time(), 'posts' => $data));
	}

	public function updatesAction()
	{
		$user = Service_User::getCurrent();
		$lastUpdate = $this->getRequest()->getPost('last_update');
		$posts = $this->getRequest()->getPost('posts');

		if (!$lastUpdate || !is_array($posts)) {
			return $this->json(array());
		}

		$feed = Service_Feed::getUserFeedUpdates($lastUpdate, $user->getId(), $posts);
		$data = array();

		foreach ($feed as &$post) {

			$post_array = $post->toArray();

			$post_array['content'] = Core_Helper_FeedFormatter::format($post_array['content']);
			$post_array['created'] = Core_Helper_DateSince::format($post_array['created']);

			if ($post_array['groupId']) {
				$post_array['group'] = Service_Group::getById($post_array['groupId'])->toArray();
			}

			$data[] = $post_array;
		}

		$this->json(array('last_update' => time(), 'posts' => $data));
	}

}