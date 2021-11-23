<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Models\User;

class UserController extends Controller
{
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

        $withOrCondition = $request->{'FilterOr'} ? ($request->{'FilterOr'} === "true") : false;

        if ($withOrCondition){
            // Or Condition
            $result = null;
            foreach ($request->all() as $name => $value) {
                if ($name[0] === "q") {
                    $query = User::query()->filter([
                        'App\Utilities\StringFilter:' . $name . ',users'
                    ])->get();

                    if($result){
                            $result = $result->merge($query);
                    } else {
                        $result = $query;

                    }
                }
            }
            if ($result){
                $users = $result->all();
                $total = count($users);
                return  new Paginator($users, $total, 10);
            } else{
                return new Paginator([], 0, 10);
            }

        } else {
            // And Condition
            return User::query()->filter([
                        'App\Utilities\StringFilter:qname,users',
                        'App\Utilities\StringFilter:qemail,users'
                        ])->paginate(10);
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
        //
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
