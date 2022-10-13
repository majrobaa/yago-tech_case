<?php
$this->loadApiResult()->getRetdata('csv');

?>
<br><br><br>
<form method="post">
    <label for="salary">Annual Revenue</label>
    <input type="number" name="salary" id="salary" value="<?= $this->utils->ga($_POST, 'salary') ?>">

    <label for="enumber">Enterprise Number</label>
    <input type="text" name="enumber" id="enumber" value="<?= $this->utils->ga($_POST, 'enumber') ?>">

    <label for="lname">Legal Name</label>
    <input type="text" name="lname" id="lname" value="<?= $this->utils->ga($_POST, 'lname') ?>">

    <label for="nperson">Natural Person</label>
    <input type="checkbox" name="nperson"
           id="nperson" <?= $this->utils->ga($_POST, 'nperson') === 'on' ? 'checked' : '' ?>>

    <label for="dformula">Deductible Formula</label>
    <select name="dformula" id="dformula">
        <option value="small" <?= $this->utils->ga($_POST, 'dformula') === 'small' ? 'selected' : '' ?>>Small</option>
        <option value="medium" <?= $this->utils->ga($_POST, 'dformula') === 'medium' || $this->utils->ga($_POST, 'dformula') === '' ? 'selected' : '' ?>>
            Medium
        </option>
        <option value="large" <?= $this->utils->ga($_POST, 'dformula') === 'large' ? 'selected' : '' ?>>Large</option>
    </select>
    <label for="cformula">Coverage Ceiling Formula</label>
    <select name="cformula" id="cformula">
        <option value="small" <?= $this->utils->ga($_POST, 'cformula') === 'small' ? 'selected' : '' ?>>Small</option>
        <option value="large" <?= $this->utils->ga($_POST, 'cformula') === 'large' ? 'selected' : '' ?>>Large</option>
    </select>
    <br>
    <label for="code">Nacabel Codes</label>
    <br>
    <?php foreach ($this->getRetData('csv') as $row) {
        if ($this->utils->ga($row, 'Code') !== '') { ?>
            <div style="display: inline-block">
                <input type="checkbox"
                       name="codes[]"
                       value="<?= $this->utils->ga($row, 'Code') ?>"
                       id="<?= $this->utils->ga($row, 'Code') ?>"
                    <?= in_array($this->utils->ga($row, 'Code'), $this->utils->ga($_POST, 'codes')) ? 'checked' : '' ?>
                >
                <label style="padding-right: 30px;"
                       for="<?= $this->utils->ga($row, 'Code') ?>"><?= $this->utils->ga($row, 'Code') ?></label>
            </div>
        <?php }
    } ?>
    <br>
    <br>
    <input type="submit" value="Show result">
</form>