<?php
namespace Packages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\UseCases\ViewAllTaskInterface;

class ViewAllTaskController extends Controller
{
    public function index(ViewAllTaskInterface $useCase)
    {
        $returns = $useCase->handle();
        dd($returns);
    }
}
