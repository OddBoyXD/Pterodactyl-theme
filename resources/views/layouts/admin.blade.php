<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Pterodactyl') }} - @yield('title')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="_token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ config('pterodactyl.theme.favicon') ?: '/favicons/apple-touch-icon.png' }}">
        <link rel="icon" type="image/png" href="{{ config('pterodactyl.theme.favicon') ?: '/favicons/favicon-32x32.png' }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ config('pterodactyl.theme.favicon') ?: '/favicons/favicon-16x16.png' }}" sizes="16x16">
        <link rel="manifest" href="/favicons/manifest.json">
        <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#bc6e3c">
        <link rel="shortcut icon" href="{{ config('pterodactyl.theme.favicon') ?: '/favicons/favicon.ico' }}">
        <meta name="msapplication-config" content="/favicons/browserconfig.xml">
        <meta name="theme-color" content="#0b0f19">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @include('layouts.scripts')

        @section('scripts')
            {!! Theme::css('vendor/select2/select2.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/bootstrap/bootstrap.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/admin.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/adminlte/colors/skin-blue.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/sweetalert/sweetalert.min.css?t={cache-version}') !!}
            {!! Theme::css('vendor/animate/animate.min.css?t={cache-version}') !!}
            {!! Theme::css('css/pterodactyl.css?t={cache-version}') !!}
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

            <style>
                /* Modern Dark Obsidian Theme for Pterodactyl Admin Panel */
                html, body, button, input, select, textarea, p, h1, h2, h3, h4, h5, h6, td, th, label, .box-title, .small-box, .info-box, span:not(.fa):not(.fas):not(.far):not(.fal):not(.fab):not([class*="fa-"]):not(.glyphicon):not(.ion), a:not(.fa):not(.fas):not(.far):not(.fal):not(.fab):not([class*="fa-"]), div:not(.fa):not(.fas):not(.far):not(.fal):not(.fab):not([class*="fa-"]) {
                    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                }
                .fa, .fas, .far, .fal, .fab, [class*="fa-"], [class^="fa-"] {
                    font-family: 'FontAwesome', 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important;
                    font-style: normal !important;
                    display: inline-block !important;
                }
                .glyphicon {
                    font-family: 'Glyphicons Halflings' !important;
                }
                .ion {
                    font-family: 'Ionicons' !important;
                }
                body, .wrapper, .content-wrapper, .right-side {
                    background-color: #0b0f19 !important;
                    color: #cbd5e1 !important;
                }
                header.main-header {
                    background: #0f1423 !important;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                    position: sticky;
                    top: 0;
                    z-index: 1030;
                }
                header.main-header .navbar {
                    background: transparent !important;
                }
                header.main-header .logo {
                    background: #0c101a !important;
                    border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                    color: #fff !important;
                    font-weight: 800 !important;
                    letter-spacing: 0.5px;
                }
                header.main-header .logo span {
                    background: linear-gradient(135deg, #c084fc, #818cf8);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
                header.main-header .sidebar-toggle {
                    float: left !important;
                    display: inline-flex !important;
                    align-items: center;
                    justify-content: center;
                    width: 50px !important;
                    height: 50px !important;
                    padding: 0 !important;
                    text-decoration: none !important;
                    background: transparent !important;
                    transition: all 0.2s ease;
                }
                header.main-header .sidebar-toggle:before {
                    display: none !important;
                }
                header.main-header .sidebar-toggle .fa-bars {
                    color: #c084fc !important;
                    font-size: 16px !important;
                    line-height: 1 !important;
                    transition: transform 0.2s ease, color 0.2s ease;
                }
                header.main-header .sidebar-toggle:hover {
                    background: rgba(192, 132, 252, 0.12) !important;
                }
                header.main-header .sidebar-toggle:hover .fa-bars {
                    color: #e9d5ff !important;
                    transform: scale(1.12);
                }
                header.main-header .navbar-nav > li > a {
                    color: #94a3b8 !important;
                    font-weight: 500;
                }
                header.main-header .navbar-nav > li > a:hover {
                    background: rgba(255, 255, 255, 0.05) !important;
                    color: #fff !important;
                }
                header.main-header .navbar-nav > .user-menu .user-image {
                    border: 2px solid #8b5cf6;
                }

                /* Sidebar */
                aside.main-sidebar, .sidebar {
                    background: #0c101a !important;
                    border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
                }
                aside.main-sidebar .sidebar-menu > li.header {
                    background: transparent !important;
                    color: #64748b !important;
                    font-size: 11px !important;
                    font-weight: 700 !important;
                    letter-spacing: 1.2px !important;
                    text-transform: uppercase !important;
                    padding: 16px 20px 6px !important;
                }
                aside.main-sidebar .sidebar-menu > li > a {
                    color: #94a3b8 !important;
                    border-radius: 8px;
                    margin: 3px 12px;
                    padding: 10px 14px;
                    font-weight: 500;
                    font-size: 13px;
                    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                    border-left: none !important;
                }
                aside.main-sidebar .sidebar-menu > li > a:hover {
                    background: rgba(255, 255, 255, 0.05) !important;
                    color: #f8fafc !important;
                    transform: translateX(3px);
                }
                aside.main-sidebar .sidebar-menu > li.active > a {
                    background: linear-gradient(135deg, rgba(168, 85, 247, 0.18), rgba(99, 102, 241, 0.12)) !important;
                    color: #c084fc !important;
                    font-weight: 600 !important;
                    box-shadow: 0 2px 10px rgba(168, 85, 247, 0.15) !important;
                    border-left: 3px solid #a855f7 !important;
                }
                aside.main-sidebar .sidebar-menu > li > a > i {
                    color: #818cf8;
                    width: 20px;
                    font-size: 14px;
                    margin-right: 6px;
                }

                /* Ptero Plugins Accordion */
                .ptero-treeview > a.ptero-toggle-btn {
                    display: flex !important;
                    align-items: center !important;
                    justify-content: space-between !important;
                    cursor: pointer !important;
                    background: rgba(168, 85, 247, 0.08) !important;
                    border-radius: 8px !important;
                    margin: 3px 12px !important;
                    padding: 10px 14px !important;
                    border-left: 3px solid #a855f7 !important;
                    transition: all 0.25s ease !important;
                    user-select: none;
                }
                .ptero-treeview > a.ptero-toggle-btn:hover {
                    background: rgba(168, 85, 247, 0.16) !important;
                    color: #fff !important;
                    transform: translateX(3px);
                }
                .ptero-treeview.menu-open > a.ptero-toggle-btn {
                    background: rgba(168, 85, 247, 0.18) !important;
                    color: #c084fc !important;
                }
                .ptero-treeview .ptero-chevron {
                    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                    font-size: 11px;
                }
                .ptero-treeview.menu-open .ptero-chevron {
                    transform: rotate(-90deg) !important;
                }
                ul.ptero-submenu {
                    background: #080c14 !important;
                    border-left: 2px solid rgba(168, 85, 247, 0.4) !important;
                    margin: 4px 12px 6px 24px !important;
                    padding: 4px 0 !important;
                    border-radius: 0 8px 8px 0;
                    list-style: none;
                }
                ul.ptero-submenu > li > a {
                    color: #94a3b8 !important;
                    padding: 8px 14px 8px 16px !important;
                    font-size: 12.5px !important;
                    border-radius: 6px;
                    margin: 2px 6px;
                    display: flex;
                    align-items: center;
                    transition: all 0.2s ease;
                }
                ul.ptero-submenu > li > a:hover {
                    background: rgba(255, 255, 255, 0.06) !important;
                    color: #fff !important;
                    transform: translateX(3px);
                }
                ul.ptero-submenu > li.active > a {
                    background: rgba(168, 85, 247, 0.22) !important;
                    color: #c084fc !important;
                    font-weight: 600 !important;
                }
                .ptero-counter-badge {
                    background: linear-gradient(135deg, #a855f7, #6366f1) !important;
                    border-radius: 10px !important;
                    font-size: 10px !important;
                    padding: 2px 7px !important;
                    color: #fff !important;
                    font-weight: 600 !important;
                }

                /* Content Area */
                .content-header > h1 {
                    color: #f8fafc !important;
                    font-weight: 800 !important;
                    font-size: 24px !important;
                    letter-spacing: -0.5px !important;
                    margin: 0 0 10px 0 !important;
                }
                .content-header > h1 > small {
                    color: #94a3b8 !important;
                    font-weight: 400 !important;
                    font-size: 14px !important;
                }
                .content-header > .breadcrumb {
                    background: rgba(255, 255, 255, 0.04) !important;
                    border-radius: 8px !important;
                    padding: 6px 14px !important;
                    font-size: 12px !important;
                }
                .content-header > .breadcrumb > li > a {
                    color: #818cf8 !important;
                }
                .content-header > .breadcrumb > .active {
                    color: #cbd5e1 !important;
                }

                /* Cards / Boxes */
                .box {
                    background: #111827 !important;
                    border: 1px solid rgba(255, 255, 255, 0.08) !important;
                    border-radius: 12px !important;
                    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35) !important;
                    margin-bottom: 22px !important;
                    color: #cbd5e1 !important;
                }
                .box-header {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
                    padding: 14px 18px !important;
                    color: #f1f5f9 !important;
                }
                .box-header .box-title {
                    color: #f1f5f9 !important;
                    font-weight: 700 !important;
                    font-size: 15px !important;
                }
                .box-body {
                    padding: 18px !important;
                    color: #cbd5e1 !important;
                }
                .box-footer {
                    background: #0d121e !important;
                    border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
                    border-radius: 0 0 12px 12px !important;
                    padding: 12px 18px !important;
                }
                .box.box-primary { border-top: 3px solid #8b5cf6 !important; }
                .box.box-success { border-top: 3px solid #10b981 !important; }
                .box.box-danger { border-top: 3px solid #ef4444 !important; }
                .box.box-warning { border-top: 3px solid #f59e0b !important; }
                .box.box-info { border-top: 3px solid #06b6d4 !important; }

                /* Inputs & Form Controls */
                .form-control {
                    background: #080c14 !important;
                    border: 1px solid rgba(255, 255, 255, 0.12) !important;
                    color: #f1f5f9 !important;
                    border-radius: 8px !important;
                    font-size: 13px !important;
                    box-shadow: none !important;
                    transition: all 0.2s ease !important;
                }
                .form-control:focus {
                    border-color: #a855f7 !important;
                    box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.25) !important;
                }
                .form-control[disabled], .form-control[readonly] {
                    background-color: #131926 !important;
                    opacity: 0.6 !important;
                    color: #64748b !important;
                }
                .input-group-addon {
                    background: #1a2233 !important;
                    border: 1px solid rgba(255, 255, 255, 0.12) !important;
                    color: #94a3b8 !important;
                    border-radius: 8px 0 0 8px !important;
                }
                label {
                    color: #94a3b8 !important;
                    font-weight: 600 !important;
                    font-size: 12px !important;
                    text-transform: uppercase !important;
                    letter-spacing: 0.5px !important;
                }
                .help-block {
                    color: #64748b !important;
                    font-size: 12px !important;
                }

                /* Tables */
                .table {
                    color: #cbd5e1 !important;
                }
                .table > thead > tr > th {
                    background: #0d121e !important;
                    color: #94a3b8 !important;
                    font-weight: 700 !important;
                    font-size: 11px !important;
                    text-transform: uppercase !important;
                    letter-spacing: 0.8px !important;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                    border-top: none !important;
                    padding: 12px 14px !important;
                }
                .table > tbody > tr > td {
                    border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
                    padding: 12px 14px !important;
                    vertical-align: middle !important;
                    color: #e2e8f0 !important;
                }
                .table-hover > tbody > tr:hover {
                    background-color: rgba(168, 85, 247, 0.05) !important;
                }
                .table-striped > tbody > tr:nth-of-type(odd) {
                    background-color: rgba(255, 255, 255, 0.015) !important;
                }
                code {
                    background: #1e293b !important;
                    color: #c084fc !important;
                    border-radius: 4px;
                    padding: 2px 6px;
                }

                /* Buttons */
                .btn {
                    border-radius: 8px !important;
                    font-weight: 600 !important;
                    font-size: 12.5px !important;
                    padding: 7px 16px !important;
                    transition: all 0.2s ease !important;
                    text-shadow: none !important;
                }
                .btn-primary {
                    background: linear-gradient(135deg, #a855f7, #6366f1) !important;
                    border: none !important;
                    color: #fff !important;
                    box-shadow: 0 2px 8px rgba(168, 85, 247, 0.35) !important;
                }
                .btn-primary:hover, .btn-primary:focus {
                    background: linear-gradient(135deg, #9333ea, #4f46e5) !important;
                    color: #fff !important;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 14px rgba(168, 85, 247, 0.5) !important;
                }
                .btn-success {
                    background: linear-gradient(135deg, #10b981, #059669) !important;
                    border: none !important;
                    color: #fff !important;
                    box-shadow: 0 2px 8px rgba(168, 85, 247, 0.3) !important;
                }
                .btn-success:hover {
                    background: linear-gradient(135deg, #059669, #047857) !important;
                    color: #fff !important;
                    transform: translateY(-1px);
                }
                .btn-danger {
                    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
                    border: none !important;
                    color: #fff !important;
                    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
                }
                .btn-danger:hover {
                    background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
                    color: #fff !important;
                    transform: translateY(-1px);
                }
                .btn-warning {
                    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
                    border: none !important;
                    color: #fff !important;
                }
                .btn-info {
                    background: linear-gradient(135deg, #06b6d4, #0284c7) !important;
                    border: none !important;
                    color: #fff !important;
                }
                .btn-default {
                    background: #1e293b !important;
                    border: 1px solid rgba(255, 255, 255, 0.1) !important;
                    color: #e2e8f0 !important;
                }
                .btn-default:hover {
                    background: #334155 !important;
                    color: #fff !important;
                }

                /* Badges / Labels */
                .label, .badge {
                    border-radius: 9999px !important;
                    font-weight: 600 !important;
                    padding: 4px 10px !important;
                    font-size: 11px !important;
                    text-shadow: none !important;
                }
                .label-primary { background: linear-gradient(135deg, #a855f7, #6366f1) !important; }
                .label-success { background: linear-gradient(135deg, #10b981, #059669) !important; }
                .label-danger { background: linear-gradient(135deg, #ef4444, #dc2626) !important; }
                .label-warning { background: linear-gradient(135deg, #f59e0b, #d97706) !important; }
                .label-info { background: linear-gradient(135deg, #06b6d4, #0284c7) !important; }
                .label-default { background: #334155 !important; color: #cbd5e1 !important; }

                /* Alerts */
                .alert {
                    border-radius: 10px !important;
                    font-size: 13px !important;
                    border: 1px solid transparent !important;
                }
                .alert-danger {
                    background: rgba(239, 68, 68, 0.15) !important;
                    border-color: rgba(239, 68, 68, 0.35) !important;
                    color: #fca5a5 !important;
                }
                .alert-success {
                    background: rgba(16, 185, 129, 0.15) !important;
                    border-color: rgba(16, 185, 129, 0.35) !important;
                    color: #6ee7b7 !important;
                }
                .alert-warning {
                    background: rgba(245, 158, 11, 0.15) !important;
                    border-color: rgba(245, 158, 11, 0.35) !important;
                    color: #fcd34d !important;
                }
                .alert-info {
                    background: rgba(59, 130, 246, 0.15) !important;
                    border-color: rgba(59, 130, 246, 0.35) !important;
                    color: #93c5fd !important;
                }

                /* Modals */
                .modal-content {
                    background: #111827 !important;
                    border: 1px solid rgba(255, 255, 255, 0.1) !important;
                    border-radius: 14px !important;
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
                    color: #cbd5e1 !important;
                }
                .modal-header {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                }
                .modal-header .modal-title {
                    color: #f8fafc !important;
                    font-weight: 700 !important;
                }
                .modal-footer {
                    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
                    background: #0c101a !important;
                    border-radius: 0 0 14px 14px;
                }

                /* Select2 */
                .select2-container--default .select2-selection--single,
                .select2-container--default .select2-selection--multiple {
                    background-color: #080c14 !important;
                    border: 1px solid rgba(255, 255, 255, 0.12) !important;
                    border-radius: 8px !important;
                    height: 38px !important;
                }
                .select2-container--default .select2-selection--single .select2-selection__rendered {
                    color: #f1f5f9 !important;
                    line-height: 36px !important;
                }
                .select2-dropdown {
                    background-color: #111827 !important;
                    border: 1px solid rgba(255, 255, 255, 0.15) !important;
                    border-radius: 8px !important;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
                }
                .select2-results__option {
                    color: #cbd5e1 !important;
                }
                .select2-results__option--highlighted {
                    background-color: #8b5cf6 !important;
                    color: #fff !important;
                }

                /* Footer */
                .main-footer {
                    background: #0c101a !important;
                    border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
                    color: #64748b !important;
                }

                /* Scrollbar */
                ::-webkit-scrollbar {
                    width: 7px;
                    height: 7px;
                }
                ::-webkit-scrollbar-track {
                    background: #0b0f19;
                }
                ::-webkit-scrollbar-thumb {
                    background: rgba(168, 85, 247, 0.35);
                    border-radius: 10px;
                }
                ::-webkit-scrollbar-thumb:hover {
                    background: rgba(168, 85, 247, 0.65);
                }
            </style>

            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        @show
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="{{ route('index') }}" class="logo">
                    <span>{{ config('app.name', 'Pterodactyl') }}</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="user-menu">
                                <a href="{{ route('account') }}">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(Auth::user()->email)) }}?s=160" class="user-image" alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name_first }} {{ Auth::user()->name_last }}</span>
                                </a>
                            </li>
                            <li>
                                <li><a href="{{ route('index') }}" data-toggle="tooltip" data-placement="bottom" title="Exit Admin Control"><i class="fa fa-server"></i></a></li>
                            </li>
                            <li>
                                <li><a href="{{ route('auth.logout') }}" id="logoutButton" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">BASIC ADMINISTRATION</li>
                        <li class="{{ Route::currentRouteName() !== 'admin.index' ?: 'active' }}">
                            <a href="{{ route('admin.index') }}">
                                <i class="fa fa-home"></i> <span>Overview</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.settings') ?: 'active' }}">
                            <a href="{{ route('admin.settings')}}">
                                <i class="fa fa-wrench"></i> <span>Settings</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.api') ?: 'active' }}">
                            <a href="{{ route('admin.api.index')}}">
                                <i class="fa fa-gamepad"></i> <span>Application API</span>
                            </a>
                        </li>

                        @php
                            $isPluginsActive = in_array(Route::currentRouteName(), ['admin.theme', 'admin.registration', 'admin.subdomains', 'admin.plugins', 'admin.versions', 'admin.tickets', 'admin.tickets.config', 'admin.settings.backups']) || starts_with(Route::currentRouteName(), 'admin.subdomains') || starts_with(Route::currentRouteName(), 'admin.plugins') || starts_with(Route::currentRouteName(), 'admin.versions') || starts_with(Route::currentRouteName(), 'admin.tickets');
                        @endphp

                        <li class="header" style="color: #c084fc; font-weight: 700; letter-spacing: 1.2px; font-size: 11px;">EXTENSIONS & PLUGINS</li>
                        <li class="treeview ptero-treeview {{ $isPluginsActive ? 'active menu-open' : '' }}" id="ptero-plugins-li">
                            <a href="javascript:void(0);" class="ptero-toggle-btn" id="ptero-plugins-toggle-btn">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa fa-cubes" style="color: #c084fc; width: 18px;"></i>
                                    <span style="font-weight: 700; letter-spacing: 0.5px;">PTERO PLUGINS</span>
                                </div>
                                <span class="pull-right-container" style="display: flex; align-items: center; gap: 8px;">
                                    <span class="label pull-right ptero-counter-badge">9</span>
                                    <i class="fa fa-chevron-left pull-right ptero-chevron" style="font-size: 11px; {{ $isPluginsActive ? 'transform: rotate(-90deg);' : '' }}"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu ptero-submenu" id="ptero-plugins-submenu" style="{{ $isPluginsActive ? 'display: block;' : 'display: none;' }}">
                                <li class="{{ starts_with(Route::currentRouteName(), 'admin.announcements') ? 'active' : '' }}">
                                    <a href="{{ route('admin.announcements') }}">
                                        <i class="fa fa-bullhorn" style="color: #f43f5e; width: 18px;"></i> <span>Announcements</span>
                                    </a>
                                </li>
                                <li class="{{ Route::currentRouteName() === 'admin.theme' ? 'active' : '' }}">
                                    <a href="{{ route('admin.theme') }}">
                                        <i class="fa fa-paint-brush" style="color: #38bdf8; width: 18px;"></i> <span>Theme Settings</span>
                                    </a>
                                </li>
                                <li class="{{ Route::currentRouteName() === 'admin.registration' ? 'active' : '' }}">
                                    <a href="{{ route('admin.registration') }}">
                                        <i class="fa fa-user-plus" style="color: #34d399; width: 18px;"></i> <span>Register Config</span>
                                    </a>
                                </li>
                                <li class="{{ starts_with(Route::currentRouteName(), 'admin.subdomains') ? 'active' : '' }}">
                                    <a href="{{ route('admin.subdomains') }}">
                                        <i class="fa fa-link" style="color: #fbbf24; width: 18px;"></i> <span>Subdomains</span>
                                    </a>
                                </li>
                                <li class="{{ starts_with(Route::currentRouteName(), 'admin.plugins') ? 'active' : '' }}">
                                    <a href="{{ route('admin.plugins') }}">
                                        <i class="fa fa-puzzle-piece" style="color: #c084fc; width: 18px;"></i> <span>Plugins Downloader</span>
                                    </a>
                                </li>
                                <li class="{{ starts_with(Route::currentRouteName(), 'admin.versions') ? 'active' : '' }}">
                                    <a href="{{ route('admin.versions') }}">
                                        <i class="fa fa-download" style="color: #2dd4bf; width: 18px;"></i> <span>Versions Downloader</span>
                                    </a>
                                </li>
                                <li class="{{ starts_with(Route::currentRouteName(), 'admin.tickets') && Route::currentRouteName() !== 'admin.tickets.config' ? 'active' : '' }}">
                                    <a href="{{ route('admin.tickets') }}">
                                        <i class="fa fa-ticket" style="color: #f87171; width: 18px;"></i> <span>Support Tickets</span>
                                    </a>
                                </li>
                                <li class="{{ Route::currentRouteName() === 'admin.tickets.config' ? 'active' : '' }}">
                                    <a href="{{ route('admin.tickets.config') }}">
                                        <i class="fa fa-wrench" style="color: #fb923c; width: 18px;"></i> <span>Tickets Config</span>
                                    </a>
                                </li>
                                <li class="{{ Route::currentRouteName() === 'admin.settings.backups' ? 'active' : '' }}">
                                    <a href="{{ route('admin.settings.backups') }}">
                                        <i class="fa fa-cloud-upload" style="color: #60a5fa; width: 18px;"></i> <span>Universal Backups</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">MANAGEMENT</li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.databases') ?: 'active' }}">
                            <a href="{{ route('admin.databases') }}">
                                <i class="fa fa-database"></i> <span>Databases</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.locations') ?: 'active' }}">
                            <a href="{{ route('admin.locations') }}">
                                <i class="fa fa-globe"></i> <span>Locations</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nodes') ?: 'active' }}">
                            <a href="{{ route('admin.nodes') }}">
                                <i class="fa fa-sitemap"></i> <span>Nodes</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.servers') ?: 'active' }}">
                            <a href="{{ route('admin.servers') }}">
                                <i class="fa fa-server"></i> <span>Servers</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.users') ?: 'active' }}">
                            <a href="{{ route('admin.users') }}">
                                <i class="fa fa-users"></i> <span>Users</span>
                            </a>
                        </li>
                        <li class="header">SERVICE MANAGEMENT</li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.mounts') ?: 'active' }}">
                            <a href="{{ route('admin.mounts') }}">
                                <i class="fa fa-magic"></i> <span>Mounts</span>
                            </a>
                        </li>
                        <li class="{{ ! starts_with(Route::currentRouteName(), 'admin.nests') ?: 'active' }}">
                            <a href="{{ route('admin.nests') }}">
                                <i class="fa fa-th-large"></i> <span>Nests</span>
                            </a>
                        </li>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    @yield('content-header')
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    There was an error validating the data provided.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @foreach (Alert::getMessages() as $type => $messages)
                                @foreach ($messages as $message)
                                    <div class="alert alert-{{ $type }} alert-dismissable" role="alert">
                                        {{ $message }}
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
                    <strong><i class="fa fa-fw {{ $appIsGit ? 'fa-git-square' : 'fa-code-fork' }}"></i></strong> {{ $appVersion }}<br />
                    <strong><i class="fa fa-fw fa-clock-o"></i></strong> {{ round(microtime(true) - (defined('LARAVEL_START') ? LARAVEL_START : microtime(true)), 3) }}s
                </div>
                @if(config('pterodactyl.theme.login_footer'))
                    {{ config('pterodactyl.theme.login_footer') }}
                @else
                    Copyright &copy; 2015 - {{ date('Y') }} <a href="https://pterodactyl.io/" style="color: #818cf8;">Pterodactyl Software</a>.
                @endif
            </footer>
        </div>
        @section('footer-scripts')
            <script src="/js/keyboard.polyfill.js" type="application/javascript"></script>
            <script>keyboardeventKeyPolyfill.polyfill();</script>

            {!! Theme::js('vendor/jquery/jquery.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/sweetalert/sweetalert.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap/bootstrap.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/slimscroll/jquery.slimscroll.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/adminlte/app.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/bootstrap-notify/bootstrap-notify.min.js?t={cache-version}') !!}
            {!! Theme::js('vendor/select2/select2.full.min.js?t={cache-version}') !!}
            {!! Theme::js('js/admin/functions.js?t={cache-version}') !!}
            <script src="/js/autocomplete.js" type="application/javascript"></script>

            @if(Auth::user()->root_admin)
                <script>
                    $('#logoutButton').on('click', function (event) {
                        event.preventDefault();

                        var that = this;
                        swal({
                            title: 'Do you want to log out?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d9534f',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Log out'
                        }, function () {
                             $.ajax({
                                type: 'POST',
                                url: '{{ route('auth.logout') }}',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },complete: function () {
                                    window.location.href = '{{route('auth.login')}}';
                                }
                        });
                    });
                });
                </script>
            @endif

            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();

                    // Bulletproof Smooth Ptero Plugins Accordion Toggle
                    $('#ptero-plugins-toggle-btn').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var $li = $('#ptero-plugins-li');
                        var $menu = $('#ptero-plugins-submenu');
                        var $chevron = $li.find('.ptero-chevron');

                        if ($li.hasClass('menu-open')) {
                            $menu.stop(true, true).slideUp(250, function() {
                                $li.removeClass('menu-open active');
                                $chevron.css('transform', 'rotate(0deg)');
                            });
                        } else {
                            $li.addClass('menu-open active');
                            $chevron.css('transform', 'rotate(-90deg)');
                            $menu.stop(true, true).slideDown(250);
                        }
                    });
                });
            </script>
        @show
    </body>
</html>
