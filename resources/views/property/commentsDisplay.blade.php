@foreach($comments as $comment)
    <div class="display-comment">
        <strong>{{ $comment->user->name }}</strong>
        <p>{{ $comment->body }}</p>
        {{--
        @if(isset($comment->replies)&& count($comment->replies) > 0)<a class="show-replay" href="" id="show-replies">more replies</a>@endif
        <a class="replay ml-3" href="" id="reply">replay</a>
        <form class="replay-form" method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group custom-control-inline w-75">
                <input type="text" name="body" class="form-control" />
                <input type="hidden" name="property_id" value="{{ $property_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group custom-control-inline w-20">
                <input type="submit" class="add-replay btn btn-warning" value="Reply" />
            </div>
            <p class="error-replay text-danger"></p>
        </form>
        --}}
    </div>
@endforeach
