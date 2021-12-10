<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

	public function __construct()
    {
        $this->middleware(['auth']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user['profile'] = $user->profile()->first();

        if (is_null($user['profile'])){
            $user['profile'] = json_decode ("{}");
        }
        return $user;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|nullable|min:8|max:191',
            'repassword' => 'sometimes|string|nullable|min:8|max:191'
        ]);


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

        $user->update($input);

        if(array_key_exists('id',$request['profile'])) {
            $user->profile()->update($request['profile']);
        } else{
            $user->profile()->create($request['profile']);
        }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
