/*
 *  Document   : be_pages_dashboard.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Dashboard Page
 */

class pageDashboard {
  /*
   * Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
   *
   */
  static initDashboardChartJS() {
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
    let chartDashboardLinesCon = document.getElementById('js-chartjs-dashboard-lines');
    let chartDashboardLinesCon2 = document.getElementById('js-chartjs-dashboard-lines2');

    // Chart Variables
    let chartDashboardLines, chartDashboardLines2;

    // Lines Charts Data
    let chartDashboardLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(2, 132, 199, .45)',
          borderColor: 'rgba(2, 132, 199, 1)',
          pointBackgroundColor: 'rgba(2, 132, 199, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(2, 132, 199, 1)',
          data: [25, 21, 23, 38, 36, 35, 39]
        }
      ]
    };

    let chartDashboardLinesOptions = {
      tension: .4,
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 50
        }
      },
      interaction: {
        intersect: false,
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              return ' ' + context.parsed.y + ' Sales';
            }
          }
        }
      }
    };

    let chartDashboardLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(101, 163, 13, .45)',
          borderColor: 'rgba(101, 163, 13, 1)',
          pointBackgroundColor: 'rgba(101, 163, 13, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(101, 163, 13, 1)',
          data: [190, 219, 235, 320, 360, 354, 390]
        }
      ]
    };

    let chartDashboardLinesOptions2 = {
      tension: .4,
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 480
        }
      },
      interaction: {
        intersect: false,
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              return ' $' + context.parsed.y;
            }
          }
        }
      }
    };

    // Init Charts
    if (chartDashboardLinesCon !== null) {
      chartDashboardLines = new Chart(chartDashboardLinesCon, {type: 'line', data: chartDashboardLinesData, options: chartDashboardLinesOptions});
    }

    if (chartDashboardLinesCon2 !== null) {
      chartDashboardLines2 = new Chart(chartDashboardLinesCon2, {type: 'line', data: chartDashboardLinesData2, options: chartDashboardLinesOptions2});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initDashboardChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboard.init());
