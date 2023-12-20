<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Image;

use App\Models\User;
use App\Models\Profile;

class ResumeController extends Controller
{
    public function resumeShow(){

        $user = Auth::user();

        $profile = $user->profile()->first() ? $user->profile()->first() : new Profile;

        return view('applicant.resume_show', compact('user','profile'));

    }

    public function resumeEdit(){

        $user = Auth::user();
        $profile = $user->profile()->first() ? $user->profile()->first() : new Profile;

        return view('applicant.resume_edit', compact('user','profile'));

    }

    public function resumePost(Request $request){

        $user = Auth::user();
        $profile = $user->profile()->first() ? $user->profile()->first() : new Profile;

        $this->validate($request, [
            'phone' => 'nullable',
            'education' => 'nullable',
            'experience' => 'nullable',
            'skill' => 'nullable',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'resume' => 'nullable|mimes:pdf|max:5000',
        ]);

        $user->phone = $request['phone'];
        $user->save();

        $profile->user_id = $user->id;
        $profile->education = $request['education'];
        $profile->experience = $request['experience'];
        $profile->skill = $request['skill'];

        if($request['resume']){

            $location = $_SERVER['DOCUMENT_ROOT'].'/uploads/resume';

            if(!file_exists($location)){
                mkdir($location, 0755, true);
            }

            $new_name = "resume_".$user->id."_".time().".".$request->resume->getClientOriginalExtension();
            $file = $request->file('resume');
            $file->move($location, $new_name);
            $profile->resume = $new_name;

        }

        if($request['photo']){

            $location = $_SERVER['DOCUMENT_ROOT'].'/uploads/photo';

            if(!file_exists($location)){
                mkdir($location, 0755, true);
            }

            $image = Image::make($request->photo->getRealPath());
            $image->resize(500,500, function($constraint){
                $constraint->aspectRatio();
            });
            $image->text("Copyright RARecruitment", 10, 10, function($font){
                $font->size(24);
                $font->color('#FFF');
            });

            $image->save($location . "/photo_".$user->id.".".$request->photo->getClientOriginalExtension());
            $profile->photo = "photo_".$user->id.".".$request->photo->getClientOriginalExtension();

            $image = Image::make($request->photo->getRealPath());
            $image->fit(200,200, function($constraint){
                $constraint->aspectRatio();
            });
            $image->save($location . "/thumbnail_photo_".$user->id.".".$request->photo->getClientOriginalExtension());

        }

        $profile->save();

        Session()->flash('success-msg', 'You resume has been updated.');
        return redirect()->route('applicant.resume.show');

    }
}
