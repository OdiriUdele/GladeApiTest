<?php

namespace App\Interfaces;


interface CompanyInterface
{
    /**
     * update the company logo.
     *
     * @param  string $role
     * @return mixed
     */
    public function updateLogo($request, $company);

    /**
     * Delete company Logo
     *
     * @param  mixed $role
     * @return boolean
     */
    public function deleteLogo($logo);

    /**
     * build company data before insert 
     *
     * @param  mixed $role
     * @return boolean
     */
    public function buildCompanyData();

    /**
     * uploadImage
     *
     * @param  mixed $role
     * @return boolean
     */
    public function uploadImage($photoObject, $destination, $prefix="", $index);
}
