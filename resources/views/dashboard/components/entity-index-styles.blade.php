<style>
    .entity-index-page {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .entity-hero {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        padding: 1.5rem;
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 26%),
            linear-gradient(135deg, color-mix(in srgb, var(--page-accent, var(--icon_color)) 90%, #0f172a) 0%, #0f172a 100%);
        color: #fff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    }

    .entity-hero::after {
        content: '';
        position: absolute;
        inset-inline-end: -2.5rem;
        bottom: -4rem;
        width: 11rem;
        height: 11rem;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.08);
    }

    .entity-hero-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(280px, 0.95fr);
        gap: 1rem;
        align-items: start;
    }

    .entity-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.42rem 0.8rem;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.94);
        font-size: 0.78rem;
        font-weight: 800;
    }

    .entity-hero-title {
        margin-top: 0.95rem;
        font-size: clamp(1.7rem, 3.5vw, 2.45rem);
        line-height: 1.08;
        font-weight: 800;
    }

    .entity-hero-subtitle {
        margin-top: 0.7rem;
        max-width: 42rem;
        color: rgba(255, 255, 255, 0.82);
        font-size: 0.96rem;
    }

    .entity-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.15rem;
    }

    .entity-hero-action {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.82rem 1rem;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-weight: 800;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .entity-hero-action:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.18);
    }

    .entity-hero-side {
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.09);
        padding: 1rem;
        backdrop-filter: blur(8px);
    }

    .entity-hero-side-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .entity-hero-side-item {
        border-radius: 1rem;
        padding: 0.9rem;
        background: rgba(255, 255, 255, 0.08);
    }

    .entity-hero-side-item strong {
        display: block;
        font-size: 1.3rem;
        line-height: 1;
        margin-bottom: 0.35rem;
    }

    .entity-stat-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 1rem;
    }

    .entity-stat-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        border-radius: 1.2rem;
        padding: 1rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
    }

    .entity-stat-card strong {
        display: block;
        margin-top: 0.7rem;
        font-size: 1.8rem;
        line-height: 1;
        color: #0f172a;
    }

    .entity-stat-card span {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .entity-panel {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        border-radius: 1.35rem;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .entity-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
    }

    .entity-panel-title {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .entity-panel-title-icon {
        width: 2.8rem;
        height: 2.8rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        background: color-mix(in srgb, var(--page-accent, var(--icon_color)) 12%, white);
        color: var(--page-accent, var(--icon_color));
    }

    .entity-panel-title h2 {
        margin: 0;
        color: #0f172a;
        font-size: 1.02rem;
        font-weight: 800;
    }

    .entity-panel-title p {
        margin: 0.2rem 0 0;
        color: #64748b;
        font-size: 0.83rem;
    }

    .entity-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
        background: #fff;
    }

    .entity-toolbar-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.75rem;
    }

    .entity-toolbar-group>* {
        min-width: 0;
        max-width: 100%;
    }

    .entity-input,
    .entity-select {
        height: 2.9rem;
        border-radius: 0.95rem;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #0f172a;
        padding: 0 1rem;
        font-weight: 600;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .entity-input {
        min-width: 260px;
    }

    .entity-select {
        min-width: 180px;
    }

    .entity-input:focus,
    .entity-select:focus {
        border-color: color-mix(in srgb, var(--page-accent, var(--icon_color)) 65%, white);
        box-shadow: 0 0 0 4px color-mix(in srgb, var(--page-accent, var(--icon_color)) 12%, transparent);
    }

    .entity-content {
        padding: 0 1.2rem 1.2rem;
    }

    .entity-table-shell {
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        border-radius: 1rem;
        border: 1px solid rgba(148, 163, 184, 0.14);
        background: #fff;
    }

    .entity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .entity-table thead th {
        padding: 1rem;
        text-align: start;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid rgba(148, 163, 184, 0.16);
    }

    .entity-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .entity-table tbody tr:hover {
        background: #f8fafc;
    }

    .entity-table tbody td {
        padding: 1rem;
        vertical-align: top;
        color: #475569;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .entity-primary-text {
        color: #0f172a;
        font-weight: 800;
    }

    .entity-secondary-text {
        margin-top: 0.25rem;
        color: #64748b;
        font-size: 0.8rem;
    }

    .entity-contact-link {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.35rem;
        color: var(--page-accent, var(--icon_color));
        font-size: 0.78rem;
        font-weight: 700;
        max-width: 100%;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .entity-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }

    .entity-empty {
        padding: 2.5rem 1rem;
        text-align: center;
        color: #94a3b8;
        font-weight: 700;
    }

    .entity-pagination {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(148, 163, 184, 0.14);
    }

    /* Compatibility layer: make legacy index pages visually match the new index design. */
    .entity-legacy-index>.flex.flex-wrap.gap-4.mb-6,
    .entity-legacy-index>.grid.grid-cols-3.gap-4.mb-6,
    .w-full>.flex.flex-wrap.gap-4.mb-6,
    .container>.grid.grid-cols-3.gap-4.mb-6,
    .content .card .row.mb-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1rem;
        position: relative;
        overflow: hidden;
        border-radius: 1.35rem;
        padding: 1rem;
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.2), transparent 28%),
            linear-gradient(135deg, color-mix(in srgb, var(--page-accent, var(--icon_color)) 86%, #0f172a) 0%, #0f172a 100%);
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.18);
    }

    .entity-legacy-index>.flex.flex-wrap.gap-4.mb-6>div,
    .entity-legacy-index>.grid.grid-cols-3.gap-4.mb-6>div,
    .w-full>.flex.flex-wrap.gap-4.mb-6>div,
    .container>.grid.grid-cols-3.gap-4.mb-6 .kt-card,
    .content .card .row.mb-4 .info-box {
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(255, 255, 255, 0.12);
        box-shadow: none;
        backdrop-filter: blur(8px);
        color: #fff;
    }

    .entity-legacy-index>.flex.flex-wrap.gap-4.mb-6>div .text-2xl,
    .entity-legacy-index>.grid.grid-cols-3.gap-4.mb-6>div .text-2xl {
        color: #fff !important;
    }

    .entity-legacy-index>.flex.flex-wrap.gap-4.mb-6>div small,
    .entity-legacy-index>.grid.grid-cols-3.gap-4.mb-6>div small {
        color: rgba(255, 255, 255, 0.84) !important;
    }

    .w-full>.bg-white.shadow-lg.radius-lg,
    .container>.kt-card,
    .content .card {
        border-radius: 1.2rem;
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .w-full>.bg-white.shadow-lg.radius-lg>.flex.justify-between.items-center.p-4.border-gray-200,
    .container>.mb-6.flex.items-center.justify-between,
    .content .card .card-header {
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        border-bottom: 1px solid rgba(148, 163, 184, 0.12);
    }

    .w-full .scroll-container table,
    .container .kt-card table,
    .content .card table {
        width: 100%;
        border-collapse: collapse;
    }

    .w-full .scroll-container table thead th,
    .container .kt-card table thead th,
    .content .card table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(148, 163, 184, 0.16);
    }

    .w-full .scroll-container table tbody td,
    .container .kt-card table tbody td,
    .content .card table tbody td {
        border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    }

    .entity-legacy-index .entity-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.16);
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.14), transparent 32%),
            linear-gradient(135deg, color-mix(in srgb, var(--page-accent, var(--icon_color)) 88%, #0f172a) 0%, #0f172a 100%);
        color: #fff;
    }

    .entity-legacy-index .entity-toolbar h5 {
        width: 100%;
        margin: 0;
        color: #fff !important;
        font-size: clamp(1.35rem, 2.6vw, 1.85rem);
        line-height: 1.1;
        font-weight: 800;
    }

    .entity-legacy-index .entity-toolbar h5 i {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .entity-legacy-index .entity-toolbar>.flex.justify-between.items-center.gap-4 {
        width: 100%;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 0.75rem;
        align-items: center;
    }

    .entity-legacy-index .entity-toolbar input[type="text"] {
        height: 2.9rem;
        border-radius: 0.95rem;
        border: 1px solid rgba(255, 255, 255, 0.22);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        width: 100% !important;
        min-width: 0 !important;
        padding-inline: 1rem;
        outline: none;
    }

    .entity-legacy-index .entity-toolbar input[type="text"]::placeholder {
        color: rgba(255, 255, 255, 0.72);
    }

    .entity-legacy-index .entity-toolbar input[type="text"]:focus {
        border-color: rgba(255, 255, 255, 0.38);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.12);
    }

    .entity-legacy-index .entity-table-shell {
        border: 0;
        border-top: 1px solid rgba(148, 163, 184, 0.12);
        border-radius: 0;
    }

    .entity-legacy-index .entity-panel>.border-b.border-gray-200 {
        border-bottom: 0;
    }

    .entity-legacy-index .entity-panel>.border-b.border-gray-200>.flex.justify-start.gap-2.pt-4.flex-wrap.px-4 {
        margin: 0 1rem 1rem;
        padding: 0.75rem;
        border-radius: 1rem;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background: #fff;
    }

    .entity-legacy-index .entity-pagination {
        margin-top: 0;
        padding: 1rem 1.2rem;
    }

    @media (max-width: 1280px) {
        .entity-stat-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 980px) {
        .entity-toolbar {
            align-items: stretch;
        }

        .entity-toolbar-group {
            width: 100%;
        }

        .entity-input,
        .entity-select {
            width: 100%;
            min-width: 0;
        }

        .entity-legacy-index>.flex.flex-wrap.gap-4.mb-6,
        .entity-legacy-index>.grid.grid-cols-3.gap-4.mb-6 {
            grid-template-columns: 1fr;
        }

        .entity-legacy-index .entity-toolbar>.flex.justify-between.items-center.gap-4 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {

        .entity-hero-grid,
        .entity-stat-grid {
            grid-template-columns: 1fr;
        }

        .entity-hero {
            padding: 1.2rem;
        }

        .entity-panel-header,
        .entity-toolbar,
        .entity-content {
            padding-inline: 1rem;
        }

        .entity-table thead {
            display: none;
        }

        .entity-table,
        .entity-table tbody,
        .entity-table tr,
        .entity-table td {
            display: block;
            width: 100%;
        }

        .entity-table tbody tr {
            padding: 0.4rem 0;
        }

        .entity-table tbody td {
            padding: 0.75rem 0.85rem;
            border-bottom: 0;
        }

        .entity-table-shell {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            border: 0;
            background: transparent;
        }

        .entity-table tbody tr {
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }
    }

    @media (max-width: 425px) {
        .entity-hero-side-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
