<?php

namespace App\Interfaces;


interface AuditInterface
{
    /**
     *  Filter Resource 
     *
     * @param  mixed $role
     * @return boolean
     */
    public function search();

    /**
     * build company data before insert 
     *
     * @param  mixed $role
     * @return boolean
     */
    public function applySearch();

    
}
