<?php

namespace App\Http\Controllers;
use App\Department;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('welcome');
    }

    public function help() {
        return view('help');
    }

    public function showChangePasswordForm(){
        return view('auth.passwords.changepassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($validatedData['new-password']);
        $user->save();
        return redirect('/')->with("status","Password changed successfully !");
    }

    public function showResetPasswordForm($id){
        if ($this->isUserType('admin')) {
            return view('auth.passwords.reset')
                ->with('user', User::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function resetPassword(Request $request){
        if ($this->isUserType('admin')) {
            $validatedData = $request->validate([ 'password' => 'required|string|min:6|confirmed' ]);
            //Change Password
            $user = User::find($request->get('id'));
            $user->password = bcrypt($validatedData['password']);
            $user->save();
            return redirect('/users')->with("success","Password changed successfully !");
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function users() {
        if ($this->isUserType('admin')) {
            return view('users.users')
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function addUser() {
        if ($this->isUserType('admin')) {
            return view('users.create')
                ->with('depts', Department::all());
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function saveUser(Request $request) {
        if ($this->isUserType('admin')) {

            $validatedData = $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $user = new User(array(
                'fname' => $validatedData['fname'],
                'lname' => $validatedData['lname'],
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']),
                'department_id' => $request->get('dept_id'),
                'remember_token' => $request->get('_token')
            ));

            if ($request->get('email') == null) $user->email = null;
            else {
                $validateEmail = $request->validate([ 'email' => 'max:255|unique:users' ]);
                $user->email = $validateEmail['email'];
            }

            $isAdmin = ($user->type == 'admin') ? true : false;

            if ($request->get('supervisor')) $user->type = 'supervisor';
            if ($request->get('mname')) $user->mname = $request->get('mname');

            if ($isAdmin) $user->type = 'admin';
            $user->save();
            $dept = Department::find($request->get('dept_id'));

            return redirect('/users')
                ->with('success', 'Added new user '.$validatedData['fname'].' '.$validatedData['lname'].' under '.$dept->name.' Department')
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function showUser($id) {
        if ($this->isUserType('admin')) {
            return view('users.show')
                ->with('user', User::find($id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function editUser($id) {
        if ($this->isUserType('admin')) {
            return view('users.edit')
                ->with('user', User::find($id))
                ->with('depts', Department::all());
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function updateUser(Request $request, $id) {
        if ($this->isUserType('admin')) {
            $user = User::find($id);
            $isAdmin = ($user->type == 'admin') ? true : false;

            if ($request->get('email') != $user->email && $request->get('username') != $user->username) {
                $validatedData = $request->validate([
                    'email' => 'string|email|max:255|unique:users',
                    'username' => 'required|string|max:255|unique:users'
                ]);
                $user->email = $validatedData['email'];
                $user->username = $validatedData['username'];
            } else if ($request->get('email') != $user->email) {
                $validatedData = $request->validate([ 'email' => 'string|email|max:255|unique:users' ]);
                $user->email = $validatedData['email'];
            } else if ($request->get('username') != $user->username) {
                $validatedData = $request->validate([ 'username' => 'required|string|max:255|unique:users' ]);
                $user->username = $validatedData['username'];
            }

            $user->fname = $request->get('fname');
            $user->lname = $request->get('lname');
            $user->email = $request->get('email');
            $user->department_id = $request->get('dept_id');
            $user->remember_token = $request->get('_token');

            if ($request->get('supervisor')) $user->type = 'supervisor';
            else $user->type = 'member';
            if ($request->get('mname')) $user->mname = $request->get('mname');

            if ($isAdmin) $user->type = 'admin';
            $user->save();
            $dept = Department::find($request->get('dept_id'));

            return redirect('/users')
                ->with('success', 'Updated user '. $user->fname .' '. $user->lname .' under '.$dept->name.' Department')
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function destroyUser($id) {
        if ($this->isUserType('admin')) {
            $user = User::find($id);
            $user->delete();

            return redirect('/users')
                ->with('success', 'Deleted user ' . $user->fname . ' ' . $user->lname . ' under ' . $user->department['name'] . ' Department')
                ->with('users', User::orderBy('updated_at', 'desc')->paginate(20));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        if(User::find(auth()->user()->id)->type == $type) return true;
        return false;
    }
}
