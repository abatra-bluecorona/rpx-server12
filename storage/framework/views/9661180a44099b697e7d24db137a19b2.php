<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Products</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Updates Enabled</th>
                <th class="px-6 py-3">Version</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="border px-6 py-3"><?php echo e($product->name); ?></td>
                <td class="border px-6 py-3"><?php echo e($product->slug); ?></td>
                <td class="border px-6 py-3">
                    <form action="<?php echo e(route('products.update', $product->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="checkbox" name="updates_enabled" value="1" 
                            <?php echo e($product->updates_enabled ? 'checked' : ''); ?> 
                            onchange="this.form.submit()">
                    </form>
                </td>
                <td class="border px-6 py-3">
                    <?php if( $product->download_url): ?>
                        <a href="<?php echo e($product->download_url); ?>" 
                           class="text-blue-500 hover:underline" 
                           download>
                            <?php echo e($product->version); ?>

                        </a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td class="border px-6 py-3">
                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Delete</button>
                    </form>
                </td>
                
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\git-projects\wpepreferred\rpx-license-server\resources\views/products/index.blade.php ENDPATH**/ ?>