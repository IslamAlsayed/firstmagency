@push('styles')
    <style>
        .profile-shell {
            --profile-accent: var(--button_color, #0f766e);
            --profile-secondary: var(--dash_primary_color, #f97316);
            --profile-ink: #0f172a;
            --profile-muted: #64748b;
            --profile-surface: rgba(255, 255, 255, 0.78);
            --profile-line: rgba(148, 163, 184, 0.18);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .profile-hero {
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 1.75rem;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 30%),
                radial-gradient(circle at bottom left, rgba(255, 255, 255, 0.12), transparent 24%),
                linear-gradient(135deg, color-mix(in srgb, var(--profile-accent) 82%, #07111f) 0%, color-mix(in srgb, var(--profile-secondary) 36%, #07111f) 100%);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
        }

        html[lang=ar] .profile-hero {
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.18), transparent 30%),
                radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.12), transparent 24%),
                linear-gradient(225deg, color-mix(in srgb, var(--profile-accent) 82%, #07111f) 0%, color-mix(in srgb, var(--profile-secondary) 36%, #07111f) 100%);
        }

        .profile-hero::before,
        .profile-hero::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            opacity: 0.22;
            pointer-events: none;
        }

        .profile-hero::before {
            width: 14rem;
            height: 14rem;
            inset-inline-end: -3rem;
            top: -5rem;
            background: rgba(255, 255, 255, 0.15);
            animation: profileFloat 9s ease-in-out infinite;
        }

        .profile-hero::after {
            width: 10rem;
            height: 10rem;
            inset-inline-start: -2rem;
            bottom: -3.5rem;
            background: rgba(255, 255, 255, 0.1);
            animation: profileFloat 11s ease-in-out infinite reverse;
        }

        .profile-hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(280px, 0.95fr);
            gap: 1.25rem;
            align-items: start;
        }

        .profile-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.48rem 0.9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .profile-title {
            margin-top: 1rem;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.02;
            font-weight: 900;
        }

        .profile-subtitle {
            max-width: 45rem;
            margin-top: 0.8rem;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.98rem;
        }

        .profile-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-top: 1.2rem;
        }

        .profile-action,
        .profile-action-secondary,
        .profile-danger,
        .profile-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            border-radius: 1rem;
            font-weight: 800;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .profile-action,
        .profile-button {
            padding: 0.85rem 1.05rem;
            color: #fff;
            background: color-mix(in srgb, var(--profile-accent) 88%, #fff 12%);
            box-shadow: 0 14px 30px color-mix(in srgb, var(--profile-accent) 24%, transparent);
        }

        .profile-action-secondary {
            padding: 0.85rem 1.05rem;
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .profile-danger {
            padding: 0.85rem 1.05rem;
            color: #fff;
            background: #dc2626;
            box-shadow: 0 14px 30px rgba(220, 38, 38, 0.22);
        }

        .profile-action:hover,
        .profile-action-secondary:hover,
        .profile-danger:hover,
        .profile-button:hover {
            transform: translateY(-2px);
        }

        .profile-side-card,
        .profile-panel,
        .profile-mini-card,
        .profile-security-list,
        .profile-form-panel {
            border-radius: 1.5rem;
            border: 1px solid var(--profile-line);
            box-shadow: 0 18px 42px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(14px);
        }

        .profile-side-card {
            background: #002959;
        }

        .profile-panel,
        .profile-mini-card,
        .profile-security-list,
        .profile-form-panel {
            background: var(--profile-surface);
        }

        .profile-side-card {
            padding: 1.1rem;
        }

        .profile-avatar-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-avatar,
        .profile-avatar-placeholder {
            width: 5.8rem;
            height: 5.8rem;
            border-radius: 1.6rem;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.16);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.24), rgba(255, 255, 255, 0.08));
        }

        .profile-avatar-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.7rem;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-top: 0.65rem;
            padding: 0.42rem 0.78rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .profile-mini-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .profile-mini-card {
            padding: 0.9rem;
            background: rgba(255, 255, 255, 0.08);
        }

        .profile-mini-card span {
            display: block;
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.76);
            margin-bottom: 0.35rem;
        }

        .profile-mini-card strong {
            display: block;
            font-size: 1rem;
            line-height: 1.25;
            color: #fff;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(320px, 0.85fr);
            gap: 1.4rem;
        }

        .profile-panel,
        .profile-form-panel {
            padding: 1.25rem;
        }

        .profile-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .profile-panel-title {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .profile-panel-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            background: color-mix(in srgb, var(--profile-accent) 14%, white);
            color: var(--profile-accent);
            box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--profile-accent) 14%, transparent);
        }

        .profile-panel-title h2,
        .profile-panel-title h3,
        .profile-panel-title h4 {
            margin: 0;
            color: var(--profile-ink);
            font-size: 1.02rem;
            font-weight: 900;
        }

        .profile-panel-title p {
            margin: 0.18rem 0 0;
            color: var(--profile-muted);
            font-size: 0.84rem;
        }

        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .profile-info-card {
            border-radius: 1.15rem;
            padding: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 252, 0.82));
        }

        .profile-info-card span {
            display: block;
            color: var(--profile-muted);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.45rem;
        }

        .profile-info-card strong,
        .profile-info-card .profile-value {
            color: var(--profile-ink);
            font-weight: 800;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .profile-rich-block {
            margin-top: 1rem;
            border-radius: 1.2rem;
            padding: 1rem 1.05rem;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: #fff;
        }

        .profile-list {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .profile-list-item {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem;
            border-radius: 1.1rem;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.85), rgba(255, 255, 255, 0.98));
        }

        .profile-list-item small {
            display: block;
            margin-top: 0.22rem;
            color: var(--profile-muted);
        }

        .profile-state-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.78rem;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 800;
        }

        .profile-state-badge.success {
            color: #166534;
            background: #dcfce7;
        }

        .profile-state-badge.warning {
            color: #854d0e;
            background: #fef3c7;
        }

        .profile-state-badge.danger {
            color: #991b1b;
            background: #fee2e2;
        }

        .profile-state-badge.info {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .profile-lang-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
        }

        .profile-lang-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 0.82rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 800;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: #fff;
            color: var(--profile-muted);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .profile-lang-chip.active {
            color: #fff;
            background: var(--profile-accent);
            box-shadow: 0 12px 24px color-mix(in srgb, var(--profile-accent) 22%, transparent);
            border-color: transparent;
        }

        .profile-lang-chip:hover {
            transform: translateY(-2px);
        }

        .profile-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .profile-field {
            position: relative;
        }

        .profile-field.full {
            grid-column: 1 / -1;
        }

        .profile-input,
        .profile-select,
        .profile-textarea,
        .profile-file {
            width: 100%;
            min-height: 4rem;
            border-radius: 1.1rem;
            border: 1px solid #d7dee8;
            background: #fff;
            color: var(--profile-ink);
            padding: 1.25rem 1rem 0.75rem;
            outline: none;
            font-weight: 700;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            text-align: left;
        }

        html[lang=ar] {

            .profile-input,
            .profile-select,
            .profile-textarea,
            .profile-file {
                text-align: right;
            }
        }

        .profile-textarea {
            min-height: 8rem;
            resize: vertical;
        }

        .profile-input:focus,
        .profile-select:focus,
        .profile-textarea:focus,
        .profile-file:focus {
            border-color: color-mix(in srgb, var(--profile-accent) 62%, white);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--profile-accent) 12%, transparent);
        }

        .profile-label {
            position: absolute;
            top: 9px;
            inset-inline-start: 1rem;
            color: var(--profile-muted);
            font-size: 0.75rem;
            font-weight: 800;
            pointer-events: none;
        }

        .profile-help,
        .profile-error {
            margin-top: 0.45rem;
            font-size: 0.78rem;
        }

        .profile-help {
            color: var(--profile-muted);
        }

        .profile-error {
            color: #dc2626;
            font-weight: 700;
        }

        .profile-upload-card {
            display: grid;
            grid-template-columns: minmax(0, 130px) minmax(0, 1fr);
            gap: 1rem;
            align-items: center;
        }

        .profile-upload-preview {
            width: 8rem;
            height: 8rem;
            border-radius: 2rem;
            background: linear-gradient(135deg, color-mix(in srgb, var(--profile-accent) 30%, white), color-mix(in srgb, var(--profile-secondary) 26%, white));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 18px 36px rgba(15, 23, 42, 0.18);
            overflow: hidden;
        }

        .profile-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-security-list {
            padding: 1rem;
        }

        .profile-security-list ul {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .profile-security-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            color: var(--profile-ink);
            font-weight: 700;
        }

        .profile-timeline {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .profile-timeline-item {
            position: relative;
            padding: 1rem 1rem 1rem 3.1rem;
            border-radius: 1.2rem;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.84));
        }

        html[lang=ar] .profile-timeline-item {
            padding: 1rem 3.1rem 1rem 1rem;
        }

        .profile-timeline-item::before {
            content: '';
            position: absolute;
            inset-inline-start: 1.15rem;
            top: 1.2rem;
            width: 0.95rem;
            height: 0.95rem;
            border-radius: 999px;
            background: var(--profile-accent);
            box-shadow: 0 0 0 6px color-mix(in srgb, var(--profile-accent) 16%, transparent);
        }

        .profile-timeline-item::after {
            content: '';
            position: absolute;
            inset-inline-start: 1.57rem;
            top: 2.25rem;
            bottom: -1.2rem;
            width: 2px;
            background: rgba(148, 163, 184, 0.18);
        }

        html[lang=ar] .profile-timeline-item::before {
            inset-inline-start: auto;
            inset-inline-end: 1.15rem;
        }

        html[lang=ar] .profile-timeline-item::after {
            inset-inline-start: auto;
            inset-inline-end: 1.57rem;
        }

        .profile-timeline-item:last-child::after {
            display: none;
        }

        .profile-animate {
            opacity: 0;
            animation: profileRise 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .flash-on-load {
            animation: profilePulse 0.75s ease-in-out 3;
        }

        .profile-delay-1 {
            animation-delay: 0.06s;
        }

        .profile-delay-2 {
            animation-delay: 0.12s;
        }

        .profile-delay-3 {
            animation-delay: 0.18s;
        }

        .profile-delay-4 {
            animation-delay: 0.24s;
        }

        .profile-delay-5 {
            animation-delay: 0.3s;
        }

        @keyframes profileRise {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes profileFloat {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, 14px, 0);
            }
        }

        @keyframes profilePulse {

            0%,
            100% {
                background-color: color-mix(in srgb, var(--profile-accent) 6%, #fff);
            }

            50% {
                background-color: color-mix(in srgb, var(--profile-accent) 14%, #fff);
            }
        }

        @media (max-width: 1100px) {

            .profile-hero-grid,
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {

            .profile-info-grid,
            .profile-form-grid,
            .profile-mini-grid {
                grid-template-columns: 1fr;
            }

            .profile-upload-card {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
            }

            .profile-hero,
            .profile-panel,
            .profile-form-panel,
            .profile-side-card,
            .profile-security-list {
                padding: 1rem;
            }
        }
    </style>
@endpush
