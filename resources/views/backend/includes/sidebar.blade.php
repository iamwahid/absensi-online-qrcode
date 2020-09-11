<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            {{-- mahasiswa --}}
            <li class="nav-item nav-dropdown {{
                active_class(Active::checkUriPattern('admin/mahasiswa*'), 'open')
            }}">
                <a class="nav-link nav-dropdown-toggle {{
                    active_class(Active::checkUriPattern('admin/mahasiswa*'))
                }}" href="#">
                    <i class="nav-icon far fa-user"></i>
                    Mahasiswa
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/mahasiswa'))
                        }}" href="{{ route('admin.mahasiswa.index') }}">
                            <i class="nav-icon far fa-user"></i> Daftar Mahasiswa
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/mahasiswa/create'))
                        }}" href="{{ route('admin.mahasiswa.create') }}">
                            <i class="nav-icon far fa-user"></i> Tambah Mahasiswa
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- dosen --}}
            <li class="nav-item nav-dropdown {{
                active_class(Active::checkUriPattern('admin/dosen*'), 'open')
            }}">
                <a class="nav-link nav-dropdown-toggle {{
                    active_class(Active::checkUriPattern('admin/dosen*'))
                }}" href="#">
                    <i class="nav-icon far fa-user"></i>
                    Dosen
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/dosen'))
                        }}" href="{{ route('admin.dosen.index') }}">
                            <i class="nav-icon far fa-user"></i> Daftar Dosen
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/dosen/create'))
                        }}" href="{{ route('admin.dosen.create') }}">
                            <i class="nav-icon far fa-user"></i> Tambah Dosen
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- mata_kuliah --}}
            <li class="nav-item nav-dropdown {{
                active_class(Active::checkUriPattern('admin/mata_kuliah*'), 'open')
            }}">
                <a class="nav-link nav-dropdown-toggle {{
                    active_class(Active::checkUriPattern('admin/mata_kuliah*'))
                }}" href="#">
                    <i class="nav-icon far fa-user"></i>
                    Mata Kuliah
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/mata_kuliah'))
                        }}" href="{{ route('admin.mata_kuliah.index') }}">
                            <i class="nav-icon far fa-user"></i> Daftar Mata Kuliah
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/mata_kuliah/create'))
                        }}" href="{{ route('admin.mata_kuliah.create') }}">
                            <i class="nav-icon far fa-user"></i> Tambah Mata Kuliah
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- jadwal --}}
            <li class="nav-item nav-dropdown {{
                active_class(Active::checkUriPattern('admin/jadwal*'), 'open')
            }}">
                <a class="nav-link nav-dropdown-toggle {{
                    active_class(Active::checkUriPattern('admin/jadwal*'))
                }}" href="#">
                    <i class="nav-icon far fa-user"></i>
                    Jadwal
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/jadwal'))
                        }}" href="{{ route('admin.jadwal.index') }}">
                            <i class="nav-icon far fa-user"></i> Daftar Jadwal
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{
                            active_class(Active::checkUriPattern('admin/jadwal/create'))
                        }}" href="{{ route('admin.jadwal.create') }}">
                            <i class="nav-icon far fa-user"></i> Tambah Jadwal
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- absensi  --}}
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/absensi'))
                }}" href="{{ route('admin.absensi.index') }}">
                    <i class="nav-icon far fa-user"></i>
                    Absensi
                </a>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{
                    active_class(Active::checkUriPattern('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Active::checkUriPattern('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li> --}}
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
