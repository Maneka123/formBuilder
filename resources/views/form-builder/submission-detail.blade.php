@extends('layout')

@section('title', 'Submission Detail')

@section('content')
<div class="container mt-5">
    <h1>Submission #{{ $submission->id }} for "{{ $form->name }}"</h1>

    <ul class="list-group">
        @foreach($submission->answerItems as $answer)
            <li class="list-group-item">
                <strong>{{ $answer->field->label }}:</strong>

                @php
                    $value = $answer->answer;

                    // Check if answer is JSON, decode it if yes
                    if (is_json($value)) {
                        $decoded = json_decode($value, true);

                        // If decoded value is array, join with commas
                        if (is_array($decoded)) {
                            $value = implode(', ', $decoded);
                        } else {
                            $value = $decoded;
                        }
                    }
                @endphp

                {{ $value }}
            </li>
        @endforeach
    </ul>
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
