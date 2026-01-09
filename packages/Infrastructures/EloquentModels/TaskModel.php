<?php
namespace Packages\Infrastructures\EloquentModels;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['name', 'due_date'];
}
