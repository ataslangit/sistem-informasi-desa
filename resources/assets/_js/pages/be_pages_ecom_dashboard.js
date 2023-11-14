/*
 *  Document   : be_pages_ecom_dashboard.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in e-Commerce Dashboard Page
 */

class pageDashboardEcom {
  /*
   * Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
   *
   */
  static initEcomChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "transparent";
    Chart.defaults.scale.grid.zeroLineColor = "transparent";
    Chart.defaults.scale.display = false;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 5;
    Chart.defaults.elements.point.hoverRadius = 7;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.display = false;

    // Chart Containers
    let chartEcomEarningsCon = document.getElementById('js-chartjs-ecom-dashboard-earnings');
    let chartEcomOrdersCon = document.getElementById('js-chartjs-ecom-dashboard-orders');

    // Charts Variables
    let chartEcomOrders, chartEcomEarnings;

    // Charts Data
    let chartEcomEarningsData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'Earnings',
          fill: true,
          backgroundColor: 'rgba(188,38,211,.25)',
          borderColor: 'rgba(188,38,211,1)',
          pointBackgroundColor: 'rgba(188,38,211,1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(188,38,211,1)',
          data: [1780, 2440, 3252, 2109, 1892, 3890, 1820]
        }
      ]
    };

    let chartEcomOrdersData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'Orders',
          fill: true,
          backgroundColor: 'rgba(112,178,156,.25)',
          borderColor: 'rgba(112,178,156,1)',
          pointBackgroundColor: 'rgba(112,178,156,1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(112,178,156,1)',
          data: [20, 27, 40, 19, 23, 38, 16]
        }
      ]
    };

    // Init Charts
    if (chartEcomEarningsCon !== null) {
      chartEcomEarnings = new Chart(chartEcomEarningsCon, {type: 'line', data: chartEcomEarningsData, options: {
          tension: .4,
          scales: {
            y: {
              suggestedMin: 0,
              suggestedMax: 4300
            }
          },
          interaction: {
            intersect: false,
          },
          plugins: {
            tooltip: {
              callbacks: {
                label: function (context) {
                  return context.dataset.label + ': $' + context.parsed.y;
                }
              }
            }
          }
        }});
    }

    if (chartEcomOrdersCon !== null) {
      chartEcomOrders = new Chart(chartEcomOrdersCon, {type: 'line', data: chartEcomOrdersData, options: {
          tension: .4,
          scales: {
            y: {
              suggestedMin: 0,
              suggestedMax: 60
            }
          },
          interaction: {
            intersect: false,
          },
        }});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initEcomChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardEcom.init());
