@extends('layout')

@section('title', 'Submit Form')

@section('content')
<div class="container mt-5">
    <h1>{{ $form->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('forms.submit.store', $form) }}">
        @csrf

        @foreach($fields as $field)
            <div class="mb-3">
                <label>{{ $field->label }} @if($field->required)<span class="text-danger">*</span>@endif</label>

                @if($field->type == 'text')
                    <input type="text" name="field_{{ $field->id }}" class="form-control" required="{{ $field->required }}">
                @elseif($field->type == 'textarea')
                    <textarea name="field_{{ $field->id }}" class="form-control" required="{{ $field->required }}"></textarea>
                @elseif($field->type == 'radio')
                    @foreach(json_decode($field->options) as $opt)
                        <div class="form-check">
                            <input type="radio" name="field_{{ $field->id }}" value="{{ $opt }}" class="form-check-input" id="opt{{ $loop->index }}">
                            <label class="form-check-label" for="opt{{ $loop->index }}">{{ $opt }}</label>
                        </div>
                    @endforeach
                @elseif($field->type == 'checkbox')
                    @foreach(json_decode($field->options) as $opt)
                        <div class="form-check">
                            <input type="checkbox" name="field_{{ $field->id }}[]" value="{{ $opt }}" class="form-check-input" id="opt{{ $loop->index }}">
                            <label class="form-check-label" for="opt{{ $loop->index }}">{{ $opt }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
