<?php

namespace App\Http\Controllers;

use App\Models\AcquisitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AcquisitionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isLibrarian()) {
            $requests = AcquisitionRequest::with('requestedBy')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $requests = AcquisitionRequest::where('requested_by', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('acquisition.index', compact('requests'));
    }

    public function create()
    {
        return view('acquisition.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AcquisitionRequest::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'notes' => $request->notes,
            'requested_by' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('acquisition.index')
            ->with('success', 'Acquisition request submitted successfully.');
    }

    public function show(AcquisitionRequest $acquisition)
    {
        // Check if user is authorized to view this request
        if (!Auth::user()->isAdmin() && !Auth::user()->isLibrarian() && Auth::id() != $acquisition->requested_by) {
            abort(403, 'Unauthorized action.');
        }

        return view('acquisition.show', compact('acquisition'));
    }

    public function updateStatus(Request $request, AcquisitionRequest $acquisition)
    {
        $this->middleware('role:admin,librarian');

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,acquired',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $acquisition->status = $request->status;

        if ($request->has('notes') && $request->notes != '') {
            $acquisition->notes = $request->notes;
        }

        $acquisition->save();

        return redirect()->route('acquisition.index')
            ->with('success', 'Acquisition request status updated successfully.');
    }
}
