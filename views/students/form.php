<?php
use App\Core\View;
use App\Core\Session;

/** Render one text input with its validation error. */
function field(array $errors, string $name, string $label, string $value, string $type = 'text'): void
{
    $bad = isset($errors[$name]);
    echo '<div class="field"><label for="' . $name . '">' . $label . '</label>';
    echo '<input id="' . $name . '" name="' . $name . '" type="' . $type . '" value="' . View::e($value) . '"'
        . ($bad ? ' class="invalid"' : '') . '>';
    if ($bad) {
        echo '<small class="error">' . View::e($errors[$name]) . '</small>';
    }
    echo '</div>';
}
?>
<div class="card narrow">
    <h2><?= View::e($title) ?></h2>
    <form method="post" action="index.php?action=<?= View::e($action) ?>" novalidate>
        <input type="hidden" name="_token" value="<?= Session::csrfToken() ?>">
        <?php if ($student->id): ?><input type="hidden" name="id" value="<?= $student->id ?>"><?php endif; ?>

        <?php field($errors, 'student_no', 'Student Number', $student->studentNo); ?>
        <div class="grid2">
            <?php field($errors, 'first_name', 'First Name', $student->firstName); ?>
            <?php field($errors, 'last_name', 'Last Name', $student->lastName); ?>
        </div>
        <?php field($errors, 'email', 'Email', $student->email, 'email'); ?>
        <div class="grid2">
            <?php field($errors, 'course', 'Course', $student->course); ?>
            <div class="field">
                <label for="year_level">Year Level</label>
                <select id="year_level" name="year_level"<?= isset($errors['year_level']) ? ' class="invalid"' : '' ?>>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <option value="<?= $i ?>"<?= $student->yearLevel === $i ? ' selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <?php if (isset($errors['year_level'])): ?><small class="error"><?= View::e($errors['year_level']) ?></small><?php endif; ?>
            </div>
        </div>

        <div class="row">
            <a class="btn" href="index.php">Cancel</a>
            <button class="btn primary" type="submit">Save</button>
        </div>
    </form>
</div>
