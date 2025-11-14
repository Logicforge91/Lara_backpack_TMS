<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
  protected function setupListOperation()
    {
        CRUD::column('employee_code');
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('position');

        CRUD::addColumn([
            'name'      => 'team_id',
            'label'     => 'Team',
            'type'      => 'select',
            'entity'    => 'team',
            'attribute' => 'name',
            'model'     => 'App\Models\Team',
        ]);

        CRUD::column('joining_date')->type('date');
        CRUD::column('status');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);

        CRUD::field('employee_code')->label('Employee Code');
        CRUD::field('name');
        CRUD::field('email')->type('email');
        CRUD::field('phone');
        CRUD::field('position');

        CRUD::addField([
            'label'     => 'Team',
            'type'      => 'select',
            'name'      => 'team_id',
            'entity'    => 'team',
            'attribute' => 'name',
            'model'     => 'App\Models\Team',
        ]);

        CRUD::addField([
            'name'  => 'joining_date',
            'label' => 'Joining Date',
            'type'  => 'date',
        ]);

        CRUD::addField([
            'name'    => 'status',
            'label'   => 'Status',
            'type'    => 'select_from_array',
            'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'],
            'default' => 'Active',
        ]);
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
