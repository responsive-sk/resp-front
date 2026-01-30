<?php $this->layout('resp-front::mark/layout', [
    'title' => 'Manage Users',
    'currentRoute' => 'mark.users.index',
]) ?>

<?php $this->start('mark-content') ?>

<div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #181c32;">Users</h1>
        <p style="margin: 0.5rem 0 0; color: #a1a5b7; font-size: 0.9rem;">Manage system access and roles</p>
    </div>
    <mark-button href="<?= $this->url('mark.users.create') ?>">+ New User</mark-button>
</div>

<?php if (isset($users) && count($users) > 0): ?>
    <mark-card no-padding>
        <mark-table>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-weight: 600; color: #fff; font-size: 0.9rem;">
                                        <?= strtoupper(substr($user->email()->toString(), 0, 2)) ?>
                                    </div>
                                    <div style="color: var(--admin-text-primary); font-weight: 500;">
                                        <?= $this->escapeHtml($user->email()->toString()) ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if ($user->role()->isMark()): ?>
                                    <mark-badge variant="primary">MANAGER</mark-badge>
                                <?php else: ?>
                                    <mark-badge variant="secondary">USER</mark-badge>
                                <?php endif; ?>
                            </td>
                            <td style="color: var(--admin-text-secondary); font-size: 0.9rem;">
                                <?= $user->createdAt()->format('M d, Y') ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <mark-button variant="icon" href="<?= $this->url('mark.users.edit', ['id' => $user->id()->toString()]) ?>">
                                        <!-- Simple SVG Icon for Edit -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </mark-button>
                                    <mark-button variant="icon-danger" href="<?= $this->url('mark.users.delete', ['id' => $user->id()->toString()]) ?>" onclick="return confirm('Delete this user?');">
                                        <!-- Simple SVG Icon for Delete -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </mark-button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </mark-table>
    </mark-card>
<?php else: ?>
    <mark-card>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
            <h3 style="font-size: 1.1rem; color: #181c32; font-weight: 600; margin-bottom: 0.5rem;">No Users Found</h3>
            <p style="color: #a1a5b7; margin-bottom: 1.5rem;">Start by adding a new user to the system.</p>
            <mark-button href="<?= $this->url('mark.users.create') ?>">Create User</mark-button>
        </div>
    </mark-card>
<?php endif; ?>

<?php $this->stop() ?>