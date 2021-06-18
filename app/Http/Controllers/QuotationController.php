<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\AgeLoad;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::all();
        return response()->json($quotations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'age_list' => 'required',
            'currency_id'  => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $_total = $this->calculateTotal($request->get('age_list'), $request->get('start_date'), $request->get('end_date'));

        $quotation = new Quotation([
            'age_list' => $request->get('age_list'),
            'currency_id' => $request->get('currency_id'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'total' => $_total,
        ]);

        $quotation->save();

        $q = Quotation::find($quotation->id);

        return response()->json([
            'total' =>  $q->total,
            'quotation_id' =>  $q->id,
            'currency_id' =>  $q->currency_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  age_list
     * @param  start_date
     * @param  end_date
     * @return \Illuminate\Http\Response
     */
    public function calculateTotal($age_list, $start_date, $end_date)
    {
        $load = 0;
        $total = 0;
        $fixed_rate = 3;
        $ages = explode(',',$age_list);

        $d1 = new DateTime($start_date);
        $d2 = new DateTime($end_date);
        $trip_length = 1+$d1->diff($d2)->d;


        foreach ($ages as $age) {
            $age_load = \App\Models\AgeLoad::select('load')->whereRaw( "? >= age_start and ? <= age_end", array($age, $age) )->firstOrFail();

            $load = $age_load->load;
            $total += ($fixed_rate * $load * $trip_length );
        }

        return $total;
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::find($id);
        return response()->json($quotation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update($request->all());

        return response()->json($quotation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  id
     */
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return 204;
    }
}
