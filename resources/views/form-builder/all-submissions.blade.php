@extends('layout')

@section('title', 'All Submissions')

@section('content')
<div class="container mt-5">
    <h1>All Form Submissions</h1>

    @if($submissions->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Form Name</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <td>{{ $submission->id }}</td>
                        <td>{{ $submission->form->name ?? 'N/A' }}</td>
                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('forms.submissions.show', [$submission->form, $submission]) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $submissions->links() }}
    @else
        <p>No submissions yet.</p>
    @endif
</div>
@endsection
