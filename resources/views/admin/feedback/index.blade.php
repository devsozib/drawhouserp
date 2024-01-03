@extends('layout.app')
@section('title', 'HRIS | Task')
@section('content')
    @include('layout/datatable')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Feedbacks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{!! url('admin/dashboard') !!}">Admin</a></li>                      
                        <li class="breadcrumb-item"><a href="javascript::void(0)">Feedbacks</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title text-center w-75">Feedback List</h3>                        
                    </div>
                    <div class="card-body" style="overflow-x: scroll;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="min-height: 400px;">
                                    <table class="table table-bordered table-striped datatbl" id="usertbl">
                                        <thead>
                                            <tr>
                                                <th>ID</th>                                               
                                                <th>Ttile</th>
                                                <th>Description</th>
                                                <th>Image</th>                                            
                                                <th>Property</th>
                                                <th>Creted By</th>                                               
                                                <th>Created time</th>
                                                <th>Status</th>
                                                {{-- <th width="150">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($feedBacks as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>                                                   
                                                    <td>{!! $item->feedbackTitle !!}</td>
                                                    <td>{!! $item->feedbackDescription !!}</td>
                                                    <td><img width="100" src="{{ asset('feedbacks/'.$item->feedbackFIle) }}" alt=""></td>
                                                    <th>{{ $item->Name }}</th>
                                                    <th>{{ $item->empname }}</th>
                                                    <th>{{ \Carbon\Carbon::parse($item->created_at)->format('F j, Y, g:i a') }}</th>
                                                    <td class="text">
                                                        <select name="status" class="form-control" onChange='updateFeedBackStatus({{ $item->id }},this.value)'>
                                                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Pending</option>
                                                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Progress</option>
                                                            <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>Done</option>                                                        
                                                        </select>
                                                    </td>                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'),{
                heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    // Add more heading options if needed
                ]
            }
            })
           
    </script>
    <script>
    let editors = {}; // Object to store the created editors

    function editor(id) {
    // Check if an editor instance already exists for the given ID
    if (editors.hasOwnProperty(id) && editors[id]) {
        // Destroy the existing editor instance
        editors[id].destroy()
        editors[id] = null;
    }

    // Create a new editor instance
    ClassicEditor
        .create(document.querySelector('#ueditor_' + id), {
        heading: {
            options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            // Add more heading options if needed
            ]
        }
        })
        .then(editor => {
        // Store the created editor instance
        editors[id] = editor;
        })
       
    }

    function updateFeedBackStatus(id, value){
            $.ajaxSetup({
                            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
            url: '{{ route('add.feedback') }}',
            method: 'POST', // Use 'POST' if you are sending data
            data: { 
                id:id,
                status: value,
                type:"statusUpdate" 
            },
            success: function(response) {               
                toastr.success('Status update success');            

            },
            });
    }
    </script>
@stop
