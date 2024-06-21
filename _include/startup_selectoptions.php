<?php
$startups = DB::query("SELECT * FROM startups");
?>

<select name="startup_id" class="form-control d-inline">
    <option value="">Select a startup</option>
    <?php foreach ($startups as $startup): ?>
        <option value="<?php echo $startup['id']; ?>" data-batch="<?php echo $startup['call_name']; ?>"><?php echo $startup['startup_name']; ?></option>
    <?php endforeach; ?>
</select>