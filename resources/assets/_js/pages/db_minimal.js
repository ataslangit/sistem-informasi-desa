/*
 *  Document   : db_minimal.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Minimal Dashboard Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageDashboardMinimal {
  /*
   * Init Charts
   *
   */
  static initMinimalChartJS() {
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
    let chartMinimalLinesCon = document.getElementById('js-chartjs-minimal-lines');
    let chartMinimalLinesCon2 = document.getElementById('js-chartjs-minimal-lines2');

    // Chart Variables
    let chartMinimalLines, chartMinimalLines2;

    // Lines Charts Data
    let chartMinimalLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(92,85,75,.1)',
          borderColor: 'rgba(92,85,75,.4)',
          pointBackgroundColor: 'rgba(92,85,75,.4)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(92,85,75,.4)',
          data: [39, 15, 25, 32, 38, 10, 45]
        }
      ]
    };

    let chartMinimalLinesOptions = {
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

    let chartMinimalLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(146,170,90,.1)',
          borderColor: 'rgba(146,170,90,.4)',
          pointBackgroundColor: 'rgba(146,170,90,.4)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(146,170,90,.4)',
          data: [345, 190, 220, 290, 380, 230, 455]
        }
      ]
    };

    let chartMinimalLinesOptions2 = {
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
    if (chartMinimalLinesCon !== null) {
      chartMinimalLines = new Chart(chartMinimalLinesCon, {type: 'line', data: chartMinimalLinesData, options: chartMinimalLinesOptions});
    }

    if (chartMinimalLinesCon2 !== null) {
      chartMinimalLines2 = new Chart(chartMinimalLinesCon2, {type: 'line', data: chartMinimalLinesData2, options: chartMinimalLinesOptions2});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initMinimalChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardMinimal.init());
