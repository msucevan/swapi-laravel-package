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
        } else if ($request->has('name') || $request->has('gender') || $request->has('skincolor') ||  $request->has('eyecolor')) {
            
            if ($request->has('name')) {
                $people = Person::where('name', 'like', '%' . $request->name . '%')->paginate();
                $people->appends(['name' => $request->input('name')]);
            }

            if ($request->has('gender')) {
                $people = Person::where('gender', '=', $request->gender)->paginate();
                $people->appends(['gender' => $request->input('gender')]);
            }

            if ($request->has('skincolor')) {
                $people = Person::where('skin_color','like', '%' . $request->skincolor . '%')->paginate();
                $people->appends(['skincolor' => $request->input('skincolor')]);
            }
            if ($request->has('eyecolor')) {
                $people = Person::where('eyecolor','like', '%' . $request->eyecolor . '%')->paginate();
                $people->appends(['eyecolor' => $request->input('eyecolor')]);
            }
        }
        return $people;
    }
}
