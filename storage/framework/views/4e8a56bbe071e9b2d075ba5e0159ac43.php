

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>
    <div class="grid grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-gray-500">Total User</div>
            <div class="text-3xl font-bold"><?php echo e($stats['total_users']); ?></div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-gray-500">Total Tiket</div>
            <div class="text-3xl font-bold"><?php echo e($stats['total_tickets']); ?></div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-gray-500">Total Produk</div>
            <div class="text-3xl font-bold"><?php echo e($stats['total_products']); ?></div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-gray-500">Total Event</div>
            <div class="text-3xl font-bold"><?php echo e($stats['total_events']); ?></div>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mt-8">
        <h2 class="text-lg font-bold mb-4">Grafik Statistik</h2>
        <canvas id="dashboardChart" height="120"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['User', 'Tiket', 'Produk', 'Event'],
                datasets: [{
                    label: 'Total Data',
                    data: [<?php echo e($stats['total_users']); ?>, <?php echo e($stats['total_tickets']); ?>, <?php echo e($stats['total_products']); ?>, <?php echo e($stats['total_events']); ?>],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(234, 179, 8, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\PunkFootball\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>