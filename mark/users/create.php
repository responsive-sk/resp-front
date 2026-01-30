<?php $this->layout('resp-front::mark/layout', [
    'title' => 'Create New User',
    'currentRoute' => 'mark.users.create',
]) ?>

<?php $this->start('mark-content') ?>

<div class="section-headers"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #181c32;">New User</h1>
        <p style="margin: 0.5rem 0 0; color: #a1a5b7; font-size: 0.9rem;">Add a new user to the system</p>
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

    <form method="post" action="<?= $this->url('mark.users.store') ?>">
        <mark-input label="Email Address" required>
            <input type="email" id="email" name="email" value="<?= $this->escapeHtml($email ?? '') ?>" required
                placeholder="e.g. mark@example.com">
        </mark-input>

        <mark-input label="Password" required>
            <input type="password" id="password" name="password" required minlength="6">
            <p style="margin: 0.35rem 0 0; color: var(--admin-text-secondary, #a1a5b7); font-size: 0.8rem;">Must be at
                least 6 characters long.</p>
        </mark-input>

        <mark-input label="Role" required>
            <select id="role" name="role">
                <option value="ROLE_USER" <?= (isset($role) && $role === 'ROLE_USER') ? 'selected' : '' ?>>User (Reader)
                </option>
                <option value="ROLE_MARK" <?= (isset($role) && $role === 'ROLE_MARK') ? 'selected' : '' ?>>Mark (Manager)
                </option>
            </select>
        </mark-input>

        <div
            style="display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border-color, #2b2b40);">
            <mark-button type="submit">Create User</mark-button>
            <mark-button variant="secondary" href="<?= $this->url('mark.users.index') ?>">Cancel</mark-button>
        </div>
    </form>
</mark-card>

<?php $this->stop() ?>