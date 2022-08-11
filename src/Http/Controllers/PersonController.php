<?php

namespace Msucevan\Swapi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Msucevan\Swapi\Models\Person;

class PersonController extends Controller
{
    public function getPerson($id)
    {

        return  Person::with('planet')->findOrFail($id);
    }

    public function getPeople(Request $request)
    {

        $people = Person::paginate();

        if ($request->has('sort')) {
            $people = Person::orderBy($request->input('sort'))->paginate();
            $people->appends(['sort' => $request->input('sort')]);
        } else if ($request->has('name') || $request->has('gender') || $request->has('skin_color') ||  $request->has('eye_color')) {
            
            if ($request->has('name')) {
                $people = Person::where('name', 'like', '%' . $request->name . '%')->paginate();
                $people->appends(['name' => $request->input('name')]);
            }

            if ($request->has('gender')) {
                $people = Person::where('gender', '=', $request->gender)->paginate();
                $people->appends(['gender' => $request->input('gender')]);
            }

            if ($request->has('skin_color')) {
                $people = Person::where('skin_color','like', '%' . $request->skin_color . '%')->paginate();
                $people->appends(['skin_color' => $request->input('skin_color')]);
            }
            if ($request->has('eye_color')) {
                $people = Person::where('eye_color','like', '%' . $request->eye_color . '%')->paginate();
                $people->appends(['eye_color' => $request->input('eye_color')]);
            }
        }
        return $people;
    }
}
