Set profile
<form method="post">
    <label for="firstname">First name</label>
    <input type="text" name="firstname" id="firstname"
           value="<?= $this->utils->ga($this->getUserData('post'), 'firstname') ?>">

    <label for="lastname">Last name</label>
    <input type="text" name="lastname" id="lastname"
           value="<?= $this->utils->ga($this->getUserData('post'), 'lastname') ?>">

    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?= $this->utils->ga($this->getUserData('post'), 'email') ?>">

    <label for="phone">Phone</label>
    <input type="text" name="phone" id="phone" value="<?= $this->utils->ga($this->getUserData('post'), 'phone') ?>">

    <label for="address">Address</label>
    <input type="text" name="address" id="address"
           value="<?= $this->utils->ga($this->getUserData('post'), 'address') ?>">
    <br>
    <label for="revenue">Annual Revenue</label>
    <input type="number" name="revenue" id="revenue"
           value="<?= $this->utils->ga($this->getUserData('post'), 'revenue') ?>">

    <label for="enumber">Enterprise Number</label>
    <input type="text" name="enumber" id="enumber"
           value="<?= $this->utils->ga($this->getUserData('post'), 'enumber') ?>">

    <label for="lname">Legal Name</label>
    <input type="text" name="lname" id="lname" value="<?= $this->utils->ga($this->getUserData('post'), 'lname') ?>">

    <label for="nperson">Natural Person</label>
    <input type="checkbox" name="nperson"
           id="nperson" <?= $this->utils->ga($this->getUserData('post'), 'nperson') === 'on' ? 'checked' : '' ?>>

    <label for="dformula">Deductible Formula</label>
    <select name="dformula" id="dformula">
        <option value="small" <?= $this->utils->ga($this->getUserData('post'), 'dformula') === 'small' ? 'selected' : '' ?>>
            Small
        </option>
        <option value="medium" <?= $this->utils->ga($this->getUserData('post'), 'dformula') === 'medium' || $this->utils->ga($this->getUserData('post'), 'dformula') === '' ? 'selected' : '' ?>>
            Medium
        </option>
        <option value="large" <?= $this->utils->ga($this->getUserData('post'), 'dformula') === 'large' ? 'selected' : '' ?>>
            Large
        </option>
    </select>
    <label for="cformula">Coverage Ceiling Formula</label>
    <select name="cformula" id="cformula">
        <option value="small" <?= $this->utils->ga($this->getUserData('post'), 'cformula') === 'small' ? 'selected' : '' ?>>
            Small
        </option>
        <option value="large" <?= $this->utils->ga($this->getUserData('post'), 'cformula') === 'large' ? 'selected' : '' ?>>
            Large
        </option>
    </select>
    <br>
    <label for="code">Nacabel Codes (medical related)</label>
    <br>
    <?php foreach ($this->getRetData('csv') as $row) {
        if ($this->utils->ga($row, 'Code') !== '') { ?>
            <input type="checkbox"
                   name="codes[]"
                   value="<?= $this->utils->ga($row, 'Code') ?>"
                   id="<?= $this->utils->ga($row, 'Code') ?>"
                <?= in_array($this->utils->ga($row, 'Code'), $this->utils->ga($this->getUserData('post'), 'codes', [], true)) ? 'checked' : '' ?>
            >
            <label style="padding-right: 30px;"
                   for="<?= $this->utils->ga($row, 'Code') ?>"><?= $this->utils->ga($row, 'Label EN') ?></label><br>

        <?php }
    } ?>
    <br>
    <br>
    <input type="hidden" name="uid" value="<?= $this->utils->s('uid') ?>">
    <input type="submit" value="Save settings">
</form>

<?php

if (count($this->getRetData('error')) > 0) {
    foreach ($this->utils->ga($this->getRetData(), 'error') as $error) {
        echo $error . '<br>';
    }
}

?>
<form method="get">
    <?php
    foreach ($this->utils->ga($this->getUserData(), 'covers', [], true) as $cover) {
        ?>
        <label for="<?= $this->utils->ga($cover, 'key') ?>"><?= $this->utils->ga($cover, 'name') . ' - ' . $this->utils->ga($cover, 'price') . ' € ' ?></label>
        <br>
    <?php } ?>
    <br>
    <input type="hidden" name="send" value="1">
    <input type="hidden" name="a" value="1">
    <input type="submit" value="Send calculation to User">
</form>

<a href="?u=1">Go to User panel</a>
