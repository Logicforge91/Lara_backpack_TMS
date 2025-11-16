<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('task', 'tasks');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
protected function setupListOperation()
{
    CRUD::column('id')->label('ID');

  CRUD::addColumn([
    'name'      => 'employee_id',
    'label'     => 'Employee Name',
    'type'      => 'select',
    'entity'    => 'employee',
    'model'     => 'App\\Models\\Employee',
    'attribute' => 'name',
    'allows_null' => false,
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
        'default' => 'Pending',
    ]);

    // CRUD::addColumn([
    //     'name' => 'due_date',
    //     'label' => 'Due Date',
    //     'type' => 'datetime',
    // ]);

    // CRUD::column('created_at')->label('Created');
}


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
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
    'allows_null' => false,
]);

    // Task Title
    CRUD::field('title')
        ->type('text')
        ->label('Title');

    // Description
    CRUD::addField([
        'name' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
    ]);

CRUD::addField([
    'name'      => 'tags',
    'label'     => 'Tags',
    'type'      => 'select_multiple',  // ⭐ WORKS IN BACKPACK FREE
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

    // Due Date Picker
    // CRUD::addField([
    //     'name' => 'due_date',
    //     'label' => 'Due Date',
    //     'type' => 'datetime_picker',
    // ]);
}


    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
