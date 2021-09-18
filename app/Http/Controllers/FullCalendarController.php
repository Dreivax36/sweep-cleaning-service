<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crud_event;

class FullCalenderController extends Controller
{

    public function index(Request $request)
    {
        return view('front.events');
    }

    public function getEvents()
    {
        $getEvents = Crud_Event::all();
        $events = [];
    
        foreach ($getEvents as $values) {
            $start_date_format = \DateTime::createFromFormat('Y-m-d h:i:s', $values->start_date);
            $end_date_format = \DateTime::createFromFormat('Y-m-d h:i:s', $values->end_date);
            $event = [];
            $event['title'] = $values->title;
            $event['start'] = $start_date_format->format('c');
            $event['end'] = $end_date_format->format('c');
            $events[] = $event;
        }
    
        return $events;
    }
}