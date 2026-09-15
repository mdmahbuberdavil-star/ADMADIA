<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMADIA Pro: Advanced Integrated Affiliate Network Management Platform | Comprehensive Advertiser Portal & Performance Analytics Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <style>
        :root {
            --bg-dark: #f4f6f9;
            --sidebar-bg: #ffffff;
            --card-bg: #ffffff;
            --border-color: #e4e6ef;
            --text-main: #3f4254;
            --text-muted: #7e8299;
            --hover-bg: rgba(54, 153, 255, 0.1);
            --clicks-color: #FF4D4D;
            --leads-color: #9B59B6;
            --earn-color: #FFC107;
            --epc-color: #2ECC71;
            --graph-dark-bg: #2C3E50;
            --graph-blue-bg: #1E90FF;
            --admin-color: #8950fc;
            --card-radius: 5px;
        }
        body.dark-theme {
            --bg-dark: #121212;
            --sidebar-bg: #1e1e2d;
            --card-bg: #1e1e2d;
            --border-color: #2b2b40;
            --text-main: #e0e0e0;
            --text-muted: #a1a1aa;
            --hover-bg: rgba(255, 255, 255, 0.05);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-main); display: flex; min-height: 100vh; overflow-x: hidden; transition: background-color 0.3s, color 0.3s; }

        .auth-wrapper { width: 100%; display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #181c32; padding: 20px; }
        .auth-container { width: 100%; max-width: 480px; background: #1e1e2d; border: 1px solid #2b2b40; padding: 30px; border-radius: var(--card-radius); box-shadow: 0 4px 15px rgba(0,0,0,0.3); color: #fff; }
        .auth-container.wide { max-width: 700px; }
        .auth-container h2 { margin-bottom: 20px; text-align: center; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 13px; color: #a1a1aa; }
        .form-group label .req { color: #f64e60; }
        .form-control { width: 100%; background: #151521; border: 1px solid #2b2b40; color: white; padding: 12px; border-radius: 6px; outline: none; transition: 0.3s; font-size: 14px; }
        .form-control:focus { border-color: #3699ff; }
        select.form-control { appearance: none; -webkit-appearance: none; }
        textarea.form-control { min-height: 70px; resize: vertical; }
        .btn-submit { width: 100%; background: #3699ff; color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; font-weight: bold; margin-top: 10px; transition: 0.3s; }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }
        .toggle-auth { text-align: center; margin-top: 15px; font-size: 13px; color: #a1a1aa; }
        .toggle-auth span { color: #3699ff; cursor: pointer; text-decoration: underline; }
        .hidden { display: none !important; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
        .tos-box { font-size: 12px; color: #a1a1aa; line-height: 1.6; max-height: 140px; overflow-y: auto; background: #151521; border: 1px solid #2b2b40; padding: 12px; border-radius: 6px; margin-bottom: 12px; }
        .checkbox-row { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px; font-size: 12px; color: #a1a1aa; line-height: 1.4; }
        .checkbox-row input { margin-top: 3px; cursor: pointer; flex-shrink: 0; }

        .sidebar { width: 250px; background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); position: fixed; height: 100vh; padding-top: 20px; z-index: 100; overflow-y: auto; transition: 0.3s; }
        .sidebar-brand { padding: 0 20px 20px 20px; font-size: 20px; font-weight: bold; color: var(--text-main); border-bottom: 1px solid var(--border-color); margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .brand-logo-icon { width: 35px; height: 35px; background: linear-gradient(135deg, #3699ff, #f64e60); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #fff; box-shadow: 0 0 12px rgba(54, 153, 255, 0.4); }
        .sidebar-menu { list-style: none; }
        .sidebar-menu > li { padding: 12px 20px; font-size: 14px; color: var(--text-main); cursor: pointer; display: flex; align-items: center; gap: 12px; transition: 0.3s; font-weight: 500; border-radius: 6px; margin: 0 10px 5px 10px; }
        .sidebar-menu > li:hover, .sidebar-menu > li.active-main { background-color: var(--hover-bg); color: #3699ff; }

        .main-wrapper { margin-left: 250px; padding: 20px; width: calc(100% - 250px); margin-top: 75px; }
        .sticky-top-header { display: flex; align-items: center; justify-content: space-between; background: var(--card-bg); border-bottom: 1px solid var(--border-color); padding: 10px 20px; position: fixed; top: 0; left: 250px; width: calc(100% - 250px); z-index: 99; box-shadow: 0 2px 5px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 15px; transition: 0.3s; }
        .header-metrics-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .timer-box { display: flex; flex-direction: column; justify-content: center; padding-right: 15px; border-right: 1px solid var(--border-color); }
        #live-timer-clock { font-size: 18px; font-weight: bold; color: var(--text-main); letter-spacing: 1px; }
        .timer-units-row { display: flex; gap: 16px; font-size: 9px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; margin-top: 1px; }
        .stat-circular-card { display: flex; align-items: center; gap: 12px; border-right: 1px solid var(--border-color); padding-right: 15px; padding-left: 5px; }
        .stat-circular-card:last-of-type { border-right: none; }
        .stat-info { display: flex; flex-direction: column; }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .stat-val-main { font-size: 15px; font-weight: bold; color: var(--text-main); line-height: 1.2; }
        .stat-val-sub { font-size: 11px; color: var(--text-muted); }
        .progress-circle { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; flex-shrink: 0; }
        .progress-circle.red-circle { background: conic-gradient(#ff4d4d calc(var(--pgPercentage, 0) * 1%), var(--border-color) 0); }
        .progress-circle.blue-circle { background: conic-gradient(#3699ff calc(var(--pgPercentage, 0) * 1%), var(--border-color) 0); }
        .circle-inner { width: 34px; height: 34px; background: var(--card-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; color: var(--text-main); transition: 0.3s; }
        .header-right-actions { display: flex; align-items: center; gap: 15px; }
        .balance-badge { background: rgba(27, 197, 189, 0.1); color: #1bc5bd; padding: 6px 14px; border-radius: 5px; font-weight: bold; font-size: 14px; display: flex; align-items: center; gap: 5px; border: 1px solid rgba(27, 197, 189, 0.2); }
        .profile-avatar-btn { width: 38px; height: 38px; border-radius: 50%; border: 2px solid #3699ff; overflow: hidden; cursor: pointer; }
        .profile-avatar-btn img { width: 100%; height: 100%; object-fit: cover; }
        #theme-toggle-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-main); padding: 5px; transition: 0.3s; }
        #theme-toggle-btn:hover { transform: scale(1.1); }

        .dashboard-main-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 20px; }
        .chart-box-panel { display: flex; height: 320px; border-radius: var(--card-radius); margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .chart-text-part { background-color: var(--graph-dark-bg); width: 25%; padding: 20px; display: flex; flex-direction: column; justify-content: center; }
        .chart-graph-part { background-color: var(--graph-blue-bg); width: 75%; padding: 20px; position: relative; }
        .metrics-grid-2x2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 25px; }
        .metric-box { height: 145px; border-radius: var(--card-radius); padding: 15px; display: flex; flex-direction: column; justify-content: center; position: relative; box-shadow: 0 4px 10px rgba(0,0,0,0.1); color: #FFFFFF; background-size: 20px 20px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px), linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px); }
        .box-clicks { background-color: var(--clicks-color); }
        .box-leads { background-color: var(--leads-color); }
        .box-earn { background-color: var(--earn-color); }
        .box-epc { background-color: var(--epc-color); }
        .metric-box h2 { font-size: 32px; font-weight: bold; margin-bottom: 5px; color: #FFFFFF; }
        .metric-box h4 { font-size: 14px; color: rgba(255,255,255,0.9); font-weight: 500; text-transform: uppercase; }
        .trend-indicator { position: absolute; bottom: 15px; right: 15px; font-size: 13px; font-weight: bold; color: #FFFFFF; background: rgba(0,0,0,0.15); padding: 4px 8px; border-radius: 4px; }
        .box-container { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--card-radius); padding: 25px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: 0.3s; }
        .box-header { font-size: 16px; font-weight: 600; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color); color: var(--text-main); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
        .notification-list { list-style: none; max-height: 250px; overflow-y: auto; }
        .notification-list li { padding: 10px 0; border-bottom: 1px solid var(--border-color); font-size: 13px; color: var(--text-muted); display: flex; gap: 10px; align-items: center; }
        .notification-list li strong { color: var(--text-main); }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        #offerContainer { display: flex; flex-direction: column; gap: 10px; max-height: 400px; overflow-y: auto; }
        .offer-item { background: var(--bg-dark); padding: 12px 15px; border-radius: 5px; border: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; transition: 0.2s; }
        .offer-item:hover { border-color: #3699ff; }
        .offer-item a { color: #3699ff; text-decoration: none; font-weight: 500; font-size: 14px; }
        .offer-actions { display: flex; gap: 8px; align-items: center; }
        .btn-getlink { background: rgba(137, 80, 252, 0.1); color: #8950fc; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; transition: 0.3s;}
        .btn-getlink:hover { background: #8950fc; color: #fff; }
        .payout-badge { background: rgba(255, 168, 0, 0.1); color: #ffa800; padding: 3px 6px; border-radius: 4px; font-size: 11px; font-weight: bold; border: 1px solid rgba(255, 168, 0, 0.2); }
        #allOffersContainer { display: flex; flex-direction: column; gap: 12px; max-height: 70vh; overflow-y: auto; padding-right: 5px;}
        .new-offer-card { background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; display: flex; flex-direction: column; gap: 12px; transition: 0.3s;}
        .offer-card-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; }
        .offer-title-btn { background: transparent; border: none; color: var(--text-main); font-size: 15px; font-weight: bold; cursor: pointer; text-align: left; transition: 0.3s;}
        .offer-title-btn:hover { color: #3699ff; text-decoration: underline; }
        .offer-badges-top { display: flex; gap: 8px; align-items: center; flex-wrap: wrap;}
        .badge-ui { padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .b-country { background: rgba(54, 153, 255, 0.1); color: #3699ff; border: 1px solid rgba(54, 153, 255, 0.2); }
        .b-id { background: rgba(137, 80, 252, 0.1); color: #8950fc; border: 1px solid rgba(137, 80, 252, 0.2); }
        .b-epc { background: rgba(27, 197, 189, 0.1); color: #1bc5bd; border: 1px solid rgba(27, 197, 189, 0.2); }
        .offer-card-footer { display: flex; justify-content: space-between; align-items: center; }
        .status-running { background: rgba(27, 197, 189, 0.1); color: #1bc5bd; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-boost { background: rgba(255, 168, 0, 0.1); color: #ffa800; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-pending { background: rgba(255,168,0,0.1); color: #ffa800; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-approved { background: rgba(27,197,189,0.1); color: #1bc5bd; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-declined { background: rgba(246,78,96,0.1); color: #f64e60; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .chat-area { height: 260px; background: var(--bg-dark); border-radius: 5px; padding: 15px; overflow-y: auto; font-size: 14px; border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 12px; transition: 0.3s;}
        .chat-msg { color: var(--text-main); line-height: 1.4; }
        .chat-msg b { color: #3699ff; font-weight: 600; margin-right: 5px; }
        .chat-time { font-size: 11px; color: var(--text-muted); margin-left: 5px; }
        .chat-input-row { display: flex; gap: 10px; margin-top: 15px; }
        .chat-input-row input { flex-grow: 1; background: var(--bg-dark); border: 1px solid var(--border-color); color: var(--text-main); padding: 10px; border-radius: 5px; outline: none; }
        .chat-input-row input:focus { border-color: #3699ff; }
        .chat-input-row input:disabled { opacity: 0.5; cursor: not-allowed; }
        .tab-filters { display: flex; gap: 8px; margin-bottom: 15px; flex-wrap: wrap; }
        .filter-btn { background: var(--bg-dark); border: 1px solid var(--border-color); color: var(--text-muted); padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; transition: 0.3s;}
        .filter-btn.active, .filter-btn:hover { background: #3699ff; color: #fff; border-color: #3699ff; }
        .badge-rank { background: rgba(137, 80, 252, 0.1); color: #8950fc; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .active-affiliates-list { list-style: none; max-height: 320px; overflow-y: auto; padding-right: 5px; }
        .active-affiliates-list li { padding: 10px 0; border-bottom: 1px solid var(--border-color); font-size: 13px; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); display: flex; justify-content: center; align-items: center; z-index: 1000; padding: 20px; overflow-y: auto; }
        .modal-box { background: var(--card-bg); border: 1px solid var(--border-color); padding: 25px; border-radius: 8px; width: 90%; max-width: 550px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); color: var(--text-main); max-height: 90vh; overflow-y: auto; }
        .modal-box.lg { max-width: 780px; }
        .modal-header-top { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 15px; }
        .modal-header-top h3 { color: var(--text-main); font-size: 18px; margin: 0; }
        .close-btn { background: none; border: none; color: #f64e60; font-size: 20px; font-weight: bold; cursor: pointer; }
        .modal-detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 8px;}
        .modal-detail-row span.label { color: var(--text-muted); }
        .modal-detail-row span.val { color: var(--text-main); font-weight: 500; }
        .table-wrap { background: var(--bg-dark); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
        .data-table thead tr { border-bottom: 1px solid var(--border-color); color: var(--text-muted); }
        .data-table th, .data-table td { padding: 10px; }
        .data-table tbody tr { border-bottom: 1px solid var(--border-color); color: var(--text-main); }
        .toast { position: fixed; bottom: 20px; right: 20px; background: #1e1e2d; color: #fff; padding: 14px 20px; border-radius: 6px; box-shadow: 0 4px 20px rgba(0,0,0,0.4); z-index: 9999; font-size: 14px; border-left: 4px solid #3699ff; max-width: 340px; }
        .toast.success { border-left-color: #1bc5bd; }
        .toast.error { border-left-color: #f64e60; }
        .ct-badge { display:inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; margin-left: 6px; }
        .ct-badge.ok { background: rgba(27,197,189,0.1); color: #1bc5bd; border: 1px solid rgba(27,197,189,0.3); }
        .ct-badge.warn { background: rgba(255,168,0,0.1); color: #ffa800; border: 1px solid rgba(255,168,0,0.3); }
        .toggle-switch { position: relative; display: inline-block; width: 50px; height: 26px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #7e8299; transition: .3s; border-radius: 26px; }
        .toggle-slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; }
        .toggle-switch input:checked + .toggle-slider { background-color: #1bc5bd; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(24px); }

        /* ==================== NEW ADMIN FEATURE STYLES ==================== */
        .admin-topbar { z-index: 150; }
        .admin-label-chip { display: flex; align-items: center; gap: 8px; background: rgba(137,80,252,0.12); border: 1px solid rgba(137,80,252,0.35); color: var(--admin-color); padding: 7px 16px; border-radius: 6px; font-weight: 800; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .notif-wrap { position: relative; }
        .notif-btn { background: var(--bg-dark); border: 1px solid var(--border-color); color: var(--text-main); width: 38px; height: 38px; border-radius: 50%; cursor: pointer; font-size: 16px; position: relative; transition: 0.2s; }
        .notif-btn:hover { border-color: #3699ff; }
        .notif-badge { position: absolute; top: -5px; right: -5px; background: #f64e60; color: #fff; font-size: 10px; font-weight: bold; border-radius: 10px; padding: 1px 6px; display: none; }
        .notif-dropdown { position: absolute; right: 0; top: 48px; width: 340px; max-height: 420px; overflow-y: auto; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 12px 34px rgba(0,0,0,0.35); z-index: 500; }
        .notif-item { padding: 11px 14px; border-bottom: 1px solid var(--border-color); font-size: 13px; color: var(--text-muted); }
        .notif-item:last-child { border-bottom: none; }
        .notif-item .notif-main { color: var(--text-main); font-weight: 500; }

        .settings-grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        @media (max-width: 900px) { .settings-grid-2 { grid-template-columns: 1fr; } }

        .redirect-card { background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color); }
        .redirect-card h4 { color: var(--text-main); margin-bottom: 14px; font-size: 15px; }
        .redirect-toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 14px; background: var(--card-bg); border-radius: 6px; border: 1px solid var(--border-color); }
        .redirect-title { font-weight: 700; color: var(--text-main); font-size: 14px; }
        .redirect-sub { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; line-height: 1.5; max-width: 380px; }
        .redirect-status { margin-top: 14px; padding: 10px 14px; border-radius: 6px; font-size: 12.5px; font-weight: 700; border: 1px solid rgba(255,168,0,0.4); background: rgba(255,168,0,0.08); color: #ffa800; transition: 0.3s; }
        .preview-box { margin-top: 22px; background: var(--bg-dark); border: 1px dashed var(--border-color); border-radius: 6px; padding: 20px; }
        .preview-title { font-size: 13px; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .preview-desc { font-size: 12.5px; color: var(--text-muted); margin-bottom: 12px; line-height: 1.6; }
        .preview-code { display: block; background: var(--card-bg); border: 1px solid var(--border-color); color: #1bc5bd; padding: 14px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 12.5px; word-break: break-all; line-height: 1.6; }
        .token-chip { display: inline-block; background: rgba(54,153,255,0.1); color: #3699ff; border: 1px solid rgba(54,153,255,0.25); border-radius: 4px; padding: 2px 8px; font-size: 11px; font-weight: 700; margin: 3px 4px 0 0; font-family: 'Courier New', monospace; }

        .inv-badge { padding: 3px 9px; border-radius: 4px; font-size: 11px; font-weight: 700; }
        .inv-paid { background: rgba(27,197,189,0.12); color: #1bc5bd; border: 1px solid rgba(27,197,189,0.3); }
        .inv-unpaid { background: rgba(255,168,0,0.12); color: #ffa800; border: 1px solid rgba(255,168,0,0.3); }
        .inv-void { background: rgba(246,78,96,0.12); color: #f64e60; border: 1px solid rgba(246,78,96,0.3); }

        .ov-chart-panel { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--card-radius); padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .ov-chart-wrap { position: relative; height: 340px; width: 100%; }
        .ov-legend-note { font-size: 11.5px; color: var(--text-muted); margin-top: 12px; line-height: 1.6; }
        @media (max-width: 1100px) { .dashboard-main-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <!-- ==================== AUTH SECTION ==================== -->
    <div id="auth-wrapper" class="auth-wrapper">
        <!-- LOGIN -->
        <div id="login-section" class="auth-container">
            <h2>
                <div class="brand-logo-icon">⚡</div>
                <span><span style="color:#3699ff;">Ad</span><span style="color:#f64e60;">Madia</span></span>
            </h2>
            <div id="login-error-msg" style="color: #f64e60; font-size: 13px; margin-bottom: 10px; text-align: center;"></div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="login-email" class="form-control" placeholder="user@domain.com">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="login-password" class="form-control" placeholder="••••••••">
            </div>

            <button id="btn-login" class="btn-submit">Sign In</button>

            <div class="toggle-auth">
                <span id="forgot-password-link">Forgot Password?</span>
            </div>
            <div class="toggle-auth">
                Don't have an affiliate account? <span id="show-signup">Sign Up here</span>
            </div>

            <div class="advertiser-auth-toggle" style="margin-top: 20px; text-align: center; font-size: 14px; border-top: 1px solid #2b2b40; padding-top: 12px;">
                <span style="color: #a1a1aa;">Are you an Advertiser?</span>
                <a href="#" id="advertiserToggleBtn" style="color: #007bff; text-decoration: none; font-weight: 500;">Sign Up / Sign In here</a>
            </div>
        </div>

        <!-- FORGOT PASSWORD -->
        <div id="forgot-section" class="auth-container hidden">
            <h2>
                <div class="brand-logo-icon">🔑</div>
                <span>Reset Password</span>
            </h2>
            <div id="forgot-msg" style="font-size: 13px; margin-bottom: 10px; text-align: center;"></div>
            <p style="color:#a1a1aa; font-size:13px; margin-bottom:15px; text-align:center;">Enter your registered email and we will send you a password reset link.</p>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="forgot-email" class="form-control" placeholder="user@domain.com">
            </div>
            <button id="btn-forgot-submit" class="btn-submit">Send Reset Link</button>
            <div class="toggle-auth">
                <span id="back-to-login">← Back to Sign In</span>
            </div>
        </div>

        <!-- SIGNUP -->
        <div id="signup-section" class="auth-container wide hidden">
            <h2>
                <div class="brand-logo-icon">⚡</div>
                <span><span style="color:#3699ff;">Ad</span><span style="color:#f64e60;">Madia</span></span>
            </h2>
            <div id="signup-error-msg" style="color: #f64e60; font-size: 13px; margin-bottom: 10px; text-align: center;"></div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" id="signup-firstname" class="form-control" placeholder="John">
                </div>
                <div class="form-group">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" id="signup-lastname" class="form-control" placeholder="Doe">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Username <span class="req">*</span></label>
                    <input type="text" id="signup-username" class="form-control" placeholder="johndoe123">
                </div>
                <div class="form-group">
                    <label>Affiliate FF ID <span class="req">*</span></label>
                    <input type="text" id="signup-ffid" class="form-control" placeholder="FF-00000 (your unique ID)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password <span class="req">*</span></label>
                    <input type="password" id="signup-password" class="form-control" placeholder="••••••••">
                </div>
                <div class="form-group">
                    <label>Re-enter Password <span class="req">*</span></label>
                    <input type="password" id="signup-password2" class="form-control" placeholder="••••••••">
                </div>
            </div>
            <div class="form-group">
                <label>Email Address <span class="req">*</span></label>
                <input type="email" id="signup-email" class="form-control" placeholder="user@domain.com">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Select Country <span class="req">*</span></label>
                    <select id="signup-country" class="form-control">
                        <option value="">-- Select Country --</option>
                        <option>United States</option><option>Canada</option><option>United Kingdom</option>
                        <option>Australia</option><option>Germany</option><option>France</option>
                        <option>India</option><option>Bangladesh</option><option>Italy</option>
                        <option>Spain</option><option>Brazil</option><option>Nigeria</option>
                        <option>Philippines</option><option>Indonesia</option><option>Pakistan</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Promo Code <span class="req">*</span></label>
                    <input type="text" id="signup-promo" class="form-control" placeholder="Enter or type NONE">
                </div>
            </div>
            <div class="form-group">
                <label>Street Address <span class="req">*</span></label>
                <input type="text" id="signup-street" class="form-control" placeholder="123 Main Street">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>State <span class="req">*</span></label>
                    <input type="text" id="signup-state" class="form-control" placeholder="State / Province">
                </div>
                <div class="form-group">
                    <label>City <span class="req">*</span></label>
                    <input type="text" id="signup-city" class="form-control" placeholder="City">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Zip / Postal Code <span class="req">*</span></label>
                    <input type="text" id="signup-zip" class="form-control" placeholder="00000">
                </div>
                <div class="form-group">
                    <label>Where did you hear about us? <span class="req">*</span></label>
                    <input type="text" id="signup-hear" class="form-control" placeholder="Google, Friend, Forum...">
                </div>
            </div>
            <div class="form-group">
                <label>Website(s)</label>
                <input type="text" id="signup-websites" class="form-control" placeholder="https://yoursite.com (optional)">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Promotional Method / Traffic Sources <span class="req">*</span></label>
                    <input type="text" id="signup-traffic" class="form-control" placeholder="SEO, Social, Email...">
                </div>
                <div class="form-group">
                    <label>Current Networks</label>
                    <input type="text" id="signup-networks" class="form-control" placeholder="e.g. AdCombo, MaxBounty...">
                </div>
            </div>

            <div class="tos-box">
                <strong>Terms of Service</strong><br>
                By registering you agree to AdMadia's terms. Fraudulent activity, false registration info, and non-compliance with traffic restrictions will result in forfeiture of your account and unpaid balance.
            </div>
            <div class="checkbox-row">
                <input type="checkbox" id="tos-agree1">
                <label for="tos-agree1">I have read and agree to the Terms of Service.</label>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" id="tos-agree2">
                <label for="tos-agree2">I confirm that the information entered above is correct and accept that registering with false information will make me ineligible to receive payments.</label>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" id="tos-agree3">
                <label for="tos-agree3">I understand that by registering with false information, generating fraudulent leads or failing to comply with the network's traffic restrictions, I risk forfeiting my account.</label>
            </div>

            <button id="btn-signup" class="btn-submit">Register Account (Pending Admin Approval)</button>
            <div class="toggle-auth">
                Already have an account? <span id="show-login">Sign In here</span>
            </div>
        </div>
    </div>

    <!-- ==================== ADMIN PORTAL ==================== -->
    <div id="admin-dashboard-section" class="hidden" style="width: 100%; display: flex;">
        <div class="sidebar" style="border-right-color: var(--admin-color);">
            <div class="sidebar-brand">
                <div class="brand-logo-icon">⚙️</div>
                <span style="color: var(--admin-color);" id="admin-brand-label">Admin Control</span>
            </div>
            <ul class="sidebar-menu">
                <li class="admin-menu-item active-main" id="admin-menu-overview">📊 Admin Overview Dashboard</li>
                <li class="admin-menu-item" id="admin-menu-settings">⚙️ Master Settings & API Sync</li>
                <li class="admin-menu-item" id="admin-menu-redirect">🔀 Redirect Controller</li>
                <li class="admin-menu-item" id="admin-menu-postbacks">📮 Postback Management</li>
                <li class="admin-menu-item" id="admin-menu-invoices">🧾 Invoice List</li>
                <li class="admin-menu-item" id="admin-menu-inbox">📬 Inbox — Affiliate Messages <span id="admin-inbox-badge" style="background:#f64e60; color:#fff; border-radius:10px; padding:1px 7px; font-size:10px; margin-left:auto; display:none;">0</span></li>
                <li class="admin-menu-item" id="admin-menu-offers">🎯 Offers Management</li>
                <li class="admin-menu-item" id="admin-menu-users">👥 Affiliate Users Management</li>
                <li class="admin-menu-item" id="admin-menu-advertiser-approvals">💳 Advertiser Payment Approvals</li>
                <li class="admin-menu-item" id="admin-menu-live-earnings">📈 Live Earnings Tracker</li>
                <li class="admin-menu-item" id="admin-menu-click-tracking">📡 Click ID Tracking Log</li>
                <li class="admin-menu-item" id="admin-menu-traffic-quality">🛡️ Traffic & IP Quality</li>
                <li class="admin-menu-item" id="admin-menu-managers">🧑‍💼 Manager Accounts</li>
                <li id="btn-admin-logout" style="color: #f64e60; margin-top: 20px;">🚪 Logout</li>
            </ul>
        </div>

        <!-- ADMIN TOP BAR with Admin label + notifications -->
        <div class="sticky-top-header admin-topbar">
            <div class="header-metrics-group">
                <span class="admin-label-chip">👑 <span id="admin-role-label">ADMIN</span></span>
                <span style="font-size: 12px; color: var(--text-muted);">Signed in as
                    <strong id="admin-signed-email" style="color: var(--text-main);">—</strong>
                </span>
            </div>
            <div class="header-right-actions">
                <button id="theme-toggle-admin" title="Toggle Dark/Light Mode" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-main);padding:5px;transition:.3s;">🌙</button>
                <div class="notif-wrap">
                    <button class="notif-btn" id="admin-notif-btn" title="Notifications">🔔<span class="notif-badge" id="admin-notif-badge">0</span></button>
                    <div class="notif-dropdown hidden" id="admin-notif-dropdown">
                        <div style="padding:12px 14px; font-weight:700; color:var(--text-main); border-bottom:1px solid var(--border-color); font-size:13px; display:flex; justify-content:space-between; align-items:center;">
                            <span>🔔 Recent Network Notifications</span>
                            <span style="font-size:11px; color:var(--text-muted); font-weight:500;">Live</span>
                        </div>
                        <div id="admin-notif-list">
                            <div style="padding:15px; color:var(--text-muted); font-size:13px; text-align:center;">No notifications.</div>
                        </div>
                    </div>
                </div>
                <div class="profile-avatar-btn" title="Administrator">
                    <img src="https://i.pravatar.cc/100?img=68" alt="Admin">
                </div>
            </div>
        </div>

        <div class="main-wrapper" style="margin-top: 78px;">

            <!-- ============ ADMIN OVERVIEW DASHBOARD ============ -->
            <div id="admin-view-overview" class="hidden">
                <div class="box-container" style="margin-bottom: 20px;">
                    <div class="box-header">
                        <span>📊 Network Performance Overview — Clicks · Conversions · Revenue · Payouts</span>
                        <span style="font-size:12px; color:#1bc5bd; font-weight:600;">● Live Aggregation</span>
                    </div>
                    <div class="metrics-grid-2x2" style="margin-bottom: 0;">
                        <div class="metric-box box-clicks">
                            <h2 id="ov-clicks">0</h2><h4>Total Clicks</h4>
                            <div class="trend-indicator">All Affiliates</div>
                        </div>
                        <div class="metric-box box-leads">
                            <h2 id="ov-conversions">0</h2><h4>Conversions</h4>
                            <div class="trend-indicator" id="ov-cr">0.00% CR</div>
                        </div>
                        <div class="metric-box box-earn">
                            <h2 id="ov-revenue">$0.00</h2><h4>Revenue</h4>
                            <div class="trend-indicator" id="ov-epc">$0.00 EPC</div>
                        </div>
                        <div class="metric-box box-epc">
                            <h2 id="ov-payouts">$0.00</h2><h4>Payouts</h4>
                            <div class="trend-indicator">Affiliate Share</div>
                        </div>
                    </div>
                </div>

                <div class="ov-chart-panel" style="margin-bottom: 25px;">
                    <div class="box-header">
                        <span>📈 7-Day Performance Chart</span>
                        <span style="font-size:12px; color:var(--text-muted);">Clicks / Conversions / Revenue / Payouts</span>
                    </div>
                    <div class="ov-chart-wrap">
                        <canvas id="adminOverviewChart"></canvas>
                    </div>
                    <div class="ov-legend-note">
                        Revenue represents total tracked conversion value. Payouts represent the affiliate-credited portion,
                        aggregated from the daily counters ledger.
                    </div>
                </div>

                <div class="box-container">
                    <div class="box-header">
                        <span>⚡ Quick Admin Actions</span>
                    </div>
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        <button class="btn-submit" style="width:auto; padding:10px 20px; margin:0;" onclick="switchView('admin-view-redirect')">🔀 Redirect Controller</button>
                        <button class="btn-submit" style="width:auto; padding:10px 20px; margin:0; background:#1bc5bd;" onclick="switchView('admin-view-postbacks')">📮 Postback Management</button>
                        <button class="btn-submit" style="width:auto; padding:10px 20px; margin:0; background:#8950fc;" onclick="switchView('admin-view-invoices')">🧾 Invoice List</button>
                        <button class="btn-submit" style="width:auto; padding:10px 20px; margin:0; background:#ffa800;" onclick="switchView('admin-view-users')">👥 Manage Affiliates</button>
                    </div>
                </div>
            </div>

            <!-- ============ REDIRECT CONTROLLER ============ -->
            <div id="admin-view-redirect" class="box-container hidden">
                <div class="box-header"><span>🔀 Redirect Controller — Global Link Routing Engine</span></div>

                <div class="settings-grid-2">
                    <div class="redirect-card">
                        <h4>Redirect Engine Switch</h4>
                        <div class="redirect-toggle-row">
                            <div>
                                <div class="redirect-title">Enable Global Redirect</div>
                                <div class="redirect-sub">
                                    When ON, every affiliate tracking link generated by the network is routed
                                    to the Target URL below instead of the default offer destination.
                                </div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="redirect-toggle">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="redirect-status" id="redirect-status-pill">● OFF — Links resolve to network offers</div>
                    </div>

                    <div class="redirect-card">
                        <h4>Target URL</h4>
                        <div class="form-group">
                            <label>Destination URL</label>
                            <input type="text" id="redirect-target-url" class="form-control"
                                   placeholder="https://example.com/target-offer"
                                   style="background: var(--card-bg);">
                        </div>
                        <button class="btn-submit" id="btn-save-redirect" style="width: 220px; background:#1bc5bd;">
                            Save Redirect Settings
                        </button>
                        <div style="margin-top:16px;">
                            <div style="font-size:11.5px; color:var(--text-muted); margin-bottom:6px; font-weight:600;">
                                Auto-appended tracking tokens:
                            </div>
                            <span class="token-chip">{clickid}</span>
                            <span class="token-chip">{aff}</span>
                            <span class="token-chip">{sub5}</span>
                        </div>
                    </div>
                </div>

                <div class="preview-box">
                    <div class="preview-title">🔎 Example URL / Live Preview</div>
                    <div class="preview-desc">
                        This is exactly how a generated affiliate tracking link will look with the current
                        Redirect Controller configuration. Toggle the switch above to compare both modes.
                    </div>
                    <code class="preview-code" id="redirect-preview-url">https://example.com/target-offer?clickid=CID-XXXXXXXXXX&amp;aff=FF-00000&amp;sub5=admedia_CID-XXXXXXXXXX_admedia_FF-00000</code>
                    <div style="display:flex; gap:10px; margin-top:14px; flex-wrap:wrap;">
                        <button class="btn-submit" style="width:auto; padding:9px 18px; margin:0; background:#3699ff;" onclick="testRedirectPreview()">▶ Test Open Preview</button>
                        <button class="btn-submit" style="width:auto; padding:9px 18px; margin:0; background:#8950fc;" onclick="copyRedirectPreview()">📋 Copy Preview URL</button>
                    </div>
                </div>
            </div>

            <!-- ============ POSTBACK MANAGEMENT ============ -->
            <div id="admin-view-postbacks" class="box-container hidden">
                <div class="box-header"><span>📮 Postback Management — Global &amp; Custom Postback URLs</span></div>

                <div class="settings-grid-2">
                    <div class="redirect-card">
                        <h4>🌐 Global Postback URL</h4>
                        <div class="form-group">
                            <label>Network-wide Postback Endpoint</label>
                            <input type="text" id="global-postback-input" class="form-control"
                                   placeholder="https://yournetwork.com/postback?clickid={clickid}&payout={payout}"
                                   style="background: var(--card-bg);">
                        </div>
                        <button class="btn-submit" id="btn-save-global-postback" style="width: 220px; background:#1bc5bd;">
                            Save Global Postback
                        </button>
                        <div style="margin-top:16px;">
                            <div style="font-size:11.5px; color:var(--text-muted); margin-bottom:6px; font-weight:600;">
                                Available tokens:
                            </div>
                            <span class="token-chip">{clickid}</span>
                            <span class="token-chip">{aff_id}</span>
                            <span class="token-chip">{payout}</span>
                            <span class="token-chip">{offer_id}</span>
                            <span class="token-chip">{status}</span>
                        </div>
                    </div>

                    <div class="redirect-card">
                        <h4>👤 Custom Postback (Per Affiliate)</h4>
                        <div class="form-group">
                            <label>Affiliate Email</label>
                            <input type="text" id="custom-postback-email" class="form-control"
                                   placeholder="affiliate@domain.com" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Custom Postback URL</label>
                            <input type="text" id="custom-postback-url" class="form-control"
                                   placeholder="https://affiliate.com/pb?cid={clickid}&amt={payout}"
                                   style="background: var(--card-bg);">
                        </div>
                        <button class="btn-submit" id="btn-save-custom-postback" style="width: 220px; background:#8950fc;">
                            Save Custom Postback
                        </button>
                        <div style="font-size:11.5px; color:var(--text-muted); margin-top:12px; line-height:1.6;">
                            Custom postbacks override the global endpoint for that specific affiliate only.
                        </div>
                    </div>
                </div>

                <div class="box-header" style="margin-top: 28px;">
                    <span>📋 Custom Postback Registry</span>
                    <span style="font-size:11px; color:#1bc5bd;">Live</span>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Affiliate</th>
                                <th>Custom Postback URL</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-postbacks-table-body">
                            <tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding: 15px;">No custom postbacks registered yet.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============ INVOICE LIST ============ -->
            <div id="admin-view-invoices" class="box-container hidden">
                <div class="box-header">
                    <span>🧾 Invoice List — Complete Payout History (All Affiliates)</span>
                    <button class="btn-submit" id="btn-generate-invoices"
                            style="margin-top:0; width:auto; padding:9px 18px; background:#8950fc;">
                        ⚙ Run Monday Invoice Generation
                    </button>
                </div>

                <div class="metrics-grid-2x2" style="margin-bottom: 22px;">
                    <div class="metric-box box-clicks"><h2 id="inv-total-count">0</h2><h4>Total Invoices</h4><div class="trend-indicator">All Time</div></div>
                    <div class="metric-box box-earn"><h2 id="inv-unpaid-count">0</h2><h4>Unpaid Invoices</h4><div class="trend-indicator">Pending</div></div>
                    <div class="metric-box box-epc"><h2 id="inv-paid-count">0</h2><h4>Paid Invoices</h4><div class="trend-indicator">Settled</div></div>
                    <div class="metric-box box-leads"><h2 id="inv-total-amount">$0.00</h2><h4>Total Invoiced</h4><div class="trend-indicator">BTC</div></div>
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px; align-items:center;">
                    <input type="text" id="invoice-search" class="form-control"
                           placeholder="Search by affiliate email or invoice ID..."
                           style="max-width:340px; background: var(--bg-dark);">
                    <div class="tab-filters" style="margin-bottom:0;">
                        <button class="filter-btn active" onclick="filterInvoices('all', this)">All</button>
                        <button class="filter-btn" onclick="filterInvoices('Unpaid', this)">Unpaid</button>
                        <button class="filter-btn" onclick="filterInvoices('Paid', this)">Paid</button>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Affiliate</th>
                                <th>Period</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-invoices-table-body">
                            <tr><td colspan="8" style="text-align:center; color: var(--text-muted); padding: 15px;">Loading invoices...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============ MASTER SETTINGS ============ -->
            <div id="admin-view-settings" class="box-container hidden">
                <div class="box-header"><span>Master Admin API & Network Controller</span></div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h4 style="color: var(--text-main); margin-bottom: 12px;">AdMadia API Configuration</h4>
                        <div class="form-group">
                            <label>Running Offers API Key</label>
                            <input type="text" id="admin-api-key-input" class="form-control" value="https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u298346&sub5=s1" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Master Global Smart Link</label>
                            <input type="text" id="admin-master-link-input" class="form-control" value="https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u298346&sub5=s1" style="background: var(--card-bg);">
                        </div>
                        <button class="btn-submit" id="btn-save-api-settings">Save & Sync Network API Key</button>
                    </div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h4 style="color: var(--text-main); margin-bottom: 12px;">🌐 Global Chat Controls</h4>
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:15px; background: var(--card-bg); border-radius:6px; border:1px solid var(--border-color); margin-bottom:15px;">
                            <div>
                                <div style="font-weight:600; color:var(--text-main); font-size:14px;">Network Chat (Affiliate ↔ Admin)</div>
                                <div style="font-size:11px; color:var(--text-muted); margin-top:3px;">When OFF, affiliates cannot send messages.</div>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="chat-toggle-switch" checked>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <h4 style="color: var(--text-main); margin-bottom: 10px;">Network Live Controls</h4>
                        <button class="btn-submit" id="btn-admin-switch-affiliate" style="background: var(--admin-color); margin-top: 0;">View As Affiliate User</button>
                    </div>
                </div>
                <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                    <h4 style="color: var(--text-main); margin-bottom: 12px;">🔍 Manual Lead Approval by Click ID</h4>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <input type="text" id="admin-click-id-search" class="form-control" placeholder="Enter Unique Click ID" style="flex: 1; min-width: 200px; background: var(--card-bg);">
                        <button class="btn-submit" style="margin-top:0; width: 120px;" id="btn-admin-search-click-id">Search</button>
                    </div>
                    <div id="admin-click-id-result" style="margin-top: 15px; color: var(--text-main);"></div>
                </div>
                <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                    <h4 style="color: var(--text-main); margin-bottom: 12px;">Manual User Balance & Lead Management</h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                        <div class="form-group">
                            <label>User Email / ID</label>
                            <input type="text" id="admin-target-user" class="form-control" placeholder="user@domain.com" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Amount ($ / Lead)</label>
                            <input type="number" id="admin-target-amount" class="form-control" placeholder="50.00" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Action Type</label>
                            <select id="admin-action-type" class="form-control" style="background: var(--card-bg); color: var(--text-main);">
                                <option value="add_balance">Add Earnings</option>
                                <option value="add_lead">Add Lead Count</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-submit" id="btn-admin-manual-update" style="width: 200px; margin-top: 10px; background: #1bc5bd;">Apply Manual Update</button>
                </div>
            </div>

            <!-- ADMIN INBOX VIEW -->
            <div id="admin-view-inbox" class="box-container hidden">
                <div class="box-header"><span>📬 Centralized Inbox — Affiliate ↔ Admin Conversations Only</span></div>
                <div style="display:grid; grid-template-columns: 320px 1fr; gap:15px; height:560px; min-height:400px;">
                    <div id="admin-inbox-list" style="overflow-y:auto; background:var(--bg-dark); border-radius:6px; border:1px solid var(--border-color);">
                        <div style="padding:15px; color:var(--text-muted); text-align:center; font-size:13px;">Loading conversations...</div>
                    </div>
                    <div style="display:flex; flex-direction:column; background:var(--bg-dark); border-radius:6px; border:1px solid var(--border-color); overflow:hidden;">
                        <div id="admin-inbox-header" style="padding:12px 15px; border-bottom:1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center; min-height:60px;">
                            <div style="color:var(--text-muted); font-size:13px;">Select a conversation from the left to start messaging.</div>
                        </div>
                        <div id="admin-inbox-messages" style="flex:1; overflow-y:auto; padding:15px; display:flex; flex-direction:column; gap:6px; background:var(--card-bg);">
                            <div style="color:var(--text-muted); text-align:center; padding:20px;">No conversation selected.</div>
                        </div>
                        <div class="chat-input-row" style="padding:12px 15px; margin:0; border-top:1px solid var(--border-color); background:var(--bg-dark);">
                            <input type="text" id="admin-inbox-input" placeholder="Type a message to the affiliate...">
                            <button id="btn-admin-inbox-send" class="btn-submit" style="margin-top:0; width:90px;">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="admin-view-offers" class="box-container hidden">
                <div class="box-header"><span>Offers Management — Add / View / Update</span></div>
                <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                    <h4 style="color: var(--text-main); margin-bottom: 12px;">➕ Add New Offer</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Offer Name</label>
                            <input type="text" id="offer-add-name" class="form-control" placeholder="e.g. Crypto Wallet App" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Country (ISO code)</label>
                            <input type="text" id="offer-add-country" class="form-control" placeholder="US" style="background: var(--card-bg);">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Category</label>
                            <select id="offer-add-category" class="form-control" style="background: var(--card-bg); color: var(--text-main);">
                                <option value="install">App Install</option>
                                <option value="sport">Sports & Gaming</option>
                                <option value="gift">Gift Card & Survey</option>
                                <option value="traffic">Standard Traffic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Payout</label>
                            <input type="text" id="offer-add-payout" class="form-control" placeholder="$20 - $50" style="background: var(--card-bg);">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Base Tracking URL (must end with sub5=s1)</label>
                        <input type="text" id="offer-add-url" class="form-control" value="https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u298346&sub5=s1" style="background: var(--card-bg);">
                    </div>
                    <button class="btn-submit" id="btn-offer-add" style="width: 220px; background:#1bc5bd;">Save New Offer</button>
                </div>
                <div class="box-header"><span>All Network Offers</span>
                    <input type="text" id="admin-offer-search" class="form-control" placeholder="Search offers..." style="width: 250px; background: var(--bg-dark);">
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Country</th><th>Category</th><th>Payout</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-offers-table-body">
                            <tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding: 15px;">Loading offers...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-users" class="box-container hidden">
                <div class="box-header">
                    <span>All Affiliate Users & Registration Requests</span>
                    <input type="text" id="admin-user-search" class="form-control" placeholder="Search by Email or ID..." style="width: 250px; background: var(--bg-dark);">
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>User ID</th><th>Name</th><th>Email</th><th>FF ID</th><th>Main Click ID</th><th>Status</th><th>Rank Assign</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-users-table-body">
                            <tr><td colspan="8" style="text-align:center; color: var(--text-muted); padding: 15px;">Loading users list...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-advertiser-approvals" class="box-container hidden">
                <div class="box-header"><span>Advertiser Payment & Deposit Approvals</span></div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Advertiser ID</th><th>Method</th><th>TxID</th><th>Receipt</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-advertiser-approvals-body">
                            <tr>
                                <td>ADV-1092</td>
                                <td>Bitcoin (BTC)</td>
                                <td><code>tx_btc_984572938475</code></td>
                                <td><a href="#" onclick="alert('Sample Receipt View')" style="color:#3699ff;">View Screenshot</a></td>
                                <td style="display:flex; gap:5px;">
                                    <button class="btn-submit" style="margin-top:0; padding: 4px 8px; font-size: 11px; background: #1bc5bd;" onclick="alert('Deposit Approved & Balance Updated!')">Approve</button>
                                    <button class="btn-submit" style="margin-top:0; padding: 4px 8px; font-size: 11px; background: #f64e60;" onclick="alert('Deposit Rejected')">Reject</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-live-earnings" class="box-container hidden">
                <div class="box-header">
                    <span>All Affiliates Live Earnings (Consolidated)</span>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="date" id="admin-live-date-start" class="form-control" style="width: 150px; background: var(--card-bg);">
                        <span>to</span>
                        <input type="date" id="admin-live-date-end" class="form-control" style="width: 150px; background: var(--card-bg);">
                        <button class="btn-submit" id="btn-admin-filter-live" style="margin-top:0; width: 100px; background: var(--admin-color);">Filter</button>
                    </div>
                </div>
                <div class="metrics-grid-2x2" style="margin-bottom: 20px;">
                    <div class="metric-box box-clicks"><h2 id="admin-live-total-clicks">0</h2><h4>Total Clicks</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-leads"><h2 id="admin-live-total-leads">0</h2><h4>Total Leads</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-earn"><h2 id="admin-live-total-earnings">$0.00</h2><h4>Total Earnings</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-epc"><h2 id="admin-live-total-epc">$0.00</h2><h4>Average EPC</h4><div class="trend-indicator">Live</div></div>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Affiliate</th><th>Clicks</th><th>Leads</th><th>Earnings</th><th>EPC</th></tr>
                        </thead>
                        <tbody id="admin-live-earnings-table-body">
                            <tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding: 15px;">Loading live data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-click-tracking" class="box-container hidden">
                <div class="box-header">
                    <span>📡 Affiliate Click Tracking — Affiliate ID & Click ID Breakdown</span>
                    <input type="text" id="admin-ct-search" class="form-control" placeholder="Search by affiliate email..." style="width: 260px; background: var(--bg-dark);">
                </div>
                <div class="metrics-grid-2x2" style="margin-bottom: 20px;">
                    <div class="metric-box box-clicks"><h2 id="ct-total-clicks">0</h2><h4>Total Clicks (All Affiliates)</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-leads"><h2 id="ct-total-affiliates">0</h2><h4>Active Affiliates</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-earn"><h2 id="ct-total-clickids">0</h2><h4>Distinct Click IDs</h4><div class="trend-indicator">Live</div></div>
                    <div class="metric-box box-epc"><h2 id="ct-last-click">—</h2><h4>Last Click (Any)</h4><div class="trend-indicator">Live</div></div>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Affiliate</th><th>Total Clicks</th><th>Last Click Time</th><th>Click ID(s)</th><th>Per-Click-ID Count</th><th>Last Click At (Per ID)</th></tr>
                        </thead>
                        <tbody id="admin-ct-table-body">
                            <tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding:15px;">Loading click tracking...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-traffic-quality" class="box-container hidden">
                <div class="box-header"><span>🛡️ Traffic & IP Quality Verification (Per-Affiliate + Aggregate)</span></div>
                <div class="metrics-grid-2x2" style="margin-bottom: 20px;">
                    <div class="metric-box box-clicks"><h2 id="tq-total-clicks">0</h2><h4>Total Clicks</h4><div class="trend-indicator">Aggregate</div></div>
                    <div class="metric-box box-leads"><h2 id="tq-unique-ips">0</h2><h4>Unique IPs</h4><div class="trend-indicator">Aggregate</div></div>
                    <div class="metric-box box-earn"><h2 id="tq-duplicate-pct">0%</h2><h4>Duplicate IP Rate</h4><div class="trend-indicator">Aggregate</div></div>
                    <div class="metric-box box-epc"><h2 id="tq-lead-quality">0%</h2><h4>Lead Quality</h4><div class="trend-indicator">Aggregate</div></div>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Affiliate</th><th>Total Clicks</th><th>Unique IPs</th><th>Duplicate IPs</th><th>Duplicate Rate</th><th>Leads</th><th>Lead Quality</th></tr>
                        </thead>
                        <tbody id="admin-traffic-quality-body">
                            <tr><td colspan="7" style="text-align:center; color: var(--text-muted); padding: 15px;">Loading traffic quality data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admin-view-managers" class="box-container hidden">
                <div class="box-header"><span>🧑‍💼 Manager Accounts</span></div>
                <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                    <h4 style="color: var(--text-main); margin-bottom: 12px;">➕ Create New Manager</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Manager Email</label>
                            <input type="email" id="manager-add-email" class="form-control" placeholder="manager@admadia.site" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Manager Password</label>
                            <input type="text" id="manager-add-password" class="form-control" placeholder="Set a password" style="background: var(--card-bg);">
                        </div>
                    </div>
                    <button class="btn-submit" id="btn-manager-add" style="width: 220px; background:#1bc5bd;">Create Manager Account</button>
                    <p style="font-size:12px; color: var(--text-muted); margin-top:10px;">Managers log in from the same login form. They receive full admin portal features. No self-registration.</p>
                </div>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr><th>Manager Email</th><th>Created</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="admin-managers-table-body">
                            <tr><td colspan="3" style="text-align:center; color: var(--text-muted); padding: 15px;">No managers created yet.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- ==================== AFFILIATE DASHBOARD ==================== -->
    <div id="dashboard-section" class="hidden" style="width: 100%; display: flex;">
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-logo-icon">⚡</div>
                <span><span style="color:#3699ff;">Ad</span><span style="color:#f64e60;">Madia</span></span>
            </div>
            <ul class="sidebar-menu">
                <li id="menu-dashboard" class="active-main">📊 Dashboard</li>
                <li id="menu-campaigns">🔒 Campaigns</li>
                <li id="menu-smartlinks">🔗 Smart Links</li>
                <li id="menu-offers">🎯 Offers</li>
                <li id="menu-reports">📈 Stats</li>
                <li id="menu-postback">📡 Postback</li>
                <li id="menu-templates">🎨 Templates</li>
                <li id="menu-balance" style="color: #1bc5bd; font-weight: bold;">💰 Balance & Bitcoin</li>
                <li id="menu-payments">💳 Payout Invoices</li>
                <li id="menu-referral" style="color: #3699ff; font-weight: bold;">👥 View Referrals</li>
                <li id="menu-profile" style="color: #8950fc; font-weight: bold;">⚙️ My Account</li>
                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 10px 0;">
                <li style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; padding: 4px 20px; font-weight: bold;">Advertiser Portal</li>
                <li id="menu-adv-deposits">💳 Deposits</li>
                <li id="menu-adv-campaigns">🚀 Campaigns</li>
                <li id="menu-adv-statistics">📊 Statistics</li>
                <li id="menu-adv-traffic-demand">📈 Traffic Demand</li>
                <li id="menu-adv-traffic-sources">🌐 Traffic Sources</li>
                <li id="menu-adv-contact-sources">📞 Contact Sources</li>
                <li id="menu-adv-whitelists">🛡️ Whitelists</li>
                <li id="btn-logout" style="color: #f64e60; margin-top: 20px;">🚪 Logout</li>
            </ul>
        </div>

        <div class="sticky-top-header">
            <div class="header-metrics-group">
                <div class="timer-box">
                    <span id="live-timer-clock">00:00:00</span>
                    <div class="timer-units-row"><span>HOUR</span><span>MIN</span><span>SEC</span></div>
                </div>
                <div class="stat-circular-card">
                    <div class="progress-circle red-circle" style="--pgPercentage: 0;" id="circle-month">
                        <div class="circle-inner" id="percent-month">0%</div>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Month</span>
                        <span class="stat-val-main" id="stat-month-earn">$0.00</span>
                        <span class="stat-val-sub" id="target-month-sub">$00.00</span>
                    </div>
                </div>
                <div class="stat-circular-card">
                    <div class="progress-circle blue-circle" style="--pgPercentage: 0;" id="circle-week">
                        <div class="circle-inner" id="percent-week">0%</div>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Week</span>
                        <span class="stat-val-main" id="stat-week-earn">$0.00</span>
                        <span class="stat-val-sub" id="target-week-sub">$0.99</span>
                    </div>
                </div>
                <div class="stat-circular-card">
                    <div class="progress-circle red-circle" style="--pgPercentage: 0;" id="circle-day">
                        <div class="circle-inner" id="percent-day">0%</div>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Day</span>
                        <span class="stat-val-main" id="stat-day-earn">$0.00</span>
                        <span class="stat-val-sub" id="target-day-sub">$0.00</span>
                    </div>
                </div>
                <div class="stat-circular-card">
                    <div class="progress-circle blue-circle" style="--pgPercentage: 100;" id="circle-hour">
                        <div class="circle-inner" id="percent-hour">100%</div>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Hour</span>
                        <span class="stat-val-main" id="stat-hour-earn">$0.00</span>
                        <span class="stat-val-sub">$0.00</span>
                    </div>
                </div>
            </div>
            <div class="header-right-actions">
                <button id="theme-toggle-btn" title="Toggle Dark/Light Mode">🌙</button>
                <div class="balance-badge" style="cursor: pointer;" onclick="document.getElementById('menu-balance').click()">💰 <span id="top-balance-amount">$0.00</span></div>
                <div class="profile-avatar-btn" title="My Account" onclick="document.getElementById('menu-profile').click()">
                    <img id="header-avatar-img" src="https://i.pravatar.cc/100?img=12" alt="Profile">
                </div>
            </div>
        </div>

        <div class="main-wrapper">
            <div id="view-dashboard">
                <div class="dashboard-main-grid">
                    <div class="left-column">
                        <div class="chart-box-panel">
                            <div class="chart-text-part">
                                <span style="font-size: 13px; color: #E0E0E0; margin-bottom: 5px;">Week Income</span>
                                <h2 id="chart-week-income" style="font-size: 36px; font-weight: bold; margin-bottom: 25px; color: #FFFFFF;">$0.00</h2>
                                <div style="font-size: 14px; color: #E0E0E0; line-height: 2;">
                                    <div><strong id="chart-leads-count" style="color: #FFF;">0</strong> Leads</div>
                                    <div><strong id="chart-conv-rate" style="color: #FFF;">0.00%</strong> Conversion</div>
                                    <div><strong id="chart-epc-val" style="color: #FFF;">$0.00</strong> EPC</div>
                                </div>
                            </div>
                            <div class="chart-graph-part">
                                <div style="position: absolute; top: 15px; right: 20px; font-size: 13px; color: #E0E0E0;">Last 7 Days</div>
                                <canvas id="incomeChart"></canvas>
                            </div>
                        </div>
                        <div class="box-container" id="affiliate-chat-box">
                            <div class="box-header">
                                <span>📬 Admin Inbox (Private Chat)</span>
                                <span style="font-size:11px; color:#1bc5bd;">Only you & admin</span>
                            </div>
                            <div class="chat-area" id="chatContainer">
                                <div style="color:var(--text-muted); text-align:center; padding:10px;">Loading messages...</div>
                            </div>
                            <div class="chat-input-row" id="affiliate-chat-input-row">
                                <input type="text" id="affiliate-chat-input" placeholder="Type a message to the admin...">
                                <button id="btn-affiliate-send-chat" class="btn-submit" style="margin-top: 0; width: 80px;">Send</button>
                            </div>
                        </div>
                        <div class="box-container" style="margin-bottom: 20px;">
                            <div class="box-header">
                                <span>Active Affiliates Online ( Live TOP Affiliates )</span>
                                <span style="font-size: 11px; background: rgba(137,80,252,0.1); color: #8950fc; padding: 3px 6px; border-radius: 4px;">Verified Feed</span>
                            </div>
                            <ul id="active-affiliates-list" class="active-affiliates-list"></ul>
                        </div>
                        <div class="box-container">
                            <div class="box-header">
                                <span>Real-time Network Leads Feed</span>
                                <span style="font-size: 11px; color: #1bc5bd;">Connected ( Live )</span>
                            </div>
                            <ul id="live-leads-list" class="notification-list"></ul>
                        </div>
                    </div>

                    <div class="right-column">
                        <div class="metrics-grid-2x2">
                            <div class="metric-box box-clicks"><h2 id="metric-clicks">0</h2><h4>Clicks</h4><div class="trend-indicator" id="trend-clicks">0% ▲</div></div>
                            <div class="metric-box box-leads"><h2 id="metric-leads">0</h2><h4>Leads</h4><div class="trend-indicator" id="trend-leads">0% ▲</div></div>
                            <div class="metric-box box-earn"><h2 id="metric-earnings">$0.00</h2><h4>Earnings</h4><div class="trend-indicator" id="trend-earnings">0% ▲</div></div>
                            <div class="metric-box box-epc"><h2 id="metric-epc">$0.00</h2><h4>EPC</h4><div class="trend-indicator" id="trend-epc">0% ▲</div></div>
                        </div>

                        <div class="box-container" style="margin-bottom: 20px;">
                            <div class="box-header">
                                <span>📡 My Click Tracking (Affiliate + Click ID)</span>
                                <span style="font-size: 12px; color:#1bc5bd;">Live</span>
                            </div>
                            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                                <div style="background: var(--bg-dark); padding: 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                                    <span style="font-size: 11px; color: var(--text-muted);">Total Clicks (Affiliate ID)</span>
                                    <h3 id="aff-ct-total" style="color:#3699ff; margin-top: 4px;">0</h3>
                                </div>
                                <div style="background: var(--bg-dark); padding: 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                                    <span style="font-size: 11px; color: var(--text-muted);">Last Click At</span>
                                    <h3 id="aff-ct-last" style="color:#ffa800; font-size: 15px; margin-top: 4px;">—</h3>
                                </div>
                            </div>
                            <div style="background: var(--bg-dark); padding: 10px; border-radius: 6px; border: 1px solid var(--border-color); font-size: 12px; color: var(--text-muted);">
                                <strong style="color: var(--text-main);">My Persistent Click ID:</strong>
                                <code id="aff-main-click-id" style="color:#1bc5bd; margin-left: 6px;">—</code>
                            </div>
                        </div>

                        <div class="box-container" style="margin-bottom: 20px;">
                            <div class="box-header">
                                <span>Top Offers Feed</span>
                                <span style="font-size: 12px; color: #1bc5bd;">API Active</span>
                            </div>
                            <div style="margin-bottom: 12px; background: var(--bg-dark); padding: 10px 12px; border-radius: 6px; border: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                                <a id="preview-global-link" href="https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u814724&sub5=s1" target="_blank" style="color: #3699ff; text-decoration: none; font-weight: 500; font-size: 13px;">Master Global Smart Link Rotator</a>
                                <div class="offer-actions">
                                    <button class="btn-getlink" onclick="trackAndOpenLink(document.getElementById('preview-global-link').href)">Get Link</button>
                                </div>
                            </div>
                            <div id="offerContainer">
                                <div style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 10px;">Loading API offers...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-campaigns" class="hidden">
                <div class="box-container">
                    <div class="box-header">
                        <span>Campaign Creation & Management</span>
                        <button style="background: #3699ff; color: #fff; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="switchView('view-dashboard')">← Back to Dashboard</button>
                    </div>
                    <div style="background: var(--bg-dark); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 20px;">
                        <span style="color: var(--text-muted);">Minimum deposit required to create a campaign: <strong style="color:#f64e60;">$500.00</strong></span>
                        <span style="margin-left: 15px; font-weight: bold; color: #1bc5bd;">Current Balance: <span id="campaign-balance-amount">$0.00</span></span>
                    </div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color); margin-bottom: 25px;">
                        <h4 style="color: var(--text-main); margin-bottom: 15px;">Create New Campaign</h4>
                        <div class="form-group">
                            <label>Campaign Name</label>
                            <input type="text" id="campaign-name-input" class="form-control" placeholder="My First Campaign" style="background: var(--card-bg);">
                        </div>
                        <button class="btn-submit" id="btn-create-campaign" style="width: 200px;">Create Campaign</button>
                    </div>
                    <div>
                        <h4 style="color: var(--text-main); margin-bottom: 10px;">Your Campaigns</h4>
                        <div id="campaigns-list-container" style="background: var(--bg-dark); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <div style="text-align: center; color: var(--text-muted);">No campaigns created yet.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-balance" class="hidden">
                <div class="box-container">
                    <div class="box-header">
                        <span>Balance & Bitcoin Payout Invoices</span>
                        <button style="background: #3699ff; color: #fff; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="switchView('view-dashboard')">← Back to Dashboard</button>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
                        <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <span style="font-size: 13px; color: var(--text-muted);">Available Bitcoin Payout Balance</span>
                            <h3 id="bitcoin-payout-balance" style="font-size: 26px; color: #1bc5bd; margin-top: 8px;">$0.00</h3>
                            <span style="font-size: 11px; color: var(--text-muted);">Minimum Payout: $100.00</span>
                        </div>
                        <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <span style="font-size: 13px; color: var(--text-muted);">Next Monday Auto-Invoice</span>
                            <h3 style="font-size: 20px; color: #ffa800; margin-top: 8px;">Every Monday</h3>
                            <span style="font-size: 11px; color: var(--text-muted);">Auto-generated if balance >= $100</span>
                        </div>
                        <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <span style="font-size: 13px; color: var(--text-muted);">Bitcoin Payout Day</span>
                            <h3 style="font-size: 20px; color: #3699ff; margin-top: 8px;">Every Tuesday</h3>
                            <span style="font-size: 11px; color: var(--text-muted);">Sent directly to BTC Wallet</span>
                        </div>
                    </div>
                    <div style="font-weight: bold; margin-bottom: 12px; font-size: 15px; color: var(--text-main);">Bitcoin Invoices & Payout History</div>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr><th>Invoice ID</th><th>Created Date (Monday)</th><th>Amount</th><th>Method</th><th>Status</th></tr>
                            </thead>
                            <tbody id="bitcoin-invoices-table-body">
                                <tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding: 15px;">No pending invoices. Invoices auto-generate on Monday if balance reaches $100+.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-offers" class="hidden">
                <div class="box-container">
                    <div class="box-header">
                        <span>All Geo-Targeted Multi-Country Offers</span>
                        <button style="background: #3699ff; color: #fff; border: none; padding: 6px 14px; border-radius: 4px; cursor: pointer; font-size: 13px;" onclick="switchView('view-dashboard')">← Back to Dashboard</button>
                    </div>
                    <div class="tab-filters">
                        <button class="filter-btn active" onclick="filterOffers('all', this)">All Country Offers</button>
                        <button class="filter-btn" onclick="filterOffers('install', this)">App Installs</button>
                        <button class="filter-btn" onclick="filterOffers('sport', this)">Sports & Gaming</button>
                        <button class="filter-btn" onclick="filterOffers('gift', this)">Gift Cards & Surveys</button>
                        <button class="filter-btn" onclick="filterOffers('traffic', this)">Standard Traffic</button>
                    </div>
                    <div id="allOffersContainer">
                        <div style="color: var(--text-muted); font-size: 14px; text-align: center; padding: 20px;">Loading Multi-Country Offers...</div>
                    </div>
                </div>
            </div>

            <div id="view-smartlinks" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Smart Links Management</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h3 style="color: var(--text-main); margin-bottom: 10px;">Master Global Rotator Link</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 15px;">Routes global traffic across multi-country offers with optimized EPC.</p>
                        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                            <input type="text" class="form-control" style="background: var(--card-bg); color: var(--text-main);" readonly id="master-smartlink-input">
                            <button class="btn-submit" style="margin-top:0; width: 150px;" onclick="trackAndOpenLink(document.getElementById('master-smartlink-input').value)">Copy Link</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-reports" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>My Performance Reports & Real-time Analytics</span></div>
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; align-items: end;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Start Date</label>
                            <input type="date" id="report-date-start" class="form-control" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label>End Date</label>
                            <input type="date" id="report-date-end" class="form-control" style="background: var(--card-bg);">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Click ID</label>
                            <input type="text" id="report-click-id" class="form-control" placeholder="Search by Click ID" style="background: var(--card-bg); width: 200px;">
                        </div>
                        <button class="btn-submit" id="btn-apply-report-filter" style="margin-top:0; width: 120px;">Apply Filter</button>
                    </div>
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr><th>Timestamp</th><th>Click ID</th><th>Campaign</th><th>IP</th><th>Conversion</th><th>Earnings</th></tr>
                            </thead>
                            <tbody id="reports-table-body">
                                <tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding: 15px;">No data. Apply filter or wait for live events.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-referral" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Affiliate Referral Program</span></div>
                    <div style="background: var(--bg-dark); padding: 25px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h3 style="color: var(--text-main); margin-bottom: 10px;">Invite Friends & Earn 5% Commission</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Share your unique referral link below. Automatically tied to your account on app.admadia.site!</p>
                        <div class="form-group">
                            <label>Your Unique Referral Link</label>
                            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                <input type="text" id="user-referral-link" class="form-control" style="background: var(--card-bg); color: var(--text-main);" readonly>
                                <button class="btn-submit" style="margin-top:0; width: 150px;" onclick="copyReferralLink()">Copy Link</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Your Affiliate FF ID</label>
                            <input type="text" id="user-ff-id-display" class="form-control" style="background: var(--card-bg); color: var(--text-main);" readonly>
                        </div>
                        <div style="border-top: 1px solid var(--border-color); margin: 20px 0;"></div>
                        <h3 style="color: var(--text-main); margin-bottom: 10px;">🎁 Redeem Promo Code</h3>
                        <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 10px;">Enter a promo code shared with you to receive a bonus credit.</p>
                        <div style="display: flex; gap: 10px; margin-bottom: 25px;">
                            <input type="text" id="promo-code-input" class="form-control" placeholder="Enter promo code..." style="background: var(--card-bg); color: var(--text-main);">
                            <button class="btn-submit" style="margin-top:0; width: 150px; background:#1bc5bd;" onclick="redeemPromoCode()">Redeem</button>
                        </div>
                        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                            <div style="background: var(--card-bg); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); flex: 1;">
                                <span style="font-size: 12px; color: var(--text-muted);">Total Referred Users</span>
                                <h3 id="ref-total-count" style="font-size: 24px; color: #3699ff; margin-top: 5px;">0</h3>
                            </div>
                            <div style="background: var(--card-bg); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color); flex: 1;">
                                <span style="font-size: 12px; color: var(--text-muted);">Total Referral Earnings</span>
                                <h3 id="ref-total-earnings" style="font-size: 24px; color: #1bc5bd; margin-top: 5px;">$0.00</h3>
                            </div>
                        </div>
                        <div style="font-weight: bold; margin-bottom: 12px; font-size: 14px; color: var(--text-main);">Referred Users List</div>
                        <div style="background: var(--card-bg); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color);">
                            <table class="data-table">
                               <thead>
                                   <tr><th>Referred User Email</th><th>Join Date</th><th>Commission Generated</th></tr>
                               </thead>
                               <tbody id="referred-users-table-body">
                                   <tr><td colspan="3" style="text-align:center; color: var(--text-muted); padding: 12px;">No referrals yet. Share your link to start earning!</td></tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-templates" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Offer & Landing Page Templates</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Custom global & country-wise landing page templates.</p>
                    </div>
                </div>
            </div>

            <div id="view-payments" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Payout Invoices & Bitcoin History</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 15px;">Invoices are created automatically every Monday if balance >= $100. Paid every Tuesday via Bitcoin.</p>
                    </div>
                </div>
            </div>

            <div id="view-postback" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Postback</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <div class="form-group">
                            <label>Global Postback URL</label>
                            <input type="text" class="form-control" style="background: var(--card-bg);" value="https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u814724&sub5=s1clickid={clickid}&payout={payout}">
                        </div>
                        <button class="btn-submit" style="width: 150px;" onclick="showToast('Postback saved successfully!', 'success')">Save Postback</button>
                    </div>
                </div>
            </div>

            <div id="view-profile" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>My Account & Profile Settings</span></div>
                    <div style="background: var(--bg-dark); padding: 25px; border-radius: 6px; border: 1px solid var(--border-color); display: flex; gap: 30px; align-items: center; flex-wrap: wrap;">
                        <div style="text-align: center;">
                            <img id="profile-view-avatar" src="https://i.pravatar.cc/100?img=12" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #3699ff; margin-bottom: 10px;">
                            <br>
                            <input type="text" id="input-avatar-url" class="form-control" placeholder="Avatar Image URL" style="width: 220px; font-size: 11px; margin-top: 5px;">
                            <button class="btn-submit" style="font-size: 12px; padding: 6px; margin-top: 5px;" onclick="updateProfileAvatar()">Update Avatar</button>
                        </div>
                        <div style="flex-grow: 1;">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="profile-input-name" class="form-control" style="background: var(--card-bg);" value="Affiliate User">
                            </div>
                            <div class="form-group">
                                <label>Email Address (Read Only)</label>
                                <input type="text" id="profile-input-email" class="form-control" style="background: var(--card-bg);" readonly>
                            </div>
                            <div class="form-group">
                                <label>Affiliate FF ID</label>
                                <input type="text" id="profile-input-ffid" class="form-control" style="background: var(--card-bg);" readonly>
                            </div>
                            <div class="form-group">
                                <label>Affiliate Account ID & Profile ID</label>
                                <input type="text" id="profile-input-id" class="form-control" style="background: var(--card-bg);" readonly>
                            </div>
                            <div class="form-group">
                                <label>My Persistent Click ID (Main Tracking ID)</label>
                                <input type="text" id="profile-input-clickid" class="form-control" style="background: var(--card-bg);" readonly>
                            </div>
                            <div class="form-group">
                                <label>Bitcoin Wallet Address (For Tuesday Payouts)</label>
                                <input type="text" id="profile-input-btc" class="form-control" style="background: var(--card-bg);" placeholder="bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh">
                            </div>
                            <button class="btn-submit" style="width: 180px; background: #1bc5bd;" onclick="saveProfileChanges()">Save Profile</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="view-adv-deposits" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Deposits & Bitcoin (BTC) Funding</span></div>
                    <div style="background: var(--bg-dark); padding: 25px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h3 style="color: var(--text-main); margin-bottom: 10px;">Fund Your Advertiser Balance via Bitcoin</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Send BTC to our wallet address and submit your transaction ID (TxID) and receipt below for instant credit verification by the admin.</p>
                        <div class="form-group">
                            <label>Official Network BTC Deposit Wallet</label>
                            <input type="text" class="form-control" style="background: var(--card-bg);" value="bc1qadvertiserfundwalletaddresssample998877" readonly>
                        </div>
                        <div class="form-group">
                            <label>Transaction ID (TxID)</label>
                            <input type="text" id="adv-btc-txid" class="form-control" placeholder="Enter Bitcoin TxID..." style="background: var(--card-bg);">
                        </div>
                        <div class="form-group">
                            <label>Payment Receipt Screenshot</label>
                            <input type="file" id="adv-btc-receipt" class="form-control" style="background: var(--card-bg); padding: 8px;">
                        </div>
                        <button class="btn-submit" style="width: 220px; background: #1bc5bd; margin-top: 10px;" onclick="submitBitcoinDeposit()">Submit Bitcoin Deposit</button>
                    </div>
                </div>
            </div>

            <div id="view-adv-campaigns" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Campaign Management & Ad Setup</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <h3 style="color: var(--text-main); margin-bottom: 10px;">Your Active Ad Campaigns</h3>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 15px;">Create, configure, and monitor your global traffic ad campaigns seamlessly.</p>
                        <button class="btn-submit" style="width: 200px; margin-bottom: 20px;" onclick="showToast('New Campaign Creator Modal Open')">+ Create New Campaign</button>
                        <table class="data-table">
                            <thead>
                                <tr><th>Campaign ID</th><th>Title</th><th>Budget</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CMP-5011</td><td>Global App Install Push</td><td>$500.00</td>
                                    <td><span style="color: #1bc5bd; font-weight: bold;">Running 🟢</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-adv-statistics" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Advertiser Performance Statistics</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Detailed click-through rates, conversions, and traffic delivery stats for your campaigns.</p>
                    </div>
                </div>
            </div>

            <div id="view-adv-traffic-demand" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Traffic Demand</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Geo-targeted traffic volume requirements and real-time market demand.</p>
                    </div>
                </div>
            </div>

            <div id="view-adv-traffic-sources" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Traffic Sources</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Analyze approved publisher sources delivering traffic to your campaigns.</p>
                    </div>
                </div>
            </div>

            <div id="view-adv-contact-sources" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Contact Sources</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Manage contact channels and leads generated from your ads.</p>
                    </div>
                </div>
            </div>

            <div id="view-adv-whitelists" class="hidden">
                <div class="box-container">
                    <div class="box-header"><span>Whitelists Management</span></div>
                    <div style="background: var(--bg-dark); padding: 20px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <p style="color: var(--text-muted); font-size: 14px;">Manage publisher whitelists and traffic filtering criteria.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- OFFER DETAILS MODAL -->
    <div id="offer-modal" class="modal-overlay hidden">
        <div class="modal-box">
            <div class="modal-header-top">
                <h3 id="modal-title">Offer Name</h3>
                <button class="close-btn" onclick="closeOfferModal()">✖</button>
            </div>
            <div>
                <div class="modal-detail-row"><span class="label">Offer ID:</span><span class="val" id="modal-id">---</span></div>
                <div class="modal-detail-row"><span class="label">Category:</span><span class="val" id="modal-category">---</span></div>
                <div class="modal-detail-row"><span class="label">Network Status:</span><span class="val" style="color: #1bc5bd; font-weight: bold;">Active</span></div>
                <div class="modal-detail-row"><span class="label">Preview URL:</span><a id="modal-preview-url" href="#" target="_blank" style="color: #3699ff; text-decoration: none;">Click to Preview</a></div>
                <div style="margin-top: 20px;">
                    <label style="color: var(--text-muted); font-size: 13px; margin-bottom: 5px; display: block;">Your Unique Tracking Link</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="modal-track-link" class="form-control" style="background: var(--bg-dark); color: var(--text-main);" readonly>
                        <button class="btn-submit" style="margin-top:0; width: 130px; background: #8950fc;" onclick="trackAndOpenLink(document.getElementById('modal-track-link').value)">Copy Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADMIN USER DETAIL MODAL -->
    <div id="admin-user-modal" class="modal-overlay hidden">
        <div class="modal-box lg">
            <div class="modal-header-top">
                <h3 id="admin-user-modal-title">User Details</h3>
                <button class="close-btn" onclick="closeAdminUserModal()">✖</button>
            </div>
            <div id="admin-user-modal-body"></div>
        </div>
    </div>

    <!-- ADMIN OFFER EDIT MODAL -->
    <div id="admin-offer-modal" class="modal-overlay hidden">
        <div class="modal-box">
            <div class="modal-header-top">
                <h3>Edit Offer</h3>
                <button class="close-btn" onclick="closeAdminOfferModal()">✖</button>
            </div>
            <div class="form-group">
                <label>Offer Name</label>
                <input type="text" id="edit-offer-name" class="form-control" style="background: var(--bg-dark);">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" id="edit-offer-country" class="form-control" style="background: var(--bg-dark);">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select id="edit-offer-category" class="form-control" style="background: var(--bg-dark); color: var(--text-main);">
                        <option value="install">App Install</option>
                        <option value="sport">Sports & Gaming</option>
                        <option value="gift">Gift Card & Survey</option>
                        <option value="traffic">Standard Traffic</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Payout</label>
                    <input type="text" id="edit-offer-payout" class="form-control" style="background: var(--bg-dark);">
                </div>
                <div class="form-group">
                    <label>EPC</label>
                    <input type="text" id="edit-offer-epc" class="form-control" style="background: var(--bg-dark);">
                </div>
            </div>
            <div class="form-group">
                <label>Base Tracking URL</label>
                <input type="text" id="edit-offer-url" class="form-control" style="background: var(--bg-dark);">
            </div>
            <button class="btn-submit" id="btn-offer-save-edit" style="background:#1bc5bd;">Save Changes</button>
        </div>
    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <script type="module">
        /* ============================================================
         *  FIREBASE REALTIME DATABASE SECURITY RULES (REFERENCE)
         *  ------------------------------------------------------------
         *  Paste these into Firebase Console → Realtime Database → Rules.
         *
         *  {
         *    "rules": {
         *      "admins": {
         *        ".read": "auth != null",
         *        "$uid": {
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || !data.exists())",
         *          ".validate": "newData.isBoolean()"
         *        }
         *      },
         *      "managers": {
         *        ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())",
         *        ".write": "root.child('admins').child(auth.uid).exists()"
         *      },
         *      "users": {
         *        "$key": {
         *          ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $key)",
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $key)"
         *        }
         *      },
         *      "offers": {
         *        ".read": "auth != null",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      },
         *      "trackings": {
         *        "$affKey": {
         *          ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)",
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "dailyCounters": {
         *        "$affKey": {
         *          ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)",
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "clickTracking": {
         *        ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())",
         *        "$affKey": {
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "campaigns": {
         *        "$affKey": {
         *          ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)",
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "chat": {
         *        ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || root.child('chatMeta').child(auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_')).exists())",
         *        "$affKey": {
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "chatMeta": {
         *        ".read": "auth != null",
         *        "$affKey": {
         *          ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $affKey)"
         *        }
         *      },
         *      "settings": {
         *        ".read": "auth != null",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      },
         *      "postbacks": {
         *        ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      },
         *      "invoices": {
         *        ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      },
         *      "leads": {
         *        ".read": "auth != null",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      },
         *      "notifications": {
         *        "$key": {
         *          ".read": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists() || auth.token.email.replace('.','_').replace('#','_').replace('$','_').replace('/','_').replace('[','_').replace(']','_') == $key)",
         *          ".write": "auth != null"
         *        }
         *      },
         *      "promoCodes": {
         *        ".read": "auth != null",
         *        ".write": "auth != null && (root.child('admins').child(auth.uid).exists() || root.child('managers').child(auth.uid).exists())"
         *      }
         *    }
         *  }
         * ============================================================ */

        import { initializeApp, deleteApp } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-app.js";
        import {
            getAuth,
            signInWithEmailAndPassword,
            createUserWithEmailAndPassword,
            sendPasswordResetEmail,
            signOut,
            onAuthStateChanged
        } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-auth.js";
        import {
            getDatabase,
            ref, set, get, update, remove, onValue, push,
            onChildAdded, query, limitToLast, serverTimestamp
        } from "https://www.gstatic.com/firebasejs/10.8.1/firebase-database.js";

        const firebaseConfig = {
            apiKey: "AIzaSyC3BWv3vXPezOg-LTMsZgoqOXAJH5UsvyY",
            authDomain: "adbluemedia-156b6.firebaseapp.com",
            databaseURL: "https://adbluemedia-156b6-default-rtdb.firebaseio.com",
            projectId: "adbluemedia-156b6",
            storageBucket: "adbluemedia-156b6.firebasestorage.app",
            messagingSenderId: "898064142957",
            appId: "1:898064142957:web:c077026297cd307e862564",
            measurementId: "G-GE7P1D17LZ"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        try {
            const { getAnalytics } = await import("https://www.gstatic.com/firebasejs/10.8.1/firebase-analytics.js");
            getAnalytics(app);
        } catch (e) { /* analytics optional */ }

        const SESSION_KEY = "admadia_session_v1";
        const SESSION_DAYS = 3;

        // ============================================================
        //  XOR-SEALED ADMIN BOOTSTRAP CREDENTIALS
        //  ------------------------------------------------------------
        //  Plaintext:
        //    Email:    admin@admadia.site
        //    Password: Adm@dia2024!Secure
        // ============================================================
        const _SEAL_EMAIL = [59, 62, 55, 51, 52, 26, 59, 62, 55, 59, 62, 51, 59, 116, 41, 51, 46, 63];
        const _SEAL_PW    = [27, 62, 55, 26, 62, 51, 59, 104, 106, 104, 110, 123, 9, 63, 57, 47, 40, 63];
        const _SEAL_K     = 0x5A;
        function _unseal(codes) {
            let out = "";
            for (let i = 0; i < codes.length; i++) out += String.fromCharCode(codes[i] ^ _SEAL_K);
            return out;
        }
        const _ADMIN_EMAIL = _unseal(_SEAL_EMAIL);
        const _ADMIN_PASSWORD = _unseal(_SEAL_PW);

        let _adminBootstrapped = false;
        async function ensureAdminBootstrap() {
            if (_adminBootstrapped) return;
            _adminBootstrapped = true;
            try {
                const existing = await get(ref(db, "admins"));
                if (existing.exists() && Object.keys(existing.val() || {}).length > 0) return;
            } catch (e) {
                console.warn("Admin bootstrap pre-check skipped:", e && e.message);
            }

            let secondaryApp = null;
            try {
                secondaryApp = initializeApp(firebaseConfig, "AdmBootstrap_" + Date.now());
                const sAuth = getAuth(secondaryApp);
                let cred = null;
                try {
                    cred = await signInWithEmailAndPassword(sAuth, _ADMIN_EMAIL, _ADMIN_PASSWORD);
                } catch (signInErr) {
                    const code = signInErr && signInErr.code ? signInErr.code : "";
                    const recoverable =
                        code === "auth/user-not-found" ||
                        code === "auth/invalid-credential" ||
                        code === "auth/invalid-login-credentials" ||
                        code === "auth/wrong-password";
                    if (!recoverable) throw signInErr;
                    try {
                        cred = await createUserWithEmailAndPassword(sAuth, _ADMIN_EMAIL, _ADMIN_PASSWORD);
                    } catch (createErr) {
                        const cCode = createErr && createErr.code ? createErr.code : "";
                        if (cCode === "auth/email-already-in-use") {
                            console.warn("Admin account exists with a different password. Bootstrap aborted.");
                            return;
                        }
                        throw createErr;
                    }
                }
                if (cred && cred.user) await set(ref(db, "admins/" + cred.user.uid), true);
                await signOut(sAuth);
            } catch (e) {
                console.warn("Admin bootstrap skipped:", e && (e.code || e.message));
            } finally {
                if (secondaryApp) { try { await deleteApp(secondaryApp); } catch (_) {} }
            }
        }
        ensureAdminBootstrap();

        // ---------- View ↔ hash mappings (for router) ----------
        const VIEW_TO_HASH = {
            'view-dashboard':           'dashboard',
            'view-campaigns':           'campaigns',
            'view-balance':             'balance',
            'view-offers':              'offers',
            'view-smartlinks':          'smartlinks',
            'view-reports':             'reports',
            'view-referral':            'referral',
            'view-templates':           'templates',
            'view-payments':            'payments',
            'view-postback':            'postback',
            'view-profile':             'profile',
            'view-adv-deposits':        'adv-deposits',
            'view-adv-campaigns':       'adv-campaigns',
            'view-adv-statistics':      'adv-statistics',
            'view-adv-traffic-demand':  'adv-traffic-demand',
            'view-adv-traffic-sources': 'adv-traffic-sources',
            'view-adv-contact-sources': 'adv-contact-sources',
            'view-adv-whitelists':      'adv-whitelists',
            'admin-view-overview':              'admin-overview',
            'admin-view-settings':              'admin-settings',
            'admin-view-redirect':              'admin-redirect',
            'admin-view-postbacks':             'admin-postbacks',
            'admin-view-invoices':              'admin-invoices',
            'admin-view-inbox':                 'admin-inbox',
            'admin-view-offers':                'admin-offers',
            'admin-view-users':                 'admin-users',
            'admin-view-advertiser-approvals':  'admin-advertiser-approvals',
            'admin-view-live-earnings':         'admin-live-earnings',
            'admin-view-click-tracking':        'admin-click-tracking',
            'admin-view-traffic-quality':       'admin-traffic-quality',
            'admin-view-managers':              'admin-managers'
        };
        const HASH_TO_VIEW = Object.fromEntries(
            Object.entries(VIEW_TO_HASH).map(([view, hash]) => [hash, view])
        );
        const VIEW_TO_MENU = {
            'view-dashboard':           'menu-dashboard',
            'view-campaigns':           'menu-campaigns',
            'view-balance':             'menu-balance',
            'view-offers':              'menu-offers',
            'view-smartlinks':          'menu-smartlinks',
            'view-reports':             'menu-reports',
            'view-referral':            'menu-referral',
            'view-templates':           'menu-templates',
            'view-payments':            'menu-payments',
            'view-postback':            'menu-postback',
            'view-profile':             'menu-profile',
            'view-adv-deposits':        'menu-adv-deposits',
            'view-adv-campaigns':       'menu-adv-campaigns',
            'view-adv-statistics':      'menu-adv-statistics',
            'view-adv-traffic-demand':  'menu-adv-traffic-demand',
            'view-adv-traffic-sources': 'menu-adv-traffic-sources',
            'view-adv-contact-sources': 'menu-adv-contact-sources',
            'view-adv-whitelists':      'menu-adv-whitelists',
            'admin-view-overview':              'admin-menu-overview',
            'admin-view-settings':              'admin-menu-settings',
            'admin-view-redirect':              'admin-menu-redirect',
            'admin-view-postbacks':             'admin-menu-postbacks',
            'admin-view-invoices':              'admin-menu-invoices',
            'admin-view-inbox':                 'admin-menu-inbox',
            'admin-view-offers':                'admin-menu-offers',
            'admin-view-users':                 'admin-menu-users',
            'admin-view-advertiser-approvals':  'admin-menu-advertiser-approvals',
            'admin-view-live-earnings':         'admin-menu-live-earnings',
            'admin-view-click-tracking':        'admin-menu-click-tracking',
            'admin-view-traffic-quality':       'admin-menu-traffic-quality',
            'admin-view-managers':              'admin-menu-managers'
        };

        // ---------- Toast ----------
        window.showToast = function(message, type='info', duration=3500) {
            const t = document.createElement('div');
            t.className = 'toast ' + (type || '');
            t.textContent = message;
            document.body.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; t.style.transition='opacity .3s'; }, duration);
            setTimeout(() => t.remove(), duration + 350);
        };

        // ---------- Session ----------
        function saveSession(email, role, ffid, mainClickId, uid) {
            const expires = Date.now() + (SESSION_DAYS * 24 * 60 * 60 * 1000);
            try {
                localStorage.setItem(SESSION_KEY, JSON.stringify({
                    email, role, ffid, uid: uid || null,
                    mainClickId: mainClickId || null,
                    expires
                }));
            } catch(e) { console.warn('localStorage unavailable', e); }
        }
        function loadSession() {
            try {
                const raw = localStorage.getItem(SESSION_KEY);
                if (!raw) return null;
                const s = JSON.parse(raw);
                if (!s || !s.expires || s.expires < Date.now()) {
                    localStorage.removeItem(SESSION_KEY);
                    return null;
                }
                return s;
            } catch(e) { return null; }
        }
        function clearSession() {
            try { localStorage.removeItem(SESSION_KEY); } catch(e) {}
        }

        // ---------- Global state ----------
        let currentApiKey = "https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u814724&sub5=s1";
        let masterGlobalLink = "https://app.trcefy.com/click?pid=2&offer_id=23972&sub2=u814724&sub5=s1";
        let cachedOffers = [];
        let currentOfferFilter = 'all';
        let loggedInUserEmail = "";
        let loggedInUserFFId = "";
        let loggedInUserMainClickId = "";
        let currentRole = "";

        // Redirect controller state
        let redirectSettings = { enabled: false, targetUrl: '' };

        // Chat state
        let chatEnabledState = true;
        let affiliateChatListener = null;
        let affiliateChatToggleListener = null;
        let adminInboxMetaListener = null;
        let adminInboxMsgUnsub = null;
        let adminInboxSelectedKey = null;

        // ---------- Utilities ----------
        function generateUniqueClickId() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const length = Math.floor(Math.random() * 11) + 10;
            let r = '';
            for (let i = 0; i < length; i++) r += chars.charAt(Math.floor(Math.random() * chars.length));
            return r;
        }
        function hashString(str) {
            let h = 0;
            for (let i = 0; i < str.length; i++) { h = ((h << 5) - h) + str.charCodeAt(i); h |= 0; }
            return h.toString();
        }
        function safeKey(email) { return String(email).replace(/[\.#\$\/\[\]]/g, '_'); }
        function todayKey() { return new Date().toISOString().slice(0, 10); }
        function escAttr(s) {
            return String(s == null ? '' : s)
                .replace(/\\/g, '\\\\')
                .replace(/'/g, "\\'")
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }
        function escapeHtml(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, c => ({
                '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
            }[c]));
        }

        // ---------- Sound ----------
        function playClickSound() {
            try {
                const a = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdYivh5eMf2p5e32QmYuPmI2IiX97fXp5eXl4eXd3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAA');
                a.play().catch(()=>{});
            } catch(e) {}
        }
        function playConversionSound() {
            try {
                const a = new Audio('data:audio/wav;base64,UklGRkZGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQYGAACBhYqFbF1fdYivh5eMf2p5e32QmYuPmI2IiX97fXp5eXl4eXd3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAA');
                a.play().catch(()=>{});
            } catch(e) {}
        }

        // ---------- Click-ID helpers ----------
        async function ensureMainClickId(email) {
            if (!email) return null;
            const key = safeKey(email);
            const pRef = ref(db, `users/${key}/profile`);
            try {
                const snap = await get(pRef);
                if (!snap.exists()) {
                    const newId = 'CID-' + generateUniqueClickId();
                    await set(pRef, {
                        email, mainClickId: newId, createdAt: Date.now(),
                        status: 'Approved', rank: 'Standard Affiliate', name: email.split('@')[0]
                    });
                    return newId;
                }
                const p = snap.val();
                if (p.mainClickId) return p.mainClickId;
                const newId = 'CID-' + generateUniqueClickId();
                await update(pRef, { mainClickId: newId });
                return newId;
            } catch(e) {
                console.warn('ensureMainClickId error:', e);
                return 'CID-' + generateUniqueClickId();
            }
        }

        async function recordClickForTracking(affiliateKey, clickId) {
            const now = Date.now();
            try {
                const summaryRef = ref(db, `clickTracking/${affiliateKey}/summary`);
                const sSnap = await get(summaryRef);
                const sData = sSnap.exists() ? sSnap.val() : { totalClicks: 0 };
                await update(summaryRef, {
                    affiliateId: affiliateKey,
                    totalClicks: (sData.totalClicks || 0) + 1,
                    lastClickAt: now
                });

                const clickIdRef = ref(db, `clickTracking/${affiliateKey}/clickIds/${clickId}`);
                const cSnap = await get(clickIdRef);
                const cData = cSnap.exists() ? cSnap.val() : { count: 0 };
                await update(clickIdRef, {
                    affiliateId: affiliateKey,
                    clickId: clickId,
                    count: (cData.count || 0) + 1,
                    lastClickAt: now
                });
            } catch(e) {
                console.warn('recordClickForTracking error:', e);
            }
        }

        function buildTrackingLink(baseUrl, affiliateFfId, clickId) {
            const marker = 'sub5=s1';
            const idx = baseUrl.indexOf(marker);
            let base = baseUrl;
            if (idx !== -1) base = baseUrl.substring(0, idx + marker.length);
            const ffid = affiliateFfId || 'FF-00000';
            const cid = clickId || ('CID-' + generateUniqueClickId());
            return { url: base + 'admedia_' + cid + '_admedia_' + ffid, clickId: cid };
        }

        // ---------- Redirect URL builder ----------
        function buildRedirectUrl(target, ffid, clickId) {
            const sep = target.includes('?') ? '&' : '?';
            const sub5 = 'admedia_' + clickId + '_admedia_' + (ffid || 'FF-00000');
            return target + sep +
                'clickid=' + encodeURIComponent(clickId) +
                '&aff=' + encodeURIComponent(ffid || 'FF-00000') +
                '&sub5=' + encodeURIComponent(sub5);
        }

        // Builds the final outbound link honouring the Redirect Controller
        function buildFinalLink(baseUrl, ffidOverride, clickIdOverride) {
            const ffid = ffidOverride || loggedInUserFFId || 'FF-00000';
            const cid = clickIdOverride || loggedInUserMainClickId || ('CID-' + generateUniqueClickId());
            if (redirectSettings.enabled && redirectSettings.targetUrl) {
                return buildRedirectUrl(redirectSettings.targetUrl, ffid, cid);
            }
            const base = String(baseUrl || masterGlobalLink).split('admedia_')[0];
            return buildTrackingLink(base, ffid, cid).url;
        }

        async function isNewIP(affiliateKey, ip) {
            const trackingsRef = ref(db, `trackings/${affiliateKey}`);
            const now = Date.now();
            const oneDayAgo = now - 24 * 60 * 60 * 1000;
            try {
                const snap = await get(trackingsRef);
                if (snap.exists()) {
                    let isNew = true;
                    snap.forEach(child => {
                        const d = child.val();
                        if (d.ip === ip && d.timestamp >= oneDayAgo) { isNew = false; return true; }
                    });
                    return isNew;
                }
                return true;
            } catch(e) { return true; }
        }

        window.trackAndOpenLink = async function(linkUrl, offerId = null) {
            if (!loggedInUserEmail) {
                showToast('Please login as affiliate to track links.', 'error');
                return;
            }
            const key = safeKey(loggedInUserEmail);

            const mainClickId = await ensureMainClickId(loggedInUserEmail) || 'CID-' + generateUniqueClickId();
            loggedInUserMainClickId = mainClickId;
            const ctEl = document.getElementById('aff-main-click-id');
            if (ctEl) ctEl.innerText = mainClickId;

            // Honour the admin Redirect Controller
            const finalUrl = buildFinalLink(linkUrl, loggedInUserFFId || 'FF-00000', mainClickId);

            try { await navigator.clipboard.writeText(finalUrl); }
            catch(e) { console.warn('Clipboard failed', e); }

            let clientIp = 'unknown';
            try {
                const r = await fetch('https://api.ipify.org?format=json');
                const d = await r.json();
                clientIp = d.ip;
            } catch(e) {}

            const allowClick = await isNewIP(key, clientIp);
            const now = Date.now();
            const day = todayKey();
            const eventId = generateUniqueClickId();

            try {
                await set(ref(db, `trackings/${key}/${eventId}`), {
                    timestamp: now,
                    ip: clientIp,
                    deviceFp: hashString(navigator.userAgent + '|' + navigator.language + '|' + screen.width + 'x' + screen.height),
                    campaignId: offerId || 'global',
                    conversion: false,
                    earnings: 0,
                    clickId: mainClickId,
                    eventId: eventId,
                    affiliate: key,
                    affiliateFfId: loggedInUserFFId || 'FF-00000',
                    isDuplicate: !allowClick,
                    dateKey: day
                });
            } catch(e) { console.warn('trackings write failed', e); }

            await recordClickForTracking(key, mainClickId);

            const userStatsRef = ref(db, `users/${key}/stats`);
            const statsSnap = await get(userStatsRef);
            const stats = statsSnap.exists() ? statsSnap.val() : {};
            const totalClicks = (stats.clicks || 0) + 1;
            const dupe = (stats.duplicateClicks || 0) + (allowClick ? 0 : 1);
            const unique = (stats.uniqueClicks || 0) + (allowClick ? 1 : 0);
            await update(userStatsRef, {
                clicks: totalClicks,
                uniqueClicks: unique,
                duplicateClicks: dupe
            });

            const dailyRef = ref(db, `dailyCounters/${key}/${day}`);
            const dailySnap = await get(dailyRef);
            const daily = dailySnap.exists() ? dailySnap.val() : { clicks: 0, leads: 0, earnings: 0 };
            await set(dailyRef, {
                clicks: (daily.clicks || 0) + 1,
                leads: daily.leads || 0,
                earnings: daily.earnings || 0
            });

            playClickSound();
            if (redirectSettings.enabled && redirectSettings.targetUrl) {
                showToast('Link copied & click registered (Redirect active).', 'success');
            } else if (allowClick) {
                showToast('Link copied & click registered (new IP).', 'success');
            } else {
                showToast('Link copied. Duplicate IP flagged.', 'info');
            }
        };

        // ============================================================
        //  REALTIME SYNC (affiliate personal data)
        // ============================================================
        let realtimeSyncKey = null;
        function initializeRealtimeSync(key) {
            if (realtimeSyncKey === key) return;
            realtimeSyncKey = key;

            onValue(ref(db, `users/${key}`), (snap) => {
                if (!snap.exists()) return;
                const data = snap.val();
                const s = data.stats || { clicks: 0, leads: 0, earnings: 0 };

                document.getElementById('top-balance-amount').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('bitcoin-payout-balance').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('stat-week-earn').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('stat-month-earn').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('stat-day-earn').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('stat-hour-earn').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('chart-week-income').innerText = `$${Number(s.earnings||0).toFixed(2)}`;
                document.getElementById('chart-leads-count').innerText = s.leads || 0;
                const epc = (s.clicks > 0) ? (s.earnings / s.clicks).toFixed(2) : "0.00";
                document.getElementById('chart-epc-val').innerText = `$${epc}`;
                const conv = (s.clicks > 0) ? ((s.leads / s.clicks) * 100).toFixed(2) : "0.00";
                document.getElementById('chart-conv-rate').innerText = `${conv}%`;

                const monthPct = Math.min(Math.round(((s.earnings||0) / 60.65) * 100), 100);
                const weekPct = Math.min(Math.round(((s.earnings||0) / 3.99) * 100), 100);
                const dayPct = Math.min(Math.round(((s.earnings||0) / 0.48) * 100), 100);
                document.getElementById('circle-month').style.setProperty('--pgPercentage', monthPct);
                document.getElementById('percent-month').innerText = `${monthPct}%`;
                document.getElementById('circle-week').style.setProperty('--pgPercentage', weekPct);
                document.getElementById('percent-week').innerText = `${weekPct}%`;
                document.getElementById('circle-day').style.setProperty('--pgPercentage', dayPct);
                document.getElementById('percent-day').innerText = `${dayPct}%`;

                const dow = new Date().getDay();
                const ib = document.getElementById('bitcoin-invoices-table-body');
                if (s.earnings >= 100 && (dow === 1 || dow === 2)) {
                    ib.innerHTML = `<tr>
                        <td>INV-${Math.floor(Math.random()*90000+10000)}</td>
                        <td>Monday Auto-Generated</td>
                        <td style="font-weight:bold; color:#1bc5bd;">$${Number(s.earnings).toFixed(2)}</td>
                        <td>Bitcoin (BTC)</td>
                        <td><span style="background: rgba(255,168,0,0.1); color: #ffa800; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">${dow===1?'Pending (Monday)':'Paid (Tuesday)'}</span></td>
                    </tr>`;
                }

                const refList = data.referrals || {};
                const refArray = Object.values(refList);
                document.getElementById('ref-total-count').innerText = refArray.length;
                document.getElementById('ref-total-earnings').innerText = `$${(refArray.length * 15.00).toFixed(2)}`;
                if (refArray.length > 0) {
                    let h = '';
                    refArray.forEach(r => {
                        h += `<tr><td>${r.email||''}</td><td>${r.date||''}</td><td style="font-weight:bold; color:#1bc5bd;">+$15.00</td></tr>`;
                    });
                    document.getElementById('referred-users-table-body').innerHTML = h;
                }
            });

            const day = todayKey();
            onValue(ref(db, `dailyCounters/${key}/${day}`), (snap) => {
                const d = snap.exists() ? snap.val() : { clicks: 0, leads: 0, earnings: 0 };
                document.getElementById('metric-clicks').innerText = d.clicks || 0;
                document.getElementById('metric-leads').innerText = d.leads || 0;
                document.getElementById('metric-earnings').innerText = `$${Number(d.earnings||0).toFixed(2)}`;
                const epc = (d.clicks > 0) ? (d.earnings / d.clicks).toFixed(2) : "0.00";
                document.getElementById('metric-epc').innerText = `$${epc}`;
            });

            onValue(ref(db, `trackings/${key}`), (snap) => {
                if (window.incomeChart && snap.exists()) {
                    const days = [];
                    const today = new Date();
                    for (let i = 6; i >= 0; i--) {
                        const d = new Date(today); d.setDate(d.getDate() - i);
                        days.push(d.toISOString().slice(0,10));
                    }
                    const dailyEarnings = days.map(() => 0);
                    snap.forEach(child => {
                        const data = child.val();
                        if (data.conversion && data.earnings) {
                            const ds = new Date(data.timestamp).toISOString().slice(0,10);
                            const idx = days.indexOf(ds);
                            if (idx >= 0) dailyEarnings[idx] += data.earnings;
                        }
                    });
                    window.incomeChart.data.datasets[0].data = dailyEarnings;
                    window.incomeChart.update();
                }
            });

            onValue(ref(db, `clickTracking/${key}/summary`), (snap) => {
                const totalEl = document.getElementById('aff-ct-total');
                const lastEl = document.getElementById('aff-ct-last');
                if (!totalEl || !lastEl) return;
                if (snap.exists()) {
                    const v = snap.val();
                    totalEl.innerText = v.totalClicks || 0;
                    lastEl.innerText = v.lastClickAt ? new Date(v.lastClickAt).toLocaleString() : '—';
                } else {
                    totalEl.innerText = 0;
                    lastEl.innerText = '—';
                }
            });
        }

        // ============================================================
        //  AFFILIATE ↔ ADMIN PRIVATE CHAT (Centralized)
        // ============================================================
        function initAffiliateChat() {
            if (!loggedInUserEmail) return;
            const key = safeKey(loggedInUserEmail);

            if (affiliateChatToggleListener) affiliateChatToggleListener();
            affiliateChatToggleListener = onValue(ref(db, 'settings/chatEnabled'), (snap) => {
                chatEnabledState = snap.exists() ? !!snap.val() : true;
                updateAffiliateChatUI();
            });

            if (affiliateChatListener) affiliateChatListener();
            const chatRef = query(ref(db, `chat/${key}`), limitToLast(200));
            affiliateChatListener = onValue(chatRef, (snap) => {
                renderAffiliateChat(snap);
            });

            update(ref(db, `chatMeta/${key}`), { unreadForAffiliate: 0 }).catch(()=>{});
        }

        function updateAffiliateChatUI() {
            const input = document.getElementById('affiliate-chat-input');
            const btn = document.getElementById('btn-affiliate-send-chat');
            const box = document.getElementById('affiliate-chat-box');
            if (!input || !btn) return;
            if (chatEnabledState) {
                input.disabled = false;
                btn.disabled = false;
                btn.style.opacity = '1';
                input.placeholder = 'Type a message to the admin...';
                if (box) box.style.opacity = '1';
            } else {
                input.disabled = true;
                btn.disabled = true;
                btn.style.opacity = '0.5';
                input.placeholder = 'Chat is currently disabled by admin.';
                if (box) box.style.opacity = '0.85';
            }
        }

        function renderAffiliateChat(snap) {
            const container = document.getElementById('chatContainer');
            if (!container) return;
            let html = '';
            if (!snap.exists()) {
                html = '<div style="color:var(--text-muted); text-align:center; padding:10px;">No messages yet. Send a message to the admin.</div>';
            } else {
                const msgs = [];
                snap.forEach(c => msgs.push({ id: c.key, ...c.val() }));
                msgs.sort((a,b) => (a.ts||0) - (b.ts||0));
                msgs.forEach(m => {
                    const from = m.from === 'admin' ? 'Admin' : 'You';
                    const color = m.from === 'admin' ? '#3699ff' : '#1bc5bd';
                    html += `<div class="chat-msg"><b style="color:${color};">${from}:</b> ${escapeHtml(m.text)} <span class="chat-time">${m.ts ? new Date(m.ts).toLocaleString() : ''}</span></div>`;
                });
            }
            container.innerHTML = html;
            container.scrollTop = container.scrollHeight;
        }

        window.sendAffiliateChat = async function() {
            if (!loggedInUserEmail) return;
            if (!chatEnabledState) { showToast('Chat is disabled by admin.', 'error'); return; }
            const input = document.getElementById('affiliate-chat-input');
            const text = input.value.trim();
            if (!text) return;
            const key = safeKey(loggedInUserEmail);
            const msgId = 'm_' + Date.now() + '_' + Math.random().toString(36).slice(2,8);
            const msg = { from: 'affiliate', text, ts: Date.now(), email: loggedInUserEmail };
            try {
                await set(ref(db, `chat/${key}/${msgId}`), msg);
                const metaRef = ref(db, `chatMeta/${key}`);
                const metaSnap = await get(metaRef);
                const meta = metaSnap.exists() ? metaSnap.val() : { unreadForAdmin: 0, unreadForAffiliate: 0 };
                await update(metaRef, {
                    email: loggedInUserEmail,
                    lastMessage: text,
                    lastTs: Date.now(),
                    lastFrom: 'affiliate',
                    unreadForAdmin: (meta.unreadForAdmin || 0) + 1,
                    unreadForAffiliate: 0
                });
                input.value = '';
            } catch(e) {
                showToast('Failed to send message: ' + (e.message || 'error'), 'error');
            }
        };

        // ============================================================
        //  ADMIN INBOX (Real-time)
        // ============================================================
        function initAdminInbox() {
            if (adminInboxMetaListener) return;
            adminInboxMetaListener = true;
            onValue(ref(db, 'chatMeta'), (snap) => {
                renderInboxList(snap);
                updateAdminInboxBadge(snap);
            });
        }

        function updateAdminInboxBadge(snap) {
            const badge = document.getElementById('admin-inbox-badge');
            if (!badge) return;
            let total = 0;
            if (snap.exists()) {
                snap.forEach(c => {
                    const v = c.val();
                    if (v && v.unreadForAdmin) total += Number(v.unreadForAdmin);
                });
            }
            if (total > 0) {
                badge.innerText = total;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        function renderInboxList(snap) {
            const listEl = document.getElementById('admin-inbox-list');
            if (!listEl) return;
            if (!snap.exists()) {
                listEl.innerHTML = '<div style="padding:15px; color:var(--text-muted); text-align:center; font-size:13px;">No conversations yet.</div>';
                return;
            }
            const items = [];
            snap.forEach(c => items.push({ key: c.key, ...c.val() }));
            items.sort((a,b) => (b.lastTs||0) - (a.lastTs||0));
            let html = '';
            items.forEach(it => {
                const active = adminInboxSelectedKey === it.key ? 'background:var(--hover-bg); border-left:3px solid #3699ff;' : '';
                const unread = it.unreadForAdmin ? `<span style="background:#f64e60; color:#fff; border-radius:10px; padding:1px 7px; font-size:10px; margin-left:6px; font-weight:bold;">${it.unreadForAdmin}</span>` : '';
                html += `
                    <div onclick="selectAdminInbox('${escAttr(it.key)}')" style="padding:12px; border-bottom:1px solid var(--border-color); cursor:pointer; ${active}">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:var(--text-main); font-size:13px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${escapeHtml(it.email || it.key.replace(/_/g,'.'))}</strong>
                            ${unread}
                        </div>
                        <div style="font-size:11px; color:var(--text-muted); margin-top:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            ${it.lastFrom === 'admin' ? '<span style="color:#3699ff;">You: </span>' : ''}${escapeHtml(it.lastMessage||'')}
                        </div>
                        <div style="font-size:10px; color:var(--text-muted); margin-top:2px;">${it.lastTs ? new Date(it.lastTs).toLocaleString() : ''}</div>
                    </div>`;
            });
            listEl.innerHTML = html;
        }

        window.selectAdminInbox = async function(key) {
            adminInboxSelectedKey = key;
            update(ref(db, `chatMeta/${key}`), { unreadForAdmin: 0 }).catch(()=>{});

            const header = document.getElementById('admin-inbox-header');
            const email = key.replace(/_/g, '.');
            header.innerHTML = `
                <div>
                    <strong style="color:var(--text-main); font-size:14px;">${escapeHtml(email)}</strong>
                    <div style="font-size:11px; color:var(--text-muted);">Affiliate account</div>
                </div>
                <button class="btn-submit" style="margin-top:0; width:auto; padding:6px 14px; background:#f64e60; font-size:12px;" onclick="terminateAffiliateAccount('${escAttr(key)}')">🚫 Terminate Account</button>
            `;

            if (adminInboxMsgUnsub) { try { adminInboxMsgUnsub(); } catch(_) {} }
            const chatRef = query(ref(db, `chat/${key}`), limitToLast(200));
            adminInboxMsgUnsub = onValue(chatRef, (snap) => {
                renderAdminInboxMessages(snap);
            });
        };

        function renderAdminInboxMessages(snap) {
            const el = document.getElementById('admin-inbox-messages');
            if (!el) return;
            if (!snap.exists()) {
                el.innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:20px; font-size:13px;">No messages in this conversation yet.</div>';
                return;
            }
            const msgs = [];
            snap.forEach(c => msgs.push({ id: c.key, ...c.val() }));
            msgs.sort((a,b) => (a.ts||0) - (b.ts||0));
            let html = '';
            msgs.forEach(m => {
                const isAdmin = m.from === 'admin';
                const align = isAdmin ? 'flex-end' : 'flex-start';
                const bg = isAdmin ? 'rgba(54,153,255,0.15)' : 'rgba(27,197,189,0.1)';
                const color = isAdmin ? '#3699ff' : '#1bc5bd';
                const name = isAdmin ? 'Admin' : 'Affiliate';
                html += `
                    <div style="display:flex; justify-content:${align}; margin-bottom:4px;">
                        <div style="max-width:75%; background:${bg}; padding:8px 12px; border-radius:8px;">
                            <div style="font-size:10px; color:${color}; font-weight:bold; margin-bottom:3px;">${name}</div>
                            <div style="color:var(--text-main); font-size:13px; line-height:1.4;">${escapeHtml(m.text)}</div>
                            <div style="font-size:10px; color:var(--text-muted); margin-top:3px;">${m.ts ? new Date(m.ts).toLocaleString() : ''}</div>
                        </div>
                    </div>`;
            });
            el.innerHTML = html;
            el.scrollTop = el.scrollHeight;
        }

        window.sendAdminInboxMsg = async function() {
            if (!adminInboxSelectedKey) { showToast('Select a conversation first.', 'error'); return; }
            const input = document.getElementById('admin-inbox-input');
            const text = input.value.trim();
            if (!text) return;
            const key = adminInboxSelectedKey;
            const msgId = 'm_' + Date.now() + '_' + Math.random().toString(36).slice(2,8);
            const msg = { from: 'admin', text, ts: Date.now() };
            try {
                await set(ref(db, `chat/${key}/${msgId}`), msg);
                const metaRef = ref(db, `chatMeta/${key}`);
                const metaSnap = await get(metaRef);
                const meta = metaSnap.exists() ? metaSnap.val() : { unreadForAdmin: 0, unreadForAffiliate: 0 };
                await update(metaRef, {
                    email: meta.email || key.replace(/_/g, '.'),
                    lastMessage: text,
                    lastTs: Date.now(),
                    lastFrom: 'admin',
                    unreadForAffiliate: (meta.unreadForAffiliate || 0) + 1,
                    unreadForAdmin: 0
                });
                input.value = '';
            } catch(e) {
                showToast('Failed to send: ' + (e.message || 'error'), 'error');
            }
        };

        window.terminateAffiliateAccount = async function(key) {
            if (!confirm('Permanently delete this affiliate account and all associated data? This cannot be undone.')) return;
            try {
                const deletions = [
                    remove(ref(db, `users/${key}`)),
                    remove(ref(db, `trackings/${key}`)),
                    remove(ref(db, `clickTracking/${key}`)),
                    remove(ref(db, `dailyCounters/${key}`)),
                    remove(ref(db, `campaigns/${key}`)),
                    remove(ref(db, `chat/${key}`)),
                    remove(ref(db, `chatMeta/${key}`))
                ];
                await Promise.all(deletions);
                showToast('Affiliate account terminated.', 'success');
                adminInboxSelectedKey = null;
                const header = document.getElementById('admin-inbox-header');
                if (header) header.innerHTML = '<div style="color:var(--text-muted); font-size:13px;">Select a conversation from the left to start messaging.</div>';
                const msgs = document.getElementById('admin-inbox-messages');
                if (msgs) msgs.innerHTML = '<div style="color:var(--text-muted); text-align:center; padding:20px;">No conversation selected.</div>';
            } catch(e) {
                showToast('Termination failed: ' + (e.message || 'error'), 'error');
            }
        };

        // ============================================================
        //  ADMIN TOP-BAR NOTIFICATIONS
        // ============================================================
        let adminNotifUnread = 0;
        let adminNotifListenerAttached = false;

        function updateNotifBadge() {
            const badge = document.getElementById('admin-notif-badge');
            if (!badge) return;
            if (adminNotifUnread > 0) {
                badge.innerText = adminNotifUnread > 99 ? '99+' : adminNotifUnread;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        function renderAdminNotifications(items) {
            const list = document.getElementById('admin-notif-list');
            if (!list) return;
            if (!items.length) {
                list.innerHTML = '<div style="padding:15px; color:var(--text-muted); font-size:13px; text-align:center;">No notifications.</div>';
            } else {
                list.innerHTML = items.map(n => `
                    <div class="notif-item">
                        <div class="notif-main">${escapeHtml(n.message || n.type || 'Notification')}</div>
                        <div style="font-size:11px; margin-top:4px;">
                            ${escapeHtml((n.aff || '').replace(/_/g, '.'))}
                            ${n.createdAt ? ' • ' + new Date(n.createdAt).toLocaleString() : ''}
                        </div>
                    </div>`).join('');
            }
            const dd = document.getElementById('admin-notif-dropdown');
            if (dd && dd.classList.contains('hidden')) {
                adminNotifUnread = items.length;
                updateNotifBadge();
            }
        }

        function initAdminNotifications() {
            const btn = document.getElementById('admin-notif-btn');
            const dd = document.getElementById('admin-notif-dropdown');
            if (btn && dd && !btn.dataset.bound) {
                btn.dataset.bound = '1';
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dd.classList.toggle('hidden');
                    if (!dd.classList.contains('hidden')) {
                        adminNotifUnread = 0;
                        updateNotifBadge();
                    }
                });
                document.addEventListener('click', (e) => {
                    if (!dd.classList.contains('hidden') && !dd.contains(e.target) && e.target !== btn) {
                        dd.classList.add('hidden');
                    }
                });
            }

            if (adminNotifListenerAttached) return;
            adminNotifListenerAttached = true;

            const nq = query(ref(db, 'notifications'), limitToLast(30));
            onValue(nq, (snap) => {
                const items = [];
                if (snap.exists()) {
                    snap.forEach(affSnap => {
                        affSnap.forEach(nSnap => {
                            const n = nSnap.val() || {};
                            items.push({ aff: affSnap.key, ...n });
                        });
                    });
                }
                items.sort((a,b) => (b.createdAt||0) - (a.createdAt||0));
                renderAdminNotifications(items.slice(0, 25));
            }, (err) => {
                console.warn('Notification listener error:', err && err.message);
            });
        }

        // ============================================================
        //  REDIRECT CONTROLLER
        // ============================================================
        let redirectListenerAttached = false;

        function updateRedirectPreview() {
            const el = document.getElementById('redirect-preview-url');
            if (!el) return;
            const cid = loggedInUserMainClickId || 'CID-9fA2Kd83Lm';
            const ffid = loggedInUserFFId || 'FF-00000';
            if (redirectSettings.enabled && redirectSettings.targetUrl) {
                el.textContent = buildRedirectUrl(redirectSettings.targetUrl, ffid, cid);
            } else {
                const base = String(masterGlobalLink).split('admedia_')[0];
                el.textContent = buildTrackingLink(base, ffid, cid).url;
            }
        }

        function updateRedirectStatusUI() {
            const pill = document.getElementById('redirect-status-pill');
            if (!pill) return;
            if (redirectSettings.enabled) {
                pill.textContent = '● ON — All tracking links are being redirected to the Target URL';
                pill.style.color = '#1bc5bd';
                pill.style.background = 'rgba(27,197,189,0.08)';
                pill.style.borderColor = 'rgba(27,197,189,0.4)';
            } else {
                pill.textContent = '● OFF — Links resolve to network offers';
                pill.style.color = '#ffa800';
                pill.style.background = 'rgba(255,168,0,0.08)';
                pill.style.borderColor = 'rgba(255,168,0,0.4)';
            }
            updateRedirectPreview();
        }

        function initRedirectController() {
            const toggle = document.getElementById('redirect-toggle');
            const urlInput = document.getElementById('redirect-target-url');
            if (!toggle || !urlInput) return;

            if (!redirectListenerAttached) {
                redirectListenerAttached = true;

                onValue(ref(db, 'settings/redirect'), (snap) => {
                    const v = snap.exists() ? (snap.val() || {}) : {};
                    redirectSettings = { enabled: !!v.enabled, targetUrl: v.targetUrl || '' };
                    toggle.checked = redirectSettings.enabled;
                    urlInput.value = redirectSettings.targetUrl;
                    updateRedirectStatusUI();
                }, (err) => {
                    console.warn('Redirect settings read failed:', err && err.message);
                });

                toggle.addEventListener('change', async () => {
                    try {
                        await update(ref(db, 'settings/redirect'), {
                            enabled: toggle.checked,
                            targetUrl: urlInput.value.trim(),
                            updatedAt: Date.now()
                        });
                        showToast('Redirect engine ' + (toggle.checked ? 'ENABLED' : 'DISABLED') + '.', 'success');
                    } catch (e) {
                        showToast('Failed to toggle redirect: ' + (e.message || 'error'), 'error');
                        toggle.checked = !toggle.checked;
                    }
                });

                document.getElementById('btn-save-redirect').addEventListener('click', async () => {
                    const url = urlInput.value.trim();
                    if (!url) { showToast('Please enter a Target URL.', 'error'); return; }
                    if (!/^https?:\/\//i.test(url)) { showToast('Target URL must start with http:// or https://', 'error'); return; }
                    try {
                        await update(ref(db, 'settings/redirect'), {
                            targetUrl: url,
                            enabled: toggle.checked,
                            updatedAt: Date.now()
                        });
                        showToast('Redirect settings saved successfully.', 'success');
                    } catch (e) {
                        showToast('Failed to save: ' + (e.message || 'error'), 'error');
                    }
                });
            }
            updateRedirectStatusUI();
        }

        window.testRedirectPreview = function() {
            const el = document.getElementById('redirect-preview-url');
            if (!el) return;
            const url = el.textContent.trim();
            if (!url) return;
            window.open(url, '_blank');
        };
        window.copyRedirectPreview = function() {
            const el = document.getElementById('redirect-preview-url');
            if (!el) return;
            const url = el.textContent.trim();
            try {
                navigator.clipboard.writeText(url);
                showToast('Preview URL copied to clipboard.', 'success');
            } catch(e) {
                showToast('Copy failed.', 'error');
            }
        };

        // ============================================================
        //  POSTBACK MANAGEMENT
        // ============================================================
        let postbackListenerAttached = false;

        function renderPostbackTable(snap) {
            const tbody = document.getElementById('admin-postbacks-table-body');
            if (!tbody) return;
            if (!snap.exists()) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding: 15px;">No custom postbacks registered yet.</td></tr>';
                return;
            }
            let h = '';
            snap.forEach(c => {
                const p = c.val() || {};
                h += `<tr>
                    <td>${escapeHtml(p.email || c.key.replace(/_/g,'.'))}</td>
                    <td><code style="color:#3699ff; word-break:break-all;">${escapeHtml(p.url || '—')}</code></td>
                    <td><span class="inv-badge inv-paid">${escapeHtml(p.status || 'Active')}</span></td>
                    <td>${p.updatedAt ? new Date(p.updatedAt).toLocaleString() : '—'}</td>
                    <td style="display:flex; gap:5px;">
                        <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#3699ff;"
                            onclick="editCustomPostback('${escAttr(c.key)}', '${escAttr(p.url||'')}', '${escAttr(p.email||'')}')">Edit</button>
                        <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#f64e60;"
                            onclick="deleteCustomPostback('${escAttr(c.key)}')">Delete</button>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = h;
        }

        function initPostbackManager() {
            const globalInput = document.getElementById('global-postback-input');
            if (!globalInput) return;
            if (postbackListenerAttached) return;
            postbackListenerAttached = true;

            onValue(ref(db, 'settings/globalPostback'), (snap) => {
                globalInput.value = snap.exists() ? (snap.val() || '') : '';
            }, (err) => { console.warn('Global postback read failed:', err && err.message); });

            document.getElementById('btn-save-global-postback').addEventListener('click', async () => {
                const url = globalInput.value.trim();
                if (!url) { showToast('Enter a global postback URL.', 'error'); return; }
                try {
                    await set(ref(db, 'settings/globalPostback'), url);
                    showToast('Global postback saved.', 'success');
                } catch (e) {
                    showToast('Failed: ' + (e.message || 'error'), 'error');
                }
            });

            document.getElementById('btn-save-custom-postback').addEventListener('click', async () => {
                const email = document.getElementById('custom-postback-email').value.trim();
                const url = document.getElementById('custom-postback-url').value.trim();
                if (!email || !url) { showToast('Affiliate email and postback URL are required.', 'error'); return; }
                const key = safeKey(email);
                try {
                    await set(ref(db, `postbacks/${key}`), {
                        email, url, status: 'Active', updatedAt: Date.now()
                    });
                    showToast('Custom postback saved.', 'success');
                    document.getElementById('custom-postback-email').value = '';
                    document.getElementById('custom-postback-url').value = '';
                } catch (e) {
                    showToast('Failed: ' + (e.message || 'error'), 'error');
                }
            });

            onValue(ref(db, 'postbacks'), (snap) => {
                renderPostbackTable(snap);
            }, (err) => {
                console.warn('Postback list read failed:', err && err.message);
            });
        }

        window.editCustomPostback = function(key, url, email) {
            document.getElementById('custom-postback-email').value = email || key.replace(/_/g, '.');
            document.getElementById('custom-postback-url').value = url || '';
            document.getElementById('custom-postback-url').focus();
            showToast('Loaded postback into the form for editing.', 'info');
        };
        window.deleteCustomPostback = async function(key) {
            if (!confirm('Delete this custom postback?')) return;
            try {
                await remove(ref(db, `postbacks/${key}`));
                showToast('Custom postback deleted.', 'info');
            } catch (e) {
                showToast('Delete failed: ' + (e.message || 'error'), 'error');
            }
        };

        // ============================================================
        //  INVOICE LIST
        // ============================================================
        let invoiceListenerAttached = false;
        let invoiceFilterState = 'all';
        let invoiceRowsCache = [];

        function renderInvoiceTable() {
            const tbody = document.getElementById('admin-invoices-table-body');
            if (!tbody) return;
            const q = (document.getElementById('invoice-search')?.value || '').toLowerCase();

            let totalCount = 0, paidCount = 0, unpaidCount = 0, totalAmount = 0;
            invoiceRowsCache.forEach(inv => {
                totalCount++;
                totalAmount += Number(inv.amount || 0);
                if (inv.status === 'Paid') paidCount++;
                else if (inv.status === 'Unpaid') unpaidCount++;
            });
            document.getElementById('inv-total-count').innerText = totalCount;
            document.getElementById('inv-paid-count').innerText = paidCount;
            document.getElementById('inv-unpaid-count').innerText = unpaidCount;
            document.getElementById('inv-total-amount').innerText = '$' + totalAmount.toFixed(2);

            const filtered = invoiceRowsCache.filter(inv => {
                if (invoiceFilterState !== 'all' && inv.status !== invoiceFilterState) return false;
                if (q) {
                    const hay = (inv.id + ' ' + inv.email + ' ' + inv.affKey).toLowerCase();
                    if (!hay.includes(q)) return false;
                }
                return true;
            });

            if (!filtered.length) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; color: var(--text-muted); padding: 15px;">No invoices match the current filter.</td></tr>';
                return;
            }

            let h = '';
            filtered.forEach(inv => {
                const badgeClass = inv.status === 'Paid' ? 'inv-paid' : (inv.status === 'Void' ? 'inv-void' : 'inv-unpaid');
                h += `<tr>
                    <td><code style="color:#8950fc;">${escapeHtml(inv.id)}</code></td>
                    <td>${escapeHtml(inv.email || inv.affKey.replace(/_/g,'.'))}</td>
                    <td>${escapeHtml(inv.period || 'Weekly')}</td>
                    <td style="font-weight:700; color:#1bc5bd;">$${Number(inv.amount||0).toFixed(2)}</td>
                    <td>${escapeHtml(inv.method || 'Bitcoin (BTC)')}</td>
                    <td>${inv.createdAt ? new Date(inv.createdAt).toLocaleDateString() : '—'}</td>
                    <td><span class="inv-badge ${badgeClass}">${escapeHtml(inv.status || 'Unpaid')}</span></td>
                    <td style="display:flex; gap:5px; flex-wrap:wrap;">
                        ${inv.status !== 'Paid'
                            ? `<button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#1bc5bd;" onclick="markInvoicePaid('${escAttr(inv.id)}')">Mark Paid</button>`
                            : `<button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#7e8299;" onclick="markInvoiceUnpaid('${escAttr(inv.id)}')">Mark Unpaid</button>`}
                        <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#f64e60;" onclick="deleteInvoice('${escAttr(inv.id)}')">Delete</button>
                    </td>
                </tr>`;
            });
            tbody.innerHTML = h;
        }

        function initInvoiceList() {
            if (invoiceListenerAttached) return;
            invoiceListenerAttached = true;

            onValue(ref(db, 'invoices'), (snap) => {
                invoiceRowsCache = [];
                if (snap.exists()) {
                    snap.forEach(c => {
                        const v = c.val() || {};
                        invoiceRowsCache.push({ id: v.id || c.key, key: c.key, affKey: v.affKey || '', ...v });
                    });
                }
                invoiceRowsCache.sort((a,b) => (b.createdAt||0) - (a.createdAt||0));
                renderInvoiceTable();
            }, (err) => {
                const tbody = document.getElementById('admin-invoices-table-body');
                if (tbody) tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; color:#f64e60; padding:15px;">Error: ${escapeHtml(err.message)}</td></tr>`;
            });

            const searchEl = document.getElementById('invoice-search');
            if (searchEl && !searchEl.dataset.bound) {
                searchEl.dataset.bound = '1';
                searchEl.addEventListener('input', renderInvoiceTable);
            }
            const genBtn = document.getElementById('btn-generate-invoices');
            if (genBtn && !genBtn.dataset.bound) {
                genBtn.dataset.bound = '1';
                genBtn.addEventListener('click', generateInvoices);
            }
        }

        window.filterInvoices = function(status, btnEl) {
            document.querySelectorAll('#admin-view-invoices .filter-btn').forEach(b => b.classList.remove('active'));
            if (btnEl) btnEl.classList.add('active');
            invoiceFilterState = status;
            renderInvoiceTable();
        };

        async function generateInvoices() {
            const btn = document.getElementById('btn-generate-invoices');
            if (btn) { btn.disabled = true; btn.innerText = 'Generating...'; }
            try {
                const [uSnap, iSnap] = await Promise.all([
                    get(ref(db, 'users')),
                    get(ref(db, 'invoices'))
                ]);

                const existingUnpaid = {};
                if (iSnap.exists()) {
                    iSnap.forEach(c => {
                        const v = c.val() || {};
                        if (v.status !== 'Paid' && v.affKey) existingUnpaid[v.affKey] = true;
                    });
                }

                const updates = {};
                let count = 0;
                if (uSnap.exists()) {
                    uSnap.forEach(c => {
                        const key = c.key;
                        const d = c.val() || {};
                        const s = d.stats || {};
                        const p = d.profile || {};
                        const earn = Number(s.earnings || 0);
                        if (earn >= 100 && !existingUnpaid[key]) {
                            const invId = 'INV-' + Date.now() + '-' + Math.floor(Math.random() * 900 + 100);
                            updates[`invoices/${invId}`] = {
                                id: invId,
                                affKey: key,
                                email: p.email || key.replace(/_/g, '.'),
                                amount: Number(earn.toFixed(2)),
                                method: 'Bitcoin (BTC)',
                                status: 'Unpaid',
                                period: 'Weekly (Mon–Sun)',
                                createdAt: Date.now()
                            };
                            count++;
                        }
                    });
                }

                if (count > 0) await update(ref(db), updates);
                showToast(count > 0 ? `${count} invoice(s) generated.` : 'No new invoices to generate.', count > 0 ? 'success' : 'info');
            } catch (e) {
                showToast('Invoice generation failed: ' + (e.message || 'error'), 'error');
            } finally {
                if (btn) { btn.disabled = false; btn.innerText = '⚙ Run Monday Invoice Generation'; }
            }
        }

        window.markInvoicePaid = async function(id) {
            try {
                await update(ref(db, `invoices/${id}`), { status: 'Paid', paidAt: Date.now() });
                showToast('Invoice marked as paid.', 'success');
            } catch (e) {
                showToast('Update failed: ' + (e.message || 'error'), 'error');
            }
        };
        window.markInvoiceUnpaid = async function(id) {
            try {
                await update(ref(db, `invoices/${id}`), { status: 'Unpaid', paidAt: null });
                showToast('Invoice marked as unpaid.', 'info');
            } catch (e) {
                showToast('Update failed: ' + (e.message || 'error'), 'error');
            }
        };
        window.deleteInvoice = async function(id) {
            if (!confirm('Delete this invoice record?')) return;
            try {
                await remove(ref(db, `invoices/${id}`));
                showToast('Invoice deleted.', 'info');
            } catch (e) {
                showToast('Delete failed: ' + (e.message || 'error'), 'error');
            }
        };

        // ============================================================
        //  ADMIN OVERVIEW DASHBOARD
        // ============================================================
        let adminOverviewChart = null;
        let adminOverviewListenerAttached = false;

        function initAdminOverviewChart() {
            const el = document.getElementById('adminOverviewChart');
            if (!el) return;
            if (adminOverviewChart) { try { adminOverviewChart.destroy(); } catch(e){} }
            adminOverviewChart = new Chart(el.getContext('2d'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [
                        { label: 'Clicks', data: [], borderColor: '#FF4D4D', backgroundColor: 'rgba(255,77,77,0.12)', borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 3, pointBackgroundColor: '#FF4D4D' },
                        { label: 'Conversions', data: [], borderColor: '#9B59B6', backgroundColor: 'rgba(155,89,182,0.12)', borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 3, pointBackgroundColor: '#9B59B6' },
                        { label: 'Revenue', data: [], borderColor: '#FFC107', backgroundColor: 'rgba(255,193,7,0.12)', borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 3, pointBackgroundColor: '#FFC107' },
                        { label: 'Payouts', data: [], borderColor: '#2ECC71', backgroundColor: 'rgba(46,204,113,0.12)', borderWidth: 2.5, tension: 0.4, fill: true, pointRadius: 3, pointBackgroundColor: '#2ECC71' }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: { color: '#7e8299', boxWidth: 14, boxHeight: 8, font: { size: 11, weight: '600' }, usePointStyle: true }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(24,28,50,0.95)',
                            titleColor: '#fff',
                            bodyColor: '#e0e0e0',
                            padding: 10,
                            cornerRadius: 6
                        }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(126,130,153,0.15)' }, ticks: { color: '#7e8299', font: { size: 11 } } },
                        y: { grid: { color: 'rgba(126,130,153,0.15)' }, ticks: { color: '#7e8299', font: { size: 11 } }, beginAtZero: true }
                    }
                }
            });
        }

        function computeAdminOverview() {
            Promise.all([
                get(ref(db, 'trackings')),
                get(ref(db, 'dailyCounters'))
            ]).then(([tSnap, dSnap]) => {
                const days = [];
                const today = new Date();
                for (let i = 6; i >= 0; i--) {
                    const d = new Date(today);
                    d.setDate(d.getDate() - i);
                    days.push(d.toISOString().slice(0, 10));
                }
                const dClicks = days.map(() => 0);
                const dConv   = days.map(() => 0);
                const dRev    = days.map(() => 0);
                const dPay    = days.map(() => 0);

                let clicks = 0, conversions = 0, revenue = 0;

                if (tSnap.exists()) {
                    tSnap.forEach(aSnap => {
                        aSnap.forEach(evSnap => {
                            const t = evSnap.val() || {};
                            clicks++;
                            const ts = Number(t.timestamp || 0);
                            const ds = new Date(ts).toISOString().slice(0, 10);
                            const idx = days.indexOf(ds);
                            if (idx >= 0) dClicks[idx]++;
                            if (t.conversion) {
                                conversions++;
                                const amt = Number(t.earnings || 0);
                                revenue += amt;
                                if (idx >= 0) { dConv[idx]++; dRev[idx] += amt; }
                            }
                        });
                    });
                }

                let payouts = 0;
                if (dSnap.exists()) {
                    dSnap.forEach(aSnap => {
                        aSnap.forEach(daySnap => {
                            const v = daySnap.val() || {};
                            const ds = daySnap.key;
                            const amt = Number(v.earnings || 0);
                            payouts += amt;
                            const idx = days.indexOf(ds);
                            if (idx >= 0) dPay[idx] += amt;
                        });
                    });
                }

                const setTxt = (id, val) => { const e = document.getElementById(id); if (e) e.innerText = val; };
                setTxt('ov-clicks', clicks.toLocaleString());
                setTxt('ov-conversions', conversions.toLocaleString());
                setTxt('ov-revenue', '$' + revenue.toFixed(2));
                setTxt('ov-payouts', '$' + payouts.toFixed(2));
                setTxt('ov-cr', (clicks ? ((conversions / clicks) * 100).toFixed(2) : '0.00') + '% CR');
                setTxt('ov-epc', '$' + (clicks ? revenue / clicks : 0).toFixed(2) + ' EPC');

                if (adminOverviewChart) {
                    adminOverviewChart.data.labels = days.map(d => d.slice(5));
                    adminOverviewChart.data.datasets[0].data = dClicks;
                    adminOverviewChart.data.datasets[1].data = dConv;
                    adminOverviewChart.data.datasets[2].data = dRev.map(v => Number(v.toFixed(2)));
                    adminOverviewChart.data.datasets[3].data = dPay.map(v => Number(v.toFixed(2)));
                    adminOverviewChart.update();
                }
            }).catch(e => {
                console.warn('Admin overview compute failed:', e && e.message);
            });
        }

        function initializeAdminOverview() {
            initAdminOverviewChart();
            computeAdminOverview();

            if (adminOverviewListenerAttached) return;
            adminOverviewListenerAttached = true;

            onValue(ref(db, 'trackings'), () => computeAdminOverview(), (err) => {
                console.warn('Overview listener error:', err && err.message);
            });
            onValue(ref(db, 'dailyCounters'), () => computeAdminOverview(), (err) => {
                console.warn('Overview daily listener error:', err && err.message);
            });
        }

        // ============================================================
        //  AUTH UI TOGGLES
        // ============================================================
        document.getElementById('show-signup').addEventListener('click', () => {
            document.getElementById('login-section').classList.add('hidden');
            document.getElementById('forgot-section').classList.add('hidden');
            document.getElementById('signup-section').classList.remove('hidden');
        });
        document.getElementById('show-login').addEventListener('click', () => {
            document.getElementById('signup-section').classList.add('hidden');
            document.getElementById('forgot-section').classList.add('hidden');
            document.getElementById('login-section').classList.remove('hidden');
        });
        document.getElementById('forgot-password-link').addEventListener('click', () => {
            document.getElementById('login-section').classList.add('hidden');
            document.getElementById('forgot-section').classList.remove('hidden');
        });
        document.getElementById('back-to-login').addEventListener('click', () => {
            document.getElementById('forgot-section').classList.add('hidden');
            document.getElementById('login-section').classList.remove('hidden');
        });

        document.getElementById('btn-forgot-submit').addEventListener('click', async () => {
            const email = document.getElementById('forgot-email').value.trim();
            const msg = document.getElementById('forgot-msg');
            msg.style.color = '#f64e60';
            if (!email) { msg.innerText = 'Please enter your email address.'; return; }
            try {
                await sendPasswordResetEmail(auth, email);
                msg.style.color = '#1bc5bd';
                msg.innerText = 'Reset link sent. Please check your email inbox/spam.';
            } catch (err) {
                msg.style.color = '#f64e60';
                msg.innerText = err.message || 'Failed to send reset email.';
            }
        });

        document.getElementById('advertiserToggleBtn').addEventListener('click', async (e) => {
            e.preventDefault();
            currentRole = 'advertiser';
            loggedInUserEmail = "advertiser@admadia.site";
            saveSession(loggedInUserEmail, 'advertiser', '', null, null);
            try { await signOut(auth); } catch(_) {}
            showAffiliateDashboard();
        });

        // ============================================================
        //  SIGNUP
        // ============================================================
        document.getElementById('btn-signup').addEventListener('click', async () => {
            const errEl = document.getElementById('signup-error-msg');
            errEl.innerText = "";

            const firstName = document.getElementById('signup-firstname').value.trim();
            const lastName = document.getElementById('signup-lastname').value.trim();
            const username = document.getElementById('signup-username').value.trim();
            const ffid = document.getElementById('signup-ffid').value.trim();
            const pw = document.getElementById('signup-password').value;
            const pw2 = document.getElementById('signup-password2').value;
            const email = document.getElementById('signup-email').value.trim();
            const country = document.getElementById('signup-country').value;
            const promo = document.getElementById('signup-promo').value.trim();
            const street = document.getElementById('signup-street').value.trim();
            const state = document.getElementById('signup-state').value.trim();
            const city = document.getElementById('signup-city').value.trim();
            const zip = document.getElementById('signup-zip').value.trim();
            const hear = document.getElementById('signup-hear').value.trim();
            const websites = document.getElementById('signup-websites').value.trim();
            const traffic = document.getElementById('signup-traffic').value.trim();
            const networks = document.getElementById('signup-networks').value.trim();

            const t1 = document.getElementById('tos-agree1').checked;
            const t2 = document.getElementById('tos-agree2').checked;
            const t3 = document.getElementById('tos-agree3').checked;

            if (!firstName || !lastName || !username || !ffid || !pw || !pw2 || !email ||
                !country || !promo || !street || !state || !city || !zip || !hear || !traffic) {
                errEl.innerText = 'Please fill all required (*) fields.'; return;
            }
            if (pw !== pw2) { errEl.innerText = 'Passwords do not match.'; return; }
            if (pw.length < 6) { errEl.innerText = 'Password must be at least 6 characters.'; return; }
            if (!t1 || !t2 || !t3) { errEl.innerText = 'You must accept all Terms of Service checkboxes.'; return; }

            let secondaryApp;
            try {
                secondaryApp = initializeApp(firebaseConfig, 'SignupApp_' + Date.now());
                const secondaryAuth = getAuth(secondaryApp);
                const cred = await createUserWithEmailAndPassword(secondaryAuth, email, pw);
                const uid = cred.user.uid;
                const key = safeKey(email);
                const mainClickId = 'CID-' + generateUniqueClickId();
                const refCode = promo || 'NONE';

                await set(ref(db, `users/${key}/profile`), {
                    firstName, lastName, username, ffid,
                    name: `${firstName} ${lastName}`,
                    email, uid,
                    country, promoCode: refCode,
                    street, state, city, zip, hear, websites, traffic, networks,
                    userId: `AFF-${Math.floor(Math.random() * 900000 + 100000)}`,
                    status: 'Pending Approval',
                    rank: 'Standard Affiliate',
                    btcWallet: '',
                    avatar: '',
                    mainClickId: mainClickId,
                    createdAt: Date.now()
                });
                await set(ref(db, `users/${key}/stats`), {
                    clicks: 0, uniqueClicks: 0, duplicateClicks: 0, leads: 0, earnings: 0, bonus: 0, payment: 0
                });

                await set(ref(db, `notifications/${key}/${Date.now()}`), {
                    type: 'signup',
                    message: `New affiliate registered: ${email}`,
                    createdAt: Date.now()
                });

                await signOut(secondaryAuth);
                await deleteApp(secondaryApp);

                showToast('Registration successful! Pending admin approval.', 'success');
                document.getElementById('show-login').click();
            } catch (err) {
                if (secondaryApp) { try { await deleteApp(secondaryApp); } catch(_) {} }
                errEl.innerText = err.message || 'Signup failed.';
            }
        });

        // ============================================================
        //  LOGIN
        // ============================================================
        document.getElementById('btn-login').addEventListener('click', async () => {
            const email = document.getElementById('login-email').value.trim();
            const pw = document.getElementById('login-password').value;
            const errEl = document.getElementById('login-error-msg');
            const btn = document.getElementById('btn-login');
            errEl.innerText = "";
            if (!email || !pw) { errEl.innerText = 'Enter email and password.'; return; }

            btn.disabled = true;
            btn.innerText = 'Signing in...';
            try {
                await signInWithEmailAndPassword(auth, email, pw);
            } catch (err) {
                errEl.innerText = err.message || 'Login failed.';
            } finally {
                btn.disabled = false;
                btn.innerText = 'Sign In';
            }
        });

        // ============================================================
        //  SESSION RESTORE via onAuthStateChanged
        // ============================================================
        onAuthStateChanged(auth, async (user) => {
            if (currentRole === 'advertiser') return;

            if (!user) {
                const s = loadSession();
                if (s) clearSession();
                return;
            }

            const email = user.email;
            const uid = user.uid;

            try {
                const adminSnap = await get(ref(db, `admins/${uid}`));
                if (adminSnap.exists() && adminSnap.val() === true) {
                    currentRole = 'admin';
                    loggedInUserEmail = email;
                    saveSession(email, 'admin', 'ADMIN', null, uid);
                    showAdminDashboard();
                    return;
                }

                const mgrSnap = await get(ref(db, `managers/${safeKey(email)}`));
                if (mgrSnap.exists() && mgrSnap.val().active !== false) {
                    currentRole = 'manager';
                    loggedInUserEmail = email;
                    saveSession(email, 'manager', 'MGR', null, uid);
                    showAdminDashboard();
                    return;
                }

                const key = safeKey(email);
                const pSnap = await get(ref(db, `users/${key}/profile`));
                if (pSnap.exists() && pSnap.val().status === 'Approved') {
                    const prof = pSnap.val();
                    loggedInUserEmail = email;
                    loggedInUserFFId = prof.ffid || 'FF-00000';
                    loggedInUserMainClickId = prof.mainClickId || '';
                    currentRole = 'affiliate';
                    saveSession(email, 'affiliate', loggedInUserFFId, loggedInUserMainClickId, uid);
                    showAffiliateDashboard();
                    return;
                }

                if (pSnap.exists() && pSnap.val().status !== 'Approved') {
                    const errEl = document.getElementById('login-error-msg');
                    if (errEl) errEl.innerText = 'Your account is not yet approved. Please wait for admin approval.';
                } else {
                    const errEl = document.getElementById('login-error-msg');
                    if (errEl) errEl.innerText = 'No account found for this login.';
                }
                await signOut(auth);
                clearSession();
            } catch (e) {
                console.warn('Session restore failed:', e);
            }
        });

        // ============================================================
        //  DASHBOARD ROUTERS
        // ============================================================
        function showAffiliateDashboard() {
            document.getElementById('auth-wrapper').classList.add('hidden');
            document.getElementById('admin-dashboard-section').classList.add('hidden');
            document.getElementById('dashboard-section').classList.remove('hidden');
            setTimeout(initChart, 200);
            generateOffersData();
            startLiveRealtimeEngine();
            populateActiveAffiliates500();
            startTimer();

            if (loggedInUserEmail) {
                const key = safeKey(loggedInUserEmail);
                ensureMainClickId(loggedInUserEmail).then(cid => {
                    loggedInUserMainClickId = cid || '';
                    const ci = document.getElementById('profile-input-clickid');
                    if (ci) ci.value = cid || '';
                    const cw = document.getElementById('aff-main-click-id');
                    if (cw) cw.innerText = cid || '—';
                    updateRedirectPreview();
                });

                initializeRealtimeSync(key);
                initAffiliateChat();
                document.getElementById('user-referral-link').value = `https://app.admadia.site/ref?id=${loggedInUserFFId || key}`;
                document.getElementById('user-ff-id-display').value = loggedInUserFFId || '';
                get(ref(db, `users/${key}/profile`)).then(snap => {
                    if (snap.exists()) {
                        const p = snap.val();
                        document.getElementById('profile-input-name').value = p.name || '';
                        document.getElementById('profile-input-email').value = p.email || '';
                        document.getElementById('profile-input-ffid').value = p.ffid || '';
                        document.getElementById('profile-input-id').value = p.userId || '';
                        document.getElementById('profile-input-btc').value = p.btcWallet || '';
                        document.getElementById('profile-input-clickid').value = p.mainClickId || '';
                        if (p.avatar) {
                            document.getElementById('header-avatar-img').src = p.avatar;
                            document.getElementById('profile-view-avatar').src = p.avatar;
                        }
                    }
                });
            }

            restoreViewFromHash();
        }

        function showAdminDashboard() {
            document.getElementById('auth-wrapper').classList.add('hidden');
            document.getElementById('dashboard-section').classList.add('hidden');
            document.getElementById('admin-dashboard-section').classList.remove('hidden');
            document.getElementById('admin-brand-label').innerText = currentRole === 'manager' ? 'Manager Control' : 'Admin Control';
            const roleLabel = document.getElementById('admin-role-label');
            if (roleLabel) roleLabel.innerText = currentRole === 'manager' ? 'MANAGER' : 'ADMIN';
            const signedEl = document.getElementById('admin-signed-email');
            if (signedEl) signedEl.innerText = loggedInUserEmail || '—';

            loadAdminUsersList();
            loadAdminOffersList();
            loadManagersList();
            initializeAdminLiveEarnings();
            initializeAdminClickTracking();
            initializeAdminTrafficQuality();
            initAdminInbox();
            initChatToggle();
            initAdminNotifications();
            initRedirectController();

            if (!location.hash.replace(/^#/, '')) {
                switchView('admin-view-overview');
            } else {
                restoreViewFromHash();
            }
        }

        // ============================================================
        //  HASH ROUTER
        // ============================================================
        function switchView(viewId, opts = {}) {
            const ALL_VIEWS = Object.keys(VIEW_TO_HASH);

            ALL_VIEWS.forEach(v => {
                const el = document.getElementById(v);
                if (el) el.classList.add('hidden');
            });

            const target = document.getElementById(viewId);
            if (!target) return;
            target.classList.remove('hidden');

            document.querySelectorAll('.sidebar-menu > li').forEach(li => li.classList.remove('active-main'));
            const menuId = VIEW_TO_MENU[viewId];
            if (menuId) document.getElementById(menuId)?.classList.add('active-main');

            if (viewId === 'view-smartlinks') {
                const inp = document.getElementById('master-smartlink-input');
                if (inp) inp.value = masterGlobalLink;
            }
            if (viewId === 'view-campaigns' && loggedInUserEmail) {
                const key = safeKey(loggedInUserEmail);
                loadCampaignsList(key);
                get(ref(db, `users/${key}/stats`)).then(snap => {
                    const e = snap.exists() ? (snap.val().earnings || 0) : 0;
                    const el = document.getElementById('campaign-balance-amount');
                    if (el) el.innerText = `$${e.toFixed(2)}`;
                });
            }

            if (viewId === 'admin-view-overview')         initializeAdminOverview();
            if (viewId === 'admin-view-settings')         { /* static */ }
            if (viewId === 'admin-view-redirect')         initRedirectController();
            if (viewId === 'admin-view-postbacks')        initPostbackManager();
            if (viewId === 'admin-view-invoices')         initInvoiceList();
            if (viewId === 'admin-view-users')            loadAdminUsersList();
            if (viewId === 'admin-view-offers')           loadAdminOffersList();
            if (viewId === 'admin-view-inbox')            initAdminInbox();
            if (viewId === 'admin-view-live-earnings')    initializeAdminLiveEarnings();
            if (viewId === 'admin-view-click-tracking')   initializeAdminClickTracking();
            if (viewId === 'admin-view-traffic-quality')  initializeAdminTrafficQuality();
            if (viewId === 'admin-view-managers')         loadManagersList();

            if (!opts.fromHash) {
                const h = VIEW_TO_HASH[viewId];
                if (h && location.hash !== '#' + h) location.hash = h;
            }
        }
        window.switchView = switchView;

        function restoreViewFromHash() {
            const h = location.hash.replace(/^#/, '');
            if (!h) return;
            const viewId = HASH_TO_VIEW[h];
            if (!viewId) return;
            const isAdminView = viewId.startsWith('admin-view-');
            if (isAdminView && currentRole !== 'admin' && currentRole !== 'manager') return;
            if (!isAdminView && (currentRole === 'admin' || currentRole === 'manager')) return;
            switchView(viewId, { fromHash: true });
        }

        window.addEventListener('hashchange', () => {
            const h = location.hash.replace(/^#/, '');
            const viewId = HASH_TO_VIEW[h];
            if (!viewId) return;
            const isAdminView = viewId.startsWith('admin-view-');
            if (isAdminView && currentRole !== 'admin' && currentRole !== 'manager') return;
            if (!isAdminView && (currentRole === 'admin' || currentRole === 'manager')) return;
            switchView(viewId, { fromHash: true });
        });

        // ============================================================
        //  SIDEBAR MENU BINDINGS
        // ============================================================
        const affiliateMenu = {
            'menu-dashboard': 'view-dashboard',
            'menu-campaigns': 'view-campaigns',
            'menu-balance':   'view-balance',
            'menu-offers':    'view-offers',
            'menu-smartlinks':'view-smartlinks',
            'menu-reports':   'view-reports',
            'menu-referral':  'view-referral',
            'menu-templates': 'view-templates',
            'menu-payments':  'view-payments',
            'menu-postback':  'view-postback',
            'menu-profile':   'view-profile',
            'menu-adv-deposits':        'view-adv-deposits',
            'menu-adv-campaigns':       'view-adv-campaigns',
            'menu-adv-statistics':      'view-adv-statistics',
            'menu-adv-traffic-demand':  'view-adv-traffic-demand',
            'menu-adv-traffic-sources': 'view-adv-traffic-sources',
            'menu-adv-contact-sources': 'view-adv-contact-sources',
            'menu-adv-whitelists':      'view-adv-whitelists'
        };
        Object.entries(affiliateMenu).forEach(([id, view]) => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('click', () => switchView(view));
        });

        const adminMenu = {
            'admin-menu-overview':             'admin-view-overview',
            'admin-menu-settings':             'admin-view-settings',
            'admin-menu-redirect':             'admin-view-redirect',
            'admin-menu-postbacks':            'admin-view-postbacks',
            'admin-menu-invoices':             'admin-view-invoices',
            'admin-menu-inbox':                'admin-view-inbox',
            'admin-menu-offers':               'admin-view-offers',
            'admin-menu-users':                'admin-view-users',
            'admin-menu-advertiser-approvals': 'admin-view-advertiser-approvals',
            'admin-menu-live-earnings':        'admin-view-live-earnings',
            'admin-menu-click-tracking':       'admin-view-click-tracking',
            'admin-menu-traffic-quality':      'admin-view-traffic-quality',
            'admin-menu-managers':             'admin-view-managers'
        };
        Object.entries(adminMenu).forEach(([id, view]) => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('click', () => switchView(view));
        });

        // ============================================================
        //  LOGOUT
        // ============================================================
        async function doLogout() {
            loggedInUserEmail = ""; loggedInUserFFId = ""; loggedInUserMainClickId = ""; currentRole = "";
            realtimeSyncKey = null;
            campaignsListenerKey = null;
            adminInboxSelectedKey = null;
            if (affiliateChatListener) { try { affiliateChatListener(); } catch(_) {} affiliateChatListener = null; }
            if (affiliateChatToggleListener) { try { affiliateChatToggleListener(); } catch(_) {} affiliateChatToggleListener = null; }
            if (adminInboxMsgUnsub) { try { adminInboxMsgUnsub(); } catch(_) {} adminInboxMsgUnsub = null; }
            clearSession();
            try { await signOut(auth); } catch(_) {}
            history.replaceState(null, '', location.pathname + location.search);
            document.getElementById('dashboard-section').classList.add('hidden');
            document.getElementById('admin-dashboard-section').classList.add('hidden');
            document.getElementById('auth-wrapper').classList.remove('hidden');
        }
        document.getElementById('btn-logout').addEventListener('click', doLogout);
        document.getElementById('btn-admin-logout').addEventListener('click', doLogout);

        // ============================================================
        //  TIMER
        // ============================================================
        let timerStarted = false;
        function startTimer() {
            if (timerStarted) return;
            timerStarted = true;
            function tick() {
                const now = new Date();
                const h = String(23 - now.getHours()).padStart(2, '0');
                const m = String(59 - now.getMinutes()).padStart(2, '0');
                const s = String(59 - now.getSeconds()).padStart(2, '0');
                const el = document.getElementById('live-timer-clock');
                if (el) el.innerText = `${h}:${m}:${s}`;
            }
            setInterval(tick, 1000); tick();
        }

        // ============================================================
        //  THEME
        // ============================================================
        (function initTheme() {
            const saved = localStorage.getItem('admadia_theme');
            if (saved === 'dark') {
                document.body.classList.add('dark-theme');
                const b = document.getElementById('theme-toggle-btn');
                if (b) b.innerText = '☀️';
                const ab = document.getElementById('theme-toggle-admin');
                if (ab) ab.innerText = '☀️';
            }
        })();
        function applyThemeToggle(isDark) {
            document.body.classList.toggle('dark-theme', isDark);
            const b = document.getElementById('theme-toggle-btn');
            if (b) b.innerText = isDark ? '☀️' : '🌙';
            const ab = document.getElementById('theme-toggle-admin');
            if (ab) ab.innerText = isDark ? '☀️' : '🌙';
            localStorage.setItem('admadia_theme', isDark ? 'dark' : 'light');
        }
        document.getElementById('theme-toggle-btn').addEventListener('click', () => {
            applyThemeToggle(!document.body.classList.contains('dark-theme'));
        });
        document.getElementById('theme-toggle-admin').addEventListener('click', () => {
            applyThemeToggle(!document.body.classList.contains('dark-theme'));
        });

        // ============================================================
        //  CHART
        // ============================================================
        function initChart() {
            const el = document.getElementById('incomeChart');
            if (!el) return;
            const ctx = el.getContext('2d');
            if (window.incomeChart) { try { window.incomeChart.destroy(); } catch(e){} }
            window.incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Day 1','Day 2','Day 3','Day 4','Day 5','Day 6','Day 7'],
                    datasets: [{
                        label: 'Earnings',
                        data: [0,0,0,0,0,0,0],
                        borderColor: '#FFFFFF',
                        backgroundColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 3,
                        pointBackgroundColor: '#FFFFFF',
                        pointRadius: 4,
                        fill: true, tension: 0.4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { color: 'rgba(255,255,255,0.2)' }, ticks: { color: '#E0E0E0' } },
                        y: { grid: { color: 'rgba(255,255,255,0.2)' }, ticks: { color: '#E0E0E0' } }
                    }
                }
            });
        }

        // ============================================================
        //  CHAT SEND HANDLERS
        // ============================================================
        document.getElementById('btn-affiliate-send-chat').addEventListener('click', () => window.sendAffiliateChat());
        document.getElementById('affiliate-chat-input').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); window.sendAffiliateChat(); }
        });
        document.getElementById('btn-admin-inbox-send').addEventListener('click', () => window.sendAdminInboxMsg());
        document.getElementById('admin-inbox-input').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); window.sendAdminInboxMsg(); }
        });

        // ============================================================
        //  ADMIN CHAT TOGGLE
        // ============================================================
        let chatToggleListenerAttached = false;
        function initChatToggle() {
            const sw = document.getElementById('chat-toggle-switch');
            if (!sw) return;
            if (!chatToggleListenerAttached) {
                chatToggleListenerAttached = true;
                sw.addEventListener('change', async (e) => {
                    try {
                        await set(ref(db, 'settings/chatEnabled'), e.target.checked);
                        showToast('Chat ' + (e.target.checked ? 'enabled' : 'disabled') + ' globally.', 'success');
                    } catch (err) {
                        showToast('Toggle failed: ' + (err.message || 'error'), 'error');
                    }
                });
            }
            onValue(ref(db, 'settings/chatEnabled'), (snap) => {
                const enabled = snap.exists() ? !!snap.val() : true;
                sw.checked = enabled;
                chatEnabledState = enabled;
            });
        }

        // ============================================================
        //  LIVE FEEDS
        // ============================================================
        const targetGeos = [
            { code: 'US', flag: '🇺🇸' }, { code: 'CA', flag: '🇨🇦' }, { code: 'GB', flag: '🇬🇧' },
            { code: 'AU', flag: '🇦🇺' }, { code: 'DE', flag: '🇩🇪' }, { code: 'FR', flag: '🇫🇷' },
            { code: 'IN', flag: '🇮🇳' }, { code: 'BD', flag: '🇧🇩' }, { code: 'IT', flag: '🇮🇹' },
            { code: 'ES', flag: '🇪🇸' }
        ];

        let liveEngineStarted = false;
        function startLiveRealtimeEngine() {
            if (liveEngineStarted) return;
            liveEngineStarted = true;

            const listEl = document.getElementById('live-leads-list');

            const leadsQ = query(ref(db, 'leads'), limitToLast(12));
            onChildAdded(leadsQ, (child) => {
                const lead = child.val() || {};
                const li = document.createElement('li');
                li.style.borderLeft = '4px solid #1bc5bd';
                li.style.background = 'rgba(27, 197, 189, 0.05)';
                li.innerHTML = `
                    <img src="https://i.pravatar.cc/100?img=${Math.floor(Math.random()*70)+1}" class="user-avatar">
                    <div style="flex-grow:1;">
                        <strong style="color: var(--text-main);">Lead (Click ID: ${lead.clickId || '—'})</strong>
                        <br><span style="font-size: 11px; color: var(--text-muted);">Affiliate: ${(lead.affiliate||'').replace(/_/g,'.')}</span>
                    </div>
                    <strong style="color: #1bc5bd;">+$${Number(lead.earnings||0).toFixed(2)}</strong>
                `;
                listEl.prepend(li);
                while (listEl.children.length > 10) listEl.removeChild(listEl.lastChild);
            });

            function pushDemo() {
                const id = Math.floor(Math.random() * 50000) + 1;
                const geo = targetGeos[Math.floor(Math.random() * targetGeos.length)];
                const pay = (Math.random() * 9.5 + 0.5).toFixed(2);
                const av = Math.floor(Math.random() * 70) + 1;
                const li = document.createElement('li');
                li.innerHTML = `
                    <img src="https://i.pravatar.cc/100?img=${av}" class="user-avatar">
                    <div style="flex-grow:1;">
                        <strong style="color: var(--text-main);">User_${id}</strong> (${geo.flag} ${geo.code})
                        <br><span style="font-size: 11px; color: var(--text-muted);">Real-time Converted Lead</span>
                    </div>
                    <strong style="color: #1bc5bd;">+$${pay}</strong>`;
                listEl.prepend(li);
                while (listEl.children.length > 8) listEl.removeChild(listEl.lastChild);
            }
            setInterval(pushDemo, 8000);
        }

        function populateActiveAffiliates500() {
            const listEl = document.getElementById('active-affiliates-list');
            const ranks = ['Top Earner 🥇', 'VIP Pro 💎', 'Super Affiliate ⚡', 'Pro Marketer 🚀'];
            const rows = [];
            for (let i = 1; i <= 500; i++) {
                rows.push({ i, geo: targetGeos[i % targetGeos.length], rank: ranks[i % ranks.length], online: i <= 40 });
            }
            rows.sort((a,b) => (b.online?1:0) - (a.online?1:0));
            let html = '';
            rows.forEach(({ i, geo, rank, online }) => {
                html += `
                    <li>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <img src="https://i.pravatar.cc/100?img=${(i*3)%70+1}" class="user-avatar">
                            <div>
                                <strong style="color: var(--text-main);">Affiliate_Pro_${i*17}</strong> ${geo.flag}
                                <br><span class="badge-rank">${rank}</span>
                            </div>
                        </div>
                        <span style="color:${online?'#1bc5bd':'#7e8299'}; font-weight:bold; font-size:12px;">${online?'Online 🟢':'Offline'}</span>
                    </li>`;
            });
            listEl.innerHTML = html;
        }

        // ============================================================
        //  OFFERS — real-time listener
        // ============================================================
        let offersListenerAttached = false;
        function generateOffersData() {
            if (!currentApiKey) { cachedOffers = []; renderOfferLists(currentOfferFilter); return; }
            if (offersListenerAttached) return;
            offersListenerAttached = true;

            onValue(ref(db, 'offers'), (snap) => {
                if (snap.exists()) {
                    cachedOffers = [];
                    snap.forEach(child => {
                        const o = child.val();
                        cachedOffers.push({
                            id: o.id || child.key,
                            country: o.country || 'US',
                            name: o.name || 'Offer',
                            category: o.category || 'install',
                            catLabel: o.category || 'Offer',
                            payout: o.payout || '$0.00',
                            epc: o.epc || '$0.00',
                            statusText: '🟢 Active',
                            statusClass: 'status-running',
                            url: o.url || masterGlobalLink
                        });
                    });
                    renderOfferLists(currentOfferFilter);
                    return;
                }

                const categories = [
                    { cat: 'install', label: 'App Install', payout: '$20 - $50', names: ['Mega Game Install','iOS Trading Setup','Crypto Wallet App'] },
                    { cat: 'sport', label: 'Credit Sport', payout: '$50 - $70', names: ['Premier League Sportsbook','Cricket Live Score Pass'] },
                    { cat: 'gift', label: 'Gift Card', payout: '$2.00+', names: ['Amazon Voucher $250','Play Store Gift Card'] },
                    { cat: 'traffic', label: 'Standard Traffic', payout: '$0.20', names: ['Quick Survey Panel','Mobile Email Submit'] }
                ];
                cachedOffers = [];
                targetGeos.forEach(g => {
                    for (let i = 1; i <= 10; i++) {
                        const c = categories[(i-1) % categories.length];
                        cachedOffers.push({
                            id: 10000 + cachedOffers.length + 1,
                            country: g.code,
                            name: c.names[(i*3) % c.names.length],
                            category: c.cat,
                            catLabel: c.label,
                            payout: c.payout,
                            epc: '$' + (Math.random()*24.95+0.05).toFixed(2),
                            statusText: Math.random() > 0.7 ? '🔥 Boost' : '🟢 Active',
                            statusClass: Math.random() > 0.7 ? 'status-boost' : 'status-running',
                            url: masterGlobalLink
                        });
                    }
                });
                renderOfferLists(currentOfferFilter);
            });
        }

        window.filterOffers = function(cat, btnEl) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            if (btnEl) btnEl.classList.add('active');
            currentOfferFilter = cat;
            renderOfferLists(cat);
        };

        function renderOfferLists(filterCategory) {
            const filtered = filterCategory === 'all' ? cachedOffers : cachedOffers.filter(o => o.category === filterCategory);

            let dh = '';
            for (let j = 0; j < Math.min(5, cachedOffers.length); j++) {
                const o = cachedOffers[j];
                const label = `[${o.country}] ${o.name}`;
                dh += `
                    <div class="offer-item">
                        <div>
                            <a href="javascript:void(0)" onclick="openOfferModal('${escAttr(o.id)}', '${escAttr(label)}', '${escAttr(o.catLabel)}', '${escAttr(o.url)}')">${label}</a>
                            <br><span class="payout-badge">${o.payout}</span>
                        </div>
                        <div class="offer-actions">
                            <button class="btn-getlink" onclick="trackAndOpenLink('${escAttr(o.url)}', '${escAttr(o.id)}')">Get Link</button>
                        </div>
                    </div>`;
            }
            $('#offerContainer').html(dh);

            let ah = '';
            $.each(filtered, function(i, o) {
                const label = `[${o.country}] ${o.name}`;
                ah += `
                    <div class="new-offer-card">
                        <div class="offer-card-header">
                            <div><button class="offer-title-btn" onclick="openOfferModal('${escAttr(o.id)}', '${escAttr(label)}', '${escAttr(o.catLabel)}', '${escAttr(o.url)}')">${label}</button></div>
                            <div class="offer-badges-top">
                                <span class="badge-ui b-id">ID: ${o.id}</span>
                                <span class="badge-ui b-country">Geo: ${o.country}</span>
                                <span class="badge-ui b-epc">EPC: ${o.epc}</span>
                            </div>
                        </div>
                        <div class="offer-card-footer">
                            <div style="display:flex; gap:10px; align-items:center;">
                                <span class="payout-badge">${o.payout}</span>
                                <span class="${o.statusClass}">${o.statusText}</span>
                            </div>
                            <button class="btn-getlink" onclick="trackAndOpenLink('${escAttr(o.url)}', '${escAttr(o.id)}')">Get Link / Copy</button>
                        </div>
                    </div>`;
            });
            $('#allOffersContainer').html(ah);
        }

        window.openOfferModal = function(id, name, cat, url) {
            document.getElementById('modal-title').innerText = name;
            document.getElementById('modal-id').innerText = id;
            document.getElementById('modal-category').innerText = cat;
            document.getElementById('modal-preview-url').href = url;
            document.getElementById('modal-track-link').value = buildFinalLink(url);
            document.getElementById('offer-modal').classList.remove('hidden');
        };
        window.closeOfferModal = function() {
            document.getElementById('offer-modal').classList.add('hidden');
        };

        // ============================================================
        //  CAMPAIGNS
        // ============================================================
        document.getElementById('btn-create-campaign').addEventListener('click', async () => {
            const name = document.getElementById('campaign-name-input').value.trim();
            if (!name) { showToast('Enter campaign name.', 'error'); return; }
            if (!loggedInUserEmail) return;
            const key = safeKey(loggedInUserEmail);
            const sSnap = await get(ref(db, `users/${key}/stats`));
            const bal = sSnap.exists() ? (sSnap.val().earnings || 0) : 0;
            if (bal < 500) { showToast('Minimum $500 balance required.', 'error'); return; }
            const cid = 'cmp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            await set(ref(db, `campaigns/${key}/${cid}`), {
                name, clickId: cid, trackingLink: masterGlobalLink, createdAt: Date.now()
            });
            showToast('Campaign created!', 'success');
            document.getElementById('campaign-name-input').value = '';
            loadCampaignsList(key);
        });

        let campaignsListenerKey = null;
        async function loadCampaignsList(key) {
            const container = document.getElementById('campaigns-list-container');
            if (campaignsListenerKey === key) return;
            campaignsListenerKey = key;
            onValue(ref(db, `campaigns/${key}`), (snap) => {
                if (!snap.exists()) { container.innerHTML = '<div style="text-align:center; color: var(--text-muted);">No campaigns yet.</div>'; return; }
                let h = '';
                snap.forEach(c => {
                    const camp = c.val();
                    h += `
                        <div style="border-bottom:1px solid var(--border-color); padding:12px 0; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <strong>${camp.name}</strong>
                                <br><span style="font-size:12px; color:var(--text-muted);">Base: ${camp.trackingLink}</span>
                                <br><span style="font-size:12px; color:var(--text-muted);">ID: <code>${camp.clickId}</code></span>
                            </div>
                            <button class="btn-getlink" onclick="trackAndOpenLink('${escAttr(camp.trackingLink)}', '${escAttr(camp.clickId)}')">Get Link</button>
                        </div>`;
                });
                container.innerHTML = h;
            });
        }

        // ============================================================
        //  REPORTS
        // ============================================================
        document.getElementById('btn-apply-report-filter').addEventListener('click', () => {
            if (!loggedInUserEmail) return;
            const key = safeKey(loggedInUserEmail);
            const sd = document.getElementById('report-date-start').value;
            const ed = document.getElementById('report-date-end').value;
            const cf = document.getElementById('report-click-id').value.trim();
            const sTs = sd ? new Date(sd).getTime() : 0;
            const eTs = ed ? new Date(ed).getTime() + 86400000 - 1 : Date.now();
            const tbody = document.getElementById('reports-table-body');
            get(ref(db, `trackings/${key}`)).then(snap => {
                if (!snap.exists()) { tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding:15px;">No data.</td></tr>'; return; }
                let h = '';
                snap.forEach(c => {
                    const d = c.val();
                    if (d.timestamp >= sTs && d.timestamp <= eTs) {
                        if (cf && d.clickId !== cf && c.key !== cf) return;
                        h += `<tr>
                            <td>${new Date(d.timestamp).toLocaleString()}</td>
                            <td><code>${d.clickId||c.key}</code></td>
                            <td>${d.campaignId||'Global'}</td>
                            <td>${d.ip||'N/A'}</td>
                            <td>${d.conversion ? 'Yes':'No'}</td>
                            <td>$${Number(d.earnings||0).toFixed(2)}</td>
                        </tr>`;
                    }
                });
                tbody.innerHTML = h || '<tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding:15px;">No matching records.</td></tr>';
            });
        });

        // ============================================================
        //  PROFILE
        // ============================================================
        window.updateProfileAvatar = async function() {
            const url = document.getElementById('input-avatar-url').value.trim();
            if (!url || !loggedInUserEmail) return;
            document.getElementById('header-avatar-img').src = url;
            document.getElementById('profile-view-avatar').src = url;
            await update(ref(db, `users/${safeKey(loggedInUserEmail)}/profile`), { avatar: url });
            showToast('Avatar updated.', 'success');
        };
        window.saveProfileChanges = async function() {
            if (!loggedInUserEmail) return;
            const name = document.getElementById('profile-input-name').value.trim();
            const btc = document.getElementById('profile-input-btc').value.trim();
            await update(ref(db, `users/${safeKey(loggedInUserEmail)}/profile`), { name, btcWallet: btc });
            showToast('Profile saved.', 'success');
        };
        window.copyReferralLink = function() {
            const v = document.getElementById('user-referral-link').value;
            try { navigator.clipboard.writeText(v); showToast('Referral link copied.', 'success'); } catch(e){}
        };
        window.redeemPromoCode = async function() {
            const code = document.getElementById('promo-code-input').value.trim();
            if (!code || !loggedInUserEmail) { showToast('Enter a promo code.', 'error'); return; }
            const pref = ref(db, `promoCodes/${code}`);
            const snap = await get(pref);
            if (!snap.exists()) { showToast('Invalid promo code.', 'error'); return; }
            const data = snap.val();
            if (data.used) { showToast('Promo code already used.', 'error'); return; }
            const reward = Number(data.reward || 10);
            const statsRef = ref(db, `users/${safeKey(loggedInUserEmail)}/stats`);
            const sSnap = await get(statsRef);
            const s = sSnap.exists() ? sSnap.val() : {};
            await update(statsRef, { earnings: (s.earnings||0) + reward, bonus: (s.bonus||0) + reward });
            await update(pref, { used: true, usedBy: loggedInUserEmail, usedAt: Date.now() });
            showToast(`Promo redeemed! +$${reward}`, 'success');
            document.getElementById('promo-code-input').value = '';
        };

        window.submitBitcoinDeposit = function() {
            const tx = document.getElementById('adv-btc-txid').value.trim();
            if (!tx) { showToast('Enter TxID.', 'error'); return; }
            showToast('Deposit submitted. Awaiting admin approval.', 'success');
            document.getElementById('adv-btc-txid').value = '';
        };

        // ============================================================
        //  ADMIN — USERS (real-time)
        // ============================================================
        let adminUsersListenerAttached = false;
        function loadAdminUsersList() {
            const tbody = document.getElementById('admin-users-table-body');
            if (!tbody) return;
            if (adminUsersListenerAttached) return;
            adminUsersListenerAttached = true;

            onValue(ref(db, 'users'), (snap) => {
                if (!snap.exists()) {
                    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; color: var(--text-muted); padding:15px;">No users found.</td></tr>';
                    return;
                }
                let h = '';
                snap.forEach(child => {
                    const key = child.key;
                    const data = child.val();
                    const p = data.profile || {};
                    const status = p.status || 'Pending Approval';
                    const statusClass = status === 'Approved' ? 'status-approved' : (status === 'Declined' ? 'status-declined' : 'status-pending');
                    h += `
                        <tr>
                            <td style="cursor:pointer; color:#3699ff; text-decoration:underline;" onclick="openAdminUserModal('${escAttr(key)}')">${p.userId || 'AFF-000'}</td>
                            <td>${p.name || p.firstName || 'User'}</td>
                            <td>${p.email || key.replace(/_/g,'.')}</td>
                            <td>${p.ffid || '—'}</td>
                            <td><code style="color:#1bc5bd;">${p.mainClickId || '—'}</code></td>
                            <td><span class="${statusClass}">${status}</span></td>
                            <td>
                                <select class="form-control" style="padding:5px; font-size:11px; background: var(--card-bg); color: var(--text-main);" onchange="updateUserRank('${escAttr(key)}', this.value)">
                                    <option value="Standard Affiliate" ${p.rank==='Standard Affiliate'?'selected':''}>Standard</option>
                                    <option value="Top Earner 🥇" ${p.rank==='Top Earner 🥇'?'selected':''}>Top Earner 🥇</option>
                                    <option value="VIP Pro 💎" ${p.rank==='VIP Pro 💎'?'selected':''}>VIP Pro 💎</option>
                                    <option value="Super Affiliate ⚡" ${p.rank==='Super Affiliate ⚡'?'selected':''}>Super Affiliate ⚡</option>
                                </select>
                            </td>
                            <td style="display:flex; gap:5px;">
                                <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#1bc5bd;" onclick="approveUser('${escAttr(key)}')">Approve</button>
                                <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#f64e60;" onclick="declineUser('${escAttr(key)}')">Decline</button>
                            </td>
                        </tr>`;
                });
                tbody.innerHTML = h;
            }, (err) => {
                tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; color:#f64e60; padding:15px;">Error: ${err.message}</td></tr>`;
            });
        }
        document.getElementById('admin-user-search').addEventListener('input', e => {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#admin-users-table-body tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        });
        window.approveUser = async function(key) {
            await update(ref(db, `users/${key}/profile`), { status: 'Approved', approvedAt: Date.now() });
            await set(ref(db, `notifications/${key}/${Date.now()}`), {
                type: 'approval', message: 'Account approved', createdAt: Date.now()
            });
            showToast('User approved. Affiliate may now log in.', 'success');
        };
        window.declineUser = async function(key) {
            await update(ref(db, `users/${key}/profile`), { status: 'Declined' });
            showToast('User declined.', 'info');
        };
        window.updateUserRank = async function(key, rank) {
            await update(ref(db, `users/${key}/profile`), { rank });
            showToast(`Rank updated to ${rank}.`, 'success');
        };

        window.openAdminUserModal = async function(key) {
            const modal = document.getElementById('admin-user-modal');
            const body = document.getElementById('admin-user-modal-body');
            const title = document.getElementById('admin-user-modal-title');
            body.innerHTML = 'Loading...';
            modal.classList.remove('hidden');
            try {
                const snap = await get(ref(db, `users/${key}`));
                if (!snap.exists()) { body.innerHTML = 'User not found.'; return; }
                const d = snap.val();
                const p = d.profile || {};
                const s = d.stats || {};
                title.innerText = p.name || p.email || key;
                body.innerHTML = `
                    <div class="modal-detail-row"><span class="label">User ID</span><span class="val">${p.userId||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Full Name</span><span class="val">${(p.firstName||'')} ${(p.lastName||'') || p.name || '—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Username</span><span class="val">${p.username||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Email</span><span class="val">${p.email||key}</span></div>
                    <div class="modal-detail-row"><span class="label">FF ID</span><span class="val">${p.ffid||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Main Click ID</span><span class="val" style="color:#1bc5bd; font-weight:bold;">${p.mainClickId||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Country</span><span class="val">${p.country||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Street</span><span class="val">${p.street||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">State / City / Zip</span><span class="val">${p.state||''} / ${p.city||''} / ${p.zip||''}</span></div>
                    <div class="modal-detail-row"><span class="label">Promo Code</span><span class="val">${p.promoCode||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Traffic Sources</span><span class="val">${p.traffic||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Networks</span><span class="val">${p.networks||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">BTC Wallet</span><span class="val">${p.btcWallet||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Status</span><span class="val">${p.status||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Rank</span><span class="val">${p.rank||'—'}</span></div>
                    <div class="modal-detail-row"><span class="label">Clicks</span><span class="val">${s.clicks||0}</span></div>
                    <div class="modal-detail-row"><span class="label">Unique Clicks</span><span class="val">${s.uniqueClicks||0}</span></div>
                    <div class="modal-detail-row"><span class="label">Duplicate Clicks</span><span class="val">${s.duplicateClicks||0}</span></div>
                    <div class="modal-detail-row"><span class="label">Leads</span><span class="val">${s.leads||0}</span></div>
                    <div class="modal-detail-row"><span class="label">Earnings</span><span class="val" style="color:#1bc5bd; font-weight:bold;">$${Number(s.earnings||0).toFixed(2)}</span></div>
                `;
            } catch(e) { body.innerHTML = 'Error: ' + e.message; }
        };
        window.closeAdminUserModal = function() {
            document.getElementById('admin-user-modal').classList.add('hidden');
        };

        // ============================================================
        //  ADMIN — OFFERS (real-time)
        // ============================================================
        let adminOffersListenerAttached = false;
        function loadAdminOffersList() {
            const tbody = document.getElementById('admin-offers-table-body');
            if (!tbody) return;
            if (adminOffersListenerAttached) return;
            adminOffersListenerAttached = true;

            onValue(ref(db, 'offers'), (snap) => {
                if (!snap.exists()) {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding:15px;">No offers yet. Add one above.</td></tr>';
                    return;
                }
                let h = '';
                snap.forEach(child => {
                    const o = child.val();
                    h += `<tr>
                        <td>${o.id || child.key}</td>
                        <td>${o.name||''}</td>
                        <td>${o.country||''}</td>
                        <td>${o.category||''}</td>
                        <td>${o.payout||''}</td>
                        <td style="display:flex; gap:5px;">
                            <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#3699ff;" onclick="openAdminOfferModal('${escAttr(child.key)}')">Edit</button>
                            <button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#f64e60;" onclick="deleteAdminOffer('${escAttr(child.key)}')">Delete</button>
                        </td>
                    </tr>`;
                });
                tbody.innerHTML = h;
            }, (err) => {
                tbody.innerHTML = `<tr><td colspan="6" style="color:#f64e60; padding:15px;">Error: ${err.message}</td></tr>`;
            });
        }
        document.getElementById('admin-offer-search').addEventListener('input', e => {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#admin-offers-table-body tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        });
        document.getElementById('btn-offer-add').addEventListener('click', async () => {
            const name = document.getElementById('offer-add-name').value.trim();
            const country = document.getElementById('offer-add-country').value.trim();
            const category = document.getElementById('offer-add-category').value;
            const payout = document.getElementById('offer-add-payout').value.trim();
            let url = document.getElementById('offer-add-url').value.trim();
            if (!name || !country || !url) { showToast('Name, country and URL required.', 'error'); return; }
            const marker = 'sub5=s1';
            const idx = url.indexOf(marker);
            if (idx !== -1) url = url.substring(0, idx + marker.length);
            const id = 'OF' + Date.now();
            await set(ref(db, `offers/${id}`), {
                id, name, country, category, payout,
                epc: '$' + (Math.random()*5+0.5).toFixed(2),
                url, createdAt: Date.now()
            });
            showToast('Offer added.', 'success');
            document.getElementById('offer-add-name').value = '';
            document.getElementById('offer-add-country').value = '';
            document.getElementById('offer-add-payout').value = '';
        });

        let editingOfferKey = null;
        window.openAdminOfferModal = async function(key) {
            const snap = await get(ref(db, `offers/${key}`));
            if (!snap.exists()) return;
            const o = snap.val();
            editingOfferKey = key;
            document.getElementById('edit-offer-name').value = o.name || '';
            document.getElementById('edit-offer-country').value = o.country || '';
            document.getElementById('edit-offer-category').value = o.category || 'install';
            document.getElementById('edit-offer-payout').value = o.payout || '';
            document.getElementById('edit-offer-epc').value = o.epc || '';
            document.getElementById('edit-offer-url').value = o.url || '';
            document.getElementById('admin-offer-modal').classList.remove('hidden');
        };
        window.closeAdminOfferModal = function() {
            document.getElementById('admin-offer-modal').classList.add('hidden');
            editingOfferKey = null;
        };
        document.getElementById('btn-offer-save-edit').addEventListener('click', async () => {
            if (!editingOfferKey) return;
            let url = document.getElementById('edit-offer-url').value.trim();
            const marker = 'sub5=s1';
            const idx = url.indexOf(marker);
            if (idx !== -1) url = url.substring(0, idx + marker.length);
            await update(ref(db, `offers/${editingOfferKey}`), {
                name: document.getElementById('edit-offer-name').value.trim(),
                country: document.getElementById('edit-offer-country').value.trim(),
                category: document.getElementById('edit-offer-category').value,
                payout: document.getElementById('edit-offer-payout').value.trim(),
                epc: document.getElementById('edit-offer-epc').value.trim(),
                url
            });
            showToast('Offer updated.', 'success');
            closeAdminOfferModal();
        });
        window.deleteAdminOffer = async function(key) {
            if (!confirm('Delete this offer?')) return;
            await remove(ref(db, `offers/${key}`));
            showToast('Offer deleted.', 'info');
        };

        // ============================================================
        //  ADMIN — LIVE EARNINGS (real-time)
        // ============================================================
        let liveEarningsListenerAttached = false;
        function initializeAdminLiveEarnings() {
            const startInput = document.getElementById('admin-live-date-start');
            const endInput = document.getElementById('admin-live-date-end');
            const now = new Date();
            const weekAgo = new Date(now); weekAgo.setDate(weekAgo.getDate() - 7);
            if (!startInput.value) startInput.value = weekAgo.toISOString().slice(0,10);
            if (!endInput.value) endInput.value = now.toISOString().slice(0,10);

            function compute() {
                const sTs = new Date(startInput.value).getTime();
                const eTs = new Date(endInput.value).getTime() + 86400000 - 1;
                get(ref(db, 'trackings')).then(snap => {
                    const map = {};
                    let tClicks = 0, tLeads = 0, tEarn = 0;
                    if (snap.exists()) {
                        snap.forEach(aSnap => {
                            const key = aSnap.key;
                            const tracks = aSnap.val();
                            let c = 0, l = 0, e = 0;
                            Object.values(tracks).forEach(t => {
                                if (t.timestamp >= sTs && t.timestamp <= eTs) {
                                    c++;
                                    if (t.conversion) { l++; e += Number(t.earnings||0); }
                                }
                            });
                            if (c > 0) {
                                map[key] = { clicks: c, leads: l, earnings: e, epc: e/c };
                                tClicks += c; tLeads += l; tEarn += e;
                            }
                        });
                    }
                    document.getElementById('admin-live-total-clicks').innerText = tClicks;
                    document.getElementById('admin-live-total-leads').innerText = tLeads;
                    document.getElementById('admin-live-total-earnings').innerText = `$${tEarn.toFixed(2)}`;
                    document.getElementById('admin-live-total-epc').innerText = `$${(tClicks?tEarn/tClicks:0).toFixed(2)}`;
                    const tb = document.getElementById('admin-live-earnings-table-body');
                    let h = '';
                    Object.entries(map).forEach(([k, v]) => {
                        h += `<tr>
                            <td>${k.replace(/_/g,'.')}</td>
                            <td>${v.clicks}</td><td>${v.leads}</td>
                            <td>$${v.earnings.toFixed(2)}</td>
                            <td>$${v.epc.toFixed(2)}</td>
                        </tr>`;
                    });
                    tb.innerHTML = h || '<tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding:15px;">No data.</td></tr>';
                });
            }
            compute();
            document.getElementById('btn-admin-filter-live').onclick = compute;

            if (liveEarningsListenerAttached) return;
            liveEarningsListenerAttached = true;
            onValue(ref(db, 'trackings'), () => compute());
        }

        // ============================================================
        //  ADMIN — CLICK TRACKING (real-time)
        // ============================================================
        let ctAllRows = [];
        let ctListenerAttached = false;
        function renderCtTable() {
            const tbody = document.getElementById('admin-ct-table-body');
            if (!tbody) return;
            const searchVal = (document.getElementById('admin-ct-search')?.value || '').toLowerCase();
            let html = '';
            ctAllRows.forEach(r => {
                if (searchVal && !r.affKey.toLowerCase().includes(searchVal)) return;
                html += `<tr>
                    <td>${r.affKey.replace(/_/g,'.')}</td>
                    <td><strong>${r.affTotal}</strong></td>
                    <td>${r.affLast ? new Date(r.affLast).toLocaleString() : '—'}</td>
                    <td><code style="color:#3699ff;">${r.cid}</code></td>
                    <td><span class="ct-badge ok">${r.cidCount} clicks</span></td>
                    <td>${r.cidLast ? new Date(r.cidLast).toLocaleString() : '—'}</td>
                </tr>`;
            });
            tbody.innerHTML = html || '<tr><td colspan="6" style="text-align:center; color: var(--text-muted); padding:15px;">No click tracking data yet. Ask affiliates to generate links.</td></tr>';
        }
        function initializeAdminClickTracking() {
            if (ctListenerAttached) return;
            ctListenerAttached = true;
            onValue(ref(db, 'clickTracking'), (snap) => {
                let totalClicks = 0, affiliateCount = 0, distinctClickIds = 0, lastGlobalAt = 0;
                const rows = [];
                if (snap.exists()) {
                    snap.forEach(affSnap => {
                        const affKey = affSnap.key;
                        const affVal = affSnap.val() || {};
                        const summary = affVal.summary || {};
                        const clickIdsMap = affVal.clickIds || {};
                        const affTotal = summary.totalClicks || 0;
                        const affLast = summary.lastClickAt || 0;
                        if (affTotal > 0) affiliateCount++;
                        totalClicks += affTotal;
                        if (affLast > lastGlobalAt) lastGlobalAt = affLast;
                        const cidList = Object.keys(clickIdsMap);
                        distinctClickIds += cidList.length;
                        cidList.forEach(cid => {
                            const c = clickIdsMap[cid] || {};
                            rows.push({ affKey, affTotal, affLast, cid, cidCount: c.count || 0, cidLast: c.lastClickAt || 0 });
                        });
                    });
                }
                document.getElementById('ct-total-clicks').innerText = totalClicks;
                document.getElementById('ct-total-affiliates').innerText = affiliateCount;
                document.getElementById('ct-total-clickids').innerText = distinctClickIds;
                document.getElementById('ct-last-click').innerText = lastGlobalAt ? new Date(lastGlobalAt).toLocaleTimeString() : '—';
                rows.sort((a,b) => (b.cidLast||0) - (a.cidLast||0));
                ctAllRows = rows;
                renderCtTable();
            });
        }
        document.getElementById('admin-ct-search').addEventListener('input', renderCtTable);

        // ============================================================
        //  ADMIN — TRAFFIC QUALITY (real-time)
        // ============================================================
        let tqListenerAttached = false;
        function initializeAdminTrafficQuality() {
            if (tqListenerAttached) return;
            tqListenerAttached = true;
            onValue(ref(db, 'trackings'), (snap) => {
                const map = {};
                let totalClicks = 0, totalUnique = 0, totalDup = 0, totalLeads = 0;
                if (snap.exists()) {
                    snap.forEach(aSnap => {
                        const key = aSnap.key;
                        const tracks = aSnap.val();
                        let c = 0, u = 0, d = 0, l = 0;
                        const ips = new Set();
                        Object.values(tracks).forEach(t => {
                            c++;
                            if (t.isDuplicate) d++; else u++;
                            if (t.ip) ips.add(t.ip);
                            if (t.conversion) l++;
                        });
                        map[key] = { clicks: c, unique: u, dup: d, leads: l, ips: ips.size };
                        totalClicks += c; totalUnique += u; totalDup += d; totalLeads += l;
                    });
                }
                document.getElementById('tq-total-clicks').innerText = totalClicks;
                document.getElementById('tq-unique-ips').innerText = totalUnique;
                document.getElementById('tq-duplicate-pct').innerText = totalClicks ? `${((totalDup/totalClicks)*100).toFixed(1)}%` : '0%';
                document.getElementById('tq-lead-quality').innerText = totalClicks ? `${((totalLeads/totalClicks)*100).toFixed(1)}%` : '0%';
                const tb = document.getElementById('admin-traffic-quality-body');
                let h = '';
                Object.entries(map).forEach(([k, v]) => {
                    const dupPct = v.clicks ? ((v.dup/v.clicks)*100).toFixed(1) : '0.0';
                    const lq = v.clicks ? ((v.leads/v.clicks)*100).toFixed(1) : '0.0';
                    h += `<tr>
                        <td>${k.replace(/_/g,'.')}</td>
                        <td>${v.clicks}</td>
                        <td>${v.unique}</td>
                        <td>${v.dup}</td>
                        <td>${dupPct}%</td>
                        <td>${v.leads}</td>
                        <td>${lq}%</td>
                    </tr>`;
                });
                tb.innerHTML = h || '<tr><td colspan="7" style="text-align:center; color: var(--text-muted); padding:15px;">No data.</td></tr>';
            });
        }

        // ============================================================
        //  ADMIN — MANAGERS (real-time)
        // ============================================================
        let managersListenerAttached = false;
        function loadManagersList() {
            const tb = document.getElementById('admin-managers-table-body');
            if (!tb) return;
            if (managersListenerAttached) return;
            managersListenerAttached = true;

            onValue(ref(db, 'managers'), (snap) => {
                if (!snap.exists()) {
                    tb.innerHTML = '<tr><td colspan="3" style="text-align:center; color: var(--text-muted); padding:15px;">No managers yet.</td></tr>';
                    return;
                }
                let h = '';
                snap.forEach(c => {
                    const m = c.val();
                    h += `<tr>
                        <td>${m.email||c.key.replace(/_/g,'.')}</td>
                        <td>${new Date(m.createdAt||Date.now()).toLocaleString()}</td>
                        <td><button class="btn-submit" style="margin-top:0; padding:4px 8px; font-size:11px; background:#f64e60;" onclick="deleteManager('${escAttr(c.key)}')">Delete</button></td>
                    </tr>`;
                });
                tb.innerHTML = h;
            }, (err) => {
                tb.innerHTML = `<tr><td colspan="3" style="color:#f64e60; padding:15px;">Error: ${err.message}</td></tr>`;
            });
        }
        document.getElementById('btn-manager-add').addEventListener('click', async () => {
            const email = document.getElementById('manager-add-email').value.trim();
            const password = document.getElementById('manager-add-password').value.trim();
            if (!email || !password) { showToast('Email and password required.', 'error'); return; }
            if (password.length < 6) { showToast('Password must be at least 6 characters.', 'error'); return; }

            let secondaryApp;
            try {
                secondaryApp = initializeApp(firebaseConfig, 'ManagerCreator_' + Date.now());
                const secondaryAuth = getAuth(secondaryApp);
                await createUserWithEmailAndPassword(secondaryAuth, email, password);
                await signOut(secondaryAuth);
                await deleteApp(secondaryApp);
            } catch (e) {
                if (secondaryApp) { try { await deleteApp(secondaryApp); } catch(_) {} }
                if (!/already-in-use/i.test(e.message || '')) {
                    showToast('Auth error: ' + (e.message || 'unknown'), 'error');
                    return;
                }
            }

            await set(ref(db, `managers/${safeKey(email)}`), {
                email, active: true,
                createdAt: Date.now(),
                createdBy: loggedInUserEmail || 'admin'
            });
            showToast('Manager account created.', 'success');
            document.getElementById('manager-add-email').value = '';
            document.getElementById('manager-add-password').value = '';
        });
        window.deleteManager = async function(key) {
            if (!confirm('Delete this manager?')) return;
            await remove(ref(db, `managers/${key}`));
            showToast('Manager deleted.', 'info');
        };

        // ============================================================
        //  ADMIN — CLICK ID SEARCH & APPROVE
        // ============================================================
        document.getElementById('btn-admin-search-click-id').addEventListener('click', async () => {
            const cid = document.getElementById('admin-click-id-search').value.trim();
            const res = document.getElementById('admin-click-id-result');
            if (!cid) { res.innerHTML = '<span style="color:#f64e60;">Enter a Click ID.</span>'; return; }
            res.innerHTML = 'Searching...';
            try {
                const snap = await get(ref(db, 'trackings'));
                let found = null, aff = null, evId = null;
                if (snap.exists()) {
                    snap.forEach(aSnap => {
                        const tracks = aSnap.val();
                        Object.keys(tracks).forEach(k => {
                            if (tracks[k].clickId === cid || k === cid) {
                                found = tracks[k]; aff = aSnap.key; evId = k;
                            }
                        });
                    });
                }
                if (!found) { res.innerHTML = '<span style="color:#f64e60;">Click ID not found.</span>'; return; }
                res.innerHTML = `
                    <div style="background: var(--card-bg); padding: 15px; border-radius: 6px; border: 1px solid var(--border-color);">
                        <strong>Click Details</strong><br>
                        Click ID: <code>${cid}</code><br>
                        Event ID: <code>${evId}</code><br>
                        Affiliate: ${aff.replace(/_/g,'.')}<br>
                        IP: ${found.ip||'N/A'}<br>
                        Timestamp: ${new Date(found.timestamp).toLocaleString()}<br>
                        Status: ${found.conversion ? 'Converted' : 'Pending'}<br>
                        ${!found.conversion ? `<button class="btn-submit" style="margin-top:10px; width:auto; padding: 8px 20px;" onclick="approveLeadByClickId('${escAttr(evId)}', '${escAttr(aff)}')">Approve Lead (+$25)</button>` : ''}
                    </div>`;
            } catch(e) { res.innerHTML = `<span style="color:#f64e60;">Error: ${e.message}</span>`; }
        });
        window.approveLeadByClickId = async function(evId, affKey) {
            await update(ref(db, `trackings/${affKey}/${evId}`), { conversion: true, earnings: 25.00 });
            const statsRef = ref(db, `users/${affKey}/stats`);
            const snap = await get(statsRef);
            const s = snap.exists() ? snap.val() : {};
            await update(statsRef, { earnings: (s.earnings||0)+25, leads: (s.leads||0)+1 });
            const day = todayKey();
            const dRef = ref(db, `dailyCounters/${affKey}/${day}`);
            const dSnap = await get(dRef);
            const d = dSnap.exists() ? dSnap.val() : { clicks: 0, leads: 0, earnings: 0 };
            await set(dRef, { clicks: d.clicks||0, leads: (d.leads||0)+1, earnings: (d.earnings||0)+25 });
            await set(ref(db, `leads/${Date.now()}`), { clickId: evId, affiliate: affKey, earnings: 25.00, timestamp: Date.now() });
            playConversionSound();
            showToast('Lead approved and balance credited.', 'success');
            document.getElementById('btn-admin-search-click-id').click();
        };

        // ============================================================
        //  ADMIN — SETTINGS & MANUAL UPDATE
        // ============================================================
        document.getElementById('btn-save-api-settings').addEventListener('click', () => {
            currentApiKey = document.getElementById('admin-api-key-input').value.trim();
            masterGlobalLink = document.getElementById('admin-master-link-input').value.trim();
            const marker = 's1';
            const idx = masterGlobalLink.indexOf(marker);
            if (idx !== -1) masterGlobalLink = masterGlobalLink.substring(0, idx + marker.length);
            const pg = document.getElementById('preview-global-link');
            if (pg) pg.href = masterGlobalLink;
            generateOffersData();
            updateRedirectPreview();
            showToast('API settings saved.', 'success');
        });
        document.getElementById('btn-admin-switch-affiliate').addEventListener('click', () => {
            loggedInUserEmail = "admin_preview@admadia.site";
            loggedInUserFFId = "FF-ADMIN";
            currentRole = "affiliate";
            showAffiliateDashboard();
        });
        document.getElementById('btn-admin-manual-update').addEventListener('click', async () => {
            const target = document.getElementById('admin-target-user').value.trim();
            const amount = parseFloat(document.getElementById('admin-target-amount').value);
            const action = document.getElementById('admin-action-type').value;
            if (!target || isNaN(amount)) { showToast('Invalid input.', 'error'); return; }
            const key = safeKey(target);
            const statsRef = ref(db, `users/${key}/stats`);
            const snap = await get(statsRef);
            let s = snap.exists() ? snap.val() : { clicks: 0, leads: 0, earnings: 0 };
            if (action === 'add_balance') s.earnings = (s.earnings||0) + amount;
            else if (action === 'add_lead') { s.leads = (s.leads||0) + amount; s.earnings = (s.earnings||0) + (amount * 25); }
            await update(statsRef, s);
            showToast(`Account updated for ${target}.`, 'success');
        });

        window.generateOffersData = generateOffersData;
    </script>
</body>
</html>
