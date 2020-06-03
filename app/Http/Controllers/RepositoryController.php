<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepositoryRequest;
use App\Repository;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $repositories = Repository::all();
        return view('Repositories.index', ['repositories' => $repositories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('Repositories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RepositoryRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(RepositoryRequest $request)
    {
        Repository::create($request->only(['name','description','user_id']));
        return redirect('/repositories');
    }

    /**
     * Display the specified resource.
     *
     * @param  Repository  $repository
     * @return Factory|View
     */
    public function show(Repository $repository)
    {

        return view('Repositories.show', ['repository' => $repository]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Repository  $repository
     * @return View
     */
    public function edit(Repository $repository)
    {
        return view('Repositories.edit', ['repository' => $repository]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RepositoryRequest $request
     * @param  Repository $repository
     * @return Redirector
     */
    public function update(RepositoryRequest $request, Repository $repository)
    {
        $repository->update($request->only(['name','description']));
        return redirect('/repositories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Repository $repository
     * @return RedirectResponse
     */
    public function destroy(Repository $repository)
    {
        $repository->destroy($repository->id);
        return redirect('/repositories');
    }
}
