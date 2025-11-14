<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CurrentReleaseRequest;
use Illuminate\Support\Facades\DB;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CurrentReleaseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CurrentReleaseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\CurrentRelease::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/current-release');
        CRUD::setEntityNameStrings('current release', 'current releases');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
  protected function setupListOperation()
{
    // Employee Name
 CRUD::addColumn([
    'name'      => 'employee_id',
    'label'     => 'Employee Name',
    'type'      => 'select',
    'entity'    => 'employee',
    'model'     => 'App\\Models\\Employee',
    'attribute' => 'name',
]);

    // Section
    CRUD::addColumn([
        'name'  => 'section',
        'label' => 'Section',
        'type'  => 'text',
    ]);

    // Description
    CRUD::addColumn([
        'name'  => 'description',
        'label' => 'Description',
        'type'  => 'textarea',
        'limit' => 50,
    ]);

    // Status
    CRUD::addColumn([
        'name'  => 'status',
        'label' => 'Status',
        'type'  => 'badge',
        'options' => [
             'Pending'     => 'Pending',
            'In Progress' => 'In Progress',
            'Released'    => 'Released',
        ],
        'colors' => [
            'pending' => 'warning',
            'in-progress' => 'info',
            'completed' => 'success',
            'released' => 'primary',
        ],
    ]);

    // Start Date
    CRUD::addColumn([
        'name'  => 'start_date',
        'label' => 'Start Date',
        'type'  => 'date',
    ]);

    // End Date
    CRUD::addColumn([
        'name'  => 'end_date',
        'label' => 'End Date',
        'type'  => 'date',
    ]);

    // Deadline Date
    CRUD::addColumn([
        'name'  => 'deadline_date',
        'label' => 'Deadline Date',
        'type'  => 'date',
    ]);

    // Comments
    CRUD::addColumn([
        'name'  => 'comments',
        'label' => 'Comments',
        'type'  => 'textarea',
        'limit' => 50,
    ]);

    // Code Verified By (Team)
    CRUD::addColumn([
        'name'      => 'code_verified_by',
        'label'     => 'Code Verified By (Team)',
        'type'      => 'select',
        'entity'    => 'verifiedTeam',
        'model'     => 'App\\Models\\Team',
        'attribute' => 'name',
    ]);

    // Story Points
    CRUD::addColumn([
        'name'  => 'story_points',
        'label' => 'Story Points',
        'type'  => 'number',
    ]);

    // Release Date
    // CRUD::addColumn([
    //     'name'  => 'release_date',
    //     'label' => 'Release Date',
    //     'type'  => 'date',
    // ]);

    // Created At
    CRUD::addColumn([
        'name'  => 'created_at',
        'label' => 'Created At',
        'type'  => 'datetime',
    ]);

    // Updated At (optional)
    CRUD::addColumn([
        'name'  => 'updated_at',
        'label' => 'Updated At',
        'type'  => 'datetime',
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
    CRUD::setValidation(CurrentReleaseRequest::class);

    // Employee Name
CRUD::addField([
    'name'      => 'employee_id',
    'label'     => 'Employee Name',
    'type'      => 'select',
    'entity'    => 'employee',
    'model'     => 'App\\Models\\Employee',
    'attribute' => 'name',
    'allows_null' => false,
]);

    // Section
    CRUD::addField([
        'name'  => 'section',
        'label' => 'Section',
        'type'  => 'text',
    ]);

    // Description
    CRUD::addField([
        'name'  => 'description',
        'label' => 'Description',
        'type'  => 'textarea',
    ]);

    // Status
    CRUD::addField([
        'name'  => 'status',
        'label' => 'Status',
        'type'  => 'select_from_array',
        'options' => [
            'Pending'     => 'Pending',
            'In Progress' => 'In Progress',
            'Released'    => 'Released',
        ],
        'allows_null' => false,
        'default'     => 'pending',
    ]);

    // Start Date
    CRUD::addField([
        'name'  => 'start_date',
        'label' => 'Start Date',
        'type'  => 'date',
    ]);

    // End Date
    CRUD::addField([
        'name'  => 'end_date',
        'label' => 'End Date',
        'type'  => 'date',
    ]);

    // Deadline Date
    CRUD::addField([
        'name'  => 'deadline_date',
        'label' => 'Deadline Date',
        'type'  => 'date',
    ]);

    // Comments
    CRUD::addField([
        'name'  => 'comments',
        'label' => 'Comments',
        'type'  => 'textarea',
    ]);

    // Code Verified By (Team)
    CRUD::addField([
        'name'      => 'code_verified_by',
        'label'     => 'Code Verified By (Team)',
        'type'      => 'select',
        'entity'    => 'verifiedTeam',
        'model'     => 'App\\Models\\Team',
        'attribute' => 'name',
        'allows_null' => true,
    ]);

    // Story Points
    CRUD::addField([
        'name'  => 'story_points',
        'label' => 'Story Points',
        'type'  => 'number',
    ]);

    // Release Date
    // CRUD::addField([
    //     'name'  => 'release_date',
    //     'label' => 'Release Date',
    //     'type'  => 'date',
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
