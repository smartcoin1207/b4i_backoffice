<?php 
    $value = $selected_value;
?>

<select name="staged" class="form-control d-inline" value="<?php echo $value; ?>">
    <option value="">Select Stage</option>
    <option <?php if($value=="Seed") echo 'selected'; ?>>Seed</option>
    <option <?php if($value=="SeriesA") echo 'selected'; ?>>SeriesA</option>
    <option <?php if($value=="SeriesB") echo 'selected'; ?>>SeriesB</option>
    <option <?php if($value=="SeriesC") echo 'selected'; ?>>SeriesC</option>
    <option <?php if($value=="Late stage") echo 'selected'; ?>>Late stage</option>
    <option <?php if($value=="Grant") echo 'selected'; ?>>Grant</option>
</select>