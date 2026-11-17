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
<!-- Automated Deployment Guidance Banner -->
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info" style="background-color: #1e293b !important; border-left-color: #3b82f6 !important; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <div style="display: flex; align-items: center;">
                <div style="font-size: 28px; margin-right: 15px; color: #60a5fa;"><i class="fa fa-bolt"></i></div>
                <div>
                    <h4 style="margin: 0 0 5px 0; font-weight: 600; color: #f8fafc;">Universal 1-Line Automated Node Deployment Ready</h4>
                    <p style="margin: 0; color: #cbd5e1; font-size: 13px;">
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
        <div class="col-md-6">
            <!-- Basic Details Box -->
            <div class="box box-primary" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pLocationId" class="form-label font-weight-bold">Location <span class="text-danger">*</span></label>
                                <select name="location_id" id="pLocationId" class="form-control">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }} @if($location->long)({{ $location->long }})@endif</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
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
            <div class="box box-info" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
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
                        <div>
                            <div class="radio radio-default radio-inline">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ old('behind_proxy', '0') == '0' ? 'checked' : '' }}>
                                <label for="pProxyFalse"><strong>Not Behind Proxy</strong></label>
                            </div>
                            <div class="radio radio-primary radio-inline">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ old('behind_proxy') == '1' ? 'checked' : '' }}>
                                <label for="pProxyTrue"><strong>Behind Proxy (Cloudflare)</strong></label>
                            </div>
                            <button type="button" class="btn btn-xs btn-default pull-right" id="applyCloudflarePresetBtn" style="margin-top: 2px;">
                                <i class="fa fa-cloud text-primary"></i> 1-Click Cloudflare Preset (Port 8443)
                            </button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">
                            Enable if running behind Cloudflare or reverse proxy to bypass local SSL certificate checks.
                        </p>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="pDaemonListen" class="form-label font-weight-bold">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="{{ old('daemonListen', '8080') }}" required/>
                            <p class="text-muted small" style="margin-top: 4px;">Default: <code>8080</code> (or <code>8443</code> for Cloudflare).</p>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="pDaemonSFTP" class="form-label font-weight-bold">SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="{{ old('daemonSFTP', '2022') }}" required/>
                            <p class="text-muted small" style="margin-top: 4px;">Default: <code>2022</code> (must not conflict with SSH).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: System Resources & Storage -->
        <div class="col-md-6">
            <!-- Memory (RAM) Box -->
            <div class="box box-success" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
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
                        <!-- Quick Click RAM Presets -->
                        <div style="margin-top: 8px;">
                            <span class="text-muted small font-weight-bold" style="margin-right: 6px;">Quick Presets:</span>
                            <button type="button" class="btn btn-xs btn-default ram-preset-btn" data-val="2048">2 GB</button>
                            <button type="button" class="btn btn-xs btn-default ram-preset-btn" data-val="4096">4 GB</button>
                            <button type="button" class="btn btn-xs btn-primary ram-preset-btn" data-val="8192">8 GB</button>
                            <button type="button" class="btn btn-xs btn-default ram-preset-btn" data-val="16384">16 GB</button>
                            <button type="button" class="btn btn-xs btn-default ram-preset-btn" data-val="32768">32 GB</button>
                            <button type="button" class="btn btn-xs btn-default ram-preset-btn" data-val="65536">64 GB</button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pMemoryOverallocate" class="form-label font-weight-bold">Memory Over-Allocation</label>
                        <div class="input-group">
                            <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate', '0') }}" required/>
                            <span class="input-group-addon font-weight-bold">%</span>
                        </div>
                        <div style="margin-top: 6px;">
                            <span class="text-muted small font-weight-bold" style="margin-right: 6px;">Presets:</span>
                            <button type="button" class="btn btn-xs btn-default ram-over-btn" data-val="0">0% (Strict)</button>
                            <button type="button" class="btn btn-xs btn-default ram-over-btn" data-val="10">10%</button>
                            <button type="button" class="btn btn-xs btn-default ram-over-btn" data-val="25">25%</button>
                            <button type="button" class="btn btn-xs btn-default ram-over-btn" data-val="-1">Unlimited (-1)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Set to <code>0</code> to strictly disallow overallocating memory. Set to <code>-1</code> to disable limit checks.</p>
                    </div>
                </div>
            </div>

            <!-- Disk Space Box -->
            <div class="box box-warning" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
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
                        <!-- Quick Click Disk Presets -->
                        <div style="margin-top: 8px;">
                            <span class="text-muted small font-weight-bold" style="margin-right: 6px;">Quick Presets:</span>
                            <button type="button" class="btn btn-xs btn-default disk-preset-btn" data-val="10240">10 GB</button>
                            <button type="button" class="btn btn-xs btn-default disk-preset-btn" data-val="25600">25 GB</button>
                            <button type="button" class="btn btn-xs btn-primary disk-preset-btn" data-val="51200">50 GB</button>
                            <button type="button" class="btn btn-xs btn-default disk-preset-btn" data-val="102400">100 GB</button>
                            <button type="button" class="btn btn-xs btn-default disk-preset-btn" data-val="256000">250 GB</button>
                            <button type="button" class="btn btn-xs btn-default disk-preset-btn" data-val="512000">500 GB</button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pDiskOverallocate" class="form-label font-weight-bold">Disk Over-Allocation</label>
                        <div class="input-group">
                            <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate', '0') }}" required/>
                            <span class="input-group-addon font-weight-bold">%</span>
                        </div>
                        <div style="margin-top: 6px;">
                            <span class="text-muted small font-weight-bold" style="margin-right: 6px;">Presets:</span>
                            <button type="button" class="btn btn-xs btn-default disk-over-btn" data-val="0">0% (Strict)</button>
                            <button type="button" class="btn btn-xs btn-default disk-over-btn" data-val="10">10%</button>
                            <button type="button" class="btn btn-xs btn-default disk-over-btn" data-val="25">25%</button>
                            <button type="button" class="btn btn-xs btn-default disk-over-btn" data-val="-1">Unlimited (-1)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Set to <code>0</code> to strictly disallow overallocating disk. Set to <code>-1</code> to disable limit checks.</p>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="pDaemonBase" class="form-label font-weight-bold">Daemon Storage Directory</label>
                        <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="{{ old('daemonBase', '/var/lib/pterodactyl/volumes') }}" required/>
                        <div style="margin-top: 6px;">
                            <button type="button" class="btn btn-xs btn-default" onclick="$('#pDaemonBase').val('/var/lib/pterodactyl/volumes');">Standard Path (/var/lib/pterodactyl/volumes)</button>
                            <button type="button" class="btn btn-xs btn-default" onclick="$('#pDaemonBase').val('/home/daemon-data');">OVH Path (/home/daemon-data)</button>
                        </div>
                        <p class="text-muted small" style="margin-top: 4px;">Standard directory where game server files and volumes will be stored.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SUBMIT ACTIONS -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); background: #ffffff;">
                <div class="box-body" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px;">
                    <div>
                        <a href="{{ route('admin.nodes') }}" class="btn btn-default btn-lg"><i class="fa fa-arrow-left"></i> Back to Nodes</a>
                    </div>
                    <div>
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-success btn-lg" style="font-weight: 600; padding: 10px 24px; box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);">
                            <i class="fa fa-check-circle"></i> Create Node &amp; Continue to 1-Line Deploy
                        </button>
                    </div>
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
            $('.ram-preset-btn').on('click', function() {
                var val = $(this).data('val');
                $('#pMemory').val(val);
                $('.ram-preset-btn').removeClass('btn-primary').addClass('btn-default');
                $(this).removeClass('btn-default').addClass('btn-primary');
            });

            // RAM overallocation presets
            $('.ram-over-btn').on('click', function() {
                $('#pMemoryOverallocate').val($(this).data('val'));
            });

            // Disk presets click handler
            $('.disk-preset-btn').on('click', function() {
                var val = $(this).data('val');
                $('#pDisk').val(val);
                $('.disk-preset-btn').removeClass('btn-primary').addClass('btn-default');
                $(this).removeClass('btn-default').addClass('btn-primary');
            });

            // Disk overallocation presets
            $('.disk-over-btn').on('click', function() {
                $('#pDiskOverallocate').val($(this).data('val'));
            });

            // 1-Click Cloudflare preset
            $('#applyCloudflarePresetBtn').on('click', function() {
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
