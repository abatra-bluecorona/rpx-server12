<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Add New Product</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Check if there are any validation errors -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>


    <form action="<?php echo e(route('products.store')); ?>" method="POST" class="bg-white p-6 rounded shadow-md">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700">Product Slug</label>
            <input type="text" id="slug" name="slug" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <div class="mb-4">
            <input type="checkbox" id="updates_enabled" name="updates_enabled" value="1">
            <label for="updates_enabled" class="ml-2 text-sm text-gray-700">Enable Updates</label>
        </div>

        <button type="submit" class="bg-sky-500 hover:bg-sky-700 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">Add Product</button>
    </form>

    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\git-projects\wpepreferred\rpx-license-server\resources\views/products/create.blade.php ENDPATH**/ ?>