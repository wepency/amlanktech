<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
 
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'poll_id' => 'required|integer',
            'option_id' => 'required|integer',
        ]);

        Vote::create($validatedData);

        return redirect()->back()->with('success', 'Vote submitted successfully');
    }

 
 
    public function update(Request $request, $id)
    {

        $vote = Vote::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'poll_id' => 'required|integer',
            'option_id' => 'required|integer',
        ]);

         $vote->update($validatedData);

        return redirect()->back()->with('success', 'Vote updated successfully');
    }

}
