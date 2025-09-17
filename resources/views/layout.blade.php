<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Form Builder</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="d-flex vh-100">
    <nav class="bg-dark text-white p-3" style="width: 220px;">
        <h2 class="mb-4">FormApp</h2>
        <ul class="nav flex-column">

            <!-- Link to all forms -->
            <li class="nav-item mb-2">
                <a href="{{ route('forms.index') }}" class="nav-link text-white">Forms</a>
            </li>

            <!-- Link to create a new form -->
            <li class="nav-item mb-2">
                <a href="{{ route('form-builder.create') }}" class="nav-link text-white">Create Form</a>
            </li>

            <!-- Optional: Link to a preview of a form -->
            <li class="nav-item mb-2">
                @if(isset($form))
                    <a href="{{ route('forms.preview', $form) }}" class="nav-link text-white">Preview</a>
                @else
                    <a href="#" class="nav-link text-white disabled">Preview</a>
                @endif
            </li>

            <!-- Submissions link: only show if $form is passed -->
            <li class="nav-item mb-2">
                @if(isset($form))
                    <a href="{{ route('forms.submissions', $form) }}" class="nav-link text-white">Submissions</a>
                @else
                    <a href="#" class="nav-link text-white disabled">Submissions</a>
                @endif
            </li>

            <!-- Optional: Settings link (can update if you create a route for it) -->
            <li class="nav-item mb-2">
                <a href="#" class="nav-link text-white">Settings</a>
            </li>

            <li class="nav-item mb-2">
    <a href="{{ route('submissions.all') }}" class="nav-link text-white">All Submissions</a>
</li>

        </ul>
    </nav>

    <main class="flex-grow-1 p-4 bg-light">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts') <!-- Load page-specific JS here -->
</body>
</html>
