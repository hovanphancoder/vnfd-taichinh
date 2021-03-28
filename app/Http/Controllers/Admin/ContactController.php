<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use Session;
use App\Users;
use Validator;

class ContactController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Contact $contact){
        $this->contact = $contact;
    }
    public function index() {
        //
        return view('admin/contact/list', [
            'listcontact' => $this->getListContact(),
        ]);
    }

    public function getListContact() {
        return $this->contact->contactList();
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

        $item = Contact::find($id);
        if(!$item){
            Session::flash('result','Error! Phone is not exist.');
            return redirect()->back();
        }
        $listid = $this->contact->getListId();
        
        // kiem tra id co ton tai trong table post
        // if (!in_array($id, $listid))
        //     return redirect("admin/contact/list");

        return view('admin/contact/view', [
            'contact' => $this->contact->getContact($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
//        echo "dsadsadaS";exit;
        if ($request->isMethod('post')) {
            if (!is_int($id) || $id <= 0)
                $id = (int) $id;
            $rules = [
                'fullname' => 'required|min:6|max:255',
                'email' => 'required|email',
                'subject' => 'required|min:6|max:255',
                'message' => 'required|min:6|max:255'
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute field is email.',
                'between' => 'The :attribute must be between :min - :max.'
            ];
//
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('admin/contact/list');
            }
            $fullname = $request->input('fullname');
            $email = $request->input('email');
            $subject = $request->input('subject');
            $message = $request->input('message');
            $updated_at = date("Y-m-d H:i:s");
            $contact = new Contact();
            $contact->doUpdate($id, $fullname, $email, $subject, $message, $updated_at);
            Session::flash('update', 'Update success');
            return redirect('admin/contact/list');
        }
        Session::flash('update', 'Update error');
        return redirect('admin/contact/list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
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
        $item = Contact::find($id);
        if(!$item){
            Session::flash('status', 'Xóa liên hệ thành công');
            return redirect()->back();
        }
        $this->contact->delContact($id);
        Session::flash('status', 'Xóa liên hệ thành công');
        return redirect('admin/contact/list');
    }

}
