<?php

namespace App\Http\Controllers;

use App\Models\NotificationTemp;
use Illuminate\Http\Request;
use App\Notifications\UserMessageNotification;

class NotificationTempController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.notification_temp.index', [
            'gsd'=>  global_user_data(),
            'notificationTemps' => NotificationTemp::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NotificationTemp $notificationTemp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationTemp $notificationTemp)
    {
        return view('Admin.notification_temp.edit', [
        'gsd' => global_user_data(),
        'notificationTemp' => $notificationTemp,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotificationTemp $notificationTemp)
    {
        
        $validated = $request->validate([
        'subject' => 'required|string',
        'body' => 'required|string',
    ]);

    $notificationTemp->update($validated);

    return redirect()->route('notification-temps.index')
                     ->with('success', 'Notification template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationTemp $notificationTemp)
    {
        //
    }
}
