<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\Acount;
use Illuminate\Http\Request;

class AcountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = Acount::all();
        return view('account.index', compact('account'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        Acount::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt(substr('nama', 0, 3) . substr('email', 0, 3)),
            
        ]);

        // atau jika seluruh data input akan dimasukkan langsung ke db bisa dengan perintah Akun::create($request->all());

        return redirect()->back()->with('success', 'Berhasil menambahkan data Akun!');
    
    }

    /**
     * Display the specified resource.
     */
    public function kelola(Acount $acount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $account = Acount::find($id);

        return view('account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required',
            'role' => 'required'
        ]);

        if($request->password){

        Acount::where('id', $id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' =>  bcrypt($request->password),
        ]);}else{
            Acount::where('id', $id)->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
            ]);
            }


        return redirect()->route('account.home')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        Acount::where('id', $request->id)->delete();

        return response()->json("berhasil", 200);
    }

   public function hapus($id){

    $account = Acount::find($id);

    return response()->json( $account);
   }
}
