<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Field;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
class FormController extends Controller
{
    public function create()
    {
        return view('form-builder.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fields' => 'required|json',
        ]);

        $form = Form::create(['name' => $request->name]);

        $fields = json_decode($request->fields, true);

        foreach ($fields as $index => $field) {
            Field::create([
                'form_id' => $form->id,
                'type' => $field['type'],
                'label' => $field['label'],
                'required' => $field['required'] ?? false,
                'options' => $field['options'] ?? null,
                'order' => $index,
            ]);
        }

        return redirect()->route('forms.preview', $form->id);
    }

    public function preview(Form $form)
    {
        $fields = $form->fields()->orderBy('order')->get();
        return view('form-builder.preview', compact('form', 'fields'));
    }

    public function index()
{
    $forms = Form::withCount('fields')->latest()->get();
    return view('form-builder.index', compact('forms'));
}

public function edit(Form $form)
{
    $fields = $form->fields()->orderBy('order')->get();

    // Prepare fields as array with decoded options
    $fieldsArray = $fields->map(function($f) {
        return [
            'type' => $f->type,
            'label' => $f->label,
            'required' => (bool) $f->required,
            'options' => $f->options ? json_decode($f->options) : null,
        ];
    })->toArray();

    return view('form-builder.edit', compact('form', 'fieldsArray'));
}


public function update(Request $request, Form $form)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'fields' => 'required|json',
    ]);

    $form->update(['name' => $request->name]);

    $fields = json_decode($request->fields, true);

    // Delete existing fields and recreate
    $form->fields()->delete();

    foreach ($fields as $index => $field) {
        Field::create([
            'form_id' => $form->id,
            'type' => $field['type'],
            'label' => $field['label'],
            'required' => $field['required'] ?? false,
            'options' => $field['options'] ?? null,
            'order' => $index,
        ]);
    }

    return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
}

public function destroy(Form $form)
{
    DB::transaction(function () use ($form) {
        $form->fields()->delete();
        $form->delete();
    });

    return redirect()->route('forms.index')->with('success', 'Form deleted.');
}


// Show the form for submission
    

    
    public function submissions(Form $form)
{
    $submissions = $form->submissions()->latest()->paginate(10);
    return view('form-builder.submissions', compact('form', 'submissions'));
}


public function showSubmission(Form $form, Submission $submission)
{
    $submission->load('answers.field');
    return view('form-builder.submission-detail', compact('form', 'submission'));
}




public function submit(Request $request, Form $form)
{
    $rules = [];

    foreach ($form->fields as $field) {
        $fieldKey = 'field_' . $field->id;

        $rule = [];
        if ($field->required) $rule[] = 'required';
        else $rule[] = 'nullable';

        if (in_array($field->type, ['text', 'textarea'])) $rule[] = 'string';
        if (in_array($field->type, ['checkbox'])) $rule[] = 'array';

        $rules[$fieldKey] = $rule;
    }

    $validated = $request->validate($rules);

    // Create submission without 'answers' field since you save answers separately
    $submission = $form->submissions()->create();

    foreach ($form->fields as $field) {
        $input = $validated['field_' . $field->id] ?? null;

        // Save array as JSON if needed
        if (is_array($input)) $input = json_encode($input);

        $submission->answers()->create([
            'field_id' => $field->id,
            'answer' => $input,
        ]);
    }

    return redirect()->route('forms.submissions.show', [$form, $submission])
        ->with('success', 'Form submitted successfully!');
}



public function show(Form $form)
{
    $fields = $form->fields()->orderBy('order')->get();
    return view('form-builder.submit', compact('form', 'fields'));
}

}
