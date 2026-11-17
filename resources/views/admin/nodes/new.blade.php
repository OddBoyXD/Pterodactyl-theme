@extends('layouts.admin')

@section('title')
    Nodes &rarr; New
@endsection

@section('content-header')
    <h1>Create Node<small>Easily add a new server node with automated deployment.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
<style>
    /* 100% Theme-Matched Dark Styling for Create Node */
    .node-mode-selector {
        display: flex;
        background: #151521;
        border: 1px solid #2b2b40;
        border-radius: 10px;
        padding: 4px;
        margin-bottom: 20px;
        gap: 6px;
    }
    .node-mode-btn {
        flex: 1;
        padding: 12px 16px;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #94a3b8;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .node-mode-btn:hover {
        color: #f1f5f9;
        background: rgba(255, 255, 255, 0.04);
    }
    .node-mode-btn.active-mode {
        background: #6366f1 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 10px rgba(99, 102, 241, 0.4);
    }
    .node-card {
        background: #1e1e2d !important;
        border: 1px solid #2b2b40 !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
        margin-bottom: 20px !important;
        color: #e2e8f0 !important;
    }
    .node-card .box-header {
        border-bottom: 1px solid #2b2b40 !important;
        padding: 14px 18px !important;
    }
    .node-card .box-title {
        color: #f8fafc !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .node-card .box-body {
        padding: 18px !important;
    }
    .node-card label.form-label {
        color: #cbd5e1 !important;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .node-card .form-control {
        background: #151521 !important;
        border: 1px solid #323248 !important;
        color: #f8fafc !important;
        border-radius: 6px !important;
        height: 40px;
        box-shadow: none !important;
    }
    .node-card .form-control:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25) !important;
    }
    .node-card .input-group-addon {
        background: #252738 !important;
        border: 1px solid #323248 !important;
        color: #94a3b8 !important;
        font-weight: 600;
    }
    .preset-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    .preset-pill-btn {
        flex: 1 1 calc(16.66% - 8px);
        min-width: 70px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        border: 1px solid #323248;
        background: #252738;
        color: #cbd5e1;
        transition: all 0.15s ease-in-out;
    }
    .preset-pill-btn:hover {
        background: #2e3046;
        color: #ffffff;
        border-color: #4b4e6d;
    }
    .preset-pill-btn.active-preset {
        background: #6366f1 !important;
        color: #ffffff !important;
        border-color: #818cf8 !important;
        box-shadow: 0 0 12px rgba(99, 102, 241, 0.45);
    }
    .sub-preset-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }
    .sub-preset-btn {
        flex: 1 1 auto;
        min-height: 32px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #323248;
        background: #252738;
        color: #94a3b8;
        transition: all 0.15s ease-in-out;
    }
    .sub-preset-btn:hover {
        background: #2e3046;
        color: #f1f5f9;
    }
    .node-action-bar {
        background: #1e1e2d;
        border: 1px solid #2b2b40;
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 10px;
        margin-bottom: 30px;
    }
    .btn-create-node {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 12px 28px !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35) !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }
    .btn-create-node:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        color: #ffffff !important;
    }
    .btn-cancel-node {
        background: #252738 !important;
        border: 1px solid #323248 !important;
        color: #cbd5e1 !important;
        font-weight: 600 !important;
        padding: 12px 20px !important;
        border-radius: 8px !important;
    }
    .btn-cancel-node:hover {
        background: #2e3046 !important;
        color: #ffffff !important;
    }
    .select2-container--default .select2-selection--single {
        background-color: #151521 !important;
        border: 1px solid #323248 !important;
        height: 40px !important;
        border-radius: 6px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f8fafc !important;
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
    }
    .select2-dropdown {
        background-color: #1e1e2d !important;
        border: 1px solid #323248 !important;
        color: #f8fafc !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #6366f1 !important;
    }
    .select2-container {
        width: 100% !important;
    }

    /* Mobile Responsive Optimizations (< 768px) */
    @media (max-width: 767px) {
        .node-mode-selector {
            flex-direction: column;
        }
        .node-mode-btn {
            width: 100%;
            height: 44px;
        }
        .preset-pill-btn {
            flex: 1 1 calc(33.33% - 8px);
            min-width: 65px;
            height: 42px;
            font-size: 13px;
        }
        .node-action-bar {
            flex-direction: column-reverse;
            padding: 16px 14px;
            gap: 12px;
        }
        .node-action-bar > div {
            width: 100%;
        }
        .node-action-bar .btn {
            width: 100%;
            height: 48px;
            justify-content: center;
        }
    }
</style>

<!-- Mode Selector Tabs: Quick Setup vs Advanced Setup -->
<div class="row">
    <div class="col-xs-12">
        <div class="node-mode-selector">
            <button type="button" class="node-mode-btn active-mode" id="quickModeBtn" onclick="switchMode('quick');">
                <i class="fa fa-bolt" style="color: #fbbf24;"></i> Quick Setup (Automated Defaults)
            </button>
            <button type="button" class="node-mode-btn" id="advancedModeBtn" onclick="switchMode('advanced');">
                <i class="fa fa-sliders" style="color: #60a5fa;"></i> Advanced / Custom Setup
            </button>
        </div>
    </div>
</div>

<form action="{{ route('admin.nodes.new') }}" method="POST" id="createNodeForm">
    {!! csrf_field() !!}

    <div class="row">
        <!-- LEFT COLUMN: Server Details & Networking -->
        <div class="col-md-6 col-xs-12">
            <!-- Basic Details Card -->
            <div class="box node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-server" style="color: #6366f1;"></i> Node Information</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Node Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="pName" class="form-control" placeholder="e.g. Node 01 - Germany" value="{{ old('name') }}" required/>
                        <p class="text-muted small" style="margin-top: 4px; color: #94a3b8 !important;">Allowed: <code>a-zA-Z0-9_.-</code> and <code>[Space]</code> (1 to 100 characters).</p>
                    </div>

                    <div class="form-group">
                        <label for="pLocationId" class="form-label">Location <span class="text-danger">*</span></label>
                        <select name="location_id" id="pLocationId" class="form-control" style="width: 100%;">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }} @if($location->long)({{ $location->long }})@endif</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pFQDN" class="form-label">Server IP Address or Domain <span class="text-danger">*</span></label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" placeholder="e.g. 123.45.67.89 or node.yourdomain.com" value="{{ old('fqdn') }}" required/>
                        <p class="text-muted small" id="fqdnHelpText" style="margin-top: 4px; color: #94a3b8 !important;">
                            Enter your VPS public IP address or domain name.
                        </p>
                    </div>

                    <!-- ADVANCED-ONLY: Description & Visibility -->
                    <div class="advanced-field" style="display: none;">
                        <div class="form-group">
                            <label for="pDescription" class="form-label">Description <small class="text-muted">(Optional)</small></label>
                            <textarea name="description" id="pDescription" rows="2" class="form-control" placeholder="Server specifications, host provider, or notes...">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Node Visibility</label>
                            <div>
                                <label style="margin-right: 16px; cursor: pointer;">
                                    <input type="radio" id="pPublicTrue" value="1" name="public" {{ old('public', '1') == '1' ? 'checked' : '' }}>
                                    <span style="color: #10b981; font-weight: 600;">Public</span> (Auto-Deploy Enabled)
                                </label>
                                <label style="cursor: pointer;">
                                    <input type="radio" id="pPublicFalse" value="0" name="public" {{ old('public') == '0' ? 'checked' : '' }}>
                                    <span style="color: #ef4444; font-weight: 600;">Private</span> (Admin Only)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ADVANCED-ONLY: Network Protocols & Ports -->
            <div class="box node-card advanced-field" style="display: none;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe" style="color: #38bdf8;"></i> Advanced Network Settings</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="form-label">SSL Connection (Scheme)</label>
                        <div>
                            <label style="margin-right: 16px; cursor: pointer;">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" {{ old('scheme', 'https') === 'https' ? 'checked' : '' }}>
                                <span style="font-weight: 600;">HTTPS</span> (SSL Domain)
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" {{ old('scheme') === 'http' ? 'checked' : '' }}>
                                <span style="font-weight: 600;">HTTP</span> (Raw IP / Direct)
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Behind Cloudflare / Proxy</label>
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                            <div>
                                <label style="margin-right: 14px; cursor: pointer;">
                                    <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ old('behind_proxy', '0') == '0' ? 'checked' : '' }}>
                                    Direct (No Proxy)
                                </label>
                                <label style="cursor: pointer;">
                                    <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ old('behind_proxy') == '1' ? 'checked' : '' }}>
                                    Behind Proxy (Cloudflare)
                                </label>
                            </div>
                            <button type="button" class="btn btn-xs sub-preset-btn" id="applyCloudflarePresetBtn">
                                <i class="fa fa-cloud" style="color: #38bdf8;"></i> Set Cloudflare Port (8443)
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="pDaemonListen" class="form-label">Daemon Port</label>
                                <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="{{ old('daemonListen', '8080') }}" required/>
                                <p class="text-muted small" style="margin-top: 4px; color: #94a3b8 !important;">Default: <code>8080</code> (or <code>8443</code> for Cloudflare).</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="pDaemonSFTP" class="form-label">SFTP Port</label>
                                <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="{{ old('daemonSFTP', '2022') }}" required/>
                                <p class="text-muted small" style="margin-top: 4px; color: #94a3b8 !important;">Default: <code>2022</code>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: RAM & Storage Resources -->
        <div class="col-md-6 col-xs-12">
            <!-- Memory (RAM) Card -->
            <div class="box node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-microchip" style="color: #10b981;"></i> RAM Allocation</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pMemory" class="form-label">Total Server RAM</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" placeholder="8192" value="{{ old('memory', '8192') }}" required/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <!-- Responsive RAM Presets -->
                        <div class="preset-pill-container">
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="2048">2 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="4096">4 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn active-preset" data-val="8192">8 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="16384">16 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="32768">32 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="65536">64 GB</button>
                        </div>
                    </div>

                    <!-- ADVANCED-ONLY: RAM Over-Allocation -->
                    <div class="form-group advanced-field" style="display: none; margin-top: 15px;">
                        <label for="pMemoryOverallocate" class="form-label">Memory Over-Allocation</label>
                        <div class="input-group">
                            <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate', '0') }}" required/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <div class="sub-preset-container">
                            <button type="button" class="sub-preset-btn" onclick="$('#pMemoryOverallocate').val('0');">0% (Strict)</button>
                            <button type="button" class="sub-preset-btn" onclick="$('#pMemoryOverallocate').val('10');">10%</button>
                            <button type="button" class="sub-preset-btn" onclick="$('#pMemoryOverallocate').val('25');">25%</button>
                            <button type="button" class="sub-preset-btn" onclick="$('#pMemoryOverallocate').val('-1');">Unlimited (-1)</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disk Storage Card -->
            <div class="box node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-hdd-o" style="color: #f59e0b;"></i> SSD / Disk Storage</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pDisk" class="form-label">Total Disk Space</label>
                        <div class="input-group">
                            <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" placeholder="51200" value="{{ old('disk', '51200') }}" required/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <!-- Responsive Disk Presets -->
                        <div class="preset-pill-container">
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="10240">10 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="25600">25 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn active-preset" data-val="51200">50 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="102400">100 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="256000">250 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="512000">500 GB</button>
                        </div>
                    </div>

                    <!-- ADVANCED-ONLY: Disk Over-Allocation & Path -->
                    <div class="advanced-field" style="display: none;">
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="pDiskOverallocate" class="form-label">Disk Over-Allocation</label>
                            <div class="input-group">
                                <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate', '0') }}" required/>
                                <span class="input-group-addon">%</span>
                            </div>
                            <div class="sub-preset-container">
                                <button type="button" class="sub-preset-btn" onclick="$('#pDiskOverallocate').val('0');">0% (Strict)</button>
                                <button type="button" class="sub-preset-btn" onclick="$('#pDiskOverallocate').val('10');">10%</button>
                                <button type="button" class="sub-preset-btn" onclick="$('#pDiskOverallocate').val('-1');">Unlimited (-1)</button>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 15px;">
                            <label for="pDaemonBase" class="form-label">Storage Directory</label>
                            <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="{{ old('daemonBase', '/var/lib/pterodactyl/volumes') }}" required/>
                            <div class="sub-preset-container">
                                <button type="button" class="sub-preset-btn" onclick="$('#pDaemonBase').val('/var/lib/pterodactyl/volumes');">Standard (/var/lib/pterodactyl/volumes)</button>
                                <button type="button" class="sub-preset-btn" onclick="$('#pDaemonBase').val('/home/daemon-data');">OVH Path (/home/daemon-data)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE BOTTOM ACTION BAR -->
    <div class="row">
        <div class="col-xs-12">
            <div class="node-action-bar">
                <div>
                    <a href="{{ route('admin.nodes') }}" class="btn btn-cancel-node"><i class="fa fa-arrow-left"></i> Back to Nodes</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-create-node">
                        <i class="fa fa-bolt"></i> Create Node &amp; Generate Direct Command
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
        function switchMode(mode) {
            if (mode === 'advanced') {
                $('.advanced-field').stop(true, true).slideDown(200);
                $('#advancedModeBtn').addClass('active-mode');
                $('#quickModeBtn').removeClass('active-mode');
            } else {
                $('.advanced-field').stop(true, true).slideUp(200);
                $('#quickModeBtn').addClass('active-mode');
                $('#advancedModeBtn').removeClass('active-mode');
            }
        }

        $(document).ready(function() {
            $('#pLocationId').select2();

            // RAM presets click handler
            $('.ram-preset-btn').on('click', function(e) {
                e.preventDefault();
                var val = $(this).data('val');
                $('#pMemory').val(val);
                $('.ram-preset-btn').removeClass('active-preset');
                $(this).addClass('active-preset');
            });

            // Disk presets click handler
            $('.disk-preset-btn').on('click', function(e) {
                e.preventDefault();
                var val = $(this).data('val');
                $('#pDisk').val(val);
                $('.disk-preset-btn').removeClass('active-preset');
                $(this).addClass('active-preset');
            });

            // 1-Click Cloudflare preset
            $('#applyCloudflarePresetBtn').on('click', function(e) {
                e.preventDefault();
                $('#pProxyTrue').prop('checked', true);
                $('#pDaemonListen').val('8443');
                $('#pSSLTrue').prop('checked', true);
                alert('Cloudflare preset applied: Port set to 8443, Behind Proxy enabled!');
            });

            // Auto-detect IP vs Domain on FQDN typing
            var ipRegex = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/;
            $('#pFQDN').on('input', function() {
                var val = $(this).val().trim();
                if (ipRegex.test(val)) {
                    $('#pSSLFalse').prop('checked', true);
                    $('#fqdnHelpText').html('<span style="color: #fbbf24;"><i class="fa fa-info-circle"></i> IP address detected. Switched to <strong>HTTP</strong> connection mode.</span>');
                } else if (val.indexOf('.') !== -1) {
                    $('#pSSLTrue').prop('checked', true);
                    $('#fqdnHelpText').html('<span style="color: #34d399;"><i class="fa fa-check-circle"></i> Domain name detected. Using <strong>HTTPS</strong> SSL connection.</span>');
                }
            });
        });
    </script>
@endsection
