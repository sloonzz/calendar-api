<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Http\Responses\ApiResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allCalendarEvents = CalendarEvent::all();
        } catch (Exception $e) {
            return new ApiResponse('Something went wrong. Please try again.', 'error', 500);
        }
        return new ApiResponse($allCalendarEvents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payload' => 'required|array',
            'payload.*.date' => 'required|date',
            'payload.*.name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return new ApiResponse($validator->errors(), 'error', 400);
        }

        try {
            $existingCalendarEvents = CalendarEvent::all();
            foreach ($existingCalendarEvents as $event) {
                $event->delete();
            }
            
            $savedCalendarEvents = [];
            foreach ($request->payload as $data) {
                $calendarEvent = new CalendarEvent($data);
                if (!$calendarEvent->save()) {
                    return new ApiResponse('Something went wrong trying to save the events. Please try again.', 'error', 500);
                }
                $savedCalendarEvents[] = $calendarEvent;
            }
        } catch (Exception $e) {
            return new ApiResponse('Something went wrong on our side. Please try again.', 'error', 500);
        } 
            
        return new ApiResponse($savedCalendarEvents);
    }
}
