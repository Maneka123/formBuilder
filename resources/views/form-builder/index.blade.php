@extends('layout')

@section('title', 'All Forms')

@section('content')
<div class="container mt-5">
    <h1>All Forms</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('forms.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create New Form
    </a>

    @if($forms->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Fields</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($forms as $form)
                    <tr>
                        <td>{{ $form->name }}</td>
                        <td>{{ $form->fields_count }}</td>
                        <td>{{ $form->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('forms.preview', $form) }}" class="btn btn-sm btn-primary" title="Preview">
                                <i class="bi bi-eye"></i> Preview
                            </a>
                            <a href="{{ route('forms.edit', $form) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="{{ route('forms.submit', $form) }}" class="btn btn-sm btn-success" title="Submit">
                                <i class="bi bi-send"></i> Submit
                            </a>
                            <form action="{{ route('forms.destroy', $form) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this form?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No forms created yet.</p>
    @endif
</div>
@endsection
