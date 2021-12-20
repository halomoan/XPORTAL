<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Spatie\Permission\Models\Role;
use App\Traits\NotifiyUserTrait;
use App\Notifications\NotificationEnum;

class RoleController extends Controller implements NotificationEnum
{
    use NotifiyUserTrait;

    public function __construct()
    {
        $this->middleware(['permission:view roles|add roles|edit roles|delete roles']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // $user = Auth::user();
        // $this->AlertUser($user,'INV','Invoices Is Ready For Viewing',self::INFO);

        // $this->AlertUser($user,'INV','There was errror during Invoices import',self::ERROR);
        // $this->AlertUser($user,'INV','There was warning during Invoices import',self::WARNING);
        // $this->AlertUser($user,'INV','Successfully Import Invoices',self::SUCCESS);
        // $this->AlertUser($user,'INV','Alert! Something was wrong during Import Invoices',self::ALERT);




        $request = request();

        $filterOR = $request->{'FilterOR'} ? $request->{'FilterOR'} : "false";

        $filters = [
            'App\Utilities\StringFilter:qname,roles,' . $filterOR
        ];

        $page = $request->query('page');

        if (isset($page)){
            return Role::query()->filter($filters)->paginate(10);
        }else{
            return Role::query()->filter($filters)->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!Auth::user()->hasPermissionTo('add roles')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

        $this->validate($request,[
            'name' => 'required|string|max:125|unique:roles'
        ]);

        $user = Auth::user();
        $this->AlertUser($user,'ROLES','A New Role Has Been Successfully Created',self::ERROR);


        return Role::create([
            'name' => $request['name']
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    public function permissions($id){

        $role = Role::findOrFail($id);
        return ['role' => $role, 'permissions' => $role->permissions ];
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

        if(!Auth::user()->hasPermissionTo('edit roles')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

        $role= Role::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:125|unique:roles'
        ]);

        $role->update($request->all());
        return ['message' => 'Updated the Role'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->hasPermissionTo('delete roles')){
            $message = ['message' => 'You do not have the required authorization.'];
            return response()->json($message, 422);
        }

        $role = Role::findOrFail($id);
        $role->delete();

        return ['message' => 'Role Deleted'];

    }
}
