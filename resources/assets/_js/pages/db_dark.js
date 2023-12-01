/*
 *  Document   : db_dark.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Dark Dashboard Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageDashboardDark {
  /*
   * Init Charts
   *
   */
  static initDarkChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "transparent";
    Chart.defaults.scale.grid.zeroLineColor = "transparent";
    Chart.defaults.scale.display = false;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 3;
    Chart.defaults.elements.point.hoverRadius = 5;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.display = false;

    // Chart Containers
    let chartDarkLinesCon = document.getElementById('js-chartjs-dark-lines');
    let chartDarkLinesCon2 = document.getElementById('js-chartjs-dark-lines2');

    // Chart Variables
    let chartDarkLines, chartDarkLines2;

    // Lines Charts Data
    let chartDarkLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(255,255,255,.1)',
          borderColor: 'rgba(255,255,255,.4)',
          pointBackgroundColor: 'rgba(255,255,255,.4)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(255,255,255,.4)',
          data: [39, 15, 25, 32, 38, 10, 45]
        }
      ]
    };

    let chartDarkLinesOptions = {
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
              return context.parsed.y + ' Sales';
            }
          }
        }
      }
    };

    let chartDarkLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(255,255,255,.1)',
          borderColor: 'rgba(255,255,255,.4)',
          pointBackgroundColor: 'rgba(255,255,255,.4)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(255,255,255,.4)',
          data: [345, 190, 220, 290, 380, 230, 455]
        }
      ]
    };

    let chartDarkLinesOptions2 = {
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
    if (chartDarkLinesCon !== null) {
      chartDarkLines = new Chart(chartDarkLinesCon, {type: 'line', data: chartDarkLinesData, options: chartDarkLinesOptions});
    }

    if (chartDarkLinesCon2 !== null) {
      chartDarkLines2 = new Chart(chartDarkLinesCon2, {type: 'line', data: chartDarkLinesData2, options: chartDarkLinesOptions2});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initDarkChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardDark.init());
