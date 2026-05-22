@extends('admin.layouts.app')

@section('title', 'Tài khoản')
@section('page_title', 'Phân vai trò tài khoản')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Danh sách user</h2>
            <form action="{{ route('admin.users.index') }}" method="get">
                <input name="q" value="{{ $filters['q'] }}" type="search" placeholder="Tìm tên, email, số điện thoại...">
                <select name="role">
                    <option value="">Mọi vai trò</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" @selected($filters['role'] === $role->name)>{{ $role->name }}</option>
                    @endforeach
                </select>
                <button class="admin-link-button" type="submit"><i class="fas fa-search"></i> Lọc</button>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Liên hệ</th>
                        <th>Vai trò hiện tại</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Phân vai trò</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong><br>
                                <span class="admin-muted">#{{ $user->id }}</span>
                            </td>
                            <td>
                                {{ $user->email }}<br>
                                <span class="admin-muted">{{ $user->phone ?: '-' }}</span>
                            </td>
                            <td>
                                <span class="admin-badge {{ $user->role_name ? '' : 'admin-badge--off' }}">{{ $user->role_name ?: 'chưa gán' }}</span>
                                @if($user->role_description)
                                    <br><span class="admin-muted">{{ $user->role_description }}</span>
                                @endif
                            </td>
                            <td><span class="admin-badge {{ $user->status === 'active' ? '' : 'admin-badge--danger' }}">{{ $user->status }}</span></td>
                            <td>{{ $user->created_at ? \Illuminate\Support\Carbon::parse($user->created_at)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if(auth()->user()->hasPermission('users.update'))
                                    <form class="admin-row-actions" action="{{ route('admin.users.role.update', $user->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role_id" @disabled((int) $user->id === (int) auth()->id())>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" @selected((int) $user->role_id === (int) $role->id)>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="status" @disabled((int) $user->id === (int) auth()->id())>
                                            <option value="active" @selected($user->status === 'active')>active</option>
                                            <option value="blocked" @selected($user->status === 'blocked')>blocked</option>
                                        </select>
                                        <button class="admin-button" type="submit" @disabled((int) $user->id === (int) auth()->id())>Lưu</button>
                                    </form>
                                    @if((int) $user->id === (int) auth()->id())
                                        <span class="admin-help">Không thể tự đổi vai trò tài khoản đang đăng nhập.</span>
                                    @endif
                                @else
                                    <span class="admin-muted">Bạn chỉ có quyền xem.</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Không có user phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
