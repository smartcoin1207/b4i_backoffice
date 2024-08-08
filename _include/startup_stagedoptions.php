<?php 
    $value = $selected_value;
?>

<select name="staged" class="form-control d-inline" value="<?php echo $value; ?>">
    <option value="">Select Stage</option>
    <option <?php if($value=="Pre-seed") echo 'selected'; ?>>Pre-seed</option>
    <option <?php if($value=="Seed") echo 'selected'; ?>>Seed</option>
    <option <?php if($value=="Equity") echo 'selected'; ?>>Equity</option>
    <option <?php if($value=="SeriesA") echo 'selected'; ?> value="SeriesA">Series A</option>
    <option <?php if($value=="SeriesB") echo 'selected'; ?> value="SeriesB">Series B</option>
    <option <?php if($value=="SeriesC") echo 'selected'; ?> value="SeriesC">Series C</option>
    <option <?php if($value=="Late stage") echo 'selected'; ?>>Late stage</option>
    <option <?php if($value=="Grant") echo 'selected'; ?>>Grant</option>
</select>