<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Field;
use Illuminate\Http\Request;

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
    return view('form-builder.edit', compact('form', 'fields'));
}

public function update(Request $request, Form $form)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'fields' => 'required|json',
    ]);

    $form->update(['name' => $request->name]);

    $form->fields()->delete(); // Wipe old fields

    $fields = json_decode($request->fields, true);

    foreach ($fields as $index => $field) {
        $form->fields()->create([
            'type' => $field['type'],
            'label' => $field['label'],
            'required' => $field['required'] ?? false,
            'options' => $field['options'] ?? null,
            'order' => $index,
        ]);
    }

    return redirect()->route('forms.index')->with('success', 'Form updated.');
}

public function destroy(Form $form)
{
    DB::transaction(function () use ($form) {
        $form->fields()->delete();
        $form->delete();
    });

    return redirect()->route('forms.index')->with('success', 'Form deleted.');
}
}
