@extends('admin.layouts.app')

@section('title', 'Vai trò & quyền')
@section('page_title', 'Phân quyền theo vai trò')

@php
    $allPermissionNames = collect($permissionGroups)->flatten(1)->pluck('name')->all();
@endphp

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__head">
            <div>
                <h2>Tạo vai trò mới</h2>
                <p class="admin-muted">Vai trò dùng để gán cho tài khoản user và quyết định user được thao tác phần nào trong admin.</p>
            </div>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="post">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="role-name">Tên vai trò</label>
                    <input id="role-name" name="name" value="{{ old('name') }}" placeholder="vd: sale_leader">
                    <span class="admin-help">Dùng chữ thường, số và dấu gạch dưới.</span>
                </div>
                <div class="admin-field">
                    <label for="role-description">Mô tả</label>
                    <input id="role-description" name="description" value="{{ old('description') }}" placeholder="Mô tả phạm vi công việc">
                </div>
            </div>

            <div class="admin-permission-grid u-m-t-18">
                @foreach($permissionGroups as $group => $permissions)
                    <div class="admin-permission-card">
                        <h3>{{ $group }}</h3>
                        <div class="admin-checks admin-checks--stacked">
                            @foreach($permissions as $permission)
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, old('permissions', []), true))>
                                    <span>{{ $permission->description }} <small>{{ $permission->name }}</small></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="admin-form-actions">
                <button class="admin-button" type="submit"><i class="fas fa-plus"></i> Tạo vai trò</button>
            </div>
        </form>
    </section>

    <section class="admin-role-grid">
        @foreach($roles as $role)
            @php
                $selectedPermissions = $role->name === 'admin'
                    ? $allPermissionNames
                    : ($rolePermissionMap->get($role->id, []) ?? []);
            @endphp
            <article class="admin-panel admin-role-card">
                <div class="admin-panel__head">
                    <div>
                        <h2>{{ $role->name }}</h2>
                        <span class="admin-muted">{{ $role->users_count }} user đang dùng vai trò này</span>
                    </div>
                    <span class="admin-badge">{{ count($selectedPermissions) }} quyền</span>
                </div>

                <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="admin-field">
                        <label for="role-description-{{ $role->id }}">Mô tả</label>
                        <input id="role-description-{{ $role->id }}" name="description" value="{{ old('description', $role->description) }}">
                        @if($role->name === 'admin')
                            <span class="admin-help">Vai trò admin luôn có toàn quyền hệ thống.</span>
                        @endif
                    </div>

                    <div class="admin-permission-grid admin-permission-grid--compact u-m-t-18">
                        @foreach($permissionGroups as $group => $permissions)
                            <div class="admin-permission-card">
                                <h3>{{ $group }}</h3>
                                <div class="admin-checks admin-checks--stacked">
                                    @foreach($permissions as $permission)
                                        <label>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $selectedPermissions, true)) @disabled($role->name === 'admin')>
                                            <span>{{ $permission->description }} <small>{{ $permission->name }}</small></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="admin-form-actions">
                        <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu quyền</button>
                    </div>
                </form>

                @if(! in_array($role->name, ['admin', 'customer'], true) && (int) $role->users_count === 0)
                    <form class="admin-form-actions" action="{{ route('admin.roles.destroy', $role->id) }}" method="post" onsubmit="return confirm('Xóa vai trò này?')">
                        @csrf
                        @method('DELETE')
                        <button class="admin-danger-button" type="submit">Xóa vai trò</button>
                    </form>
                @endif
            </article>
        @endforeach
    </section>
@endsection
