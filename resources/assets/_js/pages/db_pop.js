/*
 *  Document   : db_pop.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Pop Dashboard Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageDashboardPop {
  /*
   * Init Charts
   *
   */
  static initPopChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "rgba(0,0,0,.04)";
    Chart.defaults.scale.grid.zeroLineColor = "rgba(0,0,0,.1)";
    Chart.defaults.scale.display = true;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 6;
    Chart.defaults.elements.point.hoverRadius = 12;
    Chart.defaults.plugins.tooltip.radius = 2;
    Chart.defaults.plugins.legend.display = false;

    // Chart Containers
    let chartPopLinesCon = document.getElementById('js-chartjs-pop-lines');
    let chartPopLinesCon2 = document.getElementById('js-chartjs-pop-lines2');

    // Chart Variables
    let chartPopLines, chartPopLines2;

    // Lines Charts Data
    let chartPopLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(56,56,56,.4)',
          borderColor: 'rgba(56,56,56,.9)',
          pointBackgroundColor: 'rgba(56,56,56,.9)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(56,56,56,.9)',
          data: [75, 88, 34, 49, 52, 89, 96]
        }
      ]
    };

    let chartPopLinesOptions = {
      tension: .4,
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 100
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

    let chartPopLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(230,76,60,.4)',
          borderColor: 'rgba(230,76,60,.9)',
          pointBackgroundColor: 'rgba(230,76,60,.9)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(230,76,60,.9)',
          data: [750, 880, 398, 420, 590, 630, 930]
        }
      ]
    };

    let chartPopLinesOptions2 = {
      tension: .4,
      scales: {
        y: {
          suggestedMin: 0,
          suggestedMax: 1000
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
    if (chartPopLinesCon !== null) {
      chartPopLines = new Chart(chartPopLinesCon, {type: 'line', data: chartPopLinesData, options: chartPopLinesOptions});
    }

    if (chartPopLinesCon2 !== null) {
      chartPopLines2 = new Chart(chartPopLinesCon2, {type: 'line', data: chartPopLinesData2, options: chartPopLinesOptions2});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initPopChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardPop.init());
