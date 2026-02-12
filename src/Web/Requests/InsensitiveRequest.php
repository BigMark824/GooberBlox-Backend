<?php

namespace GooberBlox\Web\Requests;
use Illuminate\Foundation\Http\FormRequest;

/*
 * This code was written by @kylegg, it's use is permitted for GooberBlox
 * 
 * X: RbxXlxi
 * Discod: kylegg
*/


class InsensitiveRequest extends FormRequest
{
    public function rules() : array 
    {
        return [];
    }

    public function has($key) : bool 
    {
        return !is_null($this->__get($key));
    }

    public function __get($key): mixed
    {
        foreach($this->all() as $index => $value)
        {
            if(strtolower($key) == strtolower($index))
            {
                return $value;
            }
        }
        
        return null;
    }
}