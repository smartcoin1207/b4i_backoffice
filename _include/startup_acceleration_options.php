<?php 
    $value = $selected_value;
?>

<select name="acceleration_type" class="form-control d-inline" value="<?php echo $value; ?>">
    <option value=""><?php echo $all_acceleration_string ?? ''; ?></option>
    <option <?php if($value=="Acceleration") echo 'selected'; ?>>Acceleration</option>
    <option <?php if($value=="Pre-acceleration") echo 'selected'; ?>>Pre-acceleration</option>
</select>