<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ErrorController extends Controller
{
    //
    public function getError()
    {

        return view('errors.error');
    }
    /*
     * author:Thanhdv
     * date:2016-10-18
     * description:get maintain
     */
    public function getMaintain()
    {
        //check redirect from maintenance
        $status_maintenance = session('status_maintenance');
        if (!$status_maintenance) {
            return redirect('/');
        }

        return view('errors.maintain');
    }
}
