@extends('layout')

@section('title', 'Edit Form')

@section('content')
<div class="container mt-5">
    <h1>Edit Form: {{ $form->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form-builder" method="POST" action="{{ route('forms.update', $form) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="formName" class="form-label">Form Name</label>
            <input type="text" class="form-control" id="formName" name="name" value="{{ old('name', $form->name) }}" required>
        </div>

        <div class="row">
            <!-- Clickable Field Types -->
            <div class="col-md-4">
                <h5>Add Fields</h5>
                <button type="button" class="btn btn-outline-primary mb-2 w-100 add-field" data-type="text">Add Text Input</button>
                <button type="button" class="btn btn-outline-primary mb-2 w-100 add-field" data-type="textarea">Add Text Area</button>
                <button type="button" class="btn btn-outline-primary mb-2 w-100 add-field" data-type="radio">Add Radio Buttons</button>
                <button type="button" class="btn btn-outline-primary mb-2 w-100 add-field" data-type="checkbox">Add Checkboxes</button>
            </div>

            <!-- Form Preview -->
            <div class="col-md-8">
                <h5>Form Preview</h5>
                <ul class="list-group" id="fields-list" style="min-height: 200px;">
                    <li class="list-group-item text-muted">No fields added yet.</li>
                </ul>
            </div>
        </div>

        <input type="hidden" name="fields" id="fields-json">

        <button type="submit" class="btn btn-primary mt-4">Update Form</button>
        <a href="{{ route('forms.index') }}" class="btn btn-secondary mt-4 ms-2">Cancel</a>
    </form>
</div>

<!-- Modal for options -->
<div class="modal fade" id="optionsModal" tabindex="-1" aria-labelledby="optionsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="optionsForm">
        <div class="modal-header">
          <h5 class="modal-title" id="optionsModalLabel">Enter Options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="optionsText">Enter one option per line:</label>
          <textarea class="form-control" id="optionsText" rows="5" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Options</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fieldsList = document.getElementById('fields-list');
    const fieldsJsonInput = document.getElementById('fields-json');
    const optionsModal = new bootstrap.Modal(document.getElementById('optionsModal'));
    const optionsForm = document.getElementById('optionsForm');
    const optionsText = document.getElementById('optionsText');

    // Load existing fields from Blade variable
let fields = @json(old('fields') ? json_decode(old('fields'), true) : $fieldsArray);


    let pendingType = null;

    // Add field button clicked
    document.querySelectorAll('.add-field').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.type;
            if (type === 'radio' || type === 'checkbox') {
                pendingType = type;
                optionsText.value = '';
                optionsModal.show();
            } else {
                addField(type);
            }
        });
    });

    optionsForm.addEventListener('submit', e => {
        e.preventDefault();
        const opts = optionsText.value.trim().split('\n').map(o => o.trim()).filter(o => o);
        if (opts.length === 0) {
            alert('Please enter at least one option.');
            return;
        }
        addField(pendingType, opts);
        pendingType = null;
        optionsModal.hide();
    });

    function addField(type, options = null) {
        fields.push({
            type,
            label: '',
            required: false,
            options
        });
        renderFields();
    }

    function renderFields() {
        fieldsList.innerHTML = '';
        if (fields.length === 0) {
            fieldsList.innerHTML = '<li class="list-group-item text-muted">No fields added yet.</li>';
            fieldsJsonInput.value = '';
            return;
        }

        fields.forEach((field, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-start flex-wrap';

            let label = field.label || 'No label';
            if (field.required) label += ' *';

            li.innerHTML = `
                <div>
                    <strong>${label}</strong> <small class="text-muted">(${field.type})</small>
                    ${field.options ? `<br><small>Options: ${field.options.join(', ')}</small>` : ''}
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-secondary edit-btn me-2">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                </div>
            `;

            li.querySelector('.edit-btn').addEventListener('click', () => {
                const newLabel = prompt('Enter field label:', field.label);
                if (newLabel !== null) {
                    field.label = newLabel.trim();
                    field.required = confirm('Make this field required?');
                    if (field.type === 'radio' || field.type === 'checkbox') {
                        const opts = prompt('Edit options (one per line):', field.options ? field.options.join('\n') : '');
                        if (opts !== null) {
                            field.options = opts.split('\n').map(o => o.trim()).filter(o => o);
                        }
                    }
                    renderFields();
                }
            });

            li.querySelector('.delete-btn').addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this field?')) {
                    fields.splice(index, 1);
                    renderFields();
                }
            });

            fieldsList.appendChild(li);
        });

        fieldsJsonInput.value = JSON.stringify(fields);
    }

    // Validate on form submission
    document.getElementById('form-builder').addEventListener('submit', e => {
        if (fields.length === 0) {
            e.preventDefault();
            alert('Please add at least one field.');
            return;
        }

        for (let i = 0; i < fields.length; i++) {
            if (!fields[i].label.trim()) {
                e.preventDefault();
                alert(`Field #${i + 1} is missing a label.`);
                return;
            }
        }

        fieldsJsonInput.value = JSON.stringify(fields);
    });

    renderFields();
});
</script>
@endsection
