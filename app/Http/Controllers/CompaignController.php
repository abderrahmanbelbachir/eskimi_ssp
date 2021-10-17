<?php

namespace App\Http\Controllers;

use App\Models\Compaign;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compaign.index');
    }

    /**
     * filter results - sort/search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        //
        $compaigns = Compaign::whereNotNull('created_at');

        if (request()->sort_by != 'undefined.undefined') {

            $sort = explode('.', request()->sort_by);

            $compaigns->orderBy($sort[0], $sort[1]);

        }

        return response()->json($compaigns->paginate(5)) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $startDate = strtotime($request->from);
        $endDate = strtotime($request->to);
        $datediff = $endDate - $startDate;
        $days = round($datediff / (60 * 60 * 24));
        $totalBudget = (float)$request->daily_budget * $days;
        Log::info('total budget : ' . $totalBudget);
        $compaign = Compaign::create([
            'name' => $request->name,
            'from' => $request->from,
            'to' => $request->to,
            'daily_budget' => $request->daily_budget,
            'total_budget' => $totalBudget,
            'uploads' => json_encode([''])
        ]);
        $files = $request->files;
        $index = 0;
        $compaignUploads = [];

        if ($request->hasFile('files')) {
            Log::info('request has file : ' . $request);
        } else {
            Log::info('request empty files');
        }
        foreach ($request->file('files') as $file) {
            $index = $index + 1;
            $destinationPath = public_path() . '/uploads/compaigns/' . $compaign->id . '/pictures/';
            $extension = $file->getClientOriginalExtension();
            $name = 'compaign_'. $index;
            $slug = Str::slug($name, "-" , 'en');
            $fileName = $slug . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            array_push($compaignUploads , $destinationPath . $fileName);
            Log::info('parse file : ' . $fileName);
        }
        $compaign->update(['uploads' => json_encode($compaignUploads)]);
        return 'compaign created successfully !';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compaign  $compaign
     * @return \Illuminate\Http\Response
     */
    public function show(Compaign $compaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compaign  $compaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Compaign $compaign)
    {
        return view('compaign.edit' , compact('compaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compaign  $compaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compaign $compaign)
    {
        $startDate = strtotime($request->from);
        $endDate = strtotime($request->to);
        $datediff = $endDate - $startDate;
        $days = round($datediff / (60 * 60 * 24));
        $totalBudget = (float)$request->daily_budget * $days;
        $data = [
            'name' => $request->name,
            'from' => $request->from,
            'to' => $request->to,
            'daily_budget' => $request->daily_budget,
            'total_budget' => $totalBudget,
        ];
        $compaignUploads = explode( ',' ,$request->files_to_keep);
        $index = sizeof($compaignUploads);
        foreach ($request->file('files') as $file) {
            $index = $index + 1;
            $destinationPath = public_path() . '/uploads/compaigns/' . $compaign->id . '/pictures/';
            $extension = $file->getClientOriginalExtension();
            $name = 'compaign_'. $index;
            $slug = Str::slug($name, "-" , 'en');
            $fileName = $slug . '.' . $extension;
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            array_push($compaignUploads , $destinationPath . $fileName);
            Log::info('parse file : ' . $fileName);
        }
        $data['uploads'] = json_encode($compaignUploads);

        $compaign->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compaign  $compaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compaign $compaign)
    {
        //
    }
}
