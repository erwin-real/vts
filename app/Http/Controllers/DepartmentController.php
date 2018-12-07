<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if ($this->isUserType('admin')) return view('departments.index')->with('depts', Department::all());
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function create() {
        if ($this->isUserType('admin')) return view('departments.create');
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function store(DepartmentFormRequest $request) {
        if ($this->isUserType('admin')) {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:departments',
                'description' => 'required|string|max:1000'
            ]);

            $dept = new Department(array(
                'name' => $validatedData['name'],
                'desc' => $validatedData['description']
            ));
            $dept->save();
            return redirect('/depts')->with('status', 'The ' . $dept->name . ' Department has been created');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function show($id) {
        if ($this->isUserType('admin')) {
            return view('departments.show')
                ->with('dept', Department::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function edit($id) {
        if ($this->isUserType('admin')) {
            return view('departments.edit')
                ->with('dept', Department::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function update(DepartmentFormRequest $request, $id) {
        if ($this->isUserType('admin')) {
            $dept = Department::find($id);
            $dept->name = $request->get('name');
            $dept->desc = $request->get('description');

            $dept->save();
            return redirect('/depts/')->with('status', 'The ' . $dept->name . ' Department has been updated!');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function destroy($id) {
        if ($this->isUserType('admin')) {
            $dept = Department::find($id);
            $user = null;

            if (count($dept->members)) {
                foreach ($dept->members as $member) {
                    $user = User::find($member->id);
                    $user->department_id = 0;
                    $user->type = 'N/A';
                    $user->save();
                }
            }

            if (count($dept->supervisor)) {
                foreach ($dept->supervisor as $supervisor) {
                    $user = User::find($supervisor->id);
                    $user->department_id = 0;
                    $user->type = 'N/A';
                    $user->save();
                }
            }
            $dept->delete();

            return redirect('/depts')->with('status', 'The ' . $dept->name . ' Department has been deleted!');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        if(User::find(auth()->user()->id)->type == $type) return true;
        return false;
    }
}
