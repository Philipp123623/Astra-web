<aside class="dashboard-sidebar">

    <div class="dashboard-logo">
        Astra<span>Bot</span>
    </div>

    <nav class="dashboard-nav">
        <a href="/dashboard/"
           class="<?= $active === 'overview' ? 'active' : '' ?>"
           data-icon="📊">Overview</a>

        <a href="/dashboard/servers.php"
           class="<?= $active === 'servers' ? 'active' : '' ?>"
           data-icon="🖥️">Servers</a>

        <a href="/dashboard/commands.php"
           class="<?= $active === 'commands' ? 'active' : '' ?>"
           data-icon="⚙️">Commands</a>

        <a href="/dashboard/users.php"
           class="<?= $active === 'users' ? 'active' : '' ?>"
           data-icon="👥">Users</a>

        <a href="/dashboard/settings.php"
           class="<?= $active === 'settings' ? 'active' : '' ?>"
           data-icon="🛠️">Settings</a>
    </nav>

    <div class="dashboard-sidebar-footer">
        <span>Status</span>
        <span class="dashboard-status <?= $bot_online ? 'online' : 'offline' ?>">
            ● <?= $bot_online ? 'Online' : 'Offline' ?>
        </span>
    </div>

</aside>
