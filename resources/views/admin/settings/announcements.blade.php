@extends("layouts.admin")

@section("title")
    Announcements & Notifications
@endsection

@section("content-header")
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 800; color: #fff;">
                <i class="fa fa-bullhorn" style="color: #c084fc; margin-right: 8px;"></i>Announcements & Notifications
            </h1>
            <p style="margin: 4px 0 0 0; color: #94a3b8; font-size: 13px;">Create and broadcast alerts, news, and notifications to all client dashboards.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newAnnouncementModal" style="background: linear-gradient(135deg, #9333ea, #6366f1); border: none; padding: 8px 18px; border-radius: 10px; font-weight: 700; box-shadow: 0 4px 14px rgba(147, 51, 234, 0.35);">
                <i class="fa fa-plus" style="margin-right: 6px;"></i> New Announcement
            </button>
        </div>
    </div>
@endsection

@section("content")
    <!-- Quick Statistics -->
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" style="background: #111625; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
                <span class="info-box-icon" style="background: rgba(192, 132, 252, 0.15); color: #c084fc; border-radius: 10px; margin: 10px;">
                    <i class="fa fa-bullhorn"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Total Announcements</span>
                    <span class="info-box-number" style="color: #fff; font-size: 22px; font-weight: 800;">{{ $totalCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" style="background: #111625; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
                <span class="info-box-icon" style="background: rgba(52, 211, 153, 0.15); color: #34d399; border-radius: 10px; margin: 10px;">
                    <i class="fa fa-check-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Active Broadcasts</span>
                    <span class="info-box-number" style="color: #34d399; font-size: 22px; font-weight: 800;">{{ $activeCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box" style="background: #111625; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
                <span class="info-box-icon" style="background: rgba(244, 63, 94, 0.15); color: #fb7185; border-radius: 10px; margin: 10px;">
                    <i class="fa fa-bell"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text" style="color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Client Bell Notifications</span>
                    <span class="info-box-number" style="color: #fff; font-size: 14px; font-weight: 600; margin-top: 5px;">Synchronized Live</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List Table -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="background: #111625; border: 1px solid rgba(255,255,255,0.07); border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
                <div class="box-header" style="border-bottom: 1px solid rgba(255,255,255,0.06); padding: 16px 20px;">
                    <h3 class="box-title" style="color: #fff; font-weight: 700; font-size: 16px;">
                        <i class="fa fa-list" style="color: #c084fc; margin-right: 6px;"></i> All Broadcast Announcements
                    </h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(0,0,0,0.15);">
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;">Status</th>
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;">Category</th>
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;">Title & Content</th>
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;">Action Button</th>
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px;">Created</th>
                                <th style="padding: 14px 20px; color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.8px; text-align: right;">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $announcement)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle;">
                                    <td style="padding: 16px 20px; vertical-align: middle;">
                                        @if($announcement->is_active)
                                            <span class="label" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 11px;">
                                                <i class="fa fa-circle" style="font-size: 8px; margin-right: 4px;"></i> Active
                                            </span>
                                        @else
                                            <span class="label" style="background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); padding: 5px 10px; border-radius: 8px; font-weight: 600; font-size: 11px;">
                                                Draft / Hidden
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; vertical-align: middle;">
                                        @if($announcement->category === 'update')
                                            <span class="label" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 6px; padding: 4px 8px;">
                                                <i class="fa fa-rocket" style="margin-right: 3px;"></i> Update
                                            </span>
                                        @elseif($announcement->category === 'warning')
                                            <span class="label" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 6px; padding: 4px 8px;">
                                                <i class="fa fa-exclamation-triangle" style="margin-right: 3px;"></i> Warning
                                            </span>
                                        @elseif($announcement->category === 'danger')
                                            <span class="label" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 4px 8px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 3px;"></i> Critical
                                            </span>
                                        @else
                                            <span class="label" style="background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 6px; padding: 4px 8px;">
                                                <i class="fa fa-info-circle" style="margin-right: 3px;"></i> Info
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; vertical-align: middle; max-width: 380px;">
                                        <div style="font-weight: 700; color: #fff; font-size: 14px; margin-bottom: 4px;">{{ $announcement->title }}</div>
                                        <div style="color: #94a3b8; font-size: 12px; line-height: 1.4; max-height: 38px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ strip_tags($announcement->content) }}
                                        </div>
                                    </td>
                                    <td style="padding: 16px 20px; vertical-align: middle;">
                                        @if($announcement->action_url)
                                            <a href="{{ $announcement->action_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-xs btn-default" style="border-radius: 8px; border-color: rgba(255,255,255,0.15); background: rgba(255,255,255,0.05); color: #c084fc;">
                                                <i class="fa fa-external-link" style="margin-right: 4px;"></i> {{ $announcement->action_text ?: 'Open Link' }}
                                            </a>
                                        @else
                                            <span style="color: #64748b; font-size: 12px;">None</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 20px; vertical-align: middle; color: #94a3b8; font-size: 12px; white-space: nowrap;">
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </td>
                                    <td style="padding: 16px 20px; vertical-align: middle; text-align: right; white-space: nowrap;">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.announcements.toggle', $announcement->id) }}" method="POST" style="display: inline-block; margin-right: 6px;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $announcement->is_active ? 'btn-warning' : 'btn-success' }}" style="border-radius: 8px; padding: 5px 10px;" title="{{ $announcement->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="fa {{ $announcement->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal-{{ $announcement->id }}" style="border-radius: 8px; padding: 5px 10px; margin-right: 6px;" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.announcements.delete', $announcement->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px; padding: 5px 10px;" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-{{ $announcement->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" style="background: #111625; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; color: #cbd5e1; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                                            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08); padding: 18px 24px;">
                                                    <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.7;">&times;</button>
                                                    <h4 class="modal-title" style="font-weight: 700; color: #fff;">
                                                        <i class="fa fa-pencil" style="color: #38bdf8; margin-right: 6px;"></i> Edit Announcement #{{ $announcement->id }}
                                                    </h4>
                                                </div>
                                                <div class="modal-body" style="padding: 24px;">
                                                    <div class="form-group">
                                                        <label class="control-label" style="color: #cbd5e1;">Announcement Title</label>
                                                        <input type="text" name="title" class="form-control" value="{{ $announcement->title }}" required style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" style="color: #cbd5e1;">Category & Accent Type</label>
                                                        <select name="category" class="form-control" style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                                            <option value="info" {{ $announcement->category === 'info' ? 'selected' : '' }}>Info (Purple / Blue Accent)</option>
                                                            <option value="update" {{ $announcement->category === 'update' ? 'selected' : '' }}>Update & News (Emerald Green Accent)</option>
                                                            <option value="warning" {{ $announcement->category === 'warning' ? 'selected' : '' }}>Warning (Amber Yellow Accent)</option>
                                                            <option value="danger" {{ $announcement->category === 'danger' ? 'selected' : '' }}>Critical / Maintenance (Rose Red Accent)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label" style="color: #cbd5e1;">Message / Content (Markdown & HTML Supported)</label>
                                                        <textarea name="content" class="form-control" rows="4" required style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px;">{{ $announcement->content }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" style="color: #cbd5e1;">Action Button Text (Optional)</label>
                                                                <input type="text" name="action_text" class="form-control" value="{{ $announcement->action_text }}" placeholder="e.g. Join Discord, Read More" style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label" style="color: #cbd5e1;">Action Button URL (Optional)</label>
                                                                <input type="url" name="action_url" class="form-control" value="{{ $announcement->action_url }}" placeholder="https://..." style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="margin-bottom: 0;">
                                                        <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; color: #fff; font-weight: 500;">
                                                            <input type="checkbox" name="is_active" value="1" {{ $announcement->is_active ? 'checked' : '' }} style="width: 16px; height: 16px;">
                                                            Broadcast immediately (Active)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08); padding: 16px 24px;">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #38bdf8, #6366f1); border: none; border-radius: 10px; font-weight: 700; padding: 7px 18px;">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px 20px; color: #64748b;">
                                        <i class="fa fa-bullhorn" style="font-size: 32px; color: #334155; margin-bottom: 12px; display: block;"></i>
                                        No announcements created yet. Click <strong>"New Announcement"</strong> above to broadcast your first notification!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($announcements->hasPages())
                    <div class="box-footer" style="background: transparent; border-top: 1px solid rgba(255,255,255,0.06); padding: 12px 20px;">
                        {{ $announcements->render() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Announcement Modal -->
    <div class="modal fade" id="newAnnouncementModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: #111625; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; color: #cbd5e1; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                <form action="{{ route('admin.announcements.store') }}" method="POST">
                    @csrf
                    <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08); padding: 18px 24px;">
                        <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.7;">&times;</button>
                        <h4 class="modal-title" style="font-weight: 700; color: #fff;">
                            <i class="fa fa-bullhorn" style="color: #c084fc; margin-right: 6px;"></i> Create New Announcement
                        </h4>
                    </div>
                    <div class="modal-body" style="padding: 24px;">
                        <div class="form-group">
                            <label class="control-label" style="color: #cbd5e1;">Announcement Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Scheduled Node Maintenance / New Features Released" required style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label" style="color: #cbd5e1;">Category & Accent Type</label>
                            <select name="category" class="form-control" style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                <option value="info">Info (Purple / Blue Accent)</option>
                                <option value="update" selected>Update & News (Emerald Green Accent)</option>
                                <option value="warning">Warning (Amber Yellow Accent)</option>
                                <option value="danger">Critical / Maintenance (Rose Red Accent)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" style="color: #cbd5e1;">Message / Content (Markdown & HTML Supported)</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Write your announcement details here..." required style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px;"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="color: #cbd5e1;">Action Button Text (Optional)</label>
                                    <input type="text" name="action_text" class="form-control" placeholder="e.g. Join Community" style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="color: #cbd5e1;">Action Button URL (Optional)</label>
                                    <input type="url" name="action_url" class="form-control" placeholder="https://..." style="background: #0b0f19; border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 10px; height: 42px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; color: #fff; font-weight: 500;">
                                <input type="checkbox" name="is_active" value="1" checked style="width: 16px; height: 16px;">
                                Broadcast immediately (Active)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08); padding: 16px 24px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #9333ea, #6366f1); border: none; border-radius: 10px; font-weight: 700; padding: 7px 18px;">Publish Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
