@extends('layouts.admin')

@section('title')
    Nodes &rarr; New
@endsection

@section('content-header')
    <h1>Create Node<small>Easily add a new server node with automated 1-line deployment.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li class="active">New</li>
    </ol>
@endsection

@section('content')
<style>
    /* Responsive Enhancements for Create Node */
    .node-header-callout {
        background: #1e293b !important;
        border-left: 4px solid #3b82f6 !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12) !important;
        padding: 16px 20px !important;
        margin-bottom: 20px !important;
    }
    .node-header-callout-inner {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .node-header-icon {
        font-size: 30px;
        color: #60a5fa;
        flex-shrink: 0;
    }
    .node-card {
        border-radius: 8px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06) !important;
        border: 1px solid rgba(0,0,0,0.06) !important;
        margin-bottom: 20px !important;
    }
    .preset-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }
    .preset-pill-btn {
        flex: 1 1 calc(16.66% - 6px);
        min-width: 68px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        border: 1px solid #d2d6de;
        background: #f8fafc;
        color: #334155;
        transition: all 0.15s ease-in-out;
    }
    .preset-pill-btn:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }
    .preset-pill-btn.active-preset {
        background: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #2563eb !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.35);
    }
    .sub-preset-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 6px;
    }
    .sub-preset-btn {
        flex: 1 1 auto;
        min-height: 28px;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid #d2d6de;
        background: #f1f5f9;
        color: #475569;
        transition: all 0.15s ease-in-out;
    }
    .sub-preset-btn:hover {
        background: #e2e8f0;
    }
    .proxy-flex-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .node-action-bar {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: 1px solid rgba(0,0,0,0.06);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 10px;
        margin-bottom: 30px;
    }
    .select2-container {
        width: 100% !important;
    }

    /* Mobile Compatibility (< 768px) */
    @media (max-width: 767px) {
        .node-header-callout-inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .node-header-icon {
            font-size: 24px;
        }
        .preset-pill-btn {
            flex: 1 1 calc(33.33% - 6px);
            min-width: 60px;
            height: 38px;
            font-size: 12.5px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }
        .proxy-flex-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .proxy-flex-row button {
            width: 100%;
            text-align: center;
            margin-top: 4px;
        }
    }
</style>

<!-- Automated Deployment Guidance Banner -->
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info node-header-callout">
            <div class="node-header-callout-inner">
                <div class="node-header-icon"><i class="fa fa-bolt"></i></div>
                <div>
                    <h4 style="margin: 0 0 5px 0; font-weight: 600; color: #f8fafc; font-size: 16px;">Universal 1-Line Automated Node Deployment Ready</h4>
                    <p style="margin: 0; color: #cbd5e1; font-size: 13px; line-height: 1.5;">
                        Once you create this node, you can immediately copy the ready-to-run <strong>1-Line Auto Deploy command</strong> from the <em>Configuration</em> tab.
                        It automatically checks your OS, installs Docker, downloads Wings daemon, configures systemd, and brings the node online with <strong>zero manual configuration</strong>!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.nodes.new') }}" method="POST" id="createNodeForm">
    <div class="row">
        <!-- LEFT COLUMN: Node Information & Networking -->
        <div class="col-md-6 col-xs-12">
            <!-- Basic Details Box -->
            <div class="box box-primary node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-server text-primary"></i> Basic Details</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label font-weight-bold">Node Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="pName" class="form-control" placeholder="e.g. Node 01 - Germany or Main Production VPS" value="{{ old('name') }}" required/>
                        <p class="text-muted small" style="margin-top: 4px;">Allowed characters: <code>a-zA-Z0-9_.-</code> and <code>[Space]</code> (1 to 100 characters).</p>
                    </div>

                    <div class="form-group">
                        <label for="pDescription" class="form-label">Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="description" id="pDescription" rows="2" class="form-control" placeholder="Short description or notes about this node...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="pLocationId" class="form-label font-weight-bold">Location <span class="text-danger">*</span></label>
                                <select name="location_id" id="pLocationId" class="form-control" style="width: 100%;">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }} @if($location->long)({{ $location->long }})@endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label font-weight-bold">Node Visibility</label>
                                <div>
                                    <div class="radio radio-success radio-inline" style="margin-top: 5px;">
                                        <input type="radio" id="pPublicTrue" value="1" name="public" {{ old('public', '1') == '1' ? 'checked' : '' }}>
                                        <label for="pPublicTrue"><strong>Public</strong></label>
                                    </div>
                                    <div class="radio radio-danger radio-inline" style="margin-top: 5px;">
                                        <input type="radio" id="pPublicFalse" value="0" name="public" {{ old('public') == '0' ? 'checked' : '' }}>
                                        <label for="pPublicFalse"><strong>Private</strong></label>
                                    </div>
                                </div>
                                <p class="text-muted small" style="margin-top: 4px;">Public allows automatic server deployments to this node.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Network & Connection Box -->
            <div class="box box-info node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe text-info"></i> Network & Connection</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pFQDN" class="form-label font-weight-bold">FQDN / Domain or IP Address <span class="text-danger">*</span></label>
                        <input type="text" name="fqdn" id="pFQDN" class="form-control" placeholder="e.g. node.example.com or 123.45.67.89" value="{{ old('fqdn') }}" required/>
                        <p class="text-muted small" id="fqdnHelpText" style="margin-top: 4px;">
                            Enter a domain name (recommended for SSL) or a server IP address.
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-label font-weight-bold">Communicate Over SSL (Scheme)</label>
                        <div style="margin-bottom: 6px;">
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" {{ old('scheme', 'https') === 'https' ? 'checked' : '' }}>
                                <label for="pSSLTrue"><strong>HTTPS (SSL Connection)</strong></label>
                            </div>
                            <div class="radio radio-warning radio-inline">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" {{ old('scheme') === 'http' ? 'checked' : '' }}>
                                <label for="pSSLFalse"><strong>HTTP (Raw IP / Direct)</strong></label>
                            </div>
                        </div>
                        <p class="text-muted small" id="sslNotice">
                            Select <strong>HTTPS</strong> when using a domain with SSL. Select <strong>HTTP</strong> if connecting directly via a raw IP address.
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="form-label font-weight-bold">Behind Proxy / Cloudflare</label>
                        <div class="proxy-flex-row">
                            <div>
                                <div class="radio radio-default radio-inline">
                                    <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ old('behind_proxy', '0') == '0' ? 'checked' : '' }}>
                                    <label for="pProxyFalse"><strong>Not Behind Proxy</strong></label>
                                </div>
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ old('behind_proxy') == '1' ? 'checked' : '' }}>
                                    <label for="pProxyTrue"><strong>Behind Proxy (Cloudflare)</strong></label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-xs btn-default" id="applyCloudflarePresetBtn">
                                <i class="fa fa-cloud text-primary"></i> 1-Click Cloudflare Preset (Port 8443)
                            </button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">
                            Enable if running behind Cloudflare or reverse proxy to bypass local SSL certificate checks.
                        </p>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="pDaemonListen" class="form-label font-weight-bold">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="{{ old('daemonListen', '8080') }}" required/>
                            <p class="text-muted small" style="margin-top: 4px;">Default: <code>8080</code> (or <code>8443</code> for Cloudflare).</p>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="pDaemonSFTP" class="form-label font-weight-bold">SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="{{ old('daemonSFTP', '2022') }}" required/>
                            <p class="text-muted small" style="margin-top: 4px;">Default: <code>2022</code> (must not conflict with SSH).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: System Resources & Storage -->
        <div class="col-md-6 col-xs-12">
            <!-- Memory (RAM) Box -->
            <div class="box box-success node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-microchip text-success"></i> Memory (RAM) Allocation</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pMemory" class="form-label font-weight-bold">Total Memory</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" placeholder="e.g. 8192" value="{{ old('memory', '8192') }}" required/>
                            <span class="input-group-addon font-weight-bold">MiB</span>
                        </div>
                        <!-- Responsive Quick Click RAM Presets -->
                        <div class="preset-pill-container">
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="2048">2 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="4096">4 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn active-preset" data-val="8192">8 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="16384">16 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="32768">32 GB</button>
                            <button type="button" class="preset-pill-btn ram-preset-btn" data-val="65536">64 GB</button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pMemoryOverallocate" class="form-label font-weight-bold">Memory Over-Allocation</label>
                        <div class="input-group">
                            <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate', '0') }}" required/>
                            <span class="input-group-addon font-weight-bold">%</span>
                        </div>
                        <div class="sub-preset-container">
                            <button type="button" class="sub-preset-btn ram-over-btn" data-val="0">0% (Strict)</button>
                            <button type="button" class="sub-preset-btn ram-over-btn" data-val="10">10%</button>
                            <button type="button" class="sub-preset-btn ram-over-btn" data-val="25">25%</button>
                            <button type="button" class="sub-preset-btn ram-over-btn" data-val="-1">Unlimited (-1)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Set to <code>0</code> to strictly disallow overallocating memory. Set to <code>-1</code> to disable limit checks.</p>
                    </div>
                </div>
            </div>

            <!-- Disk Space Box -->
            <div class="box box-warning node-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-hdd-o text-warning"></i> Disk Storage Allocation</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pDisk" class="form-label font-weight-bold">Total Disk Space</label>
                        <div class="input-group">
                            <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" placeholder="e.g. 51200" value="{{ old('disk', '51200') }}" required/>
                            <span class="input-group-addon font-weight-bold">MiB</span>
                        </div>
                        <!-- Responsive Quick Click Disk Presets -->
                        <div class="preset-pill-container">
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="10240">10 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="25600">25 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn active-preset" data-val="51200">50 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="102400">100 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="256000">250 GB</button>
                            <button type="button" class="preset-pill-btn disk-preset-btn" data-val="512000">500 GB</button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pDiskOverallocate" class="form-label font-weight-bold">Disk Over-Allocation</label>
                        <div class="input-group">
                            <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate', '0') }}" required/>
                            <span class="input-group-addon font-weight-bold">%</span>
                        </div>
                        <div class="sub-preset-container">
                            <button type="button" class="sub-preset-btn disk-over-btn" data-val="0">0% (Strict)</button>
                            <button type="button" class="sub-preset-btn disk-over-btn" data-val="10">10%</button>
                            <button type="button" class="sub-preset-btn disk-over-btn" data-val="25">25%</button>
                            <button type="button" class="sub-preset-btn disk-over-btn" data-val="-1">Unlimited (-1)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Set to <code>0</code> to strictly disallow overallocating disk. Set to <code>-1</code> to disable limit checks.</p>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pDaemonBase" class="form-label font-weight-bold">Daemon Storage Directory</label>
                        <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="{{ old('daemonBase', '/var/lib/pterodactyl/volumes') }}" required/>
                        <div class="sub-preset-container">
                            <button type="button" class="sub-preset-btn" onclick="$('#pDaemonBase').val('/var/lib/pterodactyl/volumes');">Standard (/var/lib/pterodactyl/volumes)</button>
                            <button type="button" class="sub-preset-btn" onclick="$('#pDaemonBase').val('/home/daemon-data');">OVH Path (/home/daemon-data)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Standard directory where game server files and volumes will be stored.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESPONSIVE SUBMIT ACTIONS -->
    <div class="row">
        <div class="col-xs-12">
            <div class="node-action-bar">
                <div>
                    <a href="{{ route('admin.nodes') }}" class="btn btn-default btn-lg"><i class="fa fa-arrow-left"></i> Back to Nodes</a>
                </div>
                <div>
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-lg" style="font-weight: 600; padding: 12px 28px; box-shadow: 0 4px 12px rgba(46, 204, 113, 0.35); border-radius: 6px;">
                        <i class="fa fa-check-circle"></i> Create Node &amp; Continue to 1-Line Deploy
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

            // RAM overallocation presets
            $('.ram-over-btn').on('click', function(e) {
                e.preventDefault();
                $('#pMemoryOverallocate').val($(this).data('val'));
            });

            // Disk presets click handler
            $('.disk-preset-btn').on('click', function(e) {
                e.preventDefault();
                var val = $(this).data('val');
                $('#pDisk').val(val);
                $('.disk-preset-btn').removeClass('active-preset');
                $(this).addClass('active-preset');
            });

            // Disk overallocation presets
            $('.disk-over-btn').on('click', function(e) {
                e.preventDefault();
                $('#pDiskOverallocate').val($(this).data('val'));
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
                    $('#fqdnHelpText').html('<span class="text-warning"><i class="fa fa-info-circle"></i> IP address detected. Switched to <strong>HTTP</strong> connection mode (raw IPs cannot use SSL).</span>');
                } else if (val.indexOf('.') !== -1) {
                    $('#fqdnHelpText').html('<span class="text-success"><i class="fa fa-check-circle"></i> Domain name detected. Using <strong>HTTPS</strong> SSL connection.</span>');
                }
            });
        });
    </script>
@endsection
