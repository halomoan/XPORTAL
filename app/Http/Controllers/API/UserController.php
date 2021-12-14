<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:view users|add users|edit users|delete users']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::latest()->paginate(10);
        //return User::filterBy($request->all())->paginate(10);

        $request = request();

        $filterOR = $request->{'FilterOR'} ? $request->{'FilterOR'} : "false";

        $filters = [
                   'App\Utilities\StringFilter:qname,users,' . $filterOR,
                   'App\Utilities\StringFilter:qemail,users,' . $filterOR
        ];

        return User::query()->filter($filters)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->hasPermissionTo('add users')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

       $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8|max:191',
            'repassword' => 'required|string|min:8|max:191',
            'roles' => 'required|array',
        ]);



        $user =  User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['repassword'])
        ]);

        $user->syncRoles($request['roles']);

        return ['message' => 'Success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);


        $user['roles'] = $user->roles()->get();
        $user['profile'] = $user->profile()->first();

        if (is_null($user['profile'])){
            $user['profile'] = json_decode ("{}");
        }
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->hasPermissionTo('edit users')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

        $user = User::findOrFail($id);
          $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|nullable|min:8|max:191',
            'repassword' => 'sometimes|string|nullable|min:8|max:191',
            'roles' => 'required|array',

        ]);

        //dd($request->has('password'));
        //dd(empty($request->password));

        if ($request->has('password') && !empty($request->password)){
            if(! $request->has('repassword')){
                $errors['repassword'] = ['Re-type password is required'];
                $message = ['message' => 'Password does not match', 'errors' => $errors];
                return response()->json($message, 422);

            } else if ($request->password !== $request->repassword){
                $errors['repassword'] = ['Not match with the password'];
                $message = ['message' => 'Password does not match', 'errors' => $errors];
                return response()->json($message, 422);
            }

           $input = $request->all();
        } else{
           $input = $request->except('password');
        }

        //dd(array_key_exists('id',$request['profile']));

        $user->update($input);
        $user->syncRoles($request['roles']);

        if(array_key_exists('id',$request['profile'])) {
            $user->profile()->update($request['profile']);
        } else{
            $user->profile()->create($request['profile']);
        }

        return ['message' => 'Success'];


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(!Auth::user()->hasPermissionTo('delete users')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

        $user = User::findOrFail($id);

        $user->delete();

        return ['message' => 'User Deleted'];

    }
}
