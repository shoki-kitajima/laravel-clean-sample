<?php
namespace Packages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\UseCases\ViewAllTaskInterface;
use Packages\UseCases\RegisterTaskInterface;
use Packages\UseCases\Inputs\RegisterTaskInput;

class TaskController extends Controller
{
    public function view(ViewAllTaskInterface $useCase)
    {
        $returns = $useCase->handle();
        return view('task', compact('returns'));
    }

    public function register(RegisterTaskInterface $useCase, Request $req)
    {
        $input = new RegisterTaskInput($req->post('name'), $req->post('due_date'));
        $useCase->handle($input);
        return redirect('/');
    }

    // public function toggleIsDone(ToggleDoneTaskInterface $useCase)
    public function toggleDone(Request $req)
    {
        dd($req->post());
    }

    public function archive(Request $req)
    {
        dd($req->post());
    }
}
