<?php ?><div class="row mb-3 align-items-center">
    <div class="col-md-3 mb-2">
        <h5 class="mb-0">Total Users: <span class="badge bg-primary"><?php echo htmlspecialchars(($total) ?? '', ENT_QUOTES, 'UTF-8'); ?></span></h5>
    </div>
    <div class="col-md-6">
        <div class="row g-2">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" id="userSearch" placeholder="Search by name or email..." value="<?php echo htmlspecialchars(($search) ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <button class="btn btn-primary" type="button" onclick="searchUsers()">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-select" id="statusFilter" onchange="changeStatus(this.value)">
                    <option value="active" <?php echo htmlspecialchars(($status == 'active' ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>Active Only</option>
                    <option value="inactive" <?php echo htmlspecialchars(($status == 'inactive' ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>Inactive Only</option>
                    <option value="all" <?php echo htmlspecialchars(($status == 'all' ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>All Users</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3 text-end">
        <a href="/admin/users/create" class="btn btn-success">
            <i class="bi bi-person-plus"></i> Create User
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
            <tr>
                <td colspan="7" class="text-center">No users found</td>
            </tr>
            <?php else: ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <?php if ($user->avatar): ?>
                    <img src="/avatars/<?php echo htmlspecialchars(($user->avatar) ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        class="rounded-circle"
                        width="40"
                        height="40"
                        style="object-fit: cover;"
                        alt="Avatar">
                    <?php else: ?>
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; font-size: 1.2rem;">
                        <?php echo htmlspecialchars((strtoupper(substr($user->name, 0, 1))) ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars(($user->name) ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars(($user->email) ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <?php if ($user->role == 1): ?>
                    <span class="badge bg-danger">Admin</span>
                    <?php else: ?>
                    <span class="badge bg-primary">User</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                            type="checkbox"
                            <?php echo htmlspecialchars(($user->active == 1 ? 'checked' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            <?php echo htmlspecialchars(($user->id == \app\core\Session::user()->id ? 'disabled' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            onchange="toggleUserStatus(<?php echo htmlspecialchars(($user->id) ?? '', ENT_QUOTES, 'UTF-8'); ?>, this.checked, '<?php echo htmlspecialchars((csrf_token()) ?? '', ENT_QUOTES, 'UTF-8'); ?>')">
                    </div>
                </td>
                <td><?php echo htmlspecialchars((date('Y-m-d', strtotime($user->created_at))) ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="/admin/users/<?php echo htmlspecialchars(($user->id) ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <?php if ($user->id != \app\core\Session::user()->id): ?>
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="confirmDeleteUser(<?php echo htmlspecialchars(($user->id) ?? '', ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars((addslashes($user->name)) ?? '', ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars((csrf_token()) ?? '', ENT_QUOTES, 'UTF-8'); ?>')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination Controls -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="d-flex align-items-center">
            <label class="me-2">Show:</label>
            <select class="form-select form-select-sm w-auto" onchange="changePerPage(this.value)">
                <option value="5" <?php echo htmlspecialchars(($perPage == 5 ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>5</option>
                <option value="10" <?php echo htmlspecialchars(($perPage == 10 ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>10</option>
                <option value="20" <?php echo htmlspecialchars(($perPage == 20 ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>20</option>
                <option value="50" <?php echo htmlspecialchars(($perPage == 50 ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>50</option>
                <option value="all" <?php echo htmlspecialchars(($perPage == 'all' ? 'selected' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>>All</option>
            </select>
            <span class="ms-2">per page</span>
        </div>
    </div>
    <div class="col-md-6">
        <?php if ($totalPages > 1): ?>
        <nav aria-label="User pagination">
            <ul class="pagination pagination-sm justify-content-end mb-0">
                <li class="page-item <?php echo htmlspecialchars(($page <= 1 ? 'disabled' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <a class="page-link" href="#" onclick="goToPage(<?php echo htmlspecialchars(($page - 1) ?? '', ENT_QUOTES, 'UTF-8'); ?>); return false;">Previous</a>
                </li>

                <?php $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2); ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo htmlspecialchars(($i == $page ? 'active' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <a class="page-link" href="#" onclick="goToPage(<?php echo htmlspecialchars(($i) ?? '', ENT_QUOTES, 'UTF-8'); ?>); return false;"><?php echo htmlspecialchars(($i) ?? '', ENT_QUOTES, 'UTF-8'); ?></a>
                    </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo htmlspecialchars(($page >= $totalPages ? 'disabled' : '') ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        <a class="page-link" href="#" onclick="goToPage(<?php echo htmlspecialchars(($page + 1) ?? '', ENT_QUOTES, 'UTF-8'); ?>); return false;">Next</a>
                    </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<script>
    // Update state from server values (functions are defined in dashboard view)
    if (window.adminUsers) {
        window.adminUsers.currentPage = <?php echo $page; ?>;
        window.adminUsers.currentPerPage = '<?php echo $perPage; ?>';
        window.adminUsers.currentSearch = '<?php echo addslashes($search); ?>';
        window.adminUsers.currentStatus = '<?php echo $status; ?>';
    }

    // Re-attach Enter key listener for search (in case DOM was replaced)
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (window.searchUsers) {
                    window.searchUsers();
                }
            }
        });
    }
</script>