/*
 *  Document   : be_pages_crypto_dashboard.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Crypto Dashboard Page
 */

class pageDashboardCrypto {
  /*
   * Crypto Charts, for more examples you can check out http://www.chartjs.org/docs
   *
   */
  static initChartsCrypto() {
    // Set Global Chart.js configuration
    Chart.defaults.color = '#818d96';
    Chart.defaults.scale.grid.color = "transparent";
    Chart.defaults.elements.point.radius = 5;
    Chart.defaults.elements.point.hoverRadius = 7;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.labels.boxWidth = 15;
    Chart.defaults.plugins.legend.display = false;

    // Helper Classes
    let chartBitcoin, chartEthereum, chartLitecoin;

    // Set up labels
    let chartCryptolabels = [];
    for (i = 0; i < 30; i++) {
      chartCryptolabels[i] = (i === 29) ? '1 day ago' : (30 - i) + ' days ago';
    }

    // Cryto Data
    let chartBitcoinData = [10500, 10400, 9500, 8268, 10218, 8250, 8707, 9284, 9718, 9950, 9879, 10147, 10883, 11071, 11332, 11584, 11878, 13540, 16501, 16007, 15142, 14869, 16762, 17276, 16808, 16678, 16771, 12900, 13100, 14000];
    let chartEthereumData = [500, 525, 584, 485, 470, 320, 380, 580, 620, 785, 795, 801, 799, 750, 900, 920, 930, 1300, 1250, 1150, 1365, 1258, 980, 870, 860, 925, 999, 1050, 1090, 1100];
    let chartLitecoinData = [300, 320, 330, 331, 335, 340, 358, 310, 220, 180, 190, 195, 203, 187, 198, 258, 270, 340, 356, 309, 218, 230, 242, 243, 250, 210, 205, 226, 214, 250];

    // Init Bitcoin Chart on Tab Shown
    document.getElementById('crypto-coins-btc-tab').addEventListener('shown.bs.tab', e => {
      let chartBitcoinCon = document.getElementById('js-chartjs-bitcoin');

      // if already exists destroy it
      if (chartBitcoin) {
        chartBitcoin.destroy();
      }

      // Init Chart
      if (chartBitcoinCon !== null) {
        chartBitcoin = new Chart(chartBitcoinCon, {
          type: 'line',
          data: {
            labels: chartCryptolabels,
            datasets: [
              {
                label: 'Bitcoin Price',
                fill: true,
                backgroundColor: 'rgba(255,193,7,.25)',
                borderColor: 'rgba(255,193,7,1)',
                pointBackgroundColor: 'rgba(255,193,7,1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(255,193,7,1)',
                data: chartBitcoinData
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            tension: .4,
            scales: {
              y: {
                suggestedMin: 6000,
                suggestedMax: 20000
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
          }
        });
      }
    });

    // Init Ethereum Chart on Tab Shown
    document.getElementById('crypto-coins-eth-tab').addEventListener('shown.bs.tab', e => {
      let chartEthereumCon = document.getElementById('js-chartjs-ethereum');

      // if already exists destroy it
      if (chartEthereum) {
        chartEthereum.destroy();
      }

      // Init Chart
      if (chartEthereumCon !== null) {
        chartEthereum = new Chart(chartEthereumCon, {
          type: 'line',
          data: {
            labels: chartCryptolabels,
            datasets: [
              {
                label: 'Ethereum Price',
                fill: true,
                backgroundColor: 'rgba(111,124,186, .25)',
                borderColor: 'rgba(111,124,186, 1)',
                pointBackgroundColor: 'rgba(111,124,186, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(111,124,186, 1)',
                data: chartEthereumData
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            tension: .4,
            scales: {
              y: {
                suggestedMin: 0,
                suggestedMax: 1500
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
          }
        });
      }
    });

    // Init Litecoin Chart on Tab Shown
    document.getElementById('crypto-coins-ltc-tab').addEventListener('shown.bs.tab', e => {
      let chartLitecoinCon = document.getElementById('js-chartjs-litecoin');
      
      // if already exists destroy it
      if (chartLitecoin) {
        chartLitecoin.destroy();
      }

      // Init Chart
      if (chartLitecoinCon !== null) {
        chartLitecoin = new Chart(chartLitecoinCon, {
          type: 'line',
          data: {
            labels: chartCryptolabels,
            datasets: [
              {
                label: 'Litecoin Price',
                fill: true,
                backgroundColor: 'rgba(181,181,181,.25)',
                borderColor: 'rgba(181,181,181,1)',
                pointBackgroundColor: 'rgba(181,181,181,1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(181,181,181,1)',
                data: chartLitecoinData
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            tension: .4,
            scales: {
              y: {
                suggestedMin: 0,
                suggestedMax: 400
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
          }
        });
      }
    });

    // Shown Bitcoin Tab which will trigger the first init of the chart
    new bootstrap.Tab(document.getElementById('crypto-coins-btc-tab')).show();
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initChartsCrypto();
  }
}

// Initialize when page loads
Codebase.onLoad(pageDashboardCrypto.init());
