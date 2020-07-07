<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Author;

class AuthorController extends Controller
{
    public function __construct()
    {
        // The "auth" middleware is applied only to the showAllAuthors method
        $this->middleware('auth',['only' =>[
            'showAllAuthors'
        ]]); 
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function createAuthor(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:authors|email',
            'location' => 'required|alpha'
        ]);
        
        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function showAllAuthors() {
        return response()->json(Author::all());
    }

    public function showOneAuthor($id) {
        return response()->json(Author::find($id));
    }

    public function update($id, Request $request) {
        $author = Author::findorfail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    public function deleteAuthor($id) {
        Author::findOrfail($id)->delete();
        return response('Author Deleted', 200);
    }
}
