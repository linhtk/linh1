<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class ContactController extends Controller
{
    public function index() {
    	return view('contact.index')->with(['params' => session('data_contact')]);
    }

    public function preview(Request $request) {
        //check validate
        $datas = $request->all();
        session()->flash('data_contact', $datas);
        $validator = $this->check_validate($datas);
        if ($validator) {
            return redirect('/contact')->withErrors($validator, 'contactErrors');
        }
    	return view('contact.preview')->with(['params' => $request]);
    }

    public function submit(Request $request) {
    	if ($request->submit == 'back') {
    		return redirect('/contact')->with(['data_contact' => $request->all()]);
    	} elseif ($request->submit == 'submit') {
            $contacts = $request->all();
            // dd($contacts);
            $contact_times = session('contact_times');
            $validator = $this->check_validate($contacts);
            if ($validator) {
                session()->flash('data_contact', $contacts);
                return redirect('/contact')->withErrors($validator, 'contactErrors');
            }
            $contact_times += 1;

			$contacts = array_add($contacts, 'user_id', Auth::check() ? Auth::user()->id : 0);
    		$contacts = array_add($contacts, 'ip', $request->ip());
    		$contacts = array_add($contacts, 'user_agent', $request->server('HTTP_USER_AGENT'));

            //save data to database
            DB::beginTransaction();
            try {
                $results = Contact::create($contacts);
                if ($results) {
                    DB::commit();
                    session(['contact_times' => $contact_times]);

                    //send email to user
                    \Mail::queue('contact.mail_user',
                        array(
                            'name' => $contacts['name'],
                            'email' =>$contacts['email'],
                            'inquiry_type' => $contacts['inquiry_type'],
                            'contents' => $contacts['contents']
                        ), function($message) use($contacts)
                        {
                            $message->to($contacts['email'], $contacts['name'])->subject(trans('contact.send_mail_user_title'));
                        });

                    //send email to admin
                    $contacts = array_add($contacts, 'time', $results->created_at->toDateTimeString());
                    \Mail::queue('contact.mail_admin',
                        array(
                            'contacts' => $contacts
                        ), function($message) use($contacts)
                        {
                            $message->to(env('MAIL_SUPPORT'))->subject(trans('contact.send_mail_admin_title'));
                        });
                    return redirect('/contact/finish')->with(['finish_contact' => true, 'data_contact' => $request->all()]);
                } else {
                    return redirect('error/error')->withErrors(['message_error' => trans('contact.err_contact')]);
                }
            } catch (\Exception $e) {
                DB::rollback();
                return redirect('error/error')->withErrors(['message_error' => trans('contact.err_contact')]);
            }
		}
    }

    public function finish() {
        if (session('finish_contact')) {
            return view('contact.finish')->with(['params' => session('data_contact')]);
        }else {
            return redirect('/');
        }

    }

    public function refreshCaptcha(){
        return captcha_img('flat');
    }

    private function check_validate($datas) {
        $conds = [
            'email' => 'required|email|max:64',
            'name' => 'required|max:80',
            'inquiry_type' => 'required|integer|between:1,3',
            'contents' => 'required|max:5000',
        ];
        if (session('contact_times') > Contact::CONTACT_TIMES_MAX) {
            $conds = array_add($conds, 'captcha', 'required|captcha');
        }
        $validator = Validator::make($datas, $conds);
        if ($validator->fails()) {
            return $validator;
        } elseif (session('contact_times') > Contact::CONTACT_TIMES_MAX) {
            session(['contact_times' => 0]);
        }
        return null;
    }
}
