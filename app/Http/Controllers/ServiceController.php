<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;
 
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function admin_services(){
        //Retrieve Services Data from database  
       // $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
       // return view('admin_services', $data);

        $services = Service::latest()->paginate(5);
    
        return view('admin_services',compact('services'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    function customer_services(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_services', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
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
            'service_name'=>'required',
            'description'=>'required',
            'equipment'=>'required',
            'material'=>'required',
            'personal_protection'=>'required',
            'resident_number_of_cleaner'=>'required',
            'apartment_number_of_cleaner'=>'required',
            'condo_number_of_cleaner'=>'required',
            'resident_price'=>'required',
            'apartment_price'=>'required',
            'condo_price'=>'required'
        ]);

        //Insert data into database
        $services = new Service();
        $services->service_name = $request->service_name;
        $services->service_description = $request->description;
        $services->equipment = $request->equipment;
        $services->material = $request->material;
        $services->personal_protection = $request->personal_protection;
        $addService = $services->save();

        $id = $services->service_id;

        $prices = new Price();
        $prices->property_type = 'Medium-Upper Class Residential Areas';
        $prices->price = $request->resident_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->resident_number_of_cleaner;
        $addService = $prices->save();
        $prices = new Price();
        $prices->property_type = 'Apartments';
        $prices->price = $request->apartment_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->apartment_number_of_cleaner;
        $addService = $prices->save();
        $prices = new Price();
        $prices->property_type = 'Condominiums';
        $prices->price = $request->condo_price;
        $prices->service_id = $id;
        $prices->number_of_cleaner = $request->condo_number_of_cleaner;
        $addService = $prices->save();

        return redirect()->route('admin_services')
                        ->with('success','Service created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'service_name'=>'required',
            'description'=>'required',
            'equipment'=>'required',
            'material'=>'required',
            'personal_protection'=>'required',
            'resident_number_of_cleaner'=>'required',
            'apartment_number_of_cleaner'=>'required',
            'condo_number_of_cleaner'=>'required',
            'resident_price'=>'required',
            'apartment_price'=>'required',
            'condo_price'=>'required'
        ]);

        $id = Service::Where('service_name', $request->service_name)->value('service_id');
        $update= Service::Where('service_id', $id )->update(['service_name' => $request->service_name, 'service_description' => $request->description,'equipment' => $request->equipment, 'material' => $request->material, 'personal_protection' => $request->personal_protection]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Medium-Upper Class Residential Areas' )->update(['price' => $request->resident_price, 'number_of_cleaner' => $request->resident_number_of_cleaner]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Apartments' )->update(['price' => $request->apartment_price, 'number_of_cleaner' => $request->apartment_number_of_cleaner]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Condominiums' )->update(['price' => $request->condo_price, 'number_of_cleaner' => $request->condo_number_of_cleaner]);

        if($update){   
            return back()->with('success', 'Service Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $deleteService= Price::Where('service_id', $request->route('id') )->delete(); 
        $deleteService= Service::Where('service_id', $request->route('id') )->delete(); 
    
        if($deleteService){   
            return back()->with('success', 'Service Updated');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
}
