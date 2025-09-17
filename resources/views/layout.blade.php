<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Form Builder</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="d-flex vh-100">
    <nav class="bg-dark text-white p-3" style="width: 220px;">
    <h2 class="mb-4">FormApp</h2>
    <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="{{ route('forms') }}" class="nav-link text-white">Forms</a></li>
        <li class="nav-item mb-2"><a href="{{ route('form-builder') }}" class="nav-link text-white">Form Builder</a></li>
        <li class="nav-item mb-2"><a href="{{ route('form-builder.create') }}" class="nav-link text-white">Create Form</a></li>
        <li class="nav-item mb-2"><a href="{{ route('submissions') }}" class="nav-link text-white">Submissions</a></li>
        <li class="nav-item mb-2"><a href="{{ route('preview') }}" class="nav-link text-white">Preview</a></li>
        <li class="nav-item mb-2"><a href="{{ route('settings') }}" class="nav-link text-white">Settings</a></li>
    </ul>
</nav>


    <main class="flex-grow-1 p-4 bg-light">
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts') <!-- Load page-specific JS here -->
</body>
</html>
