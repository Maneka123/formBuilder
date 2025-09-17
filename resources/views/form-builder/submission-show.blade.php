@extends('layout')

@section('title', 'Submissions for ' . $form->name)

@section('content')
<div class="container mt-5">
    <h1>Submissions for "{{ $form->name }}"</h1>

    @if($submissions->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <td>{{ $submission->id }}</td>
                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('forms.submissions.show', [$form, $submission]) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i>
View</a>
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
