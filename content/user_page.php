Our settings for you:<br>
<?php //var_dump($this->getUserData('post')); ?>
Annual Revenue: <?= $this->utils->ga($this->getUserData('post'), 'revenue') ?><br>
Enterprise Number: <?= $this->utils->ga($this->getUserData('post'), 'enumber') ?><br>
Legal Name: <?= $this->utils->ga($this->getUserData('post'), 'lname') ?><br>
Natural Person: <?= $this->utils->ga($this->getUserData('post'), 'nperson') === 'on' ? 'Yes' : 'No' ?><br>
Deductible Formula (small recommended): <?= $this->utils->ga($this->getUserData('post'), 'dformula') ?><br>
Coverage Ceiling Formula (large recommended): <?= $this->utils->ga($this->getUserData('post'), 'cformula') ?>
<br>
<br>
*Deducitible Formila is not that important for medical activites (because probability is limited) and the smaller choice reduce the price
<br>
*Coverage Ceiling Formula will protect you for much higher amounts that the default one in case of dangerous consequences of your action (wrong medicine that kills the patient for ex).
<br><br>

<form>
    <?php foreach ($this->utils->ga($this->getRetData(), 'covers', [], true) as $cover) { ?>
        <label for="<?= $this->utils->ga($cover, 'key') ?>"><?= $this->utils->ga($cover, 'name') . ' - ' . $this->utils->ga($cover, 'price') . '€ ' ?></label>
        <?php if ($this->utils->ga($cover, 'key') === 'legalExpenses') { ?>

            <input type="checkbox" name="<?= $this->utils->ga($cover, 'key') ?>"
                   value="<?= $this->utils->ga($cover, 'price') ?>"
                   id="<?= $this->utils->ga($cover, 'key') ?>">
        <?php } ?>
        <br>
        <label for="<?= $this->utils->ga($cover, 'key') ?>">(<?= $this->utils->ga($cover, 'description') ?>)</label><br>
        <br>
    <?php } ?>
</form>
<br><br>
<a href="?a=1&u=1">Go to admin panel</a>