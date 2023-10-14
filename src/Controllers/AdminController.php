<?php
namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;
use Mallria\Core\Facades\Inertia;

class AdminController extends Controller
{
    function index(){

        return view('blog::blog.admin.index');
    }

    function create(){
        return view('blog::blog.admin.create');
    }

    function store(){

    }

    function edit(){

    }

    function save(){

    }
}