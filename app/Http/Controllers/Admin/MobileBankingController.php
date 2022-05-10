<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MobileBankingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\Country;
use App\Models\MobileBanking;
use Illuminate\Http\Request;
use Validator;

class MobileBankingController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index(MobileBankingDataTable $dataTable)
    {
        return $dataTable->render('admin.mobileBanking.view');
    }

    public function add(Request $request)
    {
        if (!$request->isMethod('post')) {
            $country = Country::pluck('name', 'id');
            return view('admin.mobileBanking.add', compact(['country']));
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name' => 'required|max:100',
                'mobile_no' => 'required|max:100',
                'message' => 'required|max:100',
                'image' => 'required'
            );


            $fieldNames = array(
                'name' => 'Name',
                'image' => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = 'mobile_banking_' . time() . '.' . $extension;

                $success = $image->move('public/front/images/mobile_bankings', $filename);

                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }

                $mobileBanking = new MobileBanking();

                $mobileBanking->name = $request->name;
                $mobileBanking->mobile_no = $request->mobile_no;
                $mobileBanking->message = $request->message;
                $mobileBanking->image = $filename;
                $mobileBanking->country_id = $request->country_id;
                $mobileBanking->status = $request->status;
                $mobileBanking->save();

                $this->helper->one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/mobile-banking');
            }
        } else {
            return redirect('admin/settings/mobile-banking');
        }
    }

    public function update(Request $request)
    {
        if (!$request->isMethod('post')) {
            $data['result'] = MobileBanking::find($request->id);
            $data['result']['country'] = Country::pluck('name', 'id');
            return view('admin.mobileBanking.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name' => 'required|max:100',
                'mobile_no' => 'required|max:100',
                'message' => 'required|max:100',
            );

            $fieldNames = array(
                'name' => 'Name',
                'image' => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $mobileBanking = MobileBanking::find($request->id);

                $mobileBanking->name = $request->name;
                $mobileBanking->mobile_no = $request->mobile_no;
                $mobileBanking->message = $request->message;
                $mobileBanking->status = $request->status;
                $mobileBanking->country_id = $request->country_id;

                $image = $request->file('image');

                if ($image) {
                    $extension = $image->getClientOriginalExtension();
                    $filename = 'mobile_banking_' . time() . '.' . $extension;

                    $success = $image->move('public/front/images/mobile_bankings', $filename);

                    if (!isset($success)) {
                        return back()->withError('Could not upload Image');
                    }

                    $mobileBanking->image = $filename;
                }

                $mobileBanking->save();

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/mobile-banking');
            }
        } else {
            return redirect('admin/settings/mobile-banking');
        }
    }

    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $mobileBanking = MobileBanking::find($request->id);
            $file_path = public_path() . '/front/images/mobile_bankings/' . $mobileBanking->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            MobileBanking::find($request->id)->delete();
            $this->helper->one_time_message('success', 'Deleted Successfully');
        }

        return redirect('admin/settings/mobile-banking');
    }
}
