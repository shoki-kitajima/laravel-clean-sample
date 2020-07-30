<?php
namespace Packages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\UseCases\ViewAllTaskInterface;
use Packages\UseCases\RegisterTaskInterface;
use Packages\UseCases\Inputs\RegisterTaskInput;
use Packages\UseCases\Inputs\ToggleIsDoneTaskInput;
use Packages\UseCases\ToggleIsDoneTaskInterface;
use Packages\UseCases\Inputs\ArchiveTaskInput;
use Packages\UseCases\ArchiveTaskInterface;

class TaskController extends Controller
{
    public function view(ViewAllTaskInterface $useCase)
    {
        $returns = $useCase->handle();
        return view('task', compact('returns'));
    }

    public function register(RegisterTaskInterface $useCase, Request $req)
    {
        $req->validate([
            'name' => 'bail|required|max:255',
            'due_date' => 'required|date_format:Y-m-d\TH:i|after:now',
        ]);
        $input = new RegisterTaskInput($req->post('name'), $req->post('due_date'));
        $useCase->handle($input);
        return redirect('/');
    }

    public function toggleIsDone(ToggleIsDoneTaskInterface $useCase, Request $req)
    {
        $input = new ToggleIsDoneTaskInput($req->post('id'));
        $useCase->handle($input);
        return redirect('/');
    }

    public function archive(ArchiveTaskInterface $useCase, Request $req)
    {
        $input = new ArchiveTaskInput($req->post('id'));
        $useCase->handle($input);
        return redirect('/');
    }
}
