<?php
namespace App\Services;


use Illuminate\Support\Facades\Storage;
use App\Company;
use App\Interfaces\CompanyInterface;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminCompanyCreatedNotification;
use App\Notifications\CompanyCreatedNotification;

class CompanyService implements CompanyInterface{

    //update company Logo
    public function updateLogo($request, $company){

        try {
            if ($company->logo) {
                $this->deleteLogo($company->logo);
            }

            $photoUrl = $this->uploadImage($request->logo, "logo/company_logo", str_replace(" ","_",$request->name), $company->id)?:null;

            $company->logo = $photoUrl;

            $company->save();

            return $company;

        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    //upload Image
    public function uploadImage($photoObject, $destination, $prefix="", $index){

        try {

            if ($photoObject) {

                $imageUrl  = $prefix.'_'.$index.'_'.time().".png";

                $photoUrl = $prefix.'_'.$index.'_'.time().'.'.$photoObject->getClientOriginalExtension();

                $fileContent = file_get_contents($photoObject);

                $path = Storage::disk('public')->put($destination."/".$photoUrl, $fileContent);

                // imagepng(imagecreatefromstring(Storage::disk('public')->get($destination.'/'.$photoUrl)), $destination.'/'.$imageUrl);

                // Storage::disk('public')->delete($destination.'/'.$photoUrl);

                return $destination.'/'.$photoUrl;
            }

            return false;
        
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }

    //delete Logo
    public function deleteLogo($logo){

        try {
            @unlink($logo);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    //set company creation details
    public function buildCompanyData(){

        $data = request()->only(["name", "email", "website"]);
        //$data['created_by'] = auth()->user()->id;
        return $data;
    }

    public function sendCompanyNotificationEmail($email, $company, $password){

        try {
            Notification::route('mail', $email)->notify(new CompanyCreatedNotification($company, $password));
        } catch (\Exception $e) {
            \Log::info('Unable to send Notification mail to user '.$e->getMessage());
        } 
    }

    public function sendAdminCompanyNotificationEmail($email, $company){

        try {
            Notification::route('mail', $email)->notify(new AdminCompanyCreatedNotification($company));
        } catch (\Exception $e) {
            \Log::info('Unable to send Notification mail to user '.$e->getMessage());
        } 
    }
}