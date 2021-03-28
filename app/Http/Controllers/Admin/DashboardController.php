<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contact;
use Session;

class DashboardController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct() {
//        echo session("locale");exit;
        if (!Session::has('locale')) {
            Session::put('locale', 'vn');
        }
    }

    public function index() {
        //
        return view("admin/dashboard", [
            'contact' => $this->countContact()
        ]);
    }

    public function countContact() {
        $contact = new Contact();
        return $contact->countContactCurrent();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
