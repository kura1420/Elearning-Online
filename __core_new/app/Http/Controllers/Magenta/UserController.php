<?php

namespace App\Http\Controllers\Magenta;

use App\User;
use App\ProfilUser;
use App\DataTables\UsersDataTable;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    const FOLDER = 'magenta.user.';
    const URL = '/mgt/user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        //
        return $dataTable->render(self::FOLDER . 'index', ['url' => self::URL]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view(self::FOLDER . 'create')
                ->with([
                    'url' => self::URL
                ]);
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
        Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'nullable|string|email|max:100|unique:users',
            'username' => 'required|string|max:100|alpha_num|unique:users',
            'password' => 'required|string|min:6',
            'tingkat' => 'required|string',
        ])->validate();

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => strtolower($request->email),
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'level' => strtolower($request->tingkat),
                'active' => 1,
                'type' => 'mgt'
            ]);
    
            ProfilUser::create([
                'nama' => $request->nama_lengkap,
                'email' => strtolower($request->email),
                'user_id' => $user->id,
            ]);
        });

        return redirect(self::URL);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $row = User::findOrFail($id);

        return view(self::FOLDER . 'edit')
                ->with([
                    'url' => self::URL,
                    'row' => $row
                ]);
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
        $row = User::findOrFail($id);

        $email_unique = $request->email !== $row->email ? '|unique:users' : NULL;

        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'nullable|string|email|max:100' . $email_unique,
            'tingkat' => 'required|string',
        ];

        $fields = [
            'name' => $request->nama_lengkap,
            'email' => strtolower($request->email),
            'level' => strtolower($request->tingkat),
            'active' => $request->status,
        ];

        if (isset($request->password)) {
            $rules['password'] = 'required|string|min:6';

            $fields['password'] = bcrypt($request->password);
        }

        Validator::make($request->all(), $rules)->validate();

        DB::transaction(function () use ($request, $row, $fields) {
            $row->update($fields);

            ProfilUser::where('user_id', $row->id)
                ->update([
                    'nama' => $request->nama_lengkap,
                    'email' => strtolower($request->email),
                ]);
        });

        return redirect(self::URL);
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
