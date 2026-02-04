<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Events - Punk Football</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <?php echo $__env->make('user.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">My Events</h1>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="btn-secondary">Back to Dashboard</a>
            </div>

            <!-- Browse Available Events -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Available Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                        $availableEvents = \App\Models\Event::active()
                            ->whereDoesntHave('participants', function($q) {
                                $q->where('user_id', auth()->id());
                            })
                            ->take(6)
                            ->get();
                    ?>
                    <?php $__currentLoopData = $availableEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card football-element">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($event->name); ?></h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo e(\Carbon\Carbon::parse($event->event_date)->format('F d, Y')); ?>

                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <?php echo e($event->location); ?>

                            </div>
                        </div>
                        <form method="POST" action="<?php echo e(route('user.events.join', $event)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-primary w-full">Join Event</button>
                        </form>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- My Registered Events -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">My Registered Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card football-element">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-semibold text-gray-900"><?php echo e($event['name']); ?></h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            <?php echo e($event['status'] === 'registered' ? 'bg-green-100 text-green-800' :
                               ($event['status'] === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')); ?>">
                            <?php echo e(ucfirst($event['status'])); ?>

                        </span>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo e(\Carbon\Carbon::parse($event['date'])->format('F d, Y')); ?>

                        </div>
                    </div>

                    <div class="mt-4 flex space-x-2">
                        <?php if($event['status'] === 'registered'): ?>
                        <a href="#" class="btn-secondary text-xs py-1 px-2">View Details</a>
                        <form method="POST" action="<?php echo e(route('user.events.leave', $event['id'])); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-primary text-xs py-1 px-2 bg-red-600 hover:bg-red-700" onclick="return confirm('Are you sure you want to leave this event?')">Leave Event</button>
                        </form>
                        <?php elseif($event['status'] === 'confirmed'): ?>
                        <a href="#" class="btn-secondary text-xs py-1 px-2">View Details</a>
                        <span class="text-green-600 text-xs">Confirmed</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <?php if(count($events) === 0): ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No events yet</h3>
                <p class="text-gray-600 mb-4">You haven't registered for any events yet.</p>
                <a href="/" class="btn-primary">Browse Events</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\PunkFootball\resources\views/user/events.blade.php ENDPATH**/ ?>