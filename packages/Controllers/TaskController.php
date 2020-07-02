<?php
namespace Packages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\UseCases\ViewAllTaskInterface;

class TaskController extends Controller
{
    public function view(ViewAllTaskInterface $useCase)
    {
        $returns = $useCase->handle();
        return view('task', compact('returns'));
    }

    // public function register(RegisterTaskInterface $useCase)
    // {
    // }
    public function register(Request $req)
    {
        dd($req->post());
    }

    // public function toggleIsDone(ToggleDoneTaskInterface $useCase)
    // {
    // }
    public function toggleDone(Request $req)
    {
        dd($req->post());
    }

    public function archive(Request $req)
    {
        dd($req->post());
    }
}
