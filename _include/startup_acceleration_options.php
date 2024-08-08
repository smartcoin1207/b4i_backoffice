<?php 
    $value = $selected_value;
?>

<select name="acceleration_type" class="form-control d-inline" value="<?php echo $value; ?>">
    <option value="">Select Acceleration</option>
    <option <?php if($value=="Acceleration program") echo 'selected'; ?>>Acceleration</option>
    <option <?php if($value=="Pre-acceleration program") echo 'selected'; ?>>Pre-acceleration</option>
</select>