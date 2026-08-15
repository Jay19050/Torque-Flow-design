<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is authenticated as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once "connection.php";

// Fetch dynamic data from existing tables
$admin_email = isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email'], ENT_QUOTES, 'UTF-8') : 'admin@torqueflow.com';

// 1. Total Customers from cust_regis
$cust_res = mysqli_query($con, "SELECT COUNT(*) AS total FROM cust_regis");
$total_customers = ($cust_res) ? mysqli_fetch_assoc($cust_res)['total'] : 0;

// 2. Total Service Centers from service_center_info
$sc_res = mysqli_query($con, "SELECT COUNT(*) AS total FROM service_center_info");
$total_centers = ($sc_res) ? mysqli_fetch_assoc($sc_res)['total'] : 0;

// 3. Customers list
$customers_query = mysqli_query($con, "SELECT * FROM cust_regis ORDER BY cust_id DESC");
$customers = [];
if ($customers_query) {
    while ($row = mysqli_fetch_assoc($customers_query)) {
        $customers[] = $row;
    }
}

// 4. Service Centers list
$centers_query = mysqli_query($con, "SELECT * FROM service_center_info ORDER BY center_id ASC");
$service_centers = [];
if ($centers_query) {
    while ($row = mysqli_fetch_assoc($centers_query)) {
        $service_centers[] = $row;
    }
}

// Standard service offerings
$standard_services = [
    ['id' => 'SRV-01', 'name' => 'Performance & Tuning', 'category' => 'Performance', 'duration' => '3-5 Hours', 'status' => 'Active'],
    ['id' => 'SRV-02', 'name' => 'Routine Maintenance', 'category' => 'Maintenance', 'duration' => '1.5-2 Hours', 'status' => 'Active'],
    ['id' => 'SRV-03', 'name' => 'Advanced Diagnostics', 'category' => 'Diagnostics', 'duration' => '1-2 Hours', 'status' => 'Active'],
    ['id' => 'SRV-04', 'name' => 'Precision Brake Service', 'category' => 'Safety & Control', 'duration' => '2-3 Hours', 'status' => 'Active'],
    ['id' => 'SRV-05', 'name' => 'Laser Wheel Alignment', 'category' => 'Handling', 'duration' => '1 Hour', 'status' => 'Active'],
    ['id' => 'SRV-06', 'name' => 'Battery & Electrical Care', 'category' => 'Electrical', 'duration' => '45 Mins', 'status' => 'Active']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Console — Torque Flow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Oswald:wght@400;500;600&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css?v=<?= time() ?>">
</head>
<body>

<div class="admin-wrapper">

    <!-- Mobile Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- =====================================================
         SIDEBAR NAVIGATION
    ===================================================== -->
    <aside class="admin-sidebar" id="adminSidebar">
        
        <div class="sidebar-brand">
            <div class="brand-title">TORQUE FLOW</div>
            <div class="brand-badge">ADMIN CONSOLE</div>
        </div>

        <nav class="sidebar-nav" aria-label="Admin Navigation">
            <div class="nav-category">Management</div>
            
            <button type="button" class="nav-item active" data-tab="tab-overview">
                <div class="nav-item-left">
                    <span class="nav-item-num">01</span>
                    <span>Dashboard</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>

            <button type="button" class="nav-item" data-tab="tab-customers">
                <div class="nav-item-left">
                    <span class="nav-item-num">02</span>
                    <span>Customers</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>

            <button type="button" class="nav-item" data-tab="tab-centers">
                <div class="nav-item-left">
                    <span class="nav-item-num">03</span>
                    <span>Service Centers</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>

            <button type="button" class="nav-item" data-tab="tab-services">
                <div class="nav-item-left">
                    <span class="nav-item-num">04</span>
                    <span>Services</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>

            <div class="nav-category">Operations</div>

            <button type="button" class="nav-item" data-tab="tab-bookings">
                <div class="nav-item-left">
                    <span class="nav-item-num">05</span>
                    <span>Bookings</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>

            <button type="button" class="nav-item" data-tab="tab-reports">
                <div class="nav-item-left">
                    <span class="nav-item-num">06</span>
                    <span>Reports</span>
                </div>
                <span class="nav-item-arrow">→</span>
            </button>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-profile-card">
                <div class="admin-avatar">TF</div>
                <div class="admin-info">
                    <div class="admin-role">Super Admin</div>
                    <div class="admin-email" title="<?= $admin_email ?>"><?= $admin_email ?></div>
                </div>
            </div>
            <a href="logout.php" class="btn-logout">
                <span>Logout Session</span>
                <span>↗</span>
            </a>
        </div>

    </aside>

    <!-- =====================================================
         MAIN CONTENT AREA
    ===================================================== -->
    <main class="admin-main">
        
        <!-- TOP HEADER -->
        <header class="admin-header">
            <div class="header-left">
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Toggle navigation menu">
                    ☰
                </button>
                <div class="page-breadcrumb">
                    <span class="breadcrumb-label">Torque Flow / Administration</span>
                    <h1 class="page-title" id="activePageTitle">Dashboard Overview</h1>
                </div>
            </div>

            <div class="header-right">
                <div class="status-pill">
                    <span class="status-dot"></span>
                    <span>Database Connected</span>
                </div>
                <a href="index.php" target="_blank" class="btn-public-site">
                    <span>View Website</span>
                    <span>↗</span>
                </a>
            </div>
        </header>

        <!-- DASHBOARD BODY CONTAINER -->
        <div class="admin-body">

            <!-- =====================================================
                 TAB 1: DASHBOARD OVERVIEW
            ===================================================== -->
            <section class="tab-content active" id="tab-overview">
                
                <!-- KPI STAT CARDS -->
                <div class="stats-grid">
                    
                    <div class="stat-card accent-stat">
                        <div class="stat-header">
                            <span class="stat-tag">Total Customers</span>
                            <span class="stat-badge badge-live">LIVE DB</span>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value"><?= str_pad($total_customers, 2, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        <div class="stat-footer">
                            <span>Registered client accounts</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-tag">Service Centers</span>
                            <span class="stat-badge badge-live">LIVE DB</span>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value"><?= str_pad($total_centers, 2, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        <div class="stat-footer">
                            <span>Active workshop locations</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-tag">Services Catalog</span>
                            <span class="stat-badge badge-live">ACTIVE</span>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">06</div>
                        </div>
                        <div class="stat-footer">
                            <span>Core automotive packages</span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-tag">Total Bookings</span>
                            <span class="stat-badge badge-placeholder">RESERVED</span>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">--</div>
                        </div>
                        <div class="stat-footer">
                            <span>Booking module placeholder</span>
                        </div>
                    </div>

                </div>

                <!-- OVERVIEW TWO COLUMN GRID -->
                <div class="two-col-grid">
                    
                    <!-- RECENT CUSTOMERS PANEL -->
                    <div class="data-panel">
                        <div class="panel-header">
                            <div class="panel-title-group">
                                <span class="panel-eyebrow">Database Record</span>
                                <h2 class="panel-heading">Recent Customer Registrations</h2>
                            </div>
                            <div class="panel-actions">
                                <button type="button" class="btn-public-site" onclick="switchTab('tab-customers')">
                                    <span>View All</span> ↗
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="tf-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>City</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($customers)): ?>
                                        <?php foreach (array_slice($customers, 0, 5) as $cust): ?>
                                            <tr>
                                                <td><span class="id-badge">#<?= htmlspecialchars($cust['cust_id'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                                <td class="primary-col"><?= htmlspecialchars($cust['cust_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><span class="tag-badge tag-city"><?= htmlspecialchars($cust['city'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                                <td><?= htmlspecialchars($cust['mobile_no'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($cust['email_id'], ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align:center; padding: 30px; color: var(--tf-text-muted);">
                                                No customer records found in database.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SYSTEM TELEMETRY & CENTER SUMMARY -->
                    <div class="data-panel">
                        <div class="panel-header">
                            <div class="panel-title-group">
                                <span class="panel-eyebrow">Environment</span>
                                <h2 class="panel-heading">System Telemetry</h2>
                            </div>
                        </div>
                        <div class="info-list">
                            <div class="info-row">
                                <span class="info-label">Active Admin</span>
                                <span class="info-val" style="color: var(--tf-accent);"><?= $admin_email ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Database Target</span>
                                <span class="info-val">torque_flow (MySQL)</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">PHP Version</span>
                                <span class="info-val"><?= phpversion() ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Server Software</span>
                                <span class="info-val"><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Apache', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Primary Service Center</span>
                                <span class="info-val"><?= !empty($service_centers) ? htmlspecialchars($service_centers[0]['center_name'] . ' (' . $service_centers[0]['city'] . ')', ENT_QUOTES, 'UTF-8') : 'None' ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Session Status</span>
                                <span class="info-val" style="color: var(--tf-success);">Active (Encrypted)</span>
                            </div>
                        </div>
                    </div>

                </div>

            </section>


            <!-- =====================================================
                 TAB 2: CUSTOMERS DIRECTORY
            ===================================================== -->
            <section class="tab-content" id="tab-customers">
                
                <div class="data-panel">
                    <div class="panel-header">
                        <div class="panel-title-group">
                            <span class="panel-eyebrow">Live Registry</span>
                            <h2 class="panel-heading">Registered Customers (<?= count($customers) ?>)</h2>
                        </div>
                        <div class="panel-actions">
                            <input type="text" class="search-input" id="searchCustomers" placeholder="Search customers, city, email..." onkeyup="filterTable('searchCustomers', 'customersTable')">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="tf-table" id="customersTable">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Full Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Mobile Number</th>
                                    <th>Email Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($customers)): ?>
                                    <?php foreach ($customers as $cust): ?>
                                        <tr>
                                            <td><span class="id-badge">#<?= htmlspecialchars($cust['cust_id'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td class="primary-col"><?= htmlspecialchars($cust['cust_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($cust['address'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><span class="tag-badge tag-city"><?= htmlspecialchars($cust['city'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td><?= htmlspecialchars($cust['mobile_no'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><a href="mailto:<?= htmlspecialchars($cust['email_id'], ENT_QUOTES, 'UTF-8') ?>" style="color: var(--tf-accent);"><?= htmlspecialchars($cust['email_id'], ENT_QUOTES, 'UTF-8') ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding: 40px; color: var(--tf-text-muted);">
                                            No customer records found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>


            <!-- =====================================================
                 TAB 3: SERVICE CENTERS DIRECTORY
            ===================================================== -->
            <section class="tab-content" id="tab-centers">
                
                <div class="data-panel">
                    <div class="panel-header">
                        <div class="panel-title-group">
                            <span class="panel-eyebrow">Workshop Locations</span>
                            <h2 class="panel-heading">Service Centers Directory (<?= count($service_centers) ?>)</h2>
                        </div>
                        <div class="panel-actions">
                            <input type="text" class="search-input" id="searchCenters" placeholder="Search center, city, phone..." onkeyup="filterTable('searchCenters', 'centersTable')">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="tf-table" id="centersTable">
                            <thead>
                                <tr>
                                    <th>Center ID</th>
                                    <th>Center Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Contact Phone</th>
                                    <th>Email ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($service_centers)): ?>
                                    <?php foreach ($service_centers as $sc): ?>
                                        <tr>
                                            <td><span class="id-badge">#<?= htmlspecialchars($sc['center_id'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td class="primary-col"><span class="tag-badge tag-center"><?= htmlspecialchars($sc['center_name'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td><?= htmlspecialchars($sc['address'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><span class="tag-badge tag-city"><?= htmlspecialchars($sc['city'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                            <td><?= htmlspecialchars($sc['mobile_no'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><a href="mailto:<?= htmlspecialchars($sc['email_id'], ENT_QUOTES, 'UTF-8') ?>" style="color: var(--tf-accent);"><?= htmlspecialchars($sc['email_id'], ENT_QUOTES, 'UTF-8') ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding: 40px; color: var(--tf-text-muted);">
                                            No service center records found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>


            <!-- =====================================================
                 TAB 4: SERVICES CATALOG
            ===================================================== -->
            <section class="tab-content" id="tab-services">
                
                <div class="data-panel">
                    <div class="panel-header">
                        <div class="panel-title-group">
                            <span class="panel-eyebrow">Service Offerings</span>
                            <h2 class="panel-heading">Torque Flow Automotive Packages (<?= count($standard_services) ?>)</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="tf-table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Package Name</th>
                                    <th>Category</th>
                                    <th>Estimated Duration</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($standard_services as $srv): ?>
                                    <tr>
                                        <td><span class="id-badge"><?= $srv['id'] ?></span></td>
                                        <td class="primary-col"><?= $srv['name'] ?></td>
                                        <td><span class="tag-badge tag-city"><?= $srv['category'] ?></span></td>
                                        <td><?= $srv['duration'] ?></td>
                                        <td><span class="status-pill" style="padding: 3px 8px; font-size: 8px;"><span class="status-dot"></span> <?= $srv['status'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>


            <!-- =====================================================
                 TAB 5: BOOKINGS (PLACEHOLDER MODULE)
            ===================================================== -->
            <section class="tab-content" id="tab-bookings">
                
                <div class="placeholder-box">
                    <div class="placeholder-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h2 class="placeholder-title">Customer Bookings Module</h2>
                    <p class="placeholder-text">
                        The customer booking module is reserved for integration with the upcoming booking engine. 
                        No arbitrary database modifications were introduced. When customer bookings are submitted, 
                        records will stream directly to this view.
                    </p>
                    <span class="placeholder-tag">System Ready for Customer Booking Integration</span>
                </div>

            </section>


            <!-- =====================================================
                 TAB 6: REPORTS (PLACEHOLDER MODULE)
            ===================================================== -->
            <section class="tab-content" id="tab-reports">
                
                <div class="placeholder-box">
                    <div class="placeholder-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                    </div>
                    <h2 class="placeholder-title">Automotive Analytics & Reports</h2>
                    <p class="placeholder-text">
                        Comprehensive workshop performance analytics, service turnaround metrics, and revenue summaries. 
                        Ready to connect to expanded telemetry datasets.
                    </p>
                    <span class="placeholder-tag">Module Reserved</span>
                </div>

            </section>

        </div>

    </main>

</div>

<script>
// Tab Switching
const tabButtons = document.querySelectorAll('.nav-item[data-tab]');
const tabPanels = document.querySelectorAll('.tab-content');
const pageTitle = document.getElementById('activePageTitle');

const tabTitles = {
    'tab-overview': 'Dashboard Overview',
    'tab-customers': 'Customer Accounts Directory',
    'tab-centers': 'Service Center Locations',
    'tab-services': 'Automotive Services Catalog',
    'tab-bookings': 'Vehicle Service Bookings',
    'tab-reports': 'Analytics & Reports'
};

function switchTab(tabId) {
    tabButtons.forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-tab') === tabId);
    });

    tabPanels.forEach(panel => {
        panel.classList.toggle('active', panel.id === tabId);
    });

    if (tabTitles[tabId] && pageTitle) {
        pageTitle.textContent = tabTitles[tabId];
    }

    // Close mobile menu if open
    closeMobileSidebar();
}

tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const targetTab = btn.getAttribute('data-tab');
        if (targetTab) {
            switchTab(targetTab);
        }
    });
});

// Live Table Search Filter
function filterTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const filter = input.value.toLowerCase();
    const table = document.getElementById(tableId);
    if (!table) return;
    const trs = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (let i = 0; i < trs.length; i++) {
        const text = trs[i].textContent.toLowerCase();
        trs[i].style.display = text.indexOf(filter) > -1 ? '' : 'none';
    }
}

// Mobile Sidebar Drawer Toggle
const menuToggle = document.getElementById('menuToggle');
const adminSidebar = document.getElementById('adminSidebar');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');

function toggleMobileSidebar() {
    if (adminSidebar && sidebarBackdrop) {
        adminSidebar.classList.toggle('open');
        sidebarBackdrop.classList.toggle('open');
    }
}

function closeMobileSidebar() {
    if (adminSidebar && sidebarBackdrop) {
        adminSidebar.classList.remove('open');
        sidebarBackdrop.classList.remove('open');
    }
}

if (menuToggle) {
    menuToggle.addEventListener('click', toggleMobileSidebar);
}

if (sidebarBackdrop) {
    sidebarBackdrop.addEventListener('click', closeMobileSidebar);
}
</script>

</body>
</html>
