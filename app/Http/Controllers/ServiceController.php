<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Price;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
 
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //View admin services page
    function admin_services(){
        //Retrieve Services Data from database  
       $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_services', $data);
    }
    //View admin transaction page
    function admin_transaction(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction', $data);
    }
    function pending(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('pending', $data);
    }

    function on_the_way(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('on_the_way', $data);
    }

    function on_progress(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('on_progress', $data);
    }

    function accepted(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('accepted', $data);
    }
   
    function done(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('done', $data);
    }
    //View Admin transaction history page
    function admin_transaction_history(){
        $data = ['LoggedUserInfo'=>Admin::where('admin_id','=', session('LoggedUser'))->first()];
        return view('admin_transaction_history', $data);
    }
    //View customer services page
    function customer_services(){
        $data = ['LoggedUserInfo'=>User::where('user_id','=', session('LoggedUser'))->first()];
        return view('customer.customer_services', $data);
    }
    
    
    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Add new Service
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required',
            'description' => 'required',
            'equipment' => 'required',
            'material' => 'required',
            'personal_protection' => 'required',
            'resident_number_of_cleaner' => 'required|numeric',
            'apartment_number_of_cleaner' => 'required|numeric',
            'condo_number_of_cleaner' => 'required|numeric',
            'resident_price' => 'required|numeric',
            'apartment_price' => 'required|numeric',
            'condo_price' => 'required|numeric',
        ]);

        //Add new service
        $services = new Service();
        $services->service_name = $request->service_name;
        $services->service_description = $request->description;
        $services->equipment = $request->equipment;
        $services->material = $request->material;
        $services->personal_protection = $request->personal_protection;
        $addService = $services->save();

        $id = $services->service_id;
        //Insert data to price table
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
                        ->with('success-add','Service created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */

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
            'service_name' => 'required',
            'description' => 'required',
            'equipment' => 'required',
            'material' => 'required',
            'personal_protection' => 'required',
            'resident_number_of_cleaner' => 'required|numeric',
            'apartment_number_of_cleaner' => 'required|numeric',
            'condo_number_of_cleaner' => 'required|numeric',
            'resident_price' => 'required|numeric',
            'apartment_price' => 'required|numeric',
            'condo_price' => 'required|numeric',
        ]);
        //Update service and price table
        $id = $request->service_id;
        $update= Service::Where('service_id', $id )->update(['service_name' => $request->service_name, 'service_description' => $request->description,'equipment' => $request->equipment, 'material' => $request->material, 'personal_protection' => $request->personal_protection]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Medium-Upper Class Residential Areas' )->update(['price' => $request->resident_price, 'number_of_cleaner' => $request->resident_number_of_cleaner]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Apartments' )->update(['price' => $request->apartment_price, 'number_of_cleaner' => $request->apartment_number_of_cleaner]);
        $update= Price::Where('service_id', $id )->Where('property_type', 'Condominiums' )->update(['price' => $request->condo_price, 'number_of_cleaner' => $request->condo_number_of_cleaner]);

        if($update){   
            return back()->with('success', 'Service Successfully Updated');
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
    //Delete a service
    public function destroy(Request $request, Service $service)
    {
        $id =  $request->service_id;
        $deleteService= Price::Where('service_id', $id )->delete(); 
        $deleteService= Service::Where('service_id', $id )->delete(); 
    
        if($deleteService){   
            return back()->with('success-delete', 'Service Successfully Deleted');
        }
        else {
            return back()->with('fail','Something went wrong, try again later ');
        }
    }
}