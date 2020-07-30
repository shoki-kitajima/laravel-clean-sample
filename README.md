# Laravel + Clean Architecture Task list sample

## Entities

1. Task
   1. id         // TaskId
   2. name       // TaskName
   3. dueDate    // Duedate
   4. isDone     // bool
   5. isArchived // bool

**path**

* /app/packages/Domain/Entities/Task.php

## Value Objects

1. TaskId   // int > 0
2. TaskName // string != '' && mb_ereg_match("^(\s|　)+$"
3. DueDate  // DateTimeImmutable

**path**

* /app/packages/Domain/TaskId.php
* /app/packages/Domain/TaskName.php
* /app/packages/Domain/DueDate.php

## Usecases

1. ViewAllTaskInterface
2. ViewAllTaskInteractor
3. RegisterTaskInterface
4. RegisterTaskInteractor
5. ToggleDoneTaskInterface
6. ToggleDoneTaskInteractor
7. ArchiveTaskInterface
8. ArchiveTaskInteractor


**path**

* /app/packages/Usecases/ViewAllTaskInterface.php
* /app/packages/Usecases/ViewAllTaskInteractor.php
* /app/packages/Usecases/RegisterTaskInterface.php
* /app/packages/Usecases/RegisterTaskInteractor.php
* /app/packages/Usecases/ToggleDoneTaskInterface.php
* /app/packages/Usecases/ToggleDoneTaskInteractor.php
* /app/packages/Usecases/ArchiveTaskInterface.php
* /app/packages/Usecases/ArchiveTaskInteractor.php

## Gateways

1. TaskRepositoryInterface
2. EloquentTaskRepository
3. InMemoryTaskRepository

**path**

* /app/packages/Domain/Repository/TaskRepositoryInterface.php
* /app/packages/Infrastructures/EloquentTaskRepository.php
* /app/packages/Infrastructures/InMemoryTaskRepository.php

## Controllers

1. TaskController
   1. index()      // view all tasks
   2. register()
   3. toggleIsDone()
   4. archive()

**path**

* /app/packages/Controllers/TaskController.php

## InputBoundary(UseCase Interfaces)

1. ViewAllTaskInterface
2. RegisterTaskInterface
3. ToggleIsDoneTaskInterface
4. ArchiveTaskInterface

**path**

* /app/packages/Usecases/ViewAllTaskInterface.php
* /app/packages/Usecases/RegisterTaskInterface.php
* /app/packages/Usecases/ToggleIsDoneTaskInterface.php
* /app/packages/Usecases/ArchiveTaskInterface.php

## InputData

1. RegisterTaskInput
2. ToggleIsDoneTaskInput
3. ArchiveTaskInput

**path**

* /app/packages/Usecases/Inputs/RegisterTaskInput.php
* /app/packages/Usecases/Inputs/ToggleIsDoneTaskInputData.php
* /app/packages/Usecases/Inputs/ArchiveTaskInput.php

## View

* task

**path**

* /app/packages/Views/task.blade.php
