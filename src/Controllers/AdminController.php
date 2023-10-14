<?php
namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Mallria\Core\Facades\Inertia;

class AdminController extends Controller
{
    function index(){

//        return Inertia::renderVue('Blog/Admin/Index');
        return view('blog::blog.admin.index');
    }

    function create(){

//        return Inertia::renderVue('Blog/Admin/Create');
        return view('blog::blog.admin.create');
    }

    function store(){

    }

    function edit(){

    }

    function save(){

    }
}