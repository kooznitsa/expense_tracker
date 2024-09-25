<?php if (array_key_exists($key, $errors)) : ?>
    <div class="bg-gray-100 mt-2 p-2 text-red-500">
        <?php echo e($errors[$key][0]); ?>
    </div>
<?php endif; ?>
