@extends('layout')

@section('title', 'Form Submissions')

@section('content')
<div class="container mt-5">
    <h1>Submissions for: {{ $form->name }}</h1>

    @if($submissions->count())
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <td>{{ $submission->id }}</td>
                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('forms.submissions.show', [$form, $submission]) }}" class="btn btn-sm btn-info">View</a>
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
