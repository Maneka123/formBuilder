@extends('layout')

@section('title', 'Submissions for ' . $form->name)

@section('content')
<div class="container mt-5">
    <h1>Submissions for "{{ $form->name }}"</h1>


    <p><strong>Total Submissions: </strong> {{ $totalCount }}</p>
    <!-- Date Filter Form -->
    <form method="GET" action="{{ route('forms.submissions', $form) }}" class="row g-3 mb-4">
        <div class="col-auto">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-auto">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>
        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary mb-3">Filter</button>
            <a href="{{ route('forms.submissions', $form) }}" class="btn btn-secondary mb-3">Clear</a>
        </div>
    </form>

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
                            <a href="{{ route('forms.submissions.show', [$form, $submission]) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $submissions->links() }}
    @else
        <p>No submissions found.</p>
    @endif
</div>
@endsection
