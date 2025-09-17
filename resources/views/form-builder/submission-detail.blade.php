@extends('layout')

@section('title', 'Submission Detail')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-file-earmark-text me-2"></i>
                Submission #{{ $submission->id }} for "{{ $form->name }}"
            </h4>
        </div>

        <div class="card-body">
            <p class="mb-3">
                <i class="bi bi-geo-alt-fill text-muted me-1"></i>
                <strong>Submitted from IP:</strong>
                <span class="badge bg-light text-dark">{{ $submission->ip_address ?? 'N/A' }}</span>
            </p>

            <div class="list-group">
                @forelse($submission->answerItems as $answer)
                    @php
                        $value = $answer->answer;
                        if (is_json($value)) {
                            $decoded = json_decode($value, true);
                            $value = is_array($decoded) ? implode(', ', $decoded) : $decoded;
                        }
                    @endphp

                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 text-primary">{{ $answer->field->label }}</h6>
                        </div>
                        <p class="mb-0 text-dark">{{ $value }}</p>
                    </div>
                @empty
                    <p class="text-muted">No answers submitted.</p>
                @endforelse
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('submissions.all') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left-circle"></i> Back to All Submissions
</a>

            <a href="{{ route('forms.submissions.export', [$form, $submission]) }}" class="btn btn-success">
        <i class="bi bi-file-earmark-spreadsheet"></i> Export to CSV
    </a>
        </div>
    </div>
</div>
@endsection

@php
if (!function_exists('is_json')) {
    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
@endphp
