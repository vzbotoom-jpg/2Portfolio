{{-- resources/views/emails/contact.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>

    {{-- Gmail / Outlook structured data for a card-style preview --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MessageCard",
        "heading": "New message from {{ $data['name'] }}",
        "description": "{{ Str::limit($data['message'], 100) }}",
        "dateSent": "{{ now()->toIso8601String() }}",
        "sender": {
            "@type": "Person",
            "name": "{{ $data['name'] }}",
            "email": "{{ $data['email'] }}"
        },
        "potentialAction": [
            {
                "@type": "ViewAction",
                "name": "View message",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "{{ route('contact.index') }}",
                    "actionPlatform": "http://schema.org/DesktopWebPlatform"
                }
            }
        ]
    }
    </script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #fafafa;
            color: #18181b;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        /* Outer "envelope" frame */
        .envelope {
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            overflow: hidden;
            margin: 32px 20px;
        }

        /* Header */
        .email-header {
            padding: 28px 32px 24px;
            border-bottom: 1px solid #ededed;
        }

        .header-logo {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.18em;
            color: #a1a1aa;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .header-title {
            font-size: 19px;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: #18181b;
        }

        .header-subtitle {
            font-size: 13px;
            color: #71717a;
            margin-top: 4px;
        }

        /* Body */
        .email-body {
            padding: 28px 32px 8px;
        }

        /* Sender info, displayed as a simple key/value list (no card chrome) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .info-table td {
            padding: 7px 0;
            font-size: 13px;
            vertical-align: top;
        }

        .info-table .info-label {
            width: 84px;
            color: #a1a1aa;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            font-size: 11px;
            padding-top: 9px;
        }

        .info-table .info-value {
            color: #27272a;
        }

        .info-table .info-value a {
            color: #18181b;
            text-decoration: none;
            border-bottom: 1px solid #d4d4d8;
        }

        /* Message block */
        .message-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: #a1a1aa;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .message-box {
            background: #fafafa;
            border: 1px solid #ededed;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 28px;
        }

        .message-content {
            font-size: 14px;
            color: #3f3f46;
            line-height: 1.7;
            white-space: pre-wrap;
        }

        /* Actions */
        .button-group {
            padding-bottom: 28px;
        }

        .btn-primary {
            display: inline-block;
            padding: 11px 22px;
            background: #18181b;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
        }

        .btn-secondary {
            display: inline-block;
            padding: 11px 22px;
            background: #ffffff;
            color: #3f3f46 !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e4e4e7;
            border-radius: 6px;
            margin-left: 8px;
        }

        /* Footer */
        .email-footer {
            padding: 16px 32px 24px;
            border-top: 1px solid #ededed;
        }

        .email-footer p {
            font-size: 12px;
            color: #a1a1aa;
            margin: 2px 0;
        }

        @media (max-width: 480px) {
            .envelope { margin: 16px 8px; }
            .email-header, .email-body, .email-footer { padding-left: 20px; padding-right: 20px; }
            .btn-secondary { margin-left: 0; margin-top: 8px; display: block; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="envelope">

            {{-- Header --}}
            <div class="email-header">
                <div class="header-logo">THELUXS.DEV</div>
                <div class="header-title">New message received</div>
                <div class="header-subtitle">Sent via the contact form on your portfolio</div>
            </div>

            {{-- Body --}}
            <div class="email-body">

                <table class="info-table" role="presentation">
                    <tr>
                        <td class="info-label">From</td>
                        <td class="info-value">{{ $data['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td class="info-value">
                            <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Subject</td>
                        <td class="info-value">{{ $data['subject'] }}</td>
                    </tr>
                    @if(!empty($data['budget']))
                    <tr>
                        <td class="info-label">Budget</td>
                        <td class="info-value">{{ $data['budget'] }}</td>
                    </tr>
                    @endif
                    @if(!empty($data['timeline']))
                    <tr>
                        <td class="info-label">Timeline</td>
                        <td class="info-value">{{ $data['timeline'] }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="info-label">Date</td>
                        <td class="info-value">{{ now()->format('F j, Y \a\t g:i A') }}</td>
                    </tr>
                </table>

                <div class="message-label">Message</div>
                <div class="message-box">
                    <div class="message-content">{{ $data['message'] }}</div>
                </div>

                <div class="button-group">
                    <a href="mailto:{{ $data['email'] }}?subject={{ rawurlencode('Re: ' . $data['subject']) }}&body={{ rawurlencode('Hi ' . $data['name'] . ",\n\n") }}"
                       class="btn-primary">
                        Reply to {{ $data['name'] }}
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn-secondary">
                        View all messages
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="email-footer">
                <p>This message was sent from the contact form on your portfolio website.</p>
                <p>&copy; {{ date('Y') }} THELUXS.DEV &middot; All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>