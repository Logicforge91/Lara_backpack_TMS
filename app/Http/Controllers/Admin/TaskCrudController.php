<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Task;

class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('task', 'tasks');
    }

    /*-----------------------------------------------------
    | LIST OPERATION
    ------------------------------------------------------*/
    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');

        CRUD::addColumn([
            'name'      => 'employee_id',
            'label'     => 'Employee',
            'type'      => 'select',
            'entity'    => 'employee',
            'model'     => 'App\\Models\\Employee',
            'attribute' => 'name',
        ]);

        CRUD::column('title')->label('Title');

        CRUD::addColumn([
            'name'      => 'tags',
            'label'     => 'Tags',
            'type'      => 'select_multiple',
            'entity'    => 'tags',
            'attribute' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'Pending' => 'Pending',
                'In Progress' => 'In Progress',
                'Completed' => 'Completed',
            ],
        ]);
         CRUD::column('due_date')->type('date');

        // ⭐ Recurring Columns
        CRUD::addColumn([
            'name'  => 'is_recurring',
            'label' => 'Recurring?',
            'type'  => 'boolean',
        ]);

        CRUD::addColumn([
            'name'  => 'recurring_type',
            'label' => 'Recurring Type',
            'type'  => 'text',
        ]);

        CRUD::addColumn([
            'name'  => 'next_run_date',
            'label' => 'Next Run Date',
            'type'  => 'date',
        ]);
    }


    /*-----------------------------------------------------
    | CREATE OPERATION
    ------------------------------------------------------*/
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaskRequest::class);

        // Employee Select
        CRUD::addField([
            'name'      => 'employee_id',
            'label'     => 'Employee Name',
            'type'      => 'select',
            'entity'    => 'employee',
            'model'     => 'App\\Models\\Employee',
            'attribute' => 'name',
        ]);

        // Task Title
        CRUD::field('title')->type('text')->label('Title');

        // Description
        CRUD::addField([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
        ]);
          CRUD::addField([
        'name' => 'due_date',
        'type' => 'date',
        'label' => 'Due Date',
    ]);

        // Tags (pivot)
        CRUD::addField([
            'name'      => 'tags',
            'label'     => 'Tags',
            'type'      => 'select_multiple',
            'entity'    => 'tags',
            'model'     => "App\Models\Tag",
            'attribute' => 'name',
            'pivot'     => true,
        ]);

        // Status Dropdown
        CRUD::addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'Pending' => 'Pending',
                'In Progress' => 'In Progress',
                'Completed' => 'Completed',
            ],
            'default' => 'Pending',
        ]);

        /*--------------------------------
        | ⭐ Recurring Task Fields
        --------------------------------*/
        CRUD::addField([
            'name'  => 'is_recurring',
            'label' => 'Is Recurring?',
            'type'  => 'checkbox',
        ]);

        CRUD::addField([
            'name'    => 'recurring_type',
            'label'   => 'Recurring Type',
            'type'    => 'select_from_array',
            'options' => [
                'daily'   => 'Daily',
                'weekly'  => 'Weekly',
                'monthly' => 'Monthly',
            ],
            'allows_null' => true,
        ]);

        CRUD::addField([
            'name'  => 'recurring_start_date',
            'label' => 'Start Date',
            'type'  => 'date',
        ]);

        CRUD::addField([
            'name'  => 'recurring_end_date',
            'label' => 'End Date',
            'type'  => 'date',
        ]);

        CRUD::addField([
            'name'  => 'next_run_date',
            'label' => 'Next Run Date',
            'type'  => 'date',
        ]);
    }


    /*-----------------------------------------------------
    | UPDATE OPERATION
    ------------------------------------------------------*/
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
{
    $response = $this->traitStore();

    $task = $this->crud->entry;

    if ($task->employee) {
        $task->employee->notify(new TaskAssignedNotification($task));
    }

  //  return $response;
   return redirect('/admin/task');
}

public function update()
{
    // Correct way to get ID in Backpack
    $id = $this->crud->getCurrentEntryId();

    // Get old task
    $oldTask = Task::find($id);

    // Perform Backpack update
    $response = $this->crud->update($id, request()->all());

    // Get updated task
    $task = $this->crud->entry;

    // SAFETY CHECK — ensure both objects exist
    if ($oldTask && $task) {

        // Notify if status changed
        if ($oldTask->status !== $task->status && $task->employee) {
            $task->employee->notify(new TaskStatusUpdatedNotification($task));
        }
    }

   // return $response;
    return redirect('/admin/task');
}




}
