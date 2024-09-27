<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />

<style>
    .icon{
        margin-right: 5px;
    }
    .task-title{
        font-size: 12px;
    }
    .fa-circle{
        font-weight: 600 !important;
        font-size: 5px !important;
        margin-right: 5px !important;
    }
    .mr-1{
        margin-right: 10px;
        font-size: 15px;
    }
    .rotate-icon {
        transform: rotate(45deg);
        margin-right: 10px;
        font-size: 15px;
    }
    .table > :not(caption) > * > * {
        padding: 0.55rem 1.25rem;
        background-color: var(--bs-table-bg);
        border-bottom-width: 0px !important;
        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    }

    .comment-section {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .comments-display {
        flex: 1; 
        overflow-y: auto; 
        padding-bottom: 20px;
    }

    .comment-input {
        position: absolute;
        bottom: 10px; 
        left: 0;
        right: 0;
    }

    .comment {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .comment-author {
        font-weight: bold;
    }

    .comment-time {
        font-size: 0.9em;
        color: #777;
    }

    .comments-list {
        max-height: 500px;
        overflow-y: auto; 
    }

</style>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('UserDashboard.Layouts.Sidenavbar')

        <div class="layout-page">

            @include('UserDashboard.Layouts.header')

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Assign Task
                        </h4>

                        <div class="card p-4">
                            <div class="card w-75 m-auto">
                                <div class="card-body p-3">
                                    <div class="d-flex">
                                        <i class="fa-solid fa-grip-vertical icon me-2 mt-1"></i>
                                        <h5 class="mb-0">My Work</h5>
                                    </div>
                                    
                                    <ul class="nav nav-tabs mt-3" id="myTab" role="tablist" style="margin-right: 0rem !important; margin-left: 0rem !important;">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">To Do</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Done</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">Delegated</button>
                                        </li>
                                    </ul>
                                    
                                    <div class="tab-content p-0 mt-3" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                            <!-- Accordion for To Do -->
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            <i class="fas fa-calendar-day me-2"></i> Today({{$todayTasksCount}})
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            @foreach($todayTask as $task)
                                                                <div class="px-1">
                                                                    <div class="task-item d-flex align-items-center border-top border-bottom p-2 m-1 cursor-pointer" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#taskModal{{ $task->id }}" 
                                                                        data-title="{{ $task->title }}" 
                                                                        data-description="{{ $task->description }}" 
                                                                        data-due-date="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}" 
                                                                        data-priority="{{ $task->priority }}">
                                                                        <div class="d-flex">
                                                                            <i class="fas fa-clock me-2 mt-2"></i>
                                                                            <div>
                                                                                <p class="m-0 p-0 task-title">{{ $task->title }}</p>
                                                                                <p class="m-0 p-0 text-dark">{{ \Illuminate\Support\Str::words($task->description, 3, '...') }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $user->c_name }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $task->priority }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-solid fa-flag 
                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                @endif">
                                                                            </i>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen-xxl-down">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">Today</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex gap-4">
                                                                                        <div class="w-50">
                                                                                            <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}"><i class="fa-solid fa-list-check"></i>Task Details</h5>
                                                                                            <h1 class="text-dark">{{ $task->title }}</h1>
                                                                                            <div class="d-flex">
                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-circle-dot mr-1"></i>
                                                                                                            <span class="fw-bold">Status </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="badge text-bg-secondary">Open</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Start Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-success">{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Due Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-danger">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-user mr-1"></i>
                                                                                                            <span class="fw-bold">User</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span>{{ $user->name }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-flag mr-1"></i>
                                                                                                            <span class="fw-bold">Priority</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                        : <i class="fa-solid fa-flag 
                                                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                                                @endif">
                                                                                                            </i>
                                                                                                            <span>{{ $task->priority }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4"><i class="menu-icon tf-icons ti ti-file-dollar"></i>Task Description</h5>
                                                                                                <p class="m-0 p-0">{{ $task->description }}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}">
                                                                                                    <i class="fa-solid fa-link"></i> Attachments
                                                                                                </h5>
                                                                                                @if(!empty($task->attachments))
                                                                                                    <ul class="list-unstyled">
                                                                                                        @foreach($task->attachments as $attachment)
                                                                                                            <li class="mb-2">
                                                                                                                @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        <img src="{{ asset('assets/Task-Attechments/' . $attachment) }}" alt="{{ $attachment }}" style="width: 100px; height: auto;">
                                                                                                                    </a>
                                                                                                                @elseif(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['pdf']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        {{ $attachment }}
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @else
                                                                                                    <p>No attachments available.</p>
                                                                                                @endif
                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="comment-section w-50 d-flex flex-column justify-content-between">
                                                                                            <h3>Comments</h3>

                                                                                            <div id="commentList-{{ $task->id }}" class="comments-list overflow-auto" style="flex-grow: 1; overflow-x: auto;">
                                                                                                @if($comments->isNotEmpty())
                                                                                                    <ul>
                                                                                                        @foreach($comments as $comment)
                                                                                                            <li class="mb-2" data-comment-id="{{ $comment->id }}">
                                                                                                                <strong>{{ $comment->user_id ?? 'Anonymous' }}:</strong> 
                                                                                                                {{ $comment->comment_text }} 
                                                                                                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Asia/Kolkata')->format('d/m/Y h:i a') }}</small>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            </div>

                                                                                            <form class="commentForm" data-post-id="{{ $task->id }}">
                                                                                                @csrf
                                                                                                <div class="comment-input d-flex gap-3">
                                                                                                    <input name="comment_text" class="form-control" placeholder="Leave a comment..." required />
                                                                                                    <input type="hidden" name="post_id" value="{{ $task->id }}">
                                                                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                                                                </div>
                                                                                            </form>
                                                                                            
                                                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                                            <script>
                                                                                                $(document).ready(function() {
                                                                                                    $('.commentForm').off('submit').on('submit', function (event) {
                                                                                                        event.preventDefault();
                                                                                                        const postId = $(this).data('post-id');
                                                                                                        const form = $(this);
                                                                                                        const commentText = form.find('input[name="comment_text"]').val();
                                                                                                        const submitButton = form.find('button[type="submit"]');

                                                                                                        submitButton.prop('disabled', true);

                                                                                                        $.ajax({
                                                                                                            url: '/comments-store',
                                                                                                            method: 'POST',
                                                                                                            data: form.serialize(),
                                                                                                            success: function (response) {
                                                                                                                let newComment = `
                                                                                                                    <li class="mb-2">
                                                                                                                        <strong>${response.comment.user_id}:</strong> 
                                                                                                                        ${response.comment.comment_text} 
                                                                                                                        <small>${new Date(response.comment.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata', dateStyle: 'short', timeStyle: 'short' })}</small>
                                                                                                                    </li>`;

                                                                                                                $(`#commentList-${response.comment.post_id}`).append(newComment);

                                                                                                                form.find('input[name="comment_text"]').val('');
                                                                                                            },
                                                                                                            error: function (xhr, status, error) {
                                                                                                                Swal.fire({
                                                                                                                    icon: 'error',
                                                                                                                    title: 'Error!',
                                                                                                                    text: 'Failed to post the comment.',
                                                                                                                    confirmButtonText: 'OK'
                                                                                                                });
                                                                                                            },
                                                                                                            complete: function() {
                                                                                                                submitButton.prop('disabled', false);
                                                                                                            }
                                                                                                        });
                                                                                                    });
                                                                                                });
                                                                                            </script>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <i class="fas fa-exclamation-triangle me-2"></i> Overdue ({{ $dueTasksCount }})
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            @foreach($dueTasks as $task)
                                                                <div class="px-1">
                                                                    <div class="task-item d-flex align-items-center border-top border-bottom p-2 m-1 cursor-pointer" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#taskModalDuetasks{{ $task->id }}" 
                                                                        data-title="{{ $task->title }}" 
                                                                        data-description="{{ $task->description }}" 
                                                                        data-due-date="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}" 
                                                                        data-priority="{{ $task->priority }}">
                                                                        <div class="d-flex">
                                                                            <i class="fas fa-clock me-2 mt-2"></i>
                                                                            <div>
                                                                                <p class="m-0 p-0 task-title">{{ $task->title }}</p>
                                                                                <p class="m-0 p-0 text-dark">{{ \Illuminate\Support\Str::words($task->description, 3, '...') }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $user->c_name }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">
                                                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $task->priority }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-solid fa-flag 
                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                @endif">
                                                                            </i>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="taskModalDuetasks{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen-xxl-down">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">Overdue</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex gap-4">
                                                                                        <div class="w-50">
                                                                                            <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}"><i class="fa-solid fa-list-check"></i>Task Details</h5>
                                                                                            <h1 class="text-dark">{{ $task->title }}</h1>
                                                                                            <div class="d-flex">
                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-circle-dot mr-1"></i>
                                                                                                            <span class="fw-bold">Status </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="badge text-bg-secondary">Open</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Start Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-success">{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Due Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-danger">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-user mr-1"></i>
                                                                                                            <span class="fw-bold">User</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span>{{ $user->name }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-flag mr-1"></i>
                                                                                                            <span class="fw-bold">Priority</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                        : <i class="fa-solid fa-flag 
                                                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                                                @endif">
                                                                                                            </i>
                                                                                                            <span>{{ $task->priority }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4"><i class="menu-icon tf-icons ti ti-file-dollar"></i>Task Description</h5>
                                                                                                <p class="m-0 p-0">{{ $task->description }}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}">
                                                                                                    <i class="fa-solid fa-link"></i> Attachments
                                                                                                </h5>
                                                                                                @if(!empty($task->attachments))
                                                                                                    <ul class="list-unstyled">
                                                                                                        @foreach($task->attachments as $attachment)
                                                                                                            <li class="mb-2">
                                                                                                                @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        <img src="{{ asset('assets/Task-Attechments/' . $attachment) }}" alt="{{ $attachment }}" style="width: 100px; height: auto;">
                                                                                                                    </a>
                                                                                                                @elseif(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['pdf']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        {{ $attachment }}
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @else
                                                                                                    <p>No attachments available.</p>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="comment-section w-50 d-flex flex-column justify-content-between">
                                                                                            <h3>Comments</h3>

                                                                                            <div id="commentList-{{ $task->id }}" class="comments-list overflow-auto" style="flex-grow: 1; overflow-x: auto;">
                                                                                                @if($comments->isNotEmpty())
                                                                                                    <ul>
                                                                                                        @foreach($comments as $comment)
                                                                                                            <li class="mb-2" data-comment-id="{{ $comment->id }}">
                                                                                                                <strong>{{ $comment->user_id ?? 'Anonymous' }}:</strong> 
                                                                                                                {{ $comment->comment_text }} 
                                                                                                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Asia/Kolkata')->format('d/m/Y h:i a') }}</small>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            </div>

                                                                                            <form class="commentForm" data-post-id="{{ $task->id }}">
                                                                                                @csrf
                                                                                                <div class="comment-input d-flex gap-3">
                                                                                                    <input name="comment_text" class="form-control" placeholder="Leave a comment..." required />
                                                                                                    <input type="hidden" name="post_id" value="{{ $task->id }}">
                                                                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                                                                </div>
                                                                                            </form>
                                                                                            
                                                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                                            <script>
                                                                                                $(document).ready(function() {
                                                                                                    $('.commentForm').off('submit').on('submit', function (event) {
                                                                                                        event.preventDefault();
                                                                                                        const postId = $(this).data('post-id');
                                                                                                        const form = $(this);
                                                                                                        const commentText = form.find('input[name="comment_text"]').val();
                                                                                                        const submitButton = form.find('button[type="submit"]');

                                                                                                        submitButton.prop('disabled', true);

                                                                                                        $.ajax({
                                                                                                            url: '/comments-store',
                                                                                                            method: 'POST',
                                                                                                            data: form.serialize(),
                                                                                                            success: function (response) {
                                                                                                                let newComment = `
                                                                                                                    <li class="mb-2">
                                                                                                                        <strong>${response.comment.user_id}:</strong> 
                                                                                                                        ${response.comment.comment_text} 
                                                                                                                        <small>${new Date(response.comment.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata', dateStyle: 'short', timeStyle: 'short' })}</small>
                                                                                                                    </li>`;

                                                                                                                $(`#commentList-${response.comment.post_id}`).append(newComment);

                                                                                                                form.find('input[name="comment_text"]').val('');
                                                                                                            },
                                                                                                            error: function (xhr, status, error) {
                                                                                                                Swal.fire({
                                                                                                                    icon: 'error',
                                                                                                                    title: 'Error!',
                                                                                                                    text: 'Failed to post the comment.',
                                                                                                                    confirmButtonText: 'OK'
                                                                                                                });
                                                                                                            },
                                                                                                            complete: function() {
                                                                                                                submitButton.prop('disabled', false);
                                                                                                            }
                                                                                                        });
                                                                                                    });
                                                                                                });
                                                                                            </script>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <i class="fas fa-arrow-right me-2"></i> Next ({{ $NextTasksCount }})
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            @foreach($NextTasks as $task)
                                                                <div class="px-1">
                                                                    <div class="task-item d-flex align-items-center border-top border-bottom p-2 m-1 cursor-pointer" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#taskModalNextTasks{{ $task->id }}" 
                                                                        data-title="{{ $task->title }}" 
                                                                        data-description="{{ $task->description }}" 
                                                                        data-due-date="{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}" 
                                                                        data-priority="{{ $task->priority }}">
                                                                        <div class="d-flex">
                                                                            <i class="fas fa-clock me-2 mt-2"></i>
                                                                            <div>
                                                                                <p class="m-0 p-0 task-title">{{ $task->title }}</p>
                                                                                <p class="m-0 p-0 text-dark">{{ \Illuminate\Support\Str::words($task->description, 3, '...') }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $user->c_name }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">
                                                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $task->priority }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-solid fa-flag 
                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                @endif">
                                                                            </i>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="taskModalNextTasks{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen-xxl-down">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">Next</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex gap-4">
                                                                                        <div class="w-50">
                                                                                            <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}"><i class="fa-solid fa-list-check"></i>Task Details</h5>
                                                                                            <h1 class="text-dark">{{ $task->title }}</h1>
                                                                                            <div class="d-flex">
                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-circle-dot mr-1"></i>
                                                                                                            <span class="fw-bold">Status </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="badge text-bg-secondary">Open</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Start Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                        : <span class="fw-bold text-success">
                                                                                                            {{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') : 'Not Scheduled' }}
                                                                                                        </span>

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Due Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-danger">
                                                                                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}
                                                                                                            </span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-user mr-1"></i>
                                                                                                            <span class="fw-bold">User</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span>{{ $user->name }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-flag mr-1"></i>
                                                                                                            <span class="fw-bold">Priority</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                        : <i class="fa-solid fa-flag 
                                                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                                                @endif">
                                                                                                            </i>
                                                                                                            <span>{{ $task->priority }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4"><i class="menu-icon tf-icons ti ti-file-dollar"></i>Task Description</h5>
                                                                                                <p class="m-0 p-0">{{ $task->description }}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}">
                                                                                                    <i class="fa-solid fa-link"></i> Attachments
                                                                                                </h5>
                                                                                                @if(!empty($task->attachments))
                                                                                                    <ul class="list-unstyled">
                                                                                                        @foreach($task->attachments as $attachment)
                                                                                                            <li class="mb-2">
                                                                                                                @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        <img src="{{ asset('assets/Task-Attechments/' . $attachment) }}" alt="{{ $attachment }}" style="width: 100px; height: auto;">
                                                                                                                    </a>
                                                                                                                @elseif(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['pdf']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        {{ $attachment }}
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @else
                                                                                                    <p>No attachments available.</p>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="comment-section w-50 d-flex flex-column justify-content-between">
                                                                                            <h3>Comments</h3>

                                                                                            <div id="commentList-{{ $task->id }}" class="comments-list overflow-auto" style="flex-grow: 1; overflow-x: auto;">
                                                                                                @if($comments->isNotEmpty())
                                                                                                    <ul>
                                                                                                        @foreach($comments as $comment)
                                                                                                            <li class="mb-2" data-comment-id="{{ $comment->id }}">
                                                                                                                <strong>{{ $comment->user_id ?? 'Anonymous' }}:</strong> 
                                                                                                                {{ $comment->comment_text }} 
                                                                                                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Asia/Kolkata')->format('d/m/Y h:i a') }}</small>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            </div>

                                                                                            <form class="commentForm" data-post-id="{{ $task->id }}">
                                                                                                @csrf
                                                                                                <div class="comment-input d-flex gap-3">
                                                                                                    <input name="comment_text" class="form-control" placeholder="Leave a comment..." required />
                                                                                                    <input type="hidden" name="post_id" value="{{ $task->id }}">
                                                                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                                                                </div>
                                                                                            </form>
                                                                                            
                                                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                                            <script>
                                                                                                $(document).ready(function() {
                                                                                                    $('.commentForm').off('submit').on('submit', function (event) {
                                                                                                        event.preventDefault();
                                                                                                        const postId = $(this).data('post-id');
                                                                                                        const form = $(this);
                                                                                                        const commentText = form.find('input[name="comment_text"]').val();
                                                                                                        const submitButton = form.find('button[type="submit"]');

                                                                                                        submitButton.prop('disabled', true);

                                                                                                        $.ajax({
                                                                                                            url: '/comments-store',
                                                                                                            method: 'POST',
                                                                                                            data: form.serialize(),
                                                                                                            success: function (response) {
                                                                                                                let newComment = `
                                                                                                                    <li class="mb-2">
                                                                                                                        <strong>${response.comment.user_id}:</strong> 
                                                                                                                        ${response.comment.comment_text} 
                                                                                                                        <small>${new Date(response.comment.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata', dateStyle: 'short', timeStyle: 'short' })}</small>
                                                                                                                    </li>`;

                                                                                                                $(`#commentList-${response.comment.post_id}`).append(newComment);

                                                                                                                form.find('input[name="comment_text"]').val('');
                                                                                                            },
                                                                                                            error: function (xhr, status, error) {
                                                                                                                Swal.fire({
                                                                                                                    icon: 'error',
                                                                                                                    title: 'Error!',
                                                                                                                    text: 'Failed to post the comment.',
                                                                                                                    confirmButtonText: 'OK'
                                                                                                                });
                                                                                                            },
                                                                                                            complete: function() {
                                                                                                                submitButton.prop('disabled', false);
                                                                                                            }
                                                                                                        });
                                                                                                    });
                                                                                                });
                                                                                            </script>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                            <i class="fas fa-clock me-2"></i> Unscheduled ({{ $UnscheduledCount }})
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            @foreach($UnscheduledTask as $task)
                                                                <div class="px-1">
                                                                    <div class="task-item d-flex align-items-center border-top border-bottom p-2 m-1 cursor-pointer" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#taskModalUndefinetask{{ $task->id }}" 
                                                                        data-title="{{ $task->title }}" 
                                                                        data-description="{{ $task->description }}" 
                                                                        data-due-date="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}" 
                                                                        data-priority="{{ $task->priority }}">
                                                                        <div class="d-flex">
                                                                            <i class="fas fa-clock me-2 mt-2"></i>
                                                                            <div>
                                                                                <p class="m-0 p-0 task-title">{{ $task->title }}</p>
                                                                                <p class="m-0 p-0 text-dark">{{ \Illuminate\Support\Str::words($task->description, 3, '...') }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $user->c_name }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">
                                                                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Not Scheduled' }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-regular fa-circle"></i>
                                                                            <p class="m-0 p-0 text-dark">{{ $task->priority }}</p>
                                                                        </div>
                                                                        <div class="mx-2 d-flex align-items-center">
                                                                            <i class="fa-solid fa-flag 
                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                @endif">
                                                                            </i>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="taskModalUndefinetask{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen-xxl-down">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="taskModalLabel{{ $task->id }}">Unscheduled</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex gap-4">
                                                                                        <div class="w-50">
                                                                                            <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}"><i class="fa-solid fa-list-check"></i>Task Details</h5>
                                                                                            <h1 class="text-dark">{{ $task->title }}</h1>
                                                                                            <div class="d-flex">
                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-circle-dot mr-1"></i>
                                                                                                            <span class="fw-bold">Status </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="badge text-bg-secondary">Open</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Start Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-success">{{ $task->start_date ? $task->start_date : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-calendar-days mr-1"></i>
                                                                                                            <span class="fw-bold">Due Date </span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span class="fw-bold text-danger">{{ $task->due_date ? $task->due_date : 'Not Scheduled' }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                                <table class="d-flex flex-column w-50 table border-none">
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-regular fa-user mr-1"></i>
                                                                                                            <span class="fw-bold">User</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                            : <span>{{ $user->name }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                    <tr class="my-2">
                                                                                                        <th>
                                                                                                            <i class="fa-solid fa-flag mr-1"></i>
                                                                                                            <span class="fw-bold">Priority</span>
                                                                                                        </th>
                                                                                                        <td>
                                                                                                        : <i class="fa-solid fa-flag 
                                                                                                                @if($task->priority === 'Urgent') text-danger 
                                                                                                                @elseif($task->priority === 'High Priority') text-warning 
                                                                                                                @elseif($task->priority === 'Normal Priority') text-info 
                                                                                                                @elseif($task->priority === 'Low Priority') text-muted 
                                                                                                                @endif">
                                                                                                            </i>
                                                                                                            <span>{{ $task->priority }}</span>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4"><i class="menu-icon tf-icons ti ti-file-dollar"></i>Task Description</h5>
                                                                                                <p class="m-0 p-0">{{ $task->description }}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h5 class="modal-title border-bottom my-4" id="taskModalLabel{{ $task->id }}">
                                                                                                    <i class="fa-solid fa-link"></i> Attachments
                                                                                                </h5>
                                                                                                @if(!empty($task->attachments))
                                                                                                    <ul class="list-unstyled">
                                                                                                        @foreach($task->attachments as $attachment)
                                                                                                            <li class="mb-2">
                                                                                                                @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        <img src="{{ asset('assets/Task-Attechments/' . $attachment) }}" alt="{{ $attachment }}" style="width: 100px; height: auto;">
                                                                                                                    </a>
                                                                                                                @elseif(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['pdf']))
                                                                                                                    <a href="{{ asset('assets/Task-Attechments/' . $attachment) }}" target="_blank">
                                                                                                                        {{ $attachment }}
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @else
                                                                                                    <p>No attachments available.</p>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="comment-section w-50 d-flex flex-column justify-content-between">
                                                                                            <h3>Comments</h3>

                                                                                            <div id="commentList-{{ $task->id }}" class="comments-list overflow-auto" style="flex-grow: 1; overflow-x: auto;">
                                                                                                @if($comments->isNotEmpty())
                                                                                                    <ul>
                                                                                                        @foreach($comments as $comment)
                                                                                                            <li class="mb-2" data-comment-id="{{ $comment->id }}">
                                                                                                                <strong>{{ $comment->user_id ?? 'Anonymous' }}:</strong> 
                                                                                                                {{ $comment->comment_text }} 
                                                                                                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Asia/Kolkata')->format('d/m/Y h:i a') }}</small>
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            </div>

                                                                                            <form class="commentForm" data-post-id="{{ $task->id }}">
                                                                                                @csrf
                                                                                                <div class="comment-input d-flex gap-3">
                                                                                                    <input name="comment_text" class="form-control" placeholder="Leave a comment..." required />
                                                                                                    <input type="hidden" name="post_id" value="{{ $task->id }}">
                                                                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                                                                </div>
                                                                                            </form>
                                                                                            
                                                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                                            <script>
                                                                                                $(document).ready(function() {
                                                                                                    $('.commentForm').off('submit').on('submit', function (event) {
                                                                                                        event.preventDefault();
                                                                                                        const postId = $(this).data('post-id');
                                                                                                        const form = $(this);
                                                                                                        const commentText = form.find('input[name="comment_text"]').val();
                                                                                                        const submitButton = form.find('button[type="submit"]');

                                                                                                        submitButton.prop('disabled', true);

                                                                                                        $.ajax({
                                                                                                            url: '/comments-store',
                                                                                                            method: 'POST',
                                                                                                            data: form.serialize(),
                                                                                                            success: function (response) {
                                                                                                                let newComment = `
                                                                                                                    <li class="mb-2">
                                                                                                                        <strong>${response.comment.user_id}:</strong> 
                                                                                                                        ${response.comment.comment_text} 
                                                                                                                        <small>${new Date(response.comment.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata', dateStyle: 'short', timeStyle: 'short' })}</small>
                                                                                                                    </li>`;

                                                                                                                $(`#commentList-${response.comment.post_id}`).append(newComment);

                                                                                                                form.find('input[name="comment_text"]').val('');
                                                                                                            },
                                                                                                            error: function (xhr, status, error) {
                                                                                                                Swal.fire({
                                                                                                                    icon: 'error',
                                                                                                                    title: 'Error!',
                                                                                                                    text: 'Failed to post the comment.',
                                                                                                                    confirmButtonText: 'OK'
                                                                                                                });
                                                                                                            },
                                                                                                            complete: function() {
                                                                                                                submitButton.prop('disabled', false);
                                                                                                            }
                                                                                                        });
                                                                                                    });
                                                                                                });

                                                                                            </script>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                            Content for Tab 2
                                        </div>
                                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                            Content for Tab 3
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- / Content -->

                @include('UserDashboard.Layouts.footer')

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
