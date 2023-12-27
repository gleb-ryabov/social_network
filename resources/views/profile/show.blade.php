<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($user->email) }}
        </h2>
    </x-slot>
    
    <div class = "body">

        @if (auth()->id() != Null)
            <!-- Form for comment -->
            <div class = "form_comment">
                <h1>Новый комментарий</h1>
                <form action="{{route('comment.create')}}" method="GET" class="form_answer">
                    @csrf
                    <input type="hidden" name="id_parent" value="0">
                    <input type="hidden" name="id_to" value="{{$user->id}}">
                    <input type="text" name="name" id="name_0" placeholder="Название">
                    <input type="text" name="comment" id="comment_0" class ="new_comment_comment" placeholder="Комментарий">
                    <button type="submit" id="submit_form_comment_0" class="submit_form_comment send_btn">Отправить</button>
                </form>
            </div>
        @endif

        <!-- Comment's container -->
        <div id = "comments_container">
            <!-- Comment -->
            @include('profile.partials.all-comments-for-show')
        </div>

        <!-- Count of comments -->
        @php
            $comment_count =  \App\Http\Controllers\CommentController::showCount($user->id);
        @endphp
        
        <!-- Button for more comments -->
        @if ($comment_count>5)
            <button id="load_more_button">↓</button>
        @endif

    </div>

</x-app-layout>


<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JS for upload comments using the ajax method -->
<script>
$(document).ready(function() {
    $("#load_more_button").click(function() {
        $.ajax({
            type: "GET",
            url: "/comment/showAll/{{$user->id}}",
            success: function(msg){
                $("#comments_container").html(msg);
                }
        })
        // hide button "load_more_button"
        $(this).hide();
    })
});
</script>