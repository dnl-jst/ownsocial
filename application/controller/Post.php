<?php

namespace Application\Controller;

use Core\Controller;
use Service\Post as PostService;
use Service\Feed;
use Service\Group;
use Service\Like;
use Model\Post as PostModel;
use Model\Like as LikeModel;
use Core\Helper\FeedFormatter;
use Core\Helper\DateSince;

class Post extends Controller
{

	public function addAction()
	{
		$userId = $this->_currentUser->getId();
		$groupId = $this->getRequest()->getPost('group');
		$content = $this->getRequest()->getPost('content');
		$imageFileId = $this->getRequest()->getPost('image', null);

		if (!$imageFileId) {
			$imageFileId = null;
		}

		$post = new PostModel();
		$post->setRootPostId(null);
		$post->setParentPostId(null);
		$post->setUserId($userId);
		$post->setGroupId($groupId);
		$post->setContent($content);
		$post->setImageFileId($imageFileId);
		$post->setCreated(time());
		$post->setModified(time());

		if ($groupId) {
			$post->setVisibility('group');
		} else {
			$post->setVisibility('public');
		}

		$postId = PostService::store($post);

		$post->setId($postId);
		$post->setRootPostId($postId);

		PostService::store($post);

		$feed_array = Feed::getUserFeedPost($userId, $postId)->toArray();

		$feed_array['content'] = FeedFormatter::format($feed_array['content']);
		$feed_array['created'] = DateSince::format($feed_array['created']);

		if ($feed_array['groupId']) {
			$feed_array['group'] = Group::getById($feed_array['groupId'])->toArray();
		}

		$this->json($feed_array);
	}

	public function addCommentAction()
	{
		$postId = $this->getRequest()->getPost('post');
		$post = PostService::getById($postId);

		if (!$this->_currentUser->canSeePost($post->getRootPostId())) {
			$this->json(array('status' => 'error', 'message' => 'permission denied'));
			return;
		}

		$content = $this->getRequest()->getPost('content');

		$comment = new PostModel();
		$comment->setRootPostId($post->getRootPostId());
		$comment->setParentPostId($post->getId());
		$comment->setUserId($this->_currentUser->getId());
		$comment->setVisibility('comment');
		$comment->setContent($content);
		$comment->setImageFileId(null);
		$comment->setCreated(time());
		$comment->setModified(time());

		$commentPostId = PostService::store($comment);

		$feed_array = Feed::getUserFeedPost($this->_currentUser->getId(), $commentPostId)->toArray();

		$feed_array['content'] = FeedFormatter::format($feed_array['content']);
		$feed_array['created'] = DateSince::format($feed_array['created']);

		if ($feed_array['groupId']) {
			$feed_array['group'] = Group::getById($feed_array['groupId'])->toArray();
		}

		$this->json($feed_array);
	}

	public function getAction()
	{
		$postId = $this->getRequest()->getGet('post');
		$post = PostService::getById($postId);

		$this->json($post->toArray());
	}

	public function deleteAction()
	{
		$postId = $this->getRequest()->getPost('post');
		$post = PostService::getById($postId);

		if ($post->getUserId() != $this->_currentUser->getId())
		{
			$this->json(array('status' => 'error', 'message' => 'permission denied'));
			return;
		}

		PostService::delete($postId);

		$this->json(array('status' => 'success'));
	}

	public function toggleLikeAction()
	{
		$userId = $this->_currentUser->getId();
		$postId = $this->getRequest()->getPost('post');
		$post = Feed::getUserFeedPost($userId, $postId);

		$like = new LikeModel();
		$like->setUserId($userId);
		$like->setPostId($postId);
		$like->setCreated(time());

		if (!$post->getLiked()) {
			Like::store($like);
		} else {
			Like::delete($like);
		}

		$post = PostService::getById($postId);
		$post->setModified(time());
		PostService::store($post);

		$post = Feed::getUserFeedPost($userId, $postId)->toArray();

		$post['content'] = FeedFormatter::format($post['content']);
		$post['created'] = DateSince::format($post['created']);

		if ($post['groupId']) {
			$post['group'] = Group::getById($post['groupId'])->toArray();
		}

		$this->json($post);
	}

}