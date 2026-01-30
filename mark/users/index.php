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
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #eff2f5;">
                        <th style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">User</th>
                        <th style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Role</th>
                        <th style="text-align: left; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Joined Date</th>
                        <th style="text-align: right; padding: 1.25rem 1.5rem; color: #b5b5c3; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr style="border-bottom: 1px dashed #eff2f5;">
                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 40px; height: 40px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; font-weight: 600; color: #5e6278; font-size: 0.9rem;">
                                        <?= strtoupper(substr($user->email()->toString(), 0, 2)) ?>
                                    </div>
                                    <div>
                                        <div style="color: #464e5f; font-weight: 600; font-size: 0.95rem;">
                                            <?= $this->escapeHtml($user->email()->toString()) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <?php if ($user->role()->isMark()): ?>
                                    <mark-badge variant="primary">MANAGER</mark-badge>
                                <?php else: ?>
                                    <mark-badge variant="secondary">USER</mark-badge>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: #7e8299; font-size: 0.9rem;">
                                <?= $user->createdAt()->format('M d, Y') ?>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <mark-button variant="icon" href="<?= $this->url('mark.users.edit', ['id' => $user->id()->toString()]) ?>">
                                        ✏️
                                    </mark-button>
                                    <mark-button variant="icon-danger" href="<?= $this->url('mark.users.delete', ['id' => $user->id()->toString()]) ?>" onclick="return confirm('Delete this user?');">
                                        🗑️
                                    </mark-button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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