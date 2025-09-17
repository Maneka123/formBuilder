@extends('layout')

@section('title', 'Preview Form')

@section('content')
<div class="container mt-5">
    <h1>Preview: {{ $form->name }}</h1>

    <form>
        @foreach($fields as $field)
            <div class="mb-3">
                <label class="form-label">
                    {{ $field->label }} 
                    @if($field->required) <span class="text-danger">*</span> @endif
                </label>

                @php
                    $required = $field->required ? 'required' : '';
                @endphp

                @if($field->type === 'text')
                    <input type="text" class="form-control" {{ $required }} disabled>
                @elseif($field->type === 'textarea')
                    <textarea class="form-control" {{ $required }} disabled></textarea>
                @elseif($field->type === 'radio')
                    @foreach($field->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" disabled>
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif($field->type === 'checkbox')
                    @foreach($field->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </form>
</div>
@endsection
