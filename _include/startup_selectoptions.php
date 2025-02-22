<?php
    $startups = DB::query("
    SELECT * 
    FROM startups s
    WHERE s.grant_application != '' AND s.`status` = 1
    AND (
        s.startup_name IN (
            SELECT startup_name
            FROM startups WHERE s.grant_application = 'Acceleration program' AND grant_application != '' AND s.`status` = 1
            GROUP BY startup_name
            HAVING COUNT(*) > 1
        )
                    OR
        s.startup_name IN (
            SELECT startup_name
            FROM startups WHERE grant_application != '' AND s.`status` = 1 
            GROUP BY startup_name
            HAVING COUNT(*) = 1
        )
    )
    ORDER BY s.startup_name ASC
    ");
?>

<select name="startup_id" class="startup_select form-control d-inline" style="width: calc(100% - 110px) !important;">
    <option value="">Select a startup</option>
    <?php foreach ($startups as $startup): ?>
        <option value="<?php echo $startup['id']; ?>" data-batch="<?php echo $startup['call_name']; ?>"><?php echo $startup['startup_name']; ?></option>
    <?php endforeach; ?>
</select>