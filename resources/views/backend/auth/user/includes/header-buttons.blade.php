<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
    <select name="role" id="role" class="custom-control">
        <option value="" {{request()->get('role') == '' || request()->get('role') == null ? 'selected' : '' }}>Semua</option>
        <option value="admin" {{request()->get('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="ustadz" {{request()->get('role') == 'ustadz' ? 'selected' : '' }}>Ustadz</option>
        <option value="walisantri" {{request()->get('role') == 'walisantri' ? 'selected' : '' }}>Wali Santri</option>
    </select>
    <a href="{{ route('admin.auth.user.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
</div><!--btn-toolbar-->
