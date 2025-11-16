{{-- Dashboard --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

{{-- Users --}}
<x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />

{{-- Teams --}}
<x-backpack::menu-item title="Teams" icon="la la-sitemap" :link="backpack_url('team')" />

{{-- Employees --}}
<x-backpack::menu-item title="Employees" icon="la la-user-tie" :link="backpack_url('employee')" />

{{-- Current Releases --}}
<x-backpack::menu-item title="Current releases" icon="la la-rocket" :link="backpack_url('current-release')" />

{{-- Completed Releases --}}
<x-backpack::menu-item title="Completed releases" icon="la la-check-circle" :link="backpack_url('completed-release')" />

{{-- Tasks --}}
<x-backpack::menu-item title="Tasks" icon="la la-tasks" :link="backpack_url('task')" />

{{-- Monthly Reports --}}
<x-backpack::menu-item title="Monthly reports" icon="la la-file-alt" :link="backpack_url('monthly-report')" />
