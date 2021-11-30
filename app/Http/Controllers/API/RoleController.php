<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $request = request();

        $filterOR = $request->{'FilterOR'} ? $request->{'FilterOR'} : "false";

        $filters = [
            'App\Utilities\StringFilter:qname,roles,' . $filterOR
        ];

        return Role::query()->filter($filters)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:125|unique:roles'
        ]);

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
        $role = Role::findOrFail($id);
        $role->delete();

        return ['message' => 'Role Deleted'];

    }
}
