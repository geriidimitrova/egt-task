@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @if(auth()->user()->is_admin)
                    <b class="my-3">Here are comments waiting for approval: </b>
                    <div class="card">
                        <div class="card-body">
                            @forelse($comments as $comment)
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $comment->user->name }}:</strong>
                                            <p>{{ $comment->content }}</p>
                                            <small>Created on {{ gmdate("Y-m-d, H:i:s", $comment->created_on) }}</small>
                                            <div class="d-flex justify-content">
                                                <button class="btn btn-success my-3" onclick="approveComment({{ $comment->id }})">Approve</button>
                                                <button class="btn btn-danger mx-3 my-3" onclick="rejectComment({{  $comment->id }})">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <p>No pending comments to approve.</p>
                            @endforelse
                        </div>
                    </div>
                @else()
                    @forelse($comments as $comment)
                        <div class="card my-3">
                            <div class="card-body">
                                <p class="card-text">{{ $comment->content }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <small>Posted by <b>{{ $comment->user->name }}</b> on {{ date("Y-m-d, H:i:s", $comment->created_on) }}</small>
                                </li>
                            </ul>
                        </div>
                    @empty
                        <p>No comments available.</p>
                    @endforelse
                    <form id="commentForm">
                        <div class="card">
                            <div class="card-header">Add new comment</div>
                            <textarea id="content" name="content" class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
                        </div>
                        <div id="message"></div>
                        <button type="submit" class="btn btn-primary my-3">Send Comment</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
