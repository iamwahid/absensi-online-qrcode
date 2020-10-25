<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
    <select name="role" id="role" class="custom-control">
        <option value="" {{request()->get('role') == '' || request()->get('role') == null ? 'selected' : '' }}>Semua</option>
        <option value="{{config('access.users.admin_role')}}" {{request()->get('role') == config('access.users.admin_role') ? 'selected' : '' }}>{{ucwords(config('access.users.admin_role'))}}</option>
        <option value="{{config('access.users.executive_role')}}" {{request()->get('role') == config('access.users.executive_role') ? 'selected' : '' }}>{{ucwords(config('access.users.executive_role'))}}</option>
        <option value="{{config('access.users.default_role')}}" {{request()->get('role') == config('access.users.default_role') ? 'selected' : '' }}>{{ucwords(config('access.users.default_role'))}}</option>
    </select>
    <a href="{{ route('admin.auth.user.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
</div><!--btn-toolbar-->
