<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MonthlyReportRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MonthlyReportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MonthlyReportCrudController extends CrudController
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
        CRUD::setModel(\App\Models\MonthlyReport::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/monthly-report');
        CRUD::setEntityNameStrings('monthly report', 'monthly reports');
         CRUD::denyAccess(['create', 'update']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
   protected function setupListOperation()
{
    // Task ID
    CRUD::addColumn([
        'name'  => 'task_id',
        'label' => 'Task ID',
        'type'  => 'number',
    ]);

    // Employee ID
    CRUD::addColumn([
        'name'  => 'employee_id',
        'label' => 'Employee',
        'type'  => 'select',
        'entity' => 'employee',        // relation method in model
        'attribute' => 'name',         // column from employees table
        'model' => "App\Models\Employee",
    ]);

    // Task Name
    CRUD::addColumn([
        'name'  => 'task_id',
        'label' => 'Task',
        'type'  => 'select',
        'entity' => 'task',        // relation method in model
        'attribute' => 'name',         // column from employees table
        'model' => "App\Models\Task",
    ]);

    // Description
    CRUD::addColumn([
        'name'  => 'description',
        'label' => 'Description',
        'type'  => 'textarea',
        'limit' => 50,  // show summary only
    ]);

    // Status
    CRUD::addColumn([
        'name'  => 'status',
        'label' => 'Status',
        'type'  => 'enum',
    ]);

    // Report Date
    CRUD::addColumn([
        'name'  => 'report_date',
        'label' => 'Report Date',
        'type'  => 'date',
    ]);
}


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MonthlyReportRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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
