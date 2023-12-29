<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_UPDATE->value)
            ->only(['edit', 'update']);
        $this->middleware('role_or_permission:' . PermissionEnum::HOTEL_DELETE->value)
            ->only(['destroy']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        $rooms = Room::where('hotel_id', $room->hotel_id)
            ->get();

        return response()->json($rooms);
    }
}
