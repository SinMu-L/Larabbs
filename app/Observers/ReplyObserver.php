<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use Illuminate\Support\Facades\DB;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        if(!app()->runningInConsole()){
            $reply->topic->updateReplyCount();

            // 通知话题作者有新的评论
            $reply->topic->user->notify(new TopicReplied($reply));
        }

    }

    public function updating(Reply $reply)
    {
        //
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
