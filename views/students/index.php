<?php use App\Core\View; use App\Core\Session; ?>
<div class="card">
    <div class="row">
        <h2>Students</h2>
        <a class="btn primary" href="index.php?action=create">+ Add Student</a>
    </div>

    <form method="get" class="search">
        <input type="text" name="q" value="<?= View::e($search) ?>" placeholder="Search name, student no., or email">
        <button class="btn" type="submit">Search</button>
        <?php if ($search !== ''): ?><a class="btn" href="index.php">Clear</a><?php endif; ?>
    </form>

    <div class="table-wrap">
    <table>
        <thead>
            <tr><th>Student No.</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php if (!$students): ?>
            <tr><td colspan="6" class="empty">No students found.</td></tr>
        <?php endif; ?>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= View::e($s->studentNo) ?></td>
                <td><?= View::e($s->fullName()) ?></td>
                <td><?= View::e($s->email) ?></td>
                <td><?= View::e($s->course) ?></td>
                <td><?= View::e($s->yearLevel) ?></td>
                <td class="actions">
                    <a class="btn small" href="index.php?action=edit&amp;id=<?= $s->id ?>">Edit</a>
                    <form method="post" action="index.php?action=destroy"
                          onsubmit="return confirm('Delete this student?');">
                        <input type="hidden" name="_token" value="<?= Session::csrfToken() ?>">
                        <input type="hidden" name="id" value="<?= $s->id ?>">
                        <button class="btn small danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
