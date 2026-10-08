@extends('layouts.admin')

@section('page_title', 'Message Detail')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.messages.index') }}" style="color: rgba(255,255,255,0.5); text-decoration: none; font-size: 0.875rem;">
            ← Back to Messages
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.05em; margin: 0;">
                Message Detail
            </h1>
            <div style="display: flex; gap: 0.5rem;">
                @if(!$message->is_read)
                    <form action="{{ route('admin.messages.mark-read', $message) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="admin-btn" style="padding: 0.5rem 1rem; font-size: 0.75rem;">
                            Mark as Read
                        </button>
                    </form>
                @endif
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
        </div>
    </div>

    {{-- Message Header --}}
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">
                    {{ $message->subject }}
                </h2>
                <div style="display: flex; align-items: center; gap: 1rem; color: rgba(255,255,255,0.5); font-size: 0.875rem;">
                    <span>From: <strong style="color: #ffffff;">{{ $message->name }}</strong></span>
                    <span>•</span>
                    <span>{{ $message->email }}</span>
                    <span>•</span>
                    <span>{{ $message->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div>
                @if($message->is_read)
                    <span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(16,185,129,0.1); color: #10b981;">
                        Read
                    </span>
                @else
                    <span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; background: rgba(239,68,68,0.1); color: #ef4444;">
                        Unread
                    </span>
                @endif
            </div>
        </div>

        @if($message->budget || $message->timeline)
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
                @if($message->budget)
                    <div>
                        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 0.5rem;">
                            Budget
                        </div>
                        <div style="font-weight: 600;">{{ $message->budget }}</div>
                    </div>
                @endif
                @if($message->timeline)
                    <div>
                        <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 0.5rem;">
                            Timeline
                        </div>
                        <div style="font-weight: 600;">{{ $message->timeline }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Message Content --}}
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
            Message
        </h3>
        <div style="color: rgba(255,255,255,0.8); line-height: 1.8; font-size: 0.9375rem; white-space: pre-wrap;">
            {{ $message->message }}
        </div>
    </div>

    {{-- Reply Section --}}
    <div class="admin-card">
        <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1.5rem;">
            Reply
        </h3>

        @if($message->reply)
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 4px; padding: 1rem; margin-bottom: 1.5rem;">
                <div style="color: rgba(255,255,255,0.4); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 0.5rem;">
                    Previous Reply ({{ $message->replied_at?->format('d M Y, H:i') }})
                </div>
                <div style="color: rgba(255,255,255,0.7); line-height: 1.7; white-space: pre-wrap;">
                    {{ $message->reply }}
                </div>
            </div>
        @endif

        <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label class="admin-label">Your Reply</label>
                <textarea name="reply" rows="6" required class="admin-textarea" placeholder="Write your reply here...">{{ old('reply', $message->reply) }}</textarea>
                @error('reply')
                    <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    Send Reply
                </button>
            </div>
        </form>

        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" 
               class="admin-btn" 
               style="width: 100%; text-align: center;">
                Open in Email Client
            </a>
        </div>
    </div>

    {{-- Technical Details --}}
    <div class="admin-card" style="margin-top: 1.5rem;">
        <h3 style="font-size: 0.875rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 1rem;">
            Technical Details
        </h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.875rem;">
            <div>
                <div style="color: rgba(255,255,255,0.4); margin-bottom: 0.25rem;">IP Address</div>
                <div>{{ $message->ip_address ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="color: rgba(255,255,255,0.4); margin-bottom: 0.25rem;">User Agent</div>
                <div style="color: rgba(255,255,255,0.6); font-size: 0.75rem; word-break: break-all;">
                    {{ $message->user_agent ?? 'N/A' }}
                </div>
            </div>
            <div>
                <div style="color: rgba(255,255,255,0.4); margin-bottom: 0.25rem;">Received At</div>
                <div>{{ $message->created_at->format('d M Y, H:i:s') }}</div>
            </div>
            <div>
                <div style="color: rgba(255,255,255,0.4); margin-bottom: 0.25rem;">Read At</div>
                <div>{{ $message->read_at?->format('d M Y, H:i:s') ?? 'Not read yet' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection