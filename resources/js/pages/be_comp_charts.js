/*
 *  Document   : be_comp_charts.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Charts Page
 */

class pageCompCharts {
  /*
   * Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
   *
   */
  static initChartsChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "rgba(0,0,0,.04)";
    Chart.defaults.scale.grid.zeroLineColor = "rgba(0,0,0,.1)";
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 5;
    Chart.defaults.elements.point.hoverRadius = 7;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.labels.boxWidth = 12;

    // Get Chart Containers
    let chartLinesCon = document.getElementById('js-chartjs-lines');
    let chartBarsCon = document.getElementById('js-chartjs-bars');
    let chartRadarCon = document.getElementById('js-chartjs-radar');
    let chartPolarCon = document.getElementById('js-chartjs-polar');
    let chartPieCon = document.getElementById('js-chartjs-pie');
    let chartDonutCon = document.getElementById('js-chartjs-donut');

    // Lines/Bar/Radar Chart Data
    let chartLinesBarsRadarData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(2, 132, 199, .75)',
          borderColor: 'rgba(2, 132, 199, 1)',
          pointBackgroundColor: 'rgba(2, 132, 199, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(2, 132, 199, 1)',
          data: [25, 38, 62, 45, 90, 115, 130]
        },
        {
          label: 'Last Week',
          fill: true,
          backgroundColor: 'rgba(2, 132, 199, .25)',
          borderColor: 'rgba(2, 132, 199, 1)',
          pointBackgroundColor: 'rgba(2, 132, 199, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(2, 132, 199, 1)',
          data: [112, 90, 142, 130, 170, 188, 196]
        }
      ]
    };

    // Polar/Pie/Donut Data
    let chartPolarPieDonutData = {
      labels: [
        'Earnings',
        'Sales',
        'Tickets'
      ],
      datasets: [{
          data: [
            50,
            25,
            25
          ],
          backgroundColor: [
            'rgba(101, 163, 13, 1)',
            'rgba(217, 119, 6, 1)',
            'rgba(220, 38, 38, 1)'
          ],
          hoverBackgroundColor: [
            'rgba(101, 163, 13, .5)',
            'rgba(217, 119, 6, .5)',
            'rgba(220, 38, 38, .5)'
          ]
        }]
    };

    // Init Charts
    let chartLines, chartBars, chartRadar, chartPolar, chartPie, chartDonut;

    if (chartLinesCon !== null) {
      chartLines = new Chart(chartLinesCon, {type: 'line', data: chartLinesBarsRadarData, options: {tension: .4}});
    }

    if (chartBarsCon !== null) {
      chartBars = new Chart(chartBarsCon, {type: 'bar', data: chartLinesBarsRadarData});
    }

    if (chartRadarCon !== null) {
      chartRadar = new Chart(chartRadarCon, {type: 'radar', data: chartLinesBarsRadarData});
    }

    if (chartPolarCon !== null) {
      chartPolar = new Chart(chartPolarCon, {type: 'polarArea', data: chartPolarPieDonutData});
    }

    if (chartPieCon !== null) {
      chartPie = new Chart(chartPieCon, {type: 'pie', data: chartPolarPieDonutData});
    }

    if (chartDonutCon !== null) {
      chartDonut = new Chart(chartDonutCon, {type: 'doughnut', data: chartPolarPieDonutData});
    }
  }

  /*
   * Randomize Easy Pie Chart values
   *
   */
  static initRandomEasyPieChart() {
    document.querySelectorAll('.js-pie-randomize').forEach(btn => {
      btn.addEventListener('click', e => {
        btn.closest('.block').querySelectorAll('.pie-chart').forEach(chart => {
          jQuery(chart).data('easyPieChart').update(Math.floor((Math.random() * 100) + 1));
        });
      });
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initRandomEasyPieChart();
    this.initChartsChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageCompCharts.init());