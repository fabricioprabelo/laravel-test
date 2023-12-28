<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_LIST->value)
            ->only(['index']);
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_CREATE->value)
            ->only(['create', 'store']);
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_UPDATE->value)
            ->only(['show', 'edit', 'update']);
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_DELETE->value)
            ->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with(['rooms'])->paginate();

        return view('hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelRequest $request)
    {
        Hotel::create($request->validated());

        return redirect()->route('hotels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelRequest $request, Hotel $hotel)
    {
        $hotel->update($request->validated());

        return redirect()->route('hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index');
    }
}
