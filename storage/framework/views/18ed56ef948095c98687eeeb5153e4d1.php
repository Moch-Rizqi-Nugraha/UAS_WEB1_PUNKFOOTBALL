

<?php $__env->startSection('title', 'Event Management - Punk Football'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Event Management</h1>
    <a href="<?php echo e(route('admin.events.create')); ?>" class="btn-primary">
        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Create New Event
    </a>
</div>

<!-- Events Table -->
<div class="card">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img class="h-12 w-12 rounded-lg object-cover" src="<?php echo e($event->getPosterUrl()); ?>" alt="<?php echo e($event->name); ?>">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($event->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e(Str::limit($event->location, 30)); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            <?php if($event->category === 'turnamen'): ?> bg-blue-100 text-blue-800
                            <?php elseif($event->category === 'pelatihan'): ?> bg-green-100 text-green-800
                            <?php else: ?> bg-purple-100 text-purple-800 <?php endif; ?>">
                            <?php echo e($event->getCategoryLabel()); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($event->event_date->format('d M Y')); ?><br>
                        <span class="text-gray-500"><?php echo e($event->event_date->format('H:i')); ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($event->current_participants); ?> / <?php echo e($event->max_participants); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST" action="<?php echo e(route('admin.events.toggle-status', $event)); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($event->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e(ucfirst($event->status)); ?>

                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="text-blue-600 hover:text-blue-900">View</a>
                            <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.events.destroy', $event)); ?>" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this event?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No events found. <a href="<?php echo e(route('admin.events.create')); ?>" class="text-blue-600 hover:text-blue-900">Create one now</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($events->hasPages()): ?>
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <?php echo e($events->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.app-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\PunkFootball\resources\views/admin/events/index.blade.php ENDPATH**/ ?>