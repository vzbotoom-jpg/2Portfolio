@extends('layouts.admin')

@section('page_title', 'Contact Messages')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.25rem; font-weight: 700; letter-spacing: 0.05em; margin: 0;">
            Contact Messages
        </h2>
        <p style="color: rgba(255,255,255,0.4); font-size: 0.875rem; margin: 0.25rem 0 0;">
            Pesan yang masuk dari form kontak
        </p>
    </div>
</div>

{{-- Stats --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Total
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">
            {{ $stats['total'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Unread
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #ef4444;">
            {{ $stats['unread'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Read
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">
            {{ $stats['read'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            Today
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #3b82f6;">
            {{ $stats['today'] }}
        </div>
    </div>
    <div class="admin-card">
        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase;">
            This Week
        </div>
        <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">
            {{ $stats['this_week'] }}
        </div>
    </div>
</div>

{{-- Filter/Search --}}
<div class="admin-card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('admin.messages.index') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label class="admin-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="admin-input" placeholder="Search messages...">
        </div>
        <div>
            <label class="admin-label">Status</label>
            <select name="status" class="admin-input" onchange="this.form.submit()">
                <option value="">All Messages</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
            </select>
        </div>
        <div>
            <label class="admin-label">From Date</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="admin-input">
        </div>
        <div>
            <label class="admin-label">To Date</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="admin-input">
        </div>
        <button type="submit" class="admin-btn">Filter</button>
    </form>
</div>

{{-- Messages Table --}}
<div class="admin-card" style="padding: 0; overflow: hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Date</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr style="{{ !$message->is_read ? 'background: rgba(239,68,68,0.02);' : '' }}">
                <td>
                    <div>
                        <div style="font-weight: 600;">{{ $message->name }}</div>
                        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">
                            {{ $message->email }}
                        </div>
                        @if($message->budget)
                            <div style="color: rgba(255,255,255,0.3); font-size: 0.75rem; margin-top: 0.25rem;">
                                Budget: {{ $message->budget }}
                            </div>
                        @endif
                    </div>
                </td>
                <td style="max-width: 200px;">
                    <div style="font-weight: 600; font-size: 0.875rem;">{{ $message->subject }}</div>
                </td>
                <td style="max-width: 300px;">
                    <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; line-height: 1.5;">
                        {{ Str::limit($message->message, 100) }}
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.875rem;">{{ $message->created_at->format('d M Y') }}</div>
                    <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem;">{{ $message->created_at->format('H:i') }}</div>
                </td>
                <td>
                    @if($message->is_read)
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(16,185,129,0.1); color: #10b981;">
                            Read
                        </span>
                    @else
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(239,68,68,0.1); color: #ef4444;">
                            Unread
                        </span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.messages.show', $message) }}" class="admin-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                            View
                        </a>
                        <form action="{{ route('admin.messages.destroy', $message) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 3rem; color: rgba(255,255,255,0.3);">
                    No messages found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($messages->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $messages->links() }}
</div>
@endif
@endsection