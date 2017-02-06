<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Validator;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::paginate();

        if (is_null($notes)) {
            return response()->json([
                'message'       => 'Resource not found.'
            ], 404);
        }

        return response()->json([
            'data' => $notes
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->input(), [
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message'   => 'Cannot process request.',
                'errors'    => $validation->messages()
            ], 422);
        }

        $note = Note::create([
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $note
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);

        if (is_null($note)) {
            return response()->json([
                'message' => 'Resource not found.'
            ], 404);
        }

        return response()->json([
            'data' => $note
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->input(), [
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message'   => 'Cannot process request.',
                'errors'    => $validation->messages()
            ], 422);
        }

        $note = Note::find($id);

        if (is_null($note)) {
            return response()->json([
                'message' => 'Resource not found.'
            ], 404);
        }

        $note->update([
            'description' => $request->description
        ]);

        return response()->json([
            'data' => $note
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);

        if (is_null($note)) {
            return response()->json([
                'message' => 'Resource not found.'
            ], 404);
        }

        $note->delete();

        return response()->json([
            'message' => "Resource with id : $note->id successfully deleted."
        ]);
    }
}
