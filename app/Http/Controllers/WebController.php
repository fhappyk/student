<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AllField;
use App\Models\Speciality;
use App\Models\StudentInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentCustomField;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{


    public function changeLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,fr',
        ]);

        session(['locale' => $request->locale]);

        return redirect()->back();
    }



    public function home(){
        $data = User::with('studentinfo')->where('role', 'student')->where('status', 'active')->get();

        // get the list of countries from the studentinfo
        $countries = $data->pluck('studentinfo')->flatten()->pluck('country')->unique();
        $cities = $data->pluck('studentinfo')->flatten()->pluck('city')->unique();
        $departments = $data->pluck('studentinfo')->flatten()->pluck('department')->unique();
        $specialities = $data->pluck('studentinfo')->flatten()->pluck('speciality')->unique();
        $regions = $data->pluck('studentinfo')->flatten()->pluck('region')->unique();
//        dd($data, $countries);

        return view('frontend.index', get_defined_vars());

    }




    public function filterStudents(Request $request)
    {
//        dd($request->all());
        $query = StudentInfo::query();

        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        if ($request->filled('speciality')) {
            $query->where('speciality', $request->input('speciality'));
        }

        if ($request->filled('region')) {
            $query->where('region', $request->input('region'));
        }

        $query->whereHas('user', function ($q) {
            $q->where('status', 'active')
                ->where('role', 'student');
        });

        $data = $query->with('user')->get();

        $data2 = User::with('studentinfo')->where('role', 'student')->where('status', 'active')->get();

        // get the list of countries from the studentinfo
        $countries = $data2->pluck('studentinfo')->flatten()->pluck('country')->unique();
        $cities = $data2->pluck('studentinfo')->flatten()->pluck('city')->unique();
        $departments = $data2->pluck('studentinfo')->flatten()->pluck('department')->unique();
        $specialities = $data2->pluck('studentinfo')->flatten()->pluck('speciality')->unique();
        $regions = $data2->pluck('studentinfo')->flatten()->pluck('region')->unique();
//        dd($data, $countries);

        return view('frontend.index', get_defined_vars());
    }







    public function viewStudent($id){
        $data = User::with('studentinfo', 'extrafield')->where('uuid', $id)->get();

        return view('frontend.viewStudent', compact('data'));
    }


    public function viewProfile(){

        $data = User::with('studentinfo')->where('uuid', auth()->user()->uuid)->get();

        return view('frontend.viewStudent', compact('data'));
    }


    public function editProfile(){

        if(auth()->user()){
        $data = User::with('studentinfo', 'extrafield')->where('uuid', auth()->user()->uuid)->get();
        $activeFields = AllField::where('status', 'active')->get();
        $specialityArea = Speciality::where('type', 'speciality area')->get();
        $speciality = Speciality::where('type', 'speciality')->get();

        return view('frontend.editProfile', compact('data', 'activeFields', 'specialityArea', 'speciality'));
        }else{
            return redirect()->route('home');
        }
    }


    public function updateProfile(Request $request){
        // dd($request);


        $validate = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:255',
//            'country' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'lattitude' => 'nullable',
            'longitude' => 'nullable',
            'professional_phone' => 'nullable',
            'other_phone' => 'nullable',
            'professional_email' => 'nullable',
            'other_email' => 'nullable',
            'speciality_area' => 'nullable',
            'speciality' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'office_name' => 'nullable',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        $studentInfo = StudentInfo::where('user_id', auth()->user()->id)->first();

        if (!$studentInfo) {
            $studentInfo = new StudentInfo();
            $studentInfo->user_id = auth()->user()->id;
        }

        if ($request->has('phone') && $request->phone !== null) {
            $countryCode = $request->country_code_1 ? $request->country_code_1 : '';
            $studentInfo->phone = $countryCode ? '+' . $countryCode . $request->phone : $request->phone;
        } else {
            $studentInfo->phone = null;
        }

        if ($request->has('professional_phone') && $request->professional_phone !== null) {
            $countryCode2 = $request->country_code_2 ? $request->country_code_2 : '';
            $studentInfo->professional_phone = $countryCode2 ? '+' . $countryCode2 . $request->professional_phone : $request->professional_phone;
        } else {
            $studentInfo->professional_phone = null;
        }

        if ($request->has('other_phone') && $request->other_phone !== null) {
            $countryCode3 = $request->country_code_3 ? $request->country_code_3 : '';
            $studentInfo->other_phone = $countryCode3 ? '+' . $countryCode3 . $request->other_phone : $request->other_phone;
        } else {
            $studentInfo->other_phone = null;
        }

//        if ($request->has('title') && $request->title !== null) {
//            $studentInfo->title = $request->title;
//        }

//        if ($request->has('years_of_experience') && $request->years_of_experience !== null) {
//            $studentInfo->years_of_experience = $request->years_of_experience;
//        }

//        if ($request->has('country') && $request->country !== null) {
//            $studentInfo->country = $request->country;
//        }

        if ($request->city === 'no') {
            $studentInfo->city = null;
        } else if ($request->has('city') && $request->city !== null) {
            $studentInfo->city = $request->city;
        } else {
            $studentInfo->city = null;
        }

        if ($request->region === 'no') {
            $studentInfo->region = null;
            $studentInfo->city = null;
        } else if ($request->region !== null) {
            $studentInfo->region = $request->region;
        }

        if ($request->has('address') && $request->address !== null) {
            $studentInfo->address = $request->address;
        } else {
            $studentInfo->address = null;
        }

        if ($request->has('lattitude') && $request->lattitude !== null) {
            $studentInfo->lattitude = $request->lattitude;
        } else {
            $studentInfo->lattitude = null;
        }

        if ($request->has('longitude') && $request->longitude !== null) {
            $studentInfo->longitude = $request->longitude;
        } else {
            $studentInfo->longitude = null;
        }

        if ($request->has('office_name') && $request->office_name !== null) {
            $studentInfo->office_name = $request->office_name;
        } else {
            $studentInfo->office_name = null;
        }

        if ($request->has('professional_email') && $request->professional_email !== null) {
            $studentInfo->professional_email = $request->professional_email;
        } else {
            $studentInfo->professional_email = null;
        }

        if ($request->has('other_email') && $request->other_email !== null) {
            $studentInfo->other_email = $request->other_email;
        } else {
            $studentInfo->other_email = null;
        }

        if ($request->has('speciality_area') && $request->speciality_area !== null) {
            $studentInfo->speciality_area = $request->speciality_area;
        } else {
            $studentInfo->speciality_area = null;
        }

        if ($request->has('speciality') && $request->speciality !== null) {
            $studentInfo->speciality = $request->speciality;
        } else {
            $studentInfo->speciality = null;
        }

        if ($request->hasFile('image')) {
            $randomNo = Str::random(8);
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $randomNo . '.' . $extension;
            $image->move('uploads', $imageName);
            $studentInfo->image = $imageName;
        }

        $studentInfo->save();






    //     $user_id = auth()->user()->id;


    //     $user = User::findOrFail($user_id);


    //     $studentInfo = StudentInfo::where('user_id', $user->id)->first();

    //     if ($studentInfo) {
    //         $studentInfo->phone = $request->phone ? $request->phone : '';
    //         $studentInfo->country = $request->country ? $request->country : '';
    //         $studentInfo->city = $request->city ? $request->city : '';
    //         $studentInfo->address = $request->address ? $request->address : '';
    //         $studentInfo->lattitude = $request->lattitude ? $request->lattitude : '';
    //         $studentInfo->longitude = $request->longitude ? $request->longitude : '';


    //         $studentInfo->professional_email = $request->professional_email ? $request->professional_email : '';
    //         $studentInfo->professional_phone = $request->professional_phone ? $request->professional_phone : '';
    //         $studentInfo->department = $request->department ? $request->department : '';
    //         $studentInfo->speciality = $request->speciality ? $request->speciality : '';
    //         $studentInfo->region = $request->region ? $request->region : '';





    //         if ($request->hasFile('image')) {
    //             $randomNo = Str::random(8);
    //             $image = $request->file('image');
    //             $extension = $image->getClientOriginalExtension();
    //             $imageName = time() . '.' . $randomNo . '.' . $extension;
    //             $image->move('uploads', $imageName);
    //             $studentInfo->image = $imageName;
    //         }

    //         $studentInfo->save();


    //     }else{
    //         $studentInfo = new StudentInfo();

    //         $studentInfo->user_id = $user->id;
    //         $studentInfo->phone = $request->phone ? $request->phone : '';
    //         $studentInfo->country = $request->country ? $request->country : '';
    //         $studentInfo->city = $request->city ? $request->city : '';
    //         $studentInfo->address = $request->address ? $request->address : '';
    //         $studentInfo->lattitude = $request->lattitude ? $request->lattitude : '';
    //         $studentInfo->longitude = $request->longitude ? $request->longitude : '';

    //         $studentInfo->professional_email = $request->professional_email ? $request->professional_email : '';
    //         $studentInfo->professional_phone = $request->professional_phone ? $request->professional_phone : '';
    //         $studentInfo->department = $request->department ? $request->department : '';
    //         $studentInfo->speciality = $request->speciality ? $request->speciality : '';
    //         $studentInfo->region = $request->region ? $request->region : '';

    //         if ($request->hasFile('image')) {
    //             $randomNo = Str::random(8);
    //             $image = $request->file('image');
    //             $extension = $image->getClientOriginalExtension();
    //             $imageName = time() . '.' . $randomNo . '.' . $extension;
    //             $image->move('uploads', $imageName);
    //             $studentInfo->image = $imageName;
    //         }


    //         $studentInfo->save();

    //     }

    // if ($request->has('extrafield')) {
    //     foreach ($request->extrafield as $label => $value) {
    //         StudentCustomField::updateOrCreate(
    //             ['user_id' => $user->id, 'label' => $label],
    //             ['value' => $value]
    //         );
    //     }
    // }

        return redirect()->route('view.profile')->with('success', 'Profile updated successfully');




    }


}
