<?php

namespace Application\Controller;

use Core\Controller;
use Service\Feed as FeedService;
use Service\User;
use Service\Group;
use Core\Helper\FeedFormatter;
use Core\Helper\DateSince;

class Feed extends Controller
{

	public function indexAction()
	{
		$user = $this->_currentUser;
		$parentPostId = $this->getRequest()->getPost('parent_post', null);

		$feed = FeedService::getUserFeed($parentPostId, $user->getId());
		$data = array();

		foreach ($feed as &$post)
		{
			$post_array = $post->toArray();

			$post_array['content'] = FeedFormatter::format($post_array['content']);
			$post_array['created'] = DateSince::format($post_array['created']);

			if ($post_array['groupId']) {
				$post_array['group'] = Group::getById($post_array['groupId'])->toArray();
			}

			$data[] = $post_array;
		}

		if ($parentPostId) {
			$data = array_reverse($data);
		}

		$this->json(array('last_update' => time(), 'posts' => $data));
	}

	public function updatesAction()
	{
		$user = User::getCurrent();
		$lastUpdate = $this->getRequest()->getPost('last_update');
		$posts = $this->getRequest()->getPost('posts');

		if (!$lastUpdate || !is_array($posts)) {
			$this->json(array());
			return;
		}

		$feed = FeedService::getUserFeedUpdates($lastUpdate, $user->getId(), $posts);
		$data = array();

		foreach ($feed as &$post) {

			$post_array = $post->toArray();

			$post_array['content'] = FeedFormatter::format($post_array['content']);
			$post_array['created'] = DateSince::format($post_array['created']);

			if ($post_array['groupId']) {
				$post_array['group'] = Group::getById($post_array['groupId'])->toArray();
			}

			$data[] = $post_array;
		}

		$this->json(array('last_update' => time(), 'posts' => $data));
	}

}