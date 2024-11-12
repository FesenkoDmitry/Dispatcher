<?php


namespace App\Http\Controllers;



use App\Models\Issue;

class IssuesController extends Controller
{

    public function list()
    {
        return Issue::all(['id', 'name']);
    }
}
