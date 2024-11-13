<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white  shadow-md rounded-xl">
    <div class="px-5 pt-5">
        <header class="flex justify-between items-start mb-2">
            <h2 class="text-lg font-semibold text-gray-800 ">Acme Advanced</h2>
        </header>
        <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Sales</div>
        <div class="flex items-start">
            <div class="text-3xl font-bold text-gray-800 mr-2">${{ number_format($dataFeed->sumDataSet(2, 1), 0) }}</div>
            <div class="text-sm font-medium text-red-700 px-1.5 bg-red-500/20 rounded-full">-14%</div>
        </div>
    </div>
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/dashboard-card-02.js for config -->
    <div class="chart-container">
        <canvas id="dashboard-card-01" width="400" height="200"></canvas>
    </div>

</div>
