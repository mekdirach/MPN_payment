<?php $routeName = Route::currentRouteName(); ?>
<!-- Layout sidenav -->
<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-sidenav-theme">

    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <br>
    <div class="app-brand demo">

        <span class="app-brand-logo ">
            <div class="d-flex justify-content-center ">
                <img src="{{ url('assets/img/bg/wr.png') }}" class="img">
            </div>
        </span>
        <a href="{{ route('member.dashboard.index') }}"
            class="app-brand-text demo sidenav-text font-weight-normal ml-2">MPN</a>
        <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>
    <br>

    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1 ps">
        <!--Dash Laporan-->
        <li class="sidenav-item{{ strpos($routeName, 'trans.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i
                    class="sidenav-icon ion ion-ios-clipboard d-block"></i>
                <div>Laporan</div>
            </a>

            <ul class="sidenav-menu">

                <li class="sidenav-item{{ $routeName == 'trans.transaksi.index' ? ' active' : '' }}">
                    <a href="{{ route('trans.transaksi.index') }}" class="sidenav-link">
                        <div>Transaksi</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'trans.transaksiahu.index' ? ' active' : '' }}">
                    <a href="{{ route('trans.transaksiahu.index') }}" class="sidenav-link">
                        <div>Laporan Transaksi AHU</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'trans.transaksinonahu.index' ? ' active' : '' }}">
                    <a href="{{ route('trans.transaksinonahu.index') }}" class="sidenav-link">
                        <div>Laporan Transaksi Non AHU</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidenav-item{{ strpos($routeName, 'limpahkan.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i
                    class="sidenav-icon ion ion-ios-clipboard d-block"></i>
                <div>Pelimpahan</div>
            </a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'limpahkan.pelimpahan.index' ? ' active' : '' }}">
                    <a href="{{ route('limpahkan.pelimpahan.index') }}" class="sidenav-link">
                        <div>Pelimpahan</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'limpahkan.nomorsakti.index' ? ' active' : '' }}">
                    <a href="{{ route('limpahkan.nomorsakti.index') }}" class="sidenav-link">
                        <div>Nomor Sakti</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'limpahkan.laporan.index' ? ' active' : '' }}">
                    <a href="{{ route('limpahkan.laporan.index') }}" class="sidenav-link">
                        <div>Laporan</div>
                    </a>
                </li>
            </ul>
        </li>
        <!--Dash Admin-->

        <li class="sidenav-item{{ strpos($routeName, 'admin.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i
                    class="sidenav-icon fas fa-users-cog d-block"></i>
                <div>Admin</div>
            </a>

            <ul class="sidenav-menu">

                <li class="sidenav-item{{ $routeName == 'admin.force.index' ? ' active' : '' }}">
                    <a href="{{ route('admin.force.index') }}" class="sidenav-link">
                        <div>Force Flaging</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'admin.manualreveral.index' ? ' active' : '' }}">
                    <a href="{{ route('admin.manualreveral.index') }}" class="sidenav-link">
                        <div>Manual Reversal</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'admin.cekstatus.index' ? ' active' : '' }}">
                    <a href="{{ route('admin.cekstatus.index') }}" class="sidenav-link">
                        <div>Cek Status Payment</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'admin.mpnstatuskoneksi.index' ? ' active' : '' }}">
                    <a href="{{ route('admin.mpnstatuskoneksi.index') }}" class="sidenav-link">
                        <div>MPN Status Koneksi</div>
                    </a>
                </li>
            </ul>
        </li>


        <!--Dash Master Data-->

        <li class="sidenav-item{{ strpos($routeName, 'member.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i
                    class="sidenav-icon fas fa-calendar-alt d-block"></i>
                <div>Master Data</div>
            </a>

            <ul class="sidenav-menu">
			<!--
                <li class="sidenav-item{{ $routeName == 'member.holiday.index' ? ' active' : '' }}">
                    <a href="{{ route('member.holiday.index') }}" class="sidenav-link">
                        <div>Holiday</div>
                    </a>
                </li>
				-->
                <li class="sidenav-item{{ $routeName == 'member.rolemanagement.index' ? ' active' : '' }}">
                    <a href="{{ route('member.rolemanagement.index') }}" class="sidenav-link">
                        <div>Role Management</div>
                    </a>
                </li>
            </ul>
        </li>


        <!--Dash Setting-->

        <li class="sidenav-item{{ strpos($routeName, 'setting.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i
                    class="sidenav-icon ion ion-md-cog d-block"></i>
                <div>Setting</div>
            </a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'setting.pengaturan.index' ? ' active' : '' }}">
                    <a href="{{ route('setting.pengaturan.index') }}" class="sidenav-link">
                        <div>Setting</div>
                    </a>
                </li>
                <li class="sidenav-item{{ $routeName == 'setting.parametersistem.index' ? ' active' : '' }}">
                    <a href="{{ route('setting.parametersistem.index') }}" class="sidenav-link">
                        <div>Parameter System</div>
                    </a>
                </li>

                <li class="sidenav-item{{ $routeName == 'setting.settingkementrian.index' ? ' active' : '' }}">
                    <a href="{{ route('setting.settingkementrian.index') }}" class="sidenav-link">
                        <div>Setting Kementrian</div>
                    </a>
                </li>
            </ul>
        </li>


    </ul>
</div>
