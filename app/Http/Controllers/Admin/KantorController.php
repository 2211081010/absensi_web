<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class KantorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function read(){
        $kantor = DB::table('kantor')->orderBy('id','DESC')->get();

        return view('admin.kantor.index',['kantor'=>$kantor]);
    }

    public function add(){
        return view('admin.kantor.tambah');
    }

    public function create(Request $request){
        DB::table('kantor')->insert([
            'nama_kantor' => $request->nama_kantor]);

        return redirect('/admin/kantor')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $kantor = DB::table('kantor')->where('id',$id)->first();

        return view('admin.kantor.edit',['kantor'=>$kantor]);
    }

    public function update(Request $request, $id) {
        DB::table('kantor')
            ->where('id', $id)
            ->update([
            'nama_kantor' => $request->nama_kantor]);

        return redirect('/admin/kantor')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('kantor')->where('id',$id)->delete();

        return redirect('/admin/kantor')->with("success","Data Berhasil Dihapus !");
    }
}
