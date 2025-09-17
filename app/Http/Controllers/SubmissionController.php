<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Symfony\Component\HttpFoundation\StreamedResponse;
class SubmissionController extends Controller
{
    // List all submissions for a form
    

        public function index(Request $request, Form $form)
{
    $query = $form->submissions()->latest();

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->input('start_date'));
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->input('end_date'));
    }

    $submissions = $query->paginate(10)->appends($request->only(['start_date', 'end_date']));
// Get total count of submissions for this form (with filters)
    $totalCount = $query->count();

    return view('form-builder.submissions', compact('form', 'submissions', 'totalCount'));
    
}

        

    // Show one specific submission detail
    public function show(Form $form, Submission $submission)
    {
        $submission->load('answerItems.field');  // Load related answers & fields
        return view('form-builder.submission-detail', compact('form', 'submission'));
    }


    

public function allSubmissions()
{
    $submissions = Submission::with('form')->latest()->paginate(10);
    return view('form-builder.all-submissions', compact('submissions'));
}



public function exportToCsv(Form $form, Submission $submission)
{
    $filename = 'submission_' . $submission->id . '_form_' . $form->id . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function() use ($submission) {
        $file = fopen('php://output', 'w');

        // Header row
        fputcsv($file, ['Field Label', 'Answer']);

        foreach ($submission->answerItems as $answer) {
            $value = $answer->answer;

            if ($this->isJson($value)) {
                $decoded = json_decode($value, true);
                $value = is_array($decoded) ? implode(', ', $decoded) : $decoded;
            }

            fputcsv($file, [$answer->field->label, $value]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

private function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

}
