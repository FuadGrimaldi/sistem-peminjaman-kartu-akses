// Dashboard Chart Initialization
function initDashboardChart(monthlyData) {
    "use strict";

    try {
        if (!monthlyData || !Array.isArray(monthlyData)) {
            console.warn("No monthly data provided for chart");
            return;
        }

        var chartLabels = [];
        var chartData = [];

        monthlyData.forEach(function (item) {
            if (item && typeof item === "object") {
                chartLabels.push(item.month || "");
                chartData.push(parseInt(item.count) || 0);
            }
        });

        var ctx = document.getElementById("monthlyChart");
        if (!ctx) {
            console.warn("Chart canvas element not found");
            return;
        }

        if (typeof Chart === "undefined") {
            console.error("Chart.js library not loaded");
            return;
        }

        var chartContext = ctx.getContext("2d");
        if (!chartContext) {
            console.error("Could not get 2d context from canvas");
            return;
        }

        new Chart(chartContext, {
            type: "line",
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "Jumlah Peminjaman",
                        data: chartData,
                        borderColor: "#4bc0c0",
                        backgroundColor: "rgba(75, 192, 192, 0.1)",
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: "#4bc0c0",
                        pointBorderColor: "#ffffff",
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                        titleColor: "#ffffff",
                        bodyColor: "#ffffff",
                        cornerRadius: 6,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                return Math.floor(value) === value ? value : "";
                            },
                        },
                        grid: {
                            color: "rgba(0, 0, 0, 0.1)",
                        },
                    },
                },
                elements: {
                    point: {
                        hoverBackgroundColor: "#ffffff",
                    },
                },
            },
        });

        console.log("Dashboard chart initialized successfully");
    } catch (error) {
        console.error("Error initializing dashboard chart:", error);
    }
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    console.log("Dashboard JavaScript loaded");
});
