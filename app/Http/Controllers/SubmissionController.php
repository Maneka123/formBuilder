<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;

class SubmissionController extends Controller
{
    // List all submissions for a form
    public function index(Form $form)
    {
        $submissions = $form->submissions()->latest()->paginate(10);
        return view('form-builder.submissions', compact('form', 'submissions'));
    }

    // Show one specific submission detail
    public function show(Form $form, Submission $submission)
    {
        $submission->load('answerItems.field');  // Load related answers & fields
        return view('form-builder.submission-detail', compact('form', 'submission'));
    }
}
