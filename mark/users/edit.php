<?php $this->layout('resp-front::mark/layout', [
    'title' => 'Edit User',
    'currentRoute' => 'mark.users.edit',
]) ?>

<?php $this->start('mark-content') ?>

<div class="section-headers"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #181c32;">Edit User</h1>
        <p style="margin: 0.5rem 0 0; color: #a1a5b7; font-size: 0.9rem;">Update user details and access</p>
    </div>
    <mark-button variant="secondary" href="<?= $this->url('mark.users.index') ?>">← Back to Users</mark-button>
</div>

<mark-card style="max-width: 800px; margin: 0 auto;">
    <?php if (isset($error)): ?>
        <div
            style="background: rgba(241, 65, 108, 0.1); color: #f1416c; padding: 1rem; border-radius: 0.6rem; margin-bottom: 1.5rem; border: 1px dashed rgba(241, 65, 108, 0.3); font-size: 0.9rem;">
            <?= $this->escapeHtml($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($user)): ?>
        <form method="post" action="<?= $this->url('mark.users.update', ['id' => $user->id()->toString()]) ?>">
            <div style="margin-bottom: 1.5rem;">
                <label
                    style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--admin-text-secondary, #a1a5b7); font-size: 0.9rem;">Email
                    Address</label>
                <div
                    style="padding: 0.75rem 1rem; background: var(--admin-bg, #151521); border: 1px solid var(--admin-border-color, #2b2b40); border-radius: 0.6rem; color: var(--admin-text-secondary, #7e8299); font-weight: 500;">
                    <?= $this->escapeHtml($user->email()->toString()) ?>
                    <span style="float: right; font-size: 0.8rem; opacity: 0.7;">(Cannot be changed)</span>
                </div>
            </div>

            <mark-input label="New Password">
                <input type="password" id="password" name="password" minlength="6"
                    placeholder="Leave blank to keep current password">
            </mark-input>

            <mark-input label="Role">
                <select id="role" name="role">
                    <option value="ROLE_USER" <?= $user->role()->isUser() ? 'selected' : '' ?>>User (Reader)</option>
                    <option value="ROLE_MARK" <?= $user->role()->isMark() ? 'selected' : '' ?>>Mark (Manager)</option>
                </select>
            </mark-input>

            <div
                style="display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border-color, #2b2b40); justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 1rem;">
                    <mark-button type="submit">Update User</mark-button>
                    <mark-button variant="secondary" href="<?= $this->url('mark.users.index') ?>">Cancel</mark-button>
                </div>

                <mark-button variant="danger"
                    href="<?= $this->url('mark.users.delete', ['id' => $user->id()->toString()]) ?>"
                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    Delete User
                </mark-button>
            </div>
        </form>
    <?php else: ?>
        <div style="text-align: center; padding: 2rem;">
            <p>User not found.</p>
        </div>
    <?php endif; ?>
</mark-card>

<?php $this->stop() ?>