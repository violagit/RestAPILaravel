<?php

namespace App\Http\Controllers;

use App\Exports\PollsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Poll as PollResource;
use App\Poll;
use Excel;
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;

class PollsController extends Controller
{
    public function indexPoll()
    {
        return response()->json(Poll::paginate(3), 200);
    }

    public function showPoll($id)
    {
        $poll = Poll::with('questions')->findOrFail($id);
        $response['poll'] = $poll;
        $response['questions'] = $poll->questions; 
        return response()->json($response, 200);
    }

    public function storePoll(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $poll = Poll::create($request->all());
        return response()->json($poll, 201);
    }

    public function updatePoll(Request $request, $id)
    {
        $poll = Poll::find($id);
        $poll->update($request->all());
        return response()->json($poll, 200);
    }

    public function deletePoll(Request $request, Poll $poll)
    {
        $poll->delete();
        return response()->json(null, 204);
    }

    public function errors()
    {
        return response()->json(['messaage' => 'Payment is required'], 501);
    }

    public function questions(Request $request, Poll $poll)
    {
        $questions = $poll->questions;
        return response()->json($questions, 200);
    }

    public function export()
    {

        return Excel::download(new PollsExport, 'polls.csv');

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Poll::latest()->get();
            return datatables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pollsAjax');
    }

    public function store(Request $request)
    {
        Poll::updateOrCreate(['id' => $request->product_id],
            ['title' => $request->title]);

        return response()->json(['success' => 'Poll saved successfully.']);
    }

    public function edit($id)
    {
        $poll = Poll::find($id);
        return response()->json($poll);
    }

    public function destroy($id)
    {
        Poll::find($id)->delete();

        return response()->json(['success' => 'Poll deleted successfully.']);
    }

    public function editableColumn(Request $request)
    {
        $poll = Poll::find($request->id);

        if (is_null($poll)) {
            return response([
                'success' => false,
                'message' => 'Poll not found',
            ], 405);
        }

        $poll->{$request->column} = $request->value;

        $poll->save();

        return response([
            'success' => true,
            'message' => 'Poll updated',
        ], 200);

    }
}
