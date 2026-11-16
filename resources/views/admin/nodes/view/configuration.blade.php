@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Configuration
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>Automated deployment and daemon configuration.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nodes</a></li>
        <li><a href="{{ route('admin.nodes.view', $node->id) }}">{{ $node->name }}</a></li>
        <li class="active">Configuration</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.nodes.view', $node->id) }}">About</a></li>
                <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}">Settings</a></li>
                <li class="active"><a href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocation</a></li>
                <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}">Servers</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bolt"></i> 1-Line Universal Automated Node Deployer (Zero Manual Setup)</h3>
            </div>
            <div class="box-body">
                <p>
                    Run this command on your remote server (Ubuntu, Debian, AlmaLinux, CentOS, Rocky Linux).
                    It will <strong>automatically check and install Docker</strong>, download the latest Wings daemon, configure systemd, register this node to your panel, and start the service with zero manual intervention required.
                </p>
                <div class="input-group">
                    <input type="text" id="autoDeployCmd" class="form-control input-lg" readonly value="Click 'Generate Deployment Command' below to generate your ready-to-run 1-line command..." style="font-family: monospace; font-size: 13px; background: #1e1e2d; color: #a6e22e; border: 1px solid #323248;">
                    <span class="input-group-btn">
                        <button type="button" id="copyDeployCmdBtn" class="btn btn-success btn-lg" style="display:none;" onclick="navigator.clipboard.writeText($('#autoDeployCmd').val()); alert('Copied 1-line deploy command to clipboard!');"><i class="fa fa-copy"></i> Copy</button>
                    </span>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" id="configTokenBtn" class="btn btn-success"><i class="fa fa-magic"></i> Generate 1-Line Deployment Command</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text-o"></i> Manual Configuration File (<code>config.yml</code>)</h3>
            </div>
            <div class="box-body">
                <pre class="no-margin" style="max-height: 380px; overflow-y: auto;">{{ $node->getYamlConfiguration() }}</pre>
            </div>
            <div class="box-footer">
                <p class="no-margin">For manual setups, place this content in <code>/etc/pterodactyl/config.yml</code> on the node.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-refresh"></i> 1-Click Wings Auto-Updater</h3>
            </div>
            <div class="box-body">
                <p class="text-muted small">
                    Already have Wings running? Run this single command on the node anytime to update Wings to the latest version in 5 seconds with zero downtime:
                </p>
                <div class="input-group">
                    <input type="text" id="wingsUpdateCmd" class="form-control" readonly value="curl -sSL https://invmc.in/t/wings-update | sudo bash" style="font-family: monospace; font-size: 11px;">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-sm" onclick="navigator.clipboard.writeText($('#wingsUpdateCmd').val()); alert('Copied update command!');"><i class="fa fa-copy"></i></button>
                    </span>
                </div>
            </div>
            <div class="box-footer">
                <small class="text-muted">Gracefully stops Wings, downloads the latest release binary, and restarts the service.</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#configTokenBtn').on('click', function (event) {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');
        $.ajax({
            method: 'POST',
            url: '{{ route('admin.nodes.view.configuration.token', $node->id) }}',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        }).done(function (data) {
            $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Re-generate Token');
            var fullCmd = 'curl -sSL https://invmc.in/t/node-deploy | sudo bash -s -- --panel {{ config('app.url') }} --node ' + data.node + ' --token ' + data.token;
            $('#autoDeployCmd').val(fullCmd);
            $('#copyDeployCmdBtn').show();

            swal({
                type: 'success',
                title: 'Deployment Command Ready!',
                text: '<p style="text-align:left;margin-bottom:8px;"><strong>1. Universal 1-Line Automated Install (Docker + Wings + Service):</strong></p>' +
                      '<pre style="text-align:left;font-size:11px;background:#1e1e2d;color:#a6e22e;padding:10px;word-break:break-all;">' + fullCmd + '</pre>' +
                      '<p style="text-align:left;margin-top:12px;margin-bottom:8px;"><strong>2. Standard Wings CLI Configure (If Wings is already installed):</strong></p>' +
                      '<pre style="text-align:left;font-size:11px;padding:10px;word-break:break-all;">cd /etc/pterodactyl && sudo wings configure --panel-url {{ config('app.url') }} --token ' + data.token + ' --node ' + data.node + '{{ config('app.debug') ? ' --allow-insecure' : '' }}</pre>',
                html: true
            });
        }).fail(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-magic"></i> Generate 1-Line Deployment Command');
            swal({
                title: 'Error',
                text: 'Something went wrong while generating your node token.',
                type: 'error'
            });
        });
    });
    </script>
@endsection
