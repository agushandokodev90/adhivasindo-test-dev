<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SiswaController extends Controller
{
    use JsonResponse;
    public function sync()
    {
        try {
            $fetch_list_siswa = Http::get('https://ogienurdiana.com/career/ecc694ce4e7f6e45a5a7912cde9fe131');
            $data = $fetch_list_siswa->object();
            $extract_data = explode("\n", $data->DATA);
            unset($extract_data[0]);

            $data_siswa=[];
            foreach($extract_data as $v){
                if($v != ""){
                    $exp=explode('|',$v);
                    $data_siswa[]=array(
                        'nim'=>$exp[0],
                        'nama' => $exp[1],
                        'ymd' => $exp[2],
                    );

                    Siswa::firstOrCreate(array(
                        'nim' => $exp[0],
                        'nama' => $exp[1],
                        'ymd' => $exp[2],
                    ));
                }
            }
            return $this->successResponse($data_siswa);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function list(Request $request)
    {
        $limit = $request->get('limit',10);
        $page = $request->get('page',1);
        $sortBy = $request->get('sortBy', 'nama');
        $sortType = $request->get('sortType', 'asc');
        $search = $request->get('search');

        $list = Siswa::query();
        if($request->filled('search')){
            $list->where(function($qry) use($search){
                $qry->where('nim','like','%'.$search.'%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('ymd', 'like', '%' . $search . '%');
            });
        }
        $list->orderBy($sortBy,$sortType);
        $data = $this->paging($list,$limit,$page);
        return $this->successResponse($data);
    }

    public function detail(Siswa $siswa)
    {
        return $this->successResponse($siswa);
    }
}
