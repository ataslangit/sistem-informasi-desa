/*
 *  Document   : db_classic.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Classic Dashboard Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageDashboardClassic {
  /*
   * Init Charts
   *
   */
  static initClassicChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "rgba(0,0,0,.04)";
    Chart.defaults.scale.grid.zeroLineColor = "rgba(0,0,0,.1)";
    Chart.defaults.scale.display = true;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 5;
    Chart.defaults.elements.point.hoverRadius = 7;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.display = false;

    // Chart Containers
    let chartClassicLinesCon = document.getElementById('js-chartjs-classic-lines');
    let chartClassicLinesCon2 = document.getElementById('js-chartjs-classic-lines2');

    // Chart Variables
    let chartClassicLines, chartClassicLines2;

    // Lines Charts Data
    let chartClassicLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(114,102,186,.15)',
          borderColor: 'rgba(114,102,186,.5)',
          pointBackgroundColor: 'rgba(114,102,186,.5)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(114,102,186,.5)',
          data: [39, 27, 23, 34, 42, 46, 31]
        }
      ]
    };

    let chartClassicLinesOptions = {
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

    let chartClassicLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(247,93,129,.15)',
          borderColor: 'rgba(247,93,129,.5)',
          pointBackgroundColor: 'rgba(247,93,129,.5)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(247,93,129,.5)',
          data: [325, 290, 209, 290, 410, 384, 425]
        }
      ]
    };

    let chartClassicLinesOptions2 = {
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
    if (chartClassicLinesCon !== null) {
      chartClassicLines = new Chart(chartClassicLinesCon, {type: 'line', data: chartClassicLinesData, options: chartClassicLinesOptions});
    }

    if (chartClassicLinesCon2 !== null) {
      chartClassicLines2 = new Chart(chartClassicLinesCon2, {type: 'line', data: chartClassicLinesData2, options: chartClassicLinesOptions2});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initClassicChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardClassic.init());
