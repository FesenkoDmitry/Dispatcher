<?php


namespace App\Services\DTO;


use Illuminate\Http\Request;

class BaseDTO
{
    public function parseFromRequest(Request $request)
    {
        foreach ($request->input() as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
}
