<div class="d-flex pt-3 pb-3 border-bottom align-items-center mb-2">
    <a href="{{ $topic->user }}" class="">
        <span class="mr-3 ant-avatar ant-avatar-square ant-avatar-image">
            <img src="{{ $topic->user->avatar }}" class="w45 rounded">
        </span>
    </a>
    <div class="d-flex flex-column justify-content-between">
        <a href="{{ route('Edu.front.topic.show',$topic) }}" class="text-secondary h5">
            {{ $topic->title }}
        </a>
        <span class="small text-black-50">
            <a href="/edu/center/topic/18907" class="">xfjpeter</a>
            . 发表于 {{ $topic->updated_at->diffForHumans() }}
            <span>. 评论 {{ $topic['comment_count'] }}</span>
            <span>. 点赞 {{ $topic['favour_count'] }}</span>
            <span>. 收藏 {{ $topic['favorite_count'] }}</span>
        </span>
    </div>
</div>
