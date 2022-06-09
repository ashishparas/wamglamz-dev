<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $ratings = Rating::where('rating_to', 'LIKE', "%$keyword%")
                ->orWhere('rating_by', 'LIKE', "%$keyword%")
                ->orWhere('ratings', 'LIKE', "%$keyword%")
                ->orWhere('reviews', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $ratings = Rating::latest()->paginate($perPage);
        }

        return view('admin.ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.ratings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Rating::create($requestData);

        return redirect('admin/ratings')->with('flash_message', 'Rating added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $rating = Rating::findOrFail($id);

        return view('admin.ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $rating = Rating::findOrFail($id);

        return view('admin.ratings.edit', compact('rating'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $rating = Rating::findOrFail($id);
        $rating->update($requestData);

        return redirect('admin/ratings')->with('flash_message', 'Rating updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Rating::destroy($id);

        return redirect('admin/ratings')->with('flash_message', 'Rating deleted!');
    }
}
