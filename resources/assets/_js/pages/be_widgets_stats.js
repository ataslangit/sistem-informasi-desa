/*
 *  Document   : be_widgets_stats.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Widgets Stats Page
 */

// Chart.js Charts, for more examples you can check out http://www.chartjs.org/docs
class pageWidgetsStats {
  /*
   * Init Charts
   *
   */
  static initWidgetsChartJS() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "transparent";
    Chart.defaults.scale.grid.zeroLineColor = "transparent";
    Chart.defaults.scale.display = false;
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.scale.ticks.suggestedMax = 11;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 5;
    Chart.defaults.elements.point.hoverRadius = 7;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.display = false;

    // Chart Containers
    let chartWidgetLinesCon = document.getElementById('js-chartjs-widget-lines');
    let chartWidgetLinesCon2 = document.getElementById('js-chartjs-widget-lines2');
    let chartWidgetLinesCon3 = document.getElementById('js-chartjs-widget-lines3');
    let chartWidgetLinesCon4 = document.getElementById('js-chartjs-widget-lines4');

    // Charts letiables
    let chartWidgetLines, chartWidgetLines2, chartWidgetLines3, chartWidgetLines4;

    // Lines Charts Data
    let chartWidgetLinesData = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(2, 132, 199, .25)',
          borderColor: 'rgba(2, 132, 199, 1)',
          pointBackgroundColor: 'rgba(2, 132, 199, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(2, 132, 199, 1)',
          data: [5, 7, 4, 5, 6, 8, 4]
        }
      ]
    };

    let chartWidgetLinesData2 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(217, 119, 6, .25)',
          borderColor: 'rgba(217, 119, 6, 1)',
          pointBackgroundColor: 'rgba(217, 119, 6, 1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(217, 119, 6, 1)',
          data: [6, 9, 5, 6, 9, 7, 10]
        }
      ]
    };

    let chartWidgetLinesData3 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(1,229,148,.25)',
          borderColor: 'rgba(1,229,148,1)',
          pointBackgroundColor: 'rgba(1,229,148,1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(1,229,148,1)',
          data: [6, 9, 5, 6, 9, 7, 10]
        }
      ]
    };

    let chartWidgetLinesData4 = {
      labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
      datasets: [
        {
          label: 'This Week',
          fill: true,
          backgroundColor: 'rgba(237,83,80,.25)',
          borderColor: 'rgba(237,83,80,1)',
          pointBackgroundColor: 'rgba(237,83,80,1)',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: 'rgba(237,83,80,1)',
          data: [5, 7, 4, 5, 6, 8, 4]
        }
      ]
    };

    // Init Charts
    if (chartWidgetLinesCon !== null) {
      chartWidgetLines = new Chart(chartWidgetLinesCon, {type: 'line', data: chartWidgetLinesData, options: {tension: .4, scales: {y: {suggestedMax: 12}}}});
    }

    if (chartWidgetLinesCon2 !== null) {
      chartWidgetLines2 = new Chart(chartWidgetLinesCon2, {type: 'line', data: chartWidgetLinesData2, options: {tension: .4, scales: {y: {suggestedMax: 12}}}});
    }

    if (chartWidgetLinesCon3 !== null) {
      chartWidgetLines3 = new Chart(chartWidgetLinesCon3, {type: 'line', data: chartWidgetLinesData3, options: {tension: .4, scales: {y: {suggestedMax: 12}}}});
    }

    if (chartWidgetLinesCon4 !== null) {
      chartWidgetLines4 = new Chart(chartWidgetLinesCon4, {type: 'line', data: chartWidgetLinesData4, options: {tension: .4, scales: {y: {suggestedMax: 12}}}});
    }
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initWidgetsChartJS();
  }
}

// Initialize when page loads
Codebase.onLoad(pageWidgetsStats.init());
