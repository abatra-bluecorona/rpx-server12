<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Clients</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Website URL</th>
                <th class="px-6 py-3">Token</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Active/Inactive</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="border px-6 py-3"><?php echo e($client->name); ?></td>
                <td class="border px-6 py-3">
                    <a href="<?php echo e($client->website_url); ?>" target="_blank" class="text-blue-500"><?php echo e($client->website_url); ?></a>
                </td>
                <td class="border px-6 py-3"><?php echo e($client->rpx_token); ?></td>
                <td class="border px-6 py-3"><?php echo e($client->status); ?></td>
                <td class="border px-6 py-3">
                    <form action="<?php echo e(route('clients.update', $client->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="checkbox" name="status" value="active" 
                            <?php echo e($client->status === 'active' ? 'checked' : ''); ?> 
                            onchange="this.form.submit()">
                    </form>
                </td>
                <td class="border px-6 py-3">
                    <form action="<?php echo e(route('clients.destroy', $client->id)); ?>" method="POST" class="inline">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\git-projects\wpepreferred\rpx-license-server\resources\views/clients/index.blade.php ENDPATH**/ ?>