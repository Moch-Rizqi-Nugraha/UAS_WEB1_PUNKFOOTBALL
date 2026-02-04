

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-12 px-4">
    <h2 class="text-4xl font-bold text-center mb-4">Event Sepak Bola Terdekat</h2>
    <p class="text-center text-gray-500 mb-12">Jangan lewatkan kesempatan untuk bergabung dalam event seru ini</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow overflow-hidden h-full flex flex-col">
                <!-- Event Image -->
                <?php if($event->poster): ?>
                    <div class="h-48 w-full overflow-hidden bg-gray-200">
                        <img src="<?php echo e($event->getPosterUrl()); ?>" alt="<?php echo e($event->name); ?>" class="w-full h-full object-cover">
                    </div>
                <?php else: ?>
                    <div class="h-48 w-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                <?php endif; ?>
                
                <div class="p-6 flex flex-col flex-grow">
                    <!-- Category Badge -->
                    <div class="mb-3">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white
                            <?php if($event->category === 'turnamen'): ?> bg-blue-500
                            <?php elseif($event->category === 'pelatihan'): ?> bg-green-500
                            <?php elseif($event->category === 'coaching'): ?> bg-purple-500
                            <?php else: ?> bg-gray-500 <?php endif; ?>">
                            <?php echo e($event->getCategoryLabel() ?? ucfirst($event->category)); ?>

                        </span>
                    </div>
                    
                    <!-- Event Title -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2"><?php echo e($event->name); ?></h3>
                    
                    <!-- Event Description -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($event->description ?? 'Event sepak bola'); ?></p>
                    
                    <!-- Event Details -->
                    <div class="space-y-2 mb-4 text-sm text-gray-500 flex-grow">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2a1 1 0 001 1h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 15.27 4.632 17 6.414 17H15a1 1 0 000-2H6.414l1-1H14a2 2 0 001.894-1.263l2.902-5.27a1 1 0 00.102-.422V5a2 2 0 00-2-2h-2.992A1 1 0 009 2H6zm6 16a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="truncate"><?php echo e($event->event_date->format('d M Y')); ?></span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="truncate"><?php echo e(Str::limit($event->location, 25)); ?></span>
                        </div>
                    </div>
                    
                    <!-- Participants -->
                    <div class="mb-4 text-sm">
                        <div class="flex justify-between text-gray-600 mb-1">
                            <span>Peserta</span>
                            <span class="font-semibold"><?php echo e($event->current_participants ?? 0); ?>/<?php echo e($event->max_participants ?? '-'); ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($event->max_participants ? (($event->current_participants ?? 0) / $event->max_participants * 100) : 0); ?>%"></div>
                        </div>
                    </div>
                    
                    <!-- Register Button -->
                    <a href="<?php echo e(route('events.register', $event->id)); ?>" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg text-center font-bold hover:from-blue-700 hover:to-blue-800 transition mt-auto">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Tidak ada event</h3>
                <p class="text-gray-500 mt-2">Event akan ditampilkan di sini ketika tersedia</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\PunkFootball\resources\views/events/index.blade.php ENDPATH**/ ?>