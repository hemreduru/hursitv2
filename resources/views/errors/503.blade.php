<!DOCTYPE html>
<html class="dark" lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex" />
    <title>Bakım Modu · Hurşit Emre Duru</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #135bec;
            --bg: #101622;
            --bg-grad: #0b101a;
            --card: #161e2c;
            --border: #232f48;
            --text: #ffffff;
            --text-muted: #94a3b8;
        }
        @media (prefers-color-scheme: light) {
            :root:not(.dark) {
                --bg: #f6f6f8;
                --bg-grad: #eef0f4;
                --card: #ffffff;
                --border: #e2e8f0;
                --text: #0f172a;
                --text-muted: #475569;
            }
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: radial-gradient(ellipse at top, var(--bg-grad), var(--bg));
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            min-height: 100dvh;
            position: relative;
            overflow: hidden;
        }
        body::before, body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 480px; height: 480px;
            background: var(--primary);
            top: -180px; left: -120px;
        }
        body::after {
            width: 420px; height: 420px;
            background: #7c3aed;
            bottom: -160px; right: -120px;
            opacity: 0.25;
        }
        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 560px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 24px 60px -20px rgba(0,0,0,0.5);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border: 1px solid var(--border);
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 28px;
            background: rgba(255,255,255,0.02);
        }
        .badge .dot {
            width: 8px; height: 8px;
            background: var(--primary);
            border-radius: 50%;
            animation: pulse 1.8s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.45; transform: scale(0.8); }
        }
        .icon-wrap {
            width: 72px; height: 72px;
            margin: 0 auto 24px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, rgba(19,91,236,0.18), rgba(124,58,237,0.18));
            border: 1px solid var(--border);
            border-radius: 18px;
        }
        .icon-wrap svg {
            width: 36px; height: 36px;
            color: var(--primary);
            animation: spin 6s linear infinite;
        }
        @keyframes spin { from { transform: rotate(0); } to { transform: rotate(360deg); } }
        h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
        }
        p.lead {
            font-size: 16px;
            line-height: 1.6;
            color: var(--text-muted);
            margin-bottom: 28px;
        }
        .meta {
            display: inline-block;
            font-family: "JetBrains Mono", ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 12px;
            color: var(--text-muted);
            padding: 8px 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 8px;
        }
        .footer {
            position: relative;
            z-index: 1;
            margin-top: 24px;
            font-size: 13px;
            color: var(--text-muted);
            text-align: center;
        }
        .footer a { color: var(--text-muted); text-decoration: none; }
        .footer a:hover { color: var(--primary); }
        @media (max-width: 480px) {
            .card { padding: 36px 24px; }
            h1 { font-size: 24px; }
        }
    </style>
    <script>
        try {
            if (localStorage.theme === 'light') document.documentElement.classList.remove('dark');
        } catch (e) {}
    </script>
</head>
<body>
    <div>
        <div class="card">
            <span class="badge"><span class="dot"></span>Maintenance in progress</span>
            <div class="icon-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                </svg>
            </div>
            <h1>Site üzerinde kısa bir çalışma yapıyorum</h1>
            <p class="lead">
                Şu anda küçük bir güncelleme yapıyorum, birkaç dakika içinde her şeyi hazır edeceğim.
                Uğradığın için teşekkür ederim — birazdan görüşmek üzere.
            </p>
            @isset($exception)
                @if($exception->getMessage())
                    <span class="meta">{{ $exception->getMessage() }}</span>
                @endif
            @endisset
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Hurşit Emre Duru &middot;
            <a href="mailto:hemreduru@gmail.com">hemreduru@gmail.com</a>
        </div>
    </div>
</body>
</html>
