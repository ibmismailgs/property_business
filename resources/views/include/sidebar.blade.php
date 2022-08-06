<div class="app-sidebar colored">
	<div class="sidebar-header">
		<a class="header-brand" href="{{route('dashboard')}}">
			<div class="logo-img">
				<img height="30" src="{{ asset('img/logo_white.png')}}" class="header-brand-img" title="Rangs">
			</div>
		</a>
		{{-- <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
		<button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button> --}}
    </div>
@php
$segment1 = request()->segment(1);
$segment2 = request()->segment(2);
@endphp

<div class="sidebar-content">
<div class="nav-container">
<nav id="main-menu-navigation" class="navigation-main">
	<div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
		<a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
	</div>

	<div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
		<a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
		<div class="submenu-content">
			@can('manage_user')
			<a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
			<a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
			@endcan
			<!-- only those have manage_role permission will get access -->
			@can('manage_roles')
			<a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
			@endcan
			<!-- only those have manage_permission permission will get access -->
			@can('manage_permission')
			<a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
			@endcan
		</div>
	</div>

{{--Start Inventory--}}
<div class="nav-item {{ ($segment1 == 'item-inventory' || $segment1 == 'item-inventory'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
	<a href="#"><i class="fas fa-align-justify" aria-hidden="true"></i><span>{{ __('label.INVENTORIES')}}</span></a>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'item-inventory') ? 'active' : '' }}">
				<span>{{ __('label.SETTINGS')}}</span></a>
				<div class="submenu-content">
					<!-- only those have manage_user permission will get access -->
                    <a href="{{ url('inventory-category') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.INVENTORY_CATEGORY')}}</a>

                    <a href="{{ url('inventory-subcategory') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.INVENTORY_SUBCATEGORY')}}</a>

					<a href="{{ url('inventory-group') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.INVENTORY_GROUP')}}</a>

					<a href="{{ url('inventory-items') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.INVENTORY_ITEMS')}}</a>
				</div>
			</div>

			<div class="submenu-content">
				<div class="nav-item has-sub">
					<a href="#" class="menu-item {{ ($segment1 == 'accounts') ? 'active' : '' }}">
						<span>{{ __('label.INVENTORY')}}</span></a>
						<div class="submenu-content">
							<a href="{{ url('item-inventory') }}"
							class="menu-item {{ ($segment1 == 'accounts') ? 'active' : '' }}">{{ __('label.INVENTORIES')}}</a>
						</div>
					</div>
				</div>

			</div>
		</div>

{{--End Inventory --}}

{{--Start Project--}}
<div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'users'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
	<a href="#"><i class="fas fa-align-justify" aria-hidden="true"></i><span>{{ __('label.PROJECTS')}}</span></a>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">
				<span>{{ __('label.SETTINGS')}}</span></a>
				<div class="submenu-content">
					<!-- only those have manage_user permission will get access -->
                    <a href="{{ url('project-type') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.PROJECT_TYPE')}}</a>

                    <a href="{{ url('components') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.COMPONENTS')}}</a>
				</div>
			</div>

			<div class="submenu-content">
				<div class="nav-item has-sub">
					<a href="#" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">
						<span>{{ __('label.PROJECT')}}</span></a>
						<div class="submenu-content">
							<a href="{{ url('projects') }}"
							class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.PROJECTS')}}</a>
						</div>
					</div>
				</div>

			<div class="submenu-content">
				<div class="nav-item has-sub">
					<a href="#" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">
						<span>{{ __('label.VIEW_PACKAGES')}}</span></a>
						<div class="submenu-content">
							<a href="{{ url('view-project-packages') }}"
							class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.VIEW_PACKAGES')}}</a>
						</div>
					</div>
				</div>

			</div>
		</div>
{{--End Projects --}}

{{--Start Project Packages--}}
<div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'users'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
	<a href="#"><i class="fas fa-align-justify" aria-hidden="true"></i><span>{{ __('label.PROJECT_PACKAGES')}}</span></a>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">
				<span>{{ __('label.SETTINGS')}}</span></a>
				<div class="submenu-content">
					<!-- only those have manage_user permission will get access -->

                    <a href="{{ url('package-type') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.PACKAGE_TYPES')}}</a>

                    <a href="{{ url('contactors') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.CONTACTORS')}}</a>
				</div>
			</div>

			<div class="submenu-content">
				<div class="nav-item has-sub">
					<a href="#" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">
						<span>{{ __('label.PROJECT_PACKAGES')}}</span></a>
						<div class="submenu-content">
							<a href="{{ url('project-packages') }}"
							class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.PROJECT_PACKAGES')}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
{{--End Projects Packages --}}

<div class="submenu-content">
	<div class="nav-item has-sub">
		<a href="#"><i class="fa fa-tasks" aria-hidden="true"></i>
			<span>{{ __('label.PACKAGES_ITEM')}}</span>
        </a>
			<div class="submenu-content">
				<a href="{{ url('package-unit') }}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('label.PACKAGE_UNITS')}}</a>
			</div>

			<div class="submenu-content">
				<a href="{{url('package-items')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('label.PACKAGE_ITEMS')}}</a>
			</div>
		</div>
	</div>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#"><i class="ik ik-users" aria-hidden="true"></i>
				<span>{{ __('label.EMPLOYEE')}}</span>
			</a>

			<div class="submenu-content">
				<a href="{{url('designation')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('label.DESIGNATION')}}</a>
			</div>

			<div class="submenu-content">
				<a href="{{url('employees')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('label.EMPLOYEES')}}</a>
			</div>
            <div class="submenu-content">
		         <a href="{{url('project-assign')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('label.PROJECT_ASSIGN')}}</a>
	        </div>
		</div>
	</div>

{{--Accounts--}}
<div class="nav-item {{ ($segment1 == 'accounts' || $segment1 == 'transactions'||$segment1 == 'banks' ) ? 'active open' : '' }} has-sub">
	<a href="#"><i class="ik ik-settings"></i>
		<span>Accounts</span>
	</a>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'transactions') ? 'active' : '' }}">
				<span>Transaction</span>
			</a>
			<div class="submenu-content">
				<a href="{{route('transactions.index')}}"
				class="menu-item {{ ($segment1 == 'transactions') ? 'active' : '' }}">Transactions</a>
			</div>
			<div class="submenu-content">
				<a href="{{route('transactions.create')}}"
				class="menu-item {{ ($segment1 == 'transactions') ? 'active' : '' }}">Create</a>
			</div>
		</div>
	</div>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'accounts') ? 'active' : '' }}">
				<span>Account</span>
			</a>
			<div class="submenu-content">
				<a href="{{route('accounts.index')}}"
				class="menu-item {{ ($segment1 == 'accounts') ? 'active' : '' }}">Accounts</a>
			</div>
			<div class="submenu-content">
				<a href="{{route('accounts.create')}}"
				class="menu-item {{ ($segment1 == 'accounts') ? 'active' : '' }}">Create</a>
			</div>
		</div>
	</div>

	<div class="submenu-content">
		<div class="nav-item has-sub">
			<a href="#" class="menu-item {{ ($segment1 == 'banks') ? 'active' : '' }}">
				<span>Bank</span>
			</a>
			<div class="submenu-content">
				<a href="{{route('banks.index')}}"
				class="menu-item {{ ($segment1 == 'banks') ? 'active' : '' }}">Banks</a>
			</div>
			<div class="submenu-content">
				<a href="{{route('banks.create')}}"
				class="menu-item {{ ($segment1 == 'banks') ? 'active' : '' }}">Create</a>
			</div>
		</div>
	</div>
</div>
</nav>
</div>
</div>
</div>
