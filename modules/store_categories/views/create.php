<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="w3-card-4">
    <div class="w3-container primary">
        <h4>Store Category Details</h4>
    </div>
    <form class="w3-container" action="<?= $form_location ?>" method="post">

        <p>
            <label class="w3-text-dark-grey"><b>Category Title</b></label>
            <input type="text" name="category_title" value="<?= $category_title ?>" class="w3-input w3-border w3-sand" placeholder="Enter Category Title">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Parent Category ID</b></label>
            <input type="text" name="parent_category_id" value="<?= $parent_category_id ?>" class="w3-input w3-border w3-sand" placeholder="Enter Parent Category ID">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Priority</b></label>
            <input type="text" name="priority" value="<?= $priority ?>" class="w3-input w3-border w3-sand" placeholder="Enter Priority">
        </p>
        <p> 
            <?php 
            $attributes['class'] = 'w3-button w3-white w3-border';
            echo anchor($cancel_url, 'CANCEL', $attributes);
            ?> 
            <button type="submit" name="submit" value="Submit" class="w3-button w3-medium primary"><?= $btn_text ?></button>
        </p>
    </form>
</div>

<script>
$('.datepicker').datepicker();
$('.datetimepicker').datetimepicker({
    separator: ' at '
});
$('.timepicker').timepicker();
</script>