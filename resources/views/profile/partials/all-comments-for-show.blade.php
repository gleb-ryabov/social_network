@foreach ($comments as $comment)

    <div class = "comment">
        <!-- Comment -->

        <!-- If this is response -->
        @if ($comment->id_parent != 0)
            <div class = "response">
                <p>Ответ на комментарий:</p>
                @php
                    $parent_comment =  \App\Http\Controllers\CommentController::showComment($comment->id_parent);
                @endphp
                @if ($parent_comment)
                    <div class = "author_comment">
                        <a href = "{{route('profile.show', $parent_comment->id_from)}}">
                            {{$parent_comment->email}}
                        </a>
                    </div>
                    <div class = "quote_comment">
                        {{$parent_comment->comment}}
                    </div>
                @else
                    Комментарий удален
                @endif
            </div>
        @endif

        <div class = "author_comment">
            <a href = "{{route('profile.show', $comment->id_from)}}">
                {{$comment->email}}
            </a>
        </div>
        <div class = "name_comment">
            {{$comment->name}}
        </div>
        <div class = "comment_comment">
            {{$comment->comment}}
        </div>

        <!-- Check log in -->
        @if (auth()->id() != Null)

            <!--Button's container  -->
            <div class = "button_comment">

                <!-- Button "Delete" for comment -->
                @if (($comment->id_from == auth()->id()) || ($comment->id_to == auth()->id()))
                <form action = "{{route('comment.destroy', $comment->id)}}" method = "POST">
                    @csrf
                    @method('delete')
                    <button type = "submit" class="delete_btn">Удалить</button>
                </form>
                @endif

                <!-- Button "Answer" for comment -->
                <div>
                    <button id="btn_answer_{{$comment->id}}" class="answer_btn">Ответить</button>
                </div>

            </div>

            <!-- Form for comment -->
            <div id="container_answer_{{$comment->id}}" style="display: none;" class = "container_answer">
                <form action="{{route('comment.create')}}" method="GET" class = "form_answer">
                    @csrf
                    <input type = "hidden" name = "id_parent" value = "{{$comment->id}}">
                    <input type = "hidden" name = "id_to" value = "{{$comment->id_to}}">
                    <input type = "text" name = "name" id = "name{{$comment->id}}" placeholder="Название">
                    <input type = "text" name = "comment" id = "comment{{$comment->id}}" class ="new_comment_comment" placeholder="Комментарий">
                    <button type = "submit" id = "submit_form_comment{{$comment->id}}" class="submit_form_comment send_btn">Отправить</button>
                </form>
            </div>

        @endif

    </div>
@endforeach