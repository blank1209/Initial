<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Admin/Branches/Branches', [
            'branches' => Branch::with('users')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Admin/Branches/CreateBranches');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            // 'branchName' => 'required|string|max:25',
            // 'contactPerson' => 'required|integer|exists:users,id',
            // 'contact' => 'required|string',
        ]);

        Branch::create($request->all());

        return Redirect::route('branches.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
        return Inertia::render('Admin/Branches/BranchSales', [
            'branches' => $branch
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
